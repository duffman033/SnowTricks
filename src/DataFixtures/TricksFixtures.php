<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Tricks;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TricksFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $tricks = ['Front Bluntslide 270', 'Nose grab', 'Method air', 'Double back flip', 'Stalefish', 'Japan Air', 'Nose grab', '180 rotation', 'Tail grab', '900 rotation'];
        $tricksCategories = ['Les Slide', 'Les Grab', 'Les one foot tricks' , 'Les flips', 'Les Grab', 'Les rotations', 'Les Grab', 'Old school' , 'Les one foot tricks', 'Les Grab'];
        $tricksDescription = [
            "Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d'un tour sur le rail.",
            "Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.",
            "Cette figure – qui consiste à attraper sa planche d'une main et le tourner perpendiculairement au sol – est un classique old school. Il n'empêche qu'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du air le plus haut en s'élevant à 9,8 mètres au-dessus du kick (sommet d'un mur d'une rampe ou autre structure de saut)",
            "Le backflip figure parmi les sauts les plus spectaculaires de cette discipline. Il nécessite la maîtrise des fondamentaux et d’une bonne perception du corps. En effet, avoir la tête en bas, même pendant quelques secondes seulement, est très difficile pour les non-initiés. Heureusement, il est possible de s’entrainer sur un trampoline avant de transposer les mouvements sur les pistes. ",
            "Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.",
            "Saisie de l'avant de la planche, avec la main avant, du côté de la carre frontside.",
            "Saisie de la partie avant de la planche, avec la main avant.",
            "Désigne un demi-tour, soit 180 degrés d'angle.",
            "Saisie de la partie arrière de la planche, avec la main arrière.",
            "Deux tours et demi.",
        ];

        $user = $this->userRepository->findOneBy(['name' => 'admin']);

        $i = 0;
        foreach ($tricks as $trick) {
            $newTrick = new Tricks();
            $newTrick->setName($trick);
            $newTrick->setCreatedAt(new \DateTime());
            $newTrick->setUpdatedAt(new \DateTime());
            $newTrick->setUser($user);
            $newTrick->setCategory($tricksCategories[$i]);
            $newTrick->setDescription($tricksDescription[$i]);

            $i++;
            $manager->persist($newTrick);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppFixtures::class
        ];
    }
}
