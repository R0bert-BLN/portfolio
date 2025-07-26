<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly ParameterBagInterface $parameterBag)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setEmail($this->parameterBag->get('USER_EMAIL'));
        $user->setPassword($this->passwordHasher->hashPassword($user, $this->parameterBag->get('USER_PASSWORD')));

        $manager->persist($user);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
