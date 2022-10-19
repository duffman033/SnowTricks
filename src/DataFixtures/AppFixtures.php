<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName("admin");
        $user->setEmail("admin@gmail.com");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'adminadmin'
        ));
        $user->setIsVerified(1);

        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setName("Duffman033");
        $user->setEmail("bmoreau72@free.fr");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'azerty'
        ));
        $user->setIsVerified(1);

        $manager->persist($user);
        $manager->flush();
    }
}
