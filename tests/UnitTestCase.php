<?php

/*
 * This file is part of the Translations Checker project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\TranslationsChecker;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;

abstract class UnitTestCase extends TestCase
{
    protected function file(string $filename): SplFileInfo
    {
        return new SplFileInfo(__DIR__.'/Fixtures/'.$filename, dirname($filename), $filename);
    }
}
