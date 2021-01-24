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
 */
interface CheckInterface
{
    /**
     * Check a given project translations and store error messages in it if necessary.
     *
     * @return void
     */
    public function check(Project $project);
}
