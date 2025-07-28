<?php

namespace App\Tests\Mapper;

use App\Dto\ProfileRequestDto;
use App\Mapper\ProfileMapper;
use App\Repository\ProfileRepository;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;

class ProfileMapperTest extends BaseTestCase
{
    private ProfileMapper $profileMapper;
    private MockObject $profileRepositoryMock;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->profileRepositoryMock = $this->createMock(ProfileRepository::class);
        $this->profileMapper = new ProfileMapper($this->profileRepositoryMock);
    }

    /**
     * @throws \ReflectionException
     */
    public function testDtoToEntityConversion()
    {
        $profileRequestDto = new ProfileRequestDto(
            firstName: 'Rob',
            lastName: 'Stark',
            jobTitle: 'Developer',
            description: 'I am a developer');

        $profileId = 1;
        $profileEntity = TestDataProvider::emptyProfileEntity();
        $this->setProperty($profileEntity, 'id', $profileId);

        $this->profileRepositoryMock->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($profileEntity);

        $result = $this->profileMapper->ToEntity($profileRequestDto, $profileId);

        $this->assertSame($profileId, $result->getId());
        $this->assertSame('Rob', $result->getFirstName());
        $this->assertSame('Stark', $result->getLastName());
        $this->assertSame('Developer', $result->getJobTitle());
        $this->assertSame('I am a developer', $result->getDescription());
        $this->assertSame($profileEntity->getCvUrl(), $result->getCvUrl());
        $this->assertSame($profileEntity->getGithubLink(), $result->getGithubLink());
        $this->assertSame($profileEntity->getLinkedinLink(), $result->getLinkedinLink());
        $this->assertSame($profileEntity->getPictureUrl(), $result->getPictureUrl());
    }

    /**
     * @throws \ReflectionException
     */
    public function testEntityToDtoConversion()
    {
        $profileId = 1;
        $profileEntity = TestDataProvider::emptyProfileEntity();
        $this->setProperty($profileEntity, 'id', $profileId);
        $profileEntity->setFirstName('Rob');
        $profileEntity->setLastName('Stark');
        $profileEntity->setJobTitle('Developer');

        $result = $this->profileMapper->ToDto($profileEntity);

        $this->assertNotNull($result->getId());
        $this->assertSame($profileEntity->getFirstName(), $result->getFirstName());
        $this->assertSame($profileEntity->getLastName(), $result->getLastName());
        $this->assertSame($profileEntity->getJobTitle(), $result->getJobTitle());
        $this->assertSame($profileEntity->getDescription(), $result->getDescription());
        $this->assertSame($profileEntity->getCvUrl(), $result->getCvUrl());
        $this->assertSame($profileEntity->getGithubLink(), $result->getGithubLink());
        $this->assertSame($profileEntity->getLinkedinLink(), $result->getLinkedinLink());
        $this->assertSame($profileEntity->getPictureUrl(), $result->getPictureUrl());
    }
}
