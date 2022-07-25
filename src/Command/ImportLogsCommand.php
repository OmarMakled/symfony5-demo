<?php

namespace App\Command;

use App\Service\LogParser;
use App\Service\LogReader;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use LimitIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Import logs file into db
 * 
 * @example `./bin/console app:import [filepath] [start]`
 * @author Omar Makled <omar.makled@gmail.com>
 */
class ImportLogsCommand extends Command
{
  protected static $defaultName = 'app:import';
  protected static $defaultDescription = 'Import logs to db';

  /**
   * @var EntityManagerInterface
   */
  private $entityManager;

  /**
   *
   * @param EntityManagerInterface $entityManager
   */
  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;

    parent::__construct();
  }

  /**
   * @inheritDoc
   */
  protected function configure(): void
  {
    $this
      ->addArgument('file', InputArgument::REQUIRED, 'file path')
      ->addArgument('start', InputArgument::OPTIONAL, 'Start from');
  }

  /**
   * @inheritDoc
   */
  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $io = new SymfonyStyle($input, $output);
    $reader = new LogReader();
    $parser = new LogParser;
    $file = $input->getArgument('file');
    $start = $input->getArgument('start');
    $count = 0;

    $lines = $start ? new LimitIterator($reader->open($file), $start) : $reader->open($file);
    try {
      foreach ($lines as $row) {
        $this->entityManager->persist($parser->fill($row));
        $this->entityManager->flush();
        ++$count;
      }
      $io->success('Inserted logs ' . $count);
      return Command::SUCCESS;
    } catch (InvalidArgumentException $e) {
      $io->error($e->getMessage() . ' Inserted logs ' . $count);
      return Command::FAILURE;
    }
  }
}
