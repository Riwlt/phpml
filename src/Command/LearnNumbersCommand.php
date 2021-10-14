<?php

declare(strict_types=1);

namespace App\Command;

use App\Extractor\Numbers\DataExtractor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LearnNumbersCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('learn:numbers');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo 'started'."\n";
        $startTime = microtime(true);

        $extractor = new DataExtractor();

//        $extractor->extract();

        echo 'finished'."\n";
        echo microtime(true) - $startTime;

        return 0;
    }
}