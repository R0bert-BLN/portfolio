<?php

namespace App\DataFixtures;

use App\Entity\ContactHistory;
use App\Entity\Education;
use App\Entity\Project;
use App\Entity\Skill;
use App\Entity\WorkExperience;
use App\Enum\SkillType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TestDataFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $education = new Education();
        $education->setInstitutionName('Oxford');
        $education->setSpecialisation('Computer Science');
        $education->setStartDate(new \DateTime('2022-02-01'));
        $education->setEndDate(new \DateTime('2022-12-31'));
        $education->setDisplayOrder(1);
        $manager->persist($education);

        $skill1 = new Skill();
        $skill1->setName('Skill 1');
        $skill1->setType(SkillType::FRAMEWORK);
        $skill1->setDisplayOrder(1);
        $manager->persist($skill1);

        $skill2 = new Skill();
        $skill2->setName('Skill 2');
        $skill2->setType(SkillType::TOOL);
        $skill2->setDisplayOrder(2);
        $manager->persist($skill2);

        $project = new Project();
        $project->setName('Project 1');
        $project->setDescription('Description 1');
        $project->setGithubLink('https://github.com/project1');
        $project->setDemoLink('https://project1.com');
        $project->setPictureUrl('https://example.com/project1.jpg');
        $project->setDisplayOrder(1);
        $project->addSkill($skill1);
        $project->addSkill($skill2);
        $manager->persist($project);

        $workExperience = new WorkExperience();
        $workExperience->setCompany('Company 1');
        $workExperience->setJobTitle('Role 1');
        $workExperience->setJobDescription('Description 1');
        $workExperience->setStartDate(new \DateTime('2022-01-01'));
        $workExperience->setEndDate(new \DateTime('2022-12-31'));
        $workExperience->setDisplayOrder(1);
        $manager->persist($workExperience);

        $contact = new ContactHistory();
        $contact->setName('John Doe');
        $contact->setEmail('qGZt2@example.com');
        $contact->setMessage('Hello, how are you?');
        $contact->setCreatedAt(new \DateTime('2022-01-01'));
        $manager->persist($contact);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
