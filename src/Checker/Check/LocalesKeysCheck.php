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
class LocalesKeysCheck implements CheckInterface
{
    public function check(Project $project)
    {
        $reference = $project->getReference();
        $referenceCatalog = $this->createReferenceCatalog($project);

        foreach ($project->getCatalog() as $domain => $locales) {
            foreach ($locales as $locale => $translations) {
                if ($reference === $locale) {
                    continue;
                }

                $referenceKeys = array_keys($referenceCatalog[$domain]);
                $localeKeys = array_keys($translations);

                $missingKeys = array_diff($referenceKeys, $localeKeys);
                foreach ($missingKeys as $missingKey) {
                    $project->addError(sprintf(
                        'Catalog <fg=yellow>%s</> is missing key <fg=yellow>%s</> (which exists in the reference catalog %s)</>',
                        $domain.'.'.$locale,
                        $missingKey,
                        $domain.'.'.$reference
                    ));
                }

                $extraKeys = array_diff($localeKeys, $referenceKeys);
                foreach ($extraKeys as $extraKey) {
                    $project->addError(sprintf(
                        'Catalog <fg=yellow>%s</> contains an extra key <fg=yellow>%s</> (which does not exist in the reference catalog %s)</>',
                        $domain.'.'.$locale,
                        $extraKey,
                        $domain.'.'.$reference
                    ));
                }
            }
        }
    }

    private function createReferenceCatalog(Project $project): ?array
    {
        $reference = $project->getReference();

        $referenceCatalog = [];
        foreach ($project->getCatalog() as $domain => $locales) {
            if (!$referenceCatalog[$domain] = $locales[$reference] ?? null) {
                $project->addError(sprintf(
                    'No <fg=yellow>%s</> reference translations were found in domain <fg=yellow>%s</>, skipping this domain',
                    $project->getReference(),
                    implode(',', array_keys($locales))
                ));
            }
        }

        return $referenceCatalog;
    }
}
