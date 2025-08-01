<?php

namespace App\Tests\Service;

use App\Entity\Skill;
use App\Exception\ResourceAlreadyExistsException;
use App\Exception\ResourceNotFoundException;
use App\Mapper\SkillMapper;
use App\Repository\SkillRepository;
use App\Service\SkillService;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException as ReflectionExceptionAlias;

class SkillServiceTest extends BaseTestCase
{
    private MockObject $skillRepositoryMock;
    private MockObject $entityManagerMock;
    private SkillService $skillService;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->skillRepositoryMock = $this->createMock(SkillRepository::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $this->skillService = new SkillService(
            $this->skillRepositoryMock,
            $this->entityManagerMock,
            new SkillMapper($this->skillRepositoryMock));
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testCreateSkillCreatesSkillWhenSuccessful(): void
    {
        $skillDto = TestDataProvider::skillRequestDto();
        $skillEntity = TestDataProvider::skillEntity();

        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->willReturnCallback(function (Skill $skill) {
                $this->setProperty($skill, 'id', 1);
            });

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $result = $this->skillService->createSkill($skillDto);

        $this->assertSame($skillEntity->getId(), $result->getId());
        $this->assertSame($skillDto->getName(), $result->getName());
        $this->assertSame($skillDto->getType(), $result->getType());
        $this->assertSame($skillDto->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testGetSkillReturnsSkillWhenSuccessful(): void
    {
        $skill = TestDataProvider::skillEntity();

        $this->skillRepositoryMock->expects($this->once())
            ->method('find')
            ->with($skill->getId())
            ->willReturn($skill);

        $result = $this->skillService->getSkill($skill->getId());

        $this->assertSame($skill->getId(), $result->getId());
        $this->assertSame($skill->getName(), $result->getName());
        $this->assertSame($skill->getType(), $result->getType());
        $this->assertSame($skill->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testDeleteSkillDeletesSkillWhenSuccessful(): void
    {
        $skill = TestDataProvider::skillEntity();

        $this->skillRepositoryMock->expects($this->once())
            ->method('find')
            ->with($skill->getId())
            ->willReturn($skill);

        $this->entityManagerMock->expects($this->once())
            ->method('remove')
            ->with($skill);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->skillService->deleteSkill($skill->getId());
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testUpdateSkillUpdatesSkillWhenSuccessful(): void
    {
        $skill = TestDataProvider::skillEntity();
        $skillDto = TestDataProvider::skillRequestDto();

        $this->skillRepositoryMock->expects($this->once())
            ->method('find')
            ->with($skill->getId())
            ->willReturn($skill);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $result = $this->skillService->updateSkill($skillDto, $skill->getId());

        $this->assertSame($skill->getId(), $result->getId());
        $this->assertSame($skillDto->getName(), $result->getName());
        $this->assertSame($skillDto->getType(), $result->getType());
        $this->assertSame($skillDto->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function testCreateSkillThrowsResourceAlreadyExistsExceptionWhenSkillAlreadyExists(): void
    {
        $skillDto = TestDataProvider::skillRequestDto();
        $skillEntity = TestDataProvider::skillEntity();

        $this->expectException(ResourceAlreadyExistsException::class);

        $this->skillRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => $skillDto->getName()])
            ->willReturn($skillEntity);

        $this->skillService->createSkill($skillDto);
    }

    public function testGetSkillThrowsResourceNotFoundExceptionWhenSkillDoesNotExist(): void
    {
        $this->expectException(ResourceNotFoundException::class);

        $this->skillRepositoryMock->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->skillService->getSkill(1);
    }
}
