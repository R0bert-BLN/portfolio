<?php

namespace App\Tests\Mapper;

use App\Mapper\SkillMapper;
use App\Repository\SkillRepository;
use App\Tests\Utils\BaseTestCase;
use App\Tests\Utils\TestDataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;

class SkillMapperTest extends BaseTestCase
{
    private MockObject $skillRepositoryMock;
    private SkillMapper $skillMapper;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->skillRepositoryMock = $this->createMock(SkillRepository::class);
        $this->skillMapper = new SkillMapper($this->skillRepositoryMock);
    }

    /**
     * @throws \ReflectionException
     */
    public function testDtoToEntityConversionWhenSuccessfully()
    {
        $skillDto = TestDataProvider::skillRequestDto();
        $skillEntity = TestDataProvider::skillEntity();

        $this->skillRepositoryMock->expects($this->once())
            ->method('find')
            ->with($skillEntity->getId())
            ->willReturn($skillEntity);

        $result = $this->skillMapper->dtoToEntity($skillDto, $skillEntity->getId());

        $this->assertSame($skillEntity->getId(), $result->getId());
        $this->assertSame($skillDto->getName(), $result->getName());
        $this->assertSame($skillDto->getType(), $result->getType());
        $this->assertSame($skillDto->getDisplayOrder(), $result->getDisplayOrder());
    }

    /**
     * @throws \ReflectionException
     */
    public function testEntityToDtoConversionWhenSuccessfully()
    {
        $skillEntity = TestDataProvider::skillEntity();

        $result = $this->skillMapper->entityToDto($skillEntity);

        $this->assertSame($skillEntity->getId(), $result->getId());
        $this->assertSame($skillEntity->getName(), $result->getName());
        $this->assertSame($skillEntity->getType(), $result->getType());
        $this->assertSame($skillEntity->getDisplayOrder(), $result->getDisplayOrder());
    }
}
