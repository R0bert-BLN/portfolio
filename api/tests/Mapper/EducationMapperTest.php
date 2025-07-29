<?php

namespace App\Tests\Mapper;

use App\Mapper\EducationMapper;
use App\Repository\EducationRepository;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

class EducationMapperTest extends BaseTestCase
{
    private MockObject $educationRepositoryMock;
    private EducationMapper $educationMapper;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->educationRepositoryMock = $this->createMock(EducationRepository::class);
        $this->educationMapper = new EducationMapper($this->educationRepositoryMock);
    }

    /**
     * @throws ReflectionException
     */
    public function testEntityToDtoMapsSuccessfully(): void
    {
        $educationEntity = TestDataProvider::educationEntity();
        $this->setProperty($educationEntity, 'id', 1);

        $result = $this->educationMapper->entityToDto($educationEntity);

        $this->assertSame($educationEntity->getId(), $result->getId());
        $this->assertSame($educationEntity->getInstitutionName(), $result->getInstitutionName());
        $this->assertSame($educationEntity->getSpecialisation(), $result->getSpecialisation());
        $this->assertSame($educationEntity->getStartDate(), $result->getStartDate());
        $this->assertSame($educationEntity->getEndDate(), $result->getEndDate());
        $this->assertSame($educationEntity->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws ReflectionException
     */
    public function testDtoToEntityMapsSuccessfully(): void
    {
        $educationDto = TestDataProvider::educationRequestDto();
        $educationEntity = TestDataProvider::educationEntity();

        $profileId = 1;
        $this->setProperty($educationEntity, 'id', $profileId);

        $this->educationRepositoryMock->expects($this->once())
            ->method('find')
            ->with($profileId)
            ->willReturn($educationEntity);

        $result = $this->educationMapper->dtoToEntity($educationDto, $profileId);

        $this->assertSame($profileId, $result->getId());
        $this->assertSame($educationDto->getInstitutionName(), $result->getInstitutionName());
        $this->assertSame($educationDto->getSpecialisation(), $result->getSpecialisation());
        $this->assertSame($educationDto->getStartDate(), $result->getStartDate());
        $this->assertSame($educationDto->getEndDate(), $result->getEndDate());
        $this->assertSame($educationDto->getDisplayOrder(), $result->getDisplayOrder());
    }
}
