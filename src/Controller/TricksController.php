<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Entity\Tricks;
use App\Form\TricksType;
use App\Repository\TricksRepository;
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
     * @Route("/new", name="app_tricks_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TricksRepository $tricksRepository): Response
    {
        $trick = new Tricks();
        $form = $this->createForm(TricksType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('pictures')->getData();

            foreach($pictures as $image){

                $fichier = md5(uniqid()).'.'.$image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Pictures();
                $img->setName($fichier);
                $trick->addPictures($img);
            }

            $tricksRepository->add($trick, true);

            return $this->redirectToRoute('app_tricks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tricks/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tricks_show", methods={"GET"})
     */
    public function show(Tricks $trick): Response
    {
        return $this->render('tricks/show.html.twig', [
            'trick' => $trick,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_tricks_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tricks $trick, TricksRepository $tricksRepository): Response
    {
        $form = $this->createForm(TricksType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictures = $form->get('pictures')->getData();

            foreach($pictures as $picture){

                $fichier = md5(uniqid()).'.'.$picture->guessExtension();

                $picture->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                $img = new Pictures();
                $img->setName($fichier);
                $trick->addPictures($img);
            }

            $tricksRepository->add($trick, true);

            return $this->redirectToRoute('app_tricks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tricks/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tricks_delete", methods={"POST"})
     */
    public function delete(Request $request, Tricks $trick, TricksRepository $tricksRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $tricksRepository->remove($trick, true);
        }

        return $this->redirectToRoute('app_tricks_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/picture/{id}", name="tricks_delete_picture", methods={"HEAD","GET","DELETE"})
     */
    public function deletePicture(Pictures $picture, Request $request){
        $data = json_decode($request->getContent(), true);
            $name = $picture->getName();
            $trickId = $picture->getTricks()->getId();

            unlink($this->getParameter('images_directory').'/'.$name);

            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();

            return $this->redirectToRoute('app_tricks_edit',['id' => $trickId]);
    }
}
