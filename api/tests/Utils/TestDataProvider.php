<?php

namespace App\Tests\Utils;

use App\Dto\EducationRequestDto;
use App\Entity\Education;
use App\Entity\Profile;
use ReflectionException;

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

    /**
     * @throws ReflectionException
     */
    public static function educationEntity(): Education
    {
        $educationEntity = new Education();

        self::setProperty($educationEntity, 'id', 1);
        $educationEntity->setInstitutionName('Institution');
        $educationEntity->setSpecialisation('Specialisation');
        $educationEntity->setStartDate(new \DateTime('2022-01-01'));
        $educationEntity->setEndDate(new \DateTime('2022-12-31'));
        $educationEntity->setDisplayOrder(1);

        return $educationEntity;
    }

    public static function educationRequestDto(): EducationRequestDto
    {
        return new EducationRequestDto(
            institutionName: 'Oxford',
            specialisation: 'Computer Science',
            startDate: '2018-01-01',
            endDate: '2022-12-31',
            displayOrder: null);
    }

    public static function educationRequestJson(): array
    {
        return [
            'institution_name' => 'Fake Institution',
            'specialisation' => 'Some Specialisation',
            'start_date' => '2022-01-01',
            'end_date' => '2022-12-31',
            'display_order' => null,
        ];
    }

    /**
     * @throws ReflectionException
     */
    private static function setProperty(object $object, string $property, mixed $value): void
    {
        $reflectionProperty = new \ReflectionProperty($object, $property);
        $reflectionProperty->setValue($object, $value);
    }
}
