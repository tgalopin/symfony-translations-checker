<?php

/*
 * This file is part of the Translations Checker project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TranslationsChecker\Checker\Parser;

use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
interface ParserInterface
{
    /**
     * Whether this parser supports the given file or not.
     */
    public function supports(SplFileInfo $file): bool;

    /**
     * Get the translation domain associated to the given file.
     */
    public function getDomain(SplFileInfo $file): string;

    /**
     * Get the locale of the given file.
     */
    public function getLocale(SplFileInfo $file): string;

    /**
     * Get the translations inside the given file as an array [key => translation].
     */
    public function getTranslations(SplFileInfo $file): array;
}
