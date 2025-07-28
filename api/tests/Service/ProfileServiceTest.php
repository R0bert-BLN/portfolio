<?php

namespace App\Tests\Service;

use App\Dto\ProfileRequestDto;
use App\Mapper\ProfileMapper;
use App\Repository\ProfileRepository;
use App\Service\ProfileService;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;

class ProfileServiceTest extends BaseTestCase
{
    private MockObject $entityManagerMock;
    private MockObject $profileRepositoryMock;
    private ProfileService $profileService;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->profileRepositoryMock = $this->createMock(ProfileRepository::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $this->profileService = new ProfileService(
            $this->profileRepositoryMock,
            $this->entityManagerMock,
            new ProfileMapper($this->profileRepositoryMock));
    }

    /**
     * @throws \ReflectionException
     */
    public function testEditProfileUpdatesProfileWhenSuccessful(): void
    {
        $profileDto = new ProfileRequestDto(firstName: 'Rob', lastName: 'Stark');
        $profileId = 2;

        $profileEntity = TestDataProvider::emptyProfileEntity();
        $this->setProperty($profileEntity, 'id', $profileId);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->profileRepositoryMock->expects($this->once())
            ->method('find')
            ->with($profileId)
            ->willReturn($profileEntity);

        $result = $this->profileService->editProfile($profileDto);

        $this->assertSame($profileId, $result->getId());
        $this->assertSame('Rob', $result->getFirstName());
        $this->assertSame('Stark', $result->getLastName());
        $this->assertSame($profileEntity->getJobTitle(), $result->getJobTitle());
        $this->assertSame($profileEntity->getDescription(), $result->getDescription());
        $this->assertSame($profileEntity->getCvUrl(), $result->getCvUrl());
        $this->assertSame($profileEntity->getGithubLink(), $result->getGithubLink());
        $this->assertSame($profileEntity->getLinkedinLink(), $result->getLinkedinLink());
        $this->assertSame($profileEntity->getPictureUrl(), $result->getPictureUrl());
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetProfileReturnsProfileWhenSuccessful(): void
    {
        $profileId = 2;
        $profileEntity = TestDataProvider::emptyProfileEntity();
        $this->setProperty($profileEntity, 'id', $profileId);

        $this->profileRepositoryMock->expects($this->once())
            ->method('find')
            ->with($profileId)
            ->willReturn($profileEntity);

        $result = $this->profileService->getProfile();

        $this->assertSame($profileId, $result->getId());
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
