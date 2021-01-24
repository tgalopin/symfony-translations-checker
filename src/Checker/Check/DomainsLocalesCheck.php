<?php

/*
 * This file is part of the Translations Checker project.
 *
 * (c) Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TranslationsChecker\Checker\Check;

use TranslationsChecker\Checker\Project;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class DomainsLocalesCheck implements CheckInterface
{
    public function check(Project $project)
    {
        $expected = $this->findNormalNumberOfLocales($project);

        foreach ($project->getCatalog() as $domain => $locales) {
            if (count($locales) !== $expected) {
                $project->addError(sprintf(
                    'Domain <fg=yellow>%s</> has an incoherent number of locales: <fg=yellow>%s</> '.
                    '(expected number based on other domains: <fg=yellow>%s</>)',
                    $domain,
                    implode(',', array_keys($locales)),
                    $expected
                ));
            }
        }
    }

    private function findNormalNumberOfLocales(Project $project)
    {
        $domainsLocalesCounts = [];
        foreach ($project->getCatalog() as $domain => $locales) {
            if (!isset($domainsLocalesCounts[count($locales)])) {
                $domainsLocalesCounts[count($locales)] = 0;
            }

            ++$domainsLocalesCounts[count($locales)];
        }

        arsort($domainsLocalesCounts);

        return (int) array_keys($domainsLocalesCounts)[0];
    }
}
