<?php

namespace App\Tests\Utils;

use App\Entity\Profile;

readonly class TestDataProvider
{
    public static function emptyProfileEntity(): Profile
    {
        $profileEntity = new Profile();

        $profileEntity->setFirstName('');
        $profileEntity->setLastName('');
        $profileEntity->setJobTitle('');
        $profileEntity->setDescription('');
        $profileEntity->setCvUrl('');
        $profileEntity->setGithubLink('');
        $profileEntity->setLinkedinLink('');
        $profileEntity->setPictureUrl('');

        return $profileEntity;
    }
}
