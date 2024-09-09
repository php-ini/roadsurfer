<?php

declare(strict_types=1);

namespace Roadsurfer\FoodBundle\Command;

use Roadsurfer\FoodBundle\Service\FoodCollectionService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'roadsurfer:food-json-process',
    description: 'Tests the Food processing a JSON file with the CollectionService.',
    hidden: false
)]
class FoodJsonProcessCommand extends Command
{
    protected static string $defaultName = 'roadsurfer:food-json-process';
    protected static string $defaultDescription = 'Tests the Food processing a JSON file with the CollectionService.';

    public function __construct(
        private readonly FoodCollectionService $foodCollectionService,
        private readonly ParameterBagInterface $parameterBag
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $defaultJsonFilePath = $this->parameterBag->get('default_food_json_file_path');

        $this
            ->addArgument(
                'jsonFilePath',
                InputArgument::OPTIONAL,
                'The path to the JSON file to process.',
                $defaultJsonFilePath
            )
            ->addOption('output', 'o', InputOption::VALUE_NONE, 'Whether to output the contents of the collections after processing.');
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

        $this->foodCollectionService->processJson($jsonData);

        if ($input->getOption('output')) {
            $fruits = $this->foodCollectionService->getFruits();
            $vegetables = $this->foodCollectionService->getVegetables();
            $io->success('Fruits and Vegetables processed successfully.');
            $io->listing([
                'Fruits: ' . count($fruits),
                'Vegetables: ' . count($vegetables)
            ]);
            $io->text('Details:');
            $io->table(
                ['ID', 'Name', 'Type', 'Quantity (g)'],
                array_merge($this->formatItemsForOutput($fruits), $this->formatItemsForOutput($vegetables))
            );
        } else {
            $io->success('JSON processed successfully.');
        }

        return Command::SUCCESS;
    }

    private function formatItemsForOutput(array $items): array
    {
        return array_map(function ($item) {
            return [$item->getId(), $item->getName(), $item->getType(), $item->getQuantity()];
        }, $items);
    }
}
