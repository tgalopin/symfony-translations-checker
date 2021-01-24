<?php

/*
 * This file is part of the Translations Checker project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\TranslationsChecker\Checker\Parser;

use Tests\TranslationsChecker\UnitTestCase;
use TranslationsChecker\Checker\Parser\YamlParser;

class YamlParserTest extends UnitTestCase
{
    public function testGetDomain()
    {
        $this->assertSame('my_domain', $this->parser()->getDomain($this->file('yaml/parser/my_domain.en_US.yaml')));
    }

    public function testGetLocale()
    {
        $this->assertSame('en_US', $this->parser()->getLocale($this->file('yaml/parser/my_domain.en_US.yaml')));
    }

    public function testGetTranslations()
    {
        $expected = [
            'account.registration.success' => 'Your account has been created successfully!',
        ];

        $this->assertSame($expected, $this->parser()->getTranslations($this->file('yaml/parser/my_domain.en_US.yaml')));
    }

    private function parser()
    {
        return new YamlParser();
    }
}
