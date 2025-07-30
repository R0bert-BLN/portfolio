<?php

namespace App\Tests\Utils;

use App\Dto\ContactHistoryRequestDto;
use App\Dto\EducationRequestDto;
use App\Dto\ProjectRequestDto;
use App\Dto\SkillRequestDto;
use App\Dto\WorkExperienceRequestDto;
use App\Entity\ContactHistory;
use App\Entity\Education;
use App\Entity\Profile;
use App\Entity\Project;
use App\Entity\Skill;
use App\Entity\WorkExperience;
use App\Enum\SkillType;
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

    public static function projectRequestDto(): ProjectRequestDto
    {
        return new ProjectRequestDto(
            name: 'Fake Project',
            description: 'Fake Description',
            pictureUrl: 'https://example.com/fake.png',
            githubLink: 'https://github.com/fake/project',
            demoLink: null,
            displayOrder: null,
            skills: [1]
        );
    }

    /**
     * @throws ReflectionException
     */
    public static function projectEntity(): Project
    {
        $projectEntity = new Project();

        self::setProperty($projectEntity, 'id', 1);
        $projectEntity->setName('Fake Project');
        $projectEntity->setDescription('Fake Description');
        $projectEntity->setPictureUrl('https://example.com/fake.png');
        $projectEntity->setGithubLink('https://github.com/fake/project');
        $projectEntity->setDemoLink(null);
        $projectEntity->setDisplayOrder(null);
        $projectEntity->addSkill(self::skillEntity());

        return $projectEntity;
    }

    public static function projectRequestJson(): array
    {
        return [
            'name' => 'Fake Project',
            'description' => 'Fake Description',
            'picture_url' => 'https://example.com/fake2.png',
            'github_link' => 'https://github.com/fake2/project',
            'demo_link' => null,
            'display_order' => null
        ];
    }

    public static function skillRequestJson(): array
    {
        return [
            'name' => 'Fake Skill',
            'type' => 'language',
            'display_order' => null
        ];
    }

    /**
     * @throws ReflectionException
     */
    public static function skillEntity(): Skill
    {
        $skillEntity = new Skill();

        self::setProperty($skillEntity, 'id', 1);
        $skillEntity->setName('Fake Skill');
        $skillEntity->setType(SkillType::LANGUAGE);
        $skillEntity->setDisplayOrder(null);

        return $skillEntity;
    }

    public static function skillRequestDto(): SkillRequestDto
    {
        return new SkillRequestDto(
            name: 'Fake Skill',
            type: SkillType::LANGUAGE,
            displayOrder: null
        );
    }

    public static function workExperienceRequestDto(): WorkExperienceRequestDto
    {
        return new WorkExperienceRequestDto(
            jobTitle: 'Fake Job',
            jobDescription: 'Fake Description',
            company: 'Fake Company',
            startDate: '2022-01-01',
            endDate: '2022-12-31',
            displayOrder: null
        );
    }

    public static function workExperienceUpdateRequestDto(): WorkExperienceRequestDto
    {
        return new WorkExperienceRequestDto(
            jobTitle: 'Fake Job Updated',
            jobDescription: 'Fake Description Updated',
            company: 'Fake Company Updated',
            startDate: '2023-01-01',
            endDate: '2023-12-31',
            displayOrder: null
        );
    }

    /**
     * @throws ReflectionException
     */
    public static function workExperienceEntity(): WorkExperience
    {
        $workExperienceEntity = new WorkExperience();

        self::setProperty($workExperienceEntity, 'id', 1);
        $workExperienceEntity->setJobTitle('Fake Job');
        $workExperienceEntity->setJobDescription('Fake Description');
        $workExperienceEntity->setCompany('Fake Company');
        $workExperienceEntity->setStartDate(new \DateTime('2022-01-01'));
        $workExperienceEntity->setEndDate(new \DateTime('2022-12-31'));
        $workExperienceEntity->setDisplayOrder(null);

        return $workExperienceEntity;
    }

    public static function workExperienceRequestJson(): array
    {
        return [
            'job_title' => 'Fake Job',
            'job_description' => 'Fake Description',
            'company' => 'Fake Company',
            'start_date' => '2022-01-01',
            'end_date' => '2022-12-31',
            'display_order' => null
        ];
    }

    public static function contactHistoryRequestDto(): ContactHistoryRequestDto
    {
        return new ContactHistoryRequestDto(
            name: 'Fake Name',
            email: 'fake@email.com',
            message: 'Fake Message'
        );
    }

    public static function contactHistoryRequestJson(): array
    {
        return [
            'name' => 'Fake Name',
            'email' => 'fake@email.com',
            'message' => 'Fake Message'
        ];
    }

    /**
     * @throws ReflectionException
     */
    public static function contactHistoryEntity(): ContactHistory
    {
        $contactHistoryEntity = new ContactHistory();

        self::setProperty($contactHistoryEntity, 'id', 1);
        $contactHistoryEntity->setName('Fake Name');
        $contactHistoryEntity->setEmail('fake@email.com');
        $contactHistoryEntity->setMessage('Fake Message');
        $contactHistoryEntity->setCreatedAt(new \DateTime('2023-01-01'));

        return $contactHistoryEntity;
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
