<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Roadsurfer\FoodBundle\Service\FoodService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Roadsurfer\FoodBundle\Service\FoodCollectionService;

#[AsCommand(
    name: 'roadsurfer:import-json',
    description: 'Imports data from a JSON file into the database.',
)]
class ImportJsonCommand extends Command
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly FoodService $foodService,
        private readonly FoodCollectionService $foodCollectionService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $defaultJsonFilePath = $this->parameterBag->get('default_food_json_file_path');

        $this
            ->addArgument('jsonFilePath',
                InputArgument::OPTIONAL,
                'The path to the JSON file to process.',
                $defaultJsonFilePath
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $jsonFilePath = $input->getArgument('jsonFilePath');

        if (!file_exists($jsonFilePath)) {
            $io->error('The specified JSON file does not exist: ' . $jsonFilePath);
            return Command::FAILURE;
        }

        $jsonData = json_decode(file_get_contents($jsonFilePath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $io->error('Failed to decode JSON: ' . json_last_error_msg());
            return Command::FAILURE;
        }

        [$fruitCollection, $vegetablesCollection] = $this->foodService->processJson($jsonData);

        $this->foodCollectionService->insert($fruitCollection);
        $this->foodCollectionService->insert($vegetablesCollection);

        $io->success('JSON data has been successfully imported into the database.');

        return Command::SUCCESS;
    }
}
