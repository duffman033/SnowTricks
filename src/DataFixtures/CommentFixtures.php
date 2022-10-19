<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Repository\UserRepository;
use App\Repository\TricksRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    private $trickRepository;

    public function __construct(TricksRepository $trickRepository)
    {
        $this->trickRepository = $trickRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $comments = [
            "Incroyable !",
            "Trop cool !",
            "Merci de l'astuce",
            "Super le partage",
            "Génial"
        ];

        foreach ($this->trickRepository->findAll() as $trick) {
            for ($i = 0; $i < 2; $i++) {
                $newComment = new Comment();
                $newComment->setCreatedAt(new \DateTime());
                $newComment->setUpdatedAt(new \DateTime());
                $newComment->setUser($trick->getUser());
                $newComment->setTrick($trick);
                $newComment->setContent($comments[array_rand($comments)]);

                $manager->persist($newComment);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppFixtures::class, TricksFixtures::class
        ];
    }
}
