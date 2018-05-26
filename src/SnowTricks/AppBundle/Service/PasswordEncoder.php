<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14/05/2018
 * Time: 14:36
 */

namespace SnowTricks\AppBundle\Service;


use SnowTricks\AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoder
{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function encodePassword(User $user, $password)
    {
        return $var = $this->userPasswordEncoder->encodePassword($user, $password);
    }

}
