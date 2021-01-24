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
use Symfony\Component\Yaml\Yaml;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @final
 */
class YamlParser extends AbstractSymfonyParser
{
    /**
     * {@inheritdoc}
     */
    public function supports(SplFileInfo $file): bool
    {
        return in_array($file->getExtension(), ['yml', 'yaml'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslations(SplFileInfo $file): array
    {
        if (!$data = Yaml::parse($file->getContents())) {
            return [];
        }

        return $this->flatten($data);
    }

    private function flatten(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $result[$key] = $value;

                continue;
            }

            foreach ($this->flatten($value) as $vKey => $vValue) {
                $result[$key.'.'.$vKey] = $vValue;
            }
        }

        return $result;
    }
}
