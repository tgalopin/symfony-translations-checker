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
 *
 * @final
 */
abstract class AbstractSymfonyParser implements ParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDomain(SplFileInfo $file): string
    {
        return explode('.', $file->getFilename())[0];
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale(SplFileInfo $file): string
    {
        return explode('.', $file->getFilename())[1];
    }
}
