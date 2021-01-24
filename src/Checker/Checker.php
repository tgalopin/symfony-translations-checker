<?php

/*
 * This file is part of the Translations Checker project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TranslationsChecker\Checker;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use TranslationsChecker\Checker\Check\CheckInterface;
use TranslationsChecker\Checker\Parser\ParserInterface;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class Checker
{
    /**
     * @var ParserInterface[]
     */
    private $parsers;

    /**
     * @var CheckInterface[]
     */
    private $checks;

    public function __construct(array $parsers, array $checks)
    {
        $this->parsers = $parsers;
        $this->checks = $checks;
    }

    public static function createDefault(): self
    {
        return new self(
            [
                new Parser\YamlParser(),
            ],
            [
                new Check\DomainsLocalesCheck(),
                new Check\LocalesKeysCheck(),
            ]
        );
    }

    public function check(Project $project): Project
    {
        $files = Finder::create()->files()->in($project->getPath())->sortByName();

        // Parse files
        foreach ($files as $file) {
            if (!$parser = $this->findParser($file)) {
                continue;
            }

            $project->addTranslations(
                $parser->getDomain($file),
                $parser->getLocale($file),
                $parser->getTranslations($file)
            );
        }

        // Running checks
        foreach ($this->checks as $check) {
            $check->check($project);
        }

        return $project;
    }

    private function findParser(SplFileInfo $file): ?ParserInterface
    {
        foreach ($this->parsers as $parser) {
            if ($parser->supports($file)) {
                return $parser;
            }
        }

        return null;
    }
}
