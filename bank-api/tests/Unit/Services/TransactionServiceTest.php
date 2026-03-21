<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TransactionService;
use App\Contracts\AccountRepositoryInterface;
use App\Exceptions\AccountNotFoundException;
use App\Exceptions\BalanceNotFoundException;
use PDO;


class TransactionServiceTest extends TestCase
{
    private $repository;
    private $pdo;
    private $service;

    protected function setUp() :void
    {
        $this->repository = $this->createMock(AccountRepositoryInterface::class);
        $this->pdo = $this->createMock(PDO::class);

        $this->service = new TransactionService(
            $this->pdo,
            $this->repository
        );
    }

    public function testShouldProcessDebitTransaction()
    {
        $this->pdo->method('beginTransaction');
        $this->pdo->method('commit');

        $this->repository
            ->method('findByAccountNumberForUpdate')
            ->willReturn([
                'id' => 1,
                'saldo' => 100
            ]);

        $this->repository
            ->expects($this->once())
            ->method('updateBalance');

        $result = $this->service->process('D', 123, 10);

        $this->assertEquals(89.7, $result['saldo']);
    }

    public function testeShouldThrowAccountNotFound()
    {
        $this->pdo->method('beginTransaction');

        $this->repository
            ->method('findByAccountNumberForUpdate')
            ->willReturn(null);

        $this->expectException(AccountNotFoundException::class);

        $this->service->process('D', 123, 10);
    }

    public function testShouldThrowBalanceNotFound()
    {
        $this->pdo->method('beginTransaction');

        $this->repository
            ->method('findByAccountNumberForUpdate')
            ->willReturn([
                'id' => 1,
                'saldo' => 5
            ]);

        $this->expectException(BalanceNotFoundException::class);

        $this->service->process('D', 123, 10);
    }
}