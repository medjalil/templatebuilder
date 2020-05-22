<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {

        $user = new User();
        $user->setEmail('info@test.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
        $user->setRoles(array('ROLE_USER'));
        $manager->persist($user);

        $manager->flush();
    }

}
