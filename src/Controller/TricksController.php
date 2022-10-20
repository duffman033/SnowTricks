<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Pictures;
use App\Entity\Tricks;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TricksType;
use App\Repository\CommentRepository;
use App\Repository\TricksRepository;
use App\Repository\VideoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tricks")
 */
class TricksController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/new", name="app_tricks_new", methods={"GET", "POST"})
     */
    public function new(
        Request $request,
        TricksRepository $tricksRepository,
        VideoRepository $videoRepository
    ): Response {
        $trick = new Tricks();
        $form = $this->createForm(TricksType::class, $trick);
        $form->handleRequest($request);
        $video = new Video();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('url')->getData()) {
                $url = $form->get('url')->getData();
                $video->setTrick($trick);
                $video->setUrl($url);
                $videoRepository->add($video, true);
            }
            $pictures = $form->get('pictures')->getData();

            foreach ($pictures as $image) {
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Pictures();
                $img->setName($fichier);
                $trick->addPictures($img);
            }
            $trick->setUser($this->getUser());
//            $trick->setSlug($form->get('name')->getData());

            $tricksRepository->add($trick, true);
            $this->addFlash('success', "Ajout effectué avec succès !");
            return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'tricks/new.html.twig',
            [
                'trick' => $trick,
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{slug}", name="app_tricks_show", methods={"POST","GET"}))
     */
    public function show(Tricks $trick, Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        if ($request->isXmlHttpRequest()) {
            $data = [];
            $comments = $commentRepository->findLoadMoreComments(
                $request->request->get('offset'),
                $commentRepository->count([]),
                $trick
            );

            foreach ($comments as $comment) {
                $data[] = [
                    'id' => $comment->getId(),
                    'user' => $comment->getUser()->getUsername(),
                    'avatar' => $comment->getUser()->getAvatar(),
                    'created' => $comment->getCreatedAt()->format('d/m/Y H:i'),
                    'content' => $comment->getContent(),
                ];
            }

            return new JsonResponse($data);
        }
        return $this->render(
            'tricks/show.html.twig',
            [
                'trick' => $trick,
                'comments' => $commentRepository->findCommentsDesc($trick),
                'countComments' => $commentRepository->count(['trick' => $trick]),
                'comment' => $comment,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{slug}/comment", name="app_tricks_show_comment", methods={"POST","GET"}))
     */
    public function comment(Tricks $trick, Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());
            $commentRepository->add($comment, true);

            $this->addFlash('success', "Votre commentaire a été ajoutée avec succès !");

            return $this->redirectToRoute('app_tricks_show', ["slug" => $trick->getSlug()],);
        }
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{slug}/edit", name="app_tricks_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        Tricks $trick,
        TricksRepository $tricksRepository,
        VideoRepository $videoRepository
    ): Response {
        $form = $this->createForm(TricksType::class, $trick);
        $form->handleRequest($request);
        $video = new Video();
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('url')->getData()) {
                $url = $form->get('url')->getData();
                $video->setTrick($trick);
                $video->setUrl($url);
                $videoRepository->add($video, true);
            }
            $pictures = $form->get('pictures')->getData();

            foreach ($pictures as $picture) {
                $fichier = md5(uniqid()) . '.' . $picture->guessExtension();

                $picture->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Pictures();
                $img->setName($fichier);
                $trick->addPictures($img);
            }
//            $trick->setUpdatedAt(new \DateTime('now'));
            $tricksRepository->add($trick, true);
            $this->addFlash('success', "Modification effectuée avec succès !");
            return $this->redirectToRoute('app_tricks_show', ["slug" => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm(
            'tricks/edit.html.twig',
            [
                'trick' => $trick,
                'form' => $form,
            ]
        );
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{slug}", name="app_tricks_delete", methods={"POST"})
     */
    public function delete(Request $request, Tricks $trick, TricksRepository $tricksRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $trick->getId(), $request->request->get('_token'))) {
            $tricksRepository->remove($trick, true);
        }
        $this->addFlash('success', "Suppression effectuée avec succès !");
        return $this->redirectToRoute('app_homepage', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/delete/picture/{id}", name="tricks_delete_picture", methods={"HEAD","GET","DELETE"})
     */
    public function deletePicture(Pictures $picture, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $name = $picture->getName();
        $trickSlug = $picture->getTricks()->getSlug();

        unlink($this->getParameter('images_directory') . '/' . $name);

        $em = $this->getDoctrine()->getManager();
        $em->remove($picture);
        $em->flush();

        $this->addFlash('success', "Suppression effectuée avec succès !");
        return $this->redirectToRoute('app_tricks_edit', ['id' => $trickSlug]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/delete/vidéo/{id}", name="tricks_delete_video", methods={"HEAD","GET","DELETE"})
     */
    public function deleteVideo(Video $video, Request $request)
    {
        $trickSlug = $video->getTrick()->getSlug();

        $em = $this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();

        $this->addFlash('success', "Suppression effectuée avec succès !");
        return $this->redirectToRoute('app_tricks_edit', ['slug' => $trickSlug]);
    }
}
