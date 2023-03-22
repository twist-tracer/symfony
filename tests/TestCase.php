<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;

class TestCase extends WebTestCase
{
    protected static Application $console;

    private EntityManagerInterface $entityManager;

    protected bool $refreshDataBase = false;

    protected bool $eachTestInTransaction = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManager = static::getContainer()->get(EntityManagerInterface::class);

        if ($this->refreshDataBase) {
            $this->refreshDataBase();
        }

        if ($this->eachTestInTransaction) {
            $this->entityManager->beginTransaction();
        }
    }

    protected static function getKernel(): KernelInterface
    {
        if (!static::$booted) {
            static::bootKernel();
        }

        return static::$kernel;
    }

    protected function getConsole(): Application
    {
        if (!isset(static::$console)) {
            static::bootConsole();
        }

        return static::$console;
    }

    protected static function bootConsole(): Application
    {
        $console = new Application(static::getKernel());
        $console->setAutoExit(false);
        static::$console = $console;

        return static::$console;
    }

    protected function runCommand(string $command, array $params = []): int
    {
        $input = new ArrayInput(array_merge($params, [
            'command' => $command
        ]));

        return $this->getConsole()->run($input);
    }

    protected function refreshDatabase(): void
    {
        if (!RefreshDatabaseState::$migrated) {
            $this->runCommand('doctrine:database:drop', ['--force' => true, '--quiet' => true]);
            $this->runCommand('doctrine:database:create', ['--quiet' => true]);
            $this->runCommand('doctrine:migrations:migrate', ['--quiet' => true]);

            RefreshDatabaseState::$migrated = true;
        }
    }

    protected function tearDown(): void
    {
        $this->entityManager->rollback();

        parent::tearDown();
    }
}
