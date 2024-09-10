<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Roadsurfer\FoodBundle\Entity\Food;
use Roadsurfer\FoodBundle\Enum\FoodType;
use Roadsurfer\FoodBundle\Enum\UnitType;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'roadsurfer:import-json',
    description: 'Imports data from a JSON file into the database.',
)]
class ImportJsonCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
        private readonly ParameterBagInterface $parameterBag
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

        $jsonData = json_decode(file_get_contents($jsonFilePath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $io->error('Failed to decode JSON: ' . json_last_error_msg());
            return Command::FAILURE;
        }

        // TODO: Must refactor below to follow separation of concerns and to be testable

        foreach ($jsonData as $item) {
            $food = new Food();
            $food->setName($item['name']);

            try {
                $foodType = FoodType::from($item['type']);
            } catch (\ValueError $e) {
                $io->error("Invalid food type: " . $item['type'] . PHP_EOL . $e->getMessage());
                continue;
            }

            $food->setType($foodType);

            $food->setQuantity($item['unit'] === UnitType::Kilogram ? $item['quantity'] * 1000 : $item['quantity']);

            try {
                UnitType::from($item['unit']);
            } catch (\ValueError $e) {
                $io->error("Invalid unit type: " . $item['unit']. PHP_EOL . $e->getMessage());
                continue;
            }

            $food->setUnit(UnitType::Gram);

            $errors = $this->validator->validate($food);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $io->error($error->getMessage());
                }
                continue;
            }

            $this->entityManager->persist($food);
        }

        $this->entityManager->flush();
        $io->success('JSON data has been successfully imported into the database.');

        return Command::SUCCESS;
    }
}
