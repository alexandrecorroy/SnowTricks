<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 21/05/2018
 * Time: 10:01
 */

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\PasswordEncoder;
use App\Service\TokenGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    private $passwordEncoder;
    private $tokenGenerator;

    public function __construct(PasswordEncoder $passwordEncoder, TokenGenerator $tokenGenerator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function load(ObjectManager $objectManager)
    {

        $user = new User();
        $user->setUsername('userdemo');
        $user->setIsActive(1);
        $user->setEmail('alexandre.corroy@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'userdemo'));
        $user->setToken($this->tokenGenerator->generateToken($user));
        $user->setPicture('avatar_user_demo.png');

        $objectManager->persist($user);
        $this->addReference('first-user', $user);
        $objectManager->flush();
    }

}