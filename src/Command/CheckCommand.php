<?php

/*
 * This file is part of the Translations Checker project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TranslationsChecker\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TranslationsChecker\Checker\Checker;
use TranslationsChecker\Checker\Project;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class CheckCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('check')
            ->setDescription('Check the coherence of the translations files in a given directory.')
            ->addArgument('translations-directory', InputArgument::REQUIRED, 'Directory containing the translation files.')
            ->addOption('reference', null, InputOption::VALUE_REQUIRED, 'Locale to use as reference for the checks.', 'en')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->writeln('Checking translations...');

        $project = new Project($input->getArgument('translations-directory'), $input->getOption('reference'));
        Checker::createDefault()->check($project);

        foreach ($project->getErrors() as $error) {
            $io->writeln('  - '.$error);
        }

        if ($errorsCount = count($project->getErrors())) {
            $io->writeln(sprintf("\n<fg=red>%s error%s</>", $errorsCount, $errorsCount > 1 ? 's' : ''));

            return Command::FAILURE;
        }

        $io->writeln("\n<fg=green>No error</>");

        return Command::SUCCESS;
    }
}
