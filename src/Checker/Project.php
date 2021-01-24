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

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class Project
{
    private $path;
    private $reference;
    private $catalog;
    private $errors;

    public function __construct(string $path, string $reference)
    {
        $this->path = $path;
        $this->reference = $reference;
        $this->catalog = [];
        $this->errors = [];
    }

    public function addTranslations(string $domain, string $locale, array $translations)
    {
        $this->catalog[$domain][$locale] = array_merge($this->catalog[$domain][$locale] ?? [], $translations);
    }

    public function addError(string $error)
    {
        $this->errors[] = $error;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getCatalog(): array
    {
        return $this->catalog;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
