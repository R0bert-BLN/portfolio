<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $profile = new Profile();

        $profile->setFirstName('');
        $profile->setLastName('');
        $profile->setDescription('');
        $profile->setCvUrl('');
        $profile->setGithubLink('');
        $profile->setLinkedinLink('');
        $profile->setJobTitle('');

        $manager->persist($profile);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['profile'];
    }
}
