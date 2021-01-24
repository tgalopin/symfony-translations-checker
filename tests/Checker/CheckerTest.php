<?php

/*
 * This file is part of the Translations Checker project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\TranslationsChecker\Checker;

use Tests\TranslationsChecker\UnitTestCase;
use TranslationsChecker\Checker\Check\DomainsLocalesCheck;
use TranslationsChecker\Checker\Check\LocalesKeysCheck;
use TranslationsChecker\Checker\Checker;
use TranslationsChecker\Checker\Parser\YamlParser;
use TranslationsChecker\Checker\Project;

class CheckerTest extends UnitTestCase
{
    public function provideCheck()
    {
        yield 'domains-locales' => [
            'checks' => [new DomainsLocalesCheck()],
            'project' => new Project(__DIR__.'/../Fixtures/yaml/domains-locales', 'en'),
            'expectedErrors' => [
                'Domain <fg=yellow>account</> has an incoherent number of locales: <fg=yellow>en,fr,pt</> (expected number based on other domains: <fg=yellow>2</>)',
            ],
        ];

        yield 'locales-keys-en' => [
            'checks' => [new LocalesKeysCheck()],
            'project' => new Project(__DIR__.'/../Fixtures/yaml/locales-keys-en', 'en'),
            'expectedErrors' => [
                'Catalog <fg=yellow>account.fr</> is missing key <fg=yellow>account.additional_key</> (which exists in the reference catalog account.en)</>',
            ],
        ];

        yield 'locales-keys-fr' => [
            'checks' => [new LocalesKeysCheck()],
            'project' => new Project(__DIR__.'/../Fixtures/yaml/locales-keys-fr', 'fr'),
            'expectedErrors' => [
                'Catalog <fg=yellow>account.en</> contains an extra key <fg=yellow>account.additional_key</> (which does not exist in the reference catalog account.fr)</>',
            ],
        ];

        yield 'ok' => [
            'checks' => [new DomainsLocalesCheck(), new LocalesKeysCheck()],
            'project' => new Project(__DIR__.'/../Fixtures/yaml/ok', 'en'),
            'expectedErrors' => [],
        ];
    }

    /**
     * @dataProvider provideCheck
     */
    public function testCheck(array $checks, Project $project, array $expectedErrors)
    {
        $checker = new Checker([new YamlParser()], $checks);
        $checker->check($project);

        $this->assertSame($expectedErrors, $project->getErrors());
    }
}
