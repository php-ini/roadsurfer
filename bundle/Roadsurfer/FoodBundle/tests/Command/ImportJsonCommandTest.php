<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Tests\Command;

use PHPUnit\Framework\TestCase;
use Roadsurfer\FoodBundle\Command\ImportJsonCommand;
use Roadsurfer\FoodBundle\Service\FoodCollectionService;
use Roadsurfer\FoodBundle\Service\FoodService;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImportJsonCommandTest extends TestCase
{
    private $parameterBag;
    private $foodService;
    private $foodCollectionService;
    private $commandTester;

    protected function setUp(): void
    {
        $this->parameterBag = $this->createMock(ParameterBagInterface::class);
        $this->foodService = $this->createMock(FoodService::class);
        $this->foodCollectionService = $this->createMock(FoodCollectionService::class);

        $command = new ImportJsonCommand(
            $this->parameterBag,
            $this->foodService,
            $this->foodCollectionService
        );

        $application = new Application();
        $application->add($command);

        $this->commandTester = new CommandTester($application->find('roadsurfer:import-json'));
    }

    public function testExecuteWithNonExistentFile(): void
    {
        $this->parameterBag->method('get')->willReturn('/non/existent/file.json');

        $this->commandTester->execute(['jsonFilePath' => '/non/existent/file.json']);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('The specified JSON file does not exist', $output);
        $this->assertEquals(ImportJsonCommand::FAILURE, $this->commandTester->getStatusCode());
    }

    public function testExecuteWithInvalidJson(): void
    {
        $this->parameterBag->method('get')->willReturn('/path/to/invalid.json');

        file_put_contents('/path/to/invalid.json', 'invalid json');

        $this->commandTester->execute(['jsonFilePath' => '/path/to/invalid.json']);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Failed to decode JSON', $output);
        $this->assertEquals(ImportJsonCommand::FAILURE, $this->commandTester->getStatusCode());

        unlink('/path/to/invalid.json');
    }

    public function testExecuteWithValidJson(): void
    {
        $this->parameterBag->method('get')->willReturn('/path/to/valid.json');

        $jsonData = [
            'fruits' => [],
            'vegetables' => []
        ];

        file_put_contents('/path/to/valid.json', json_encode($jsonData));

        $this->foodService->method('processJson')->willReturn([[], []]);

        $this->commandTester->execute(['jsonFilePath' => '/path/to/valid.json']);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('JSON data has been successfully imported into the database', $output);
        $this->assertEquals(ImportJsonCommand::SUCCESS, $this->commandTester->getStatusCode());

        unlink('/path/to/valid.json');
    }
}