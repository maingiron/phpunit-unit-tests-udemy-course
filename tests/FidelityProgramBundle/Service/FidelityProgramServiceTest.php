<?php

declare(strict_types=1);

namespace Tests\FidelityProgramBundle\Service;

use FidelityProgramBundle\Repository\PointsRepository;
use FidelityProgramBundle\Service\FidelityProgramService;
use FidelityProgramBundle\Service\PointsCalculator;
use MyFramework\LoggerInterface;
use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

final class FidelityProgramServiceTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSaveWhenReceivePoints()
    {
        $repositoryMock = $this->createMock(PointsRepository::class);
        $repositoryMock->expects($this->once())
            ->method('save'); // assertion here

        $calculatorMock = $this->createMock(PointsCalculator::class);
        $calculatorMock->method('calculatePointsToReceive')
            ->willReturn(100);

        $loggerMock = $this->createMock(LoggerInterface::class);

        $service = new FidelityProgramService($repositoryMock, $calculatorMock, $loggerMock);

        $customerMock = $this->createMock(Customer::class);
        $valueFake = 50;

        $service->addPoints($customerMock, $valueFake);
    }

    /**
     * @test
     */
    public function shouldNotSaveWhenReceiveZeroPoint()
    {
        $repositoryMock = $this->createMock(PointsRepository::class);
        $repositoryMock->expects($this->never())
            ->method('save'); // assertion here

        $calculatorMock = $this->createMock(PointsCalculator::class);
        $calculatorMock->method('calculatePointsToReceive')
            ->willReturn(0);

        $loggerMock = $this->createMock(LoggerInterface::class);

        $service = new FidelityProgramService($repositoryMock, $calculatorMock, $loggerMock);

        $customerMock = $this->createMock(Customer::class);
        $valueFake = 20;

        $service->addPoints($customerMock, $valueFake);
    }
}
