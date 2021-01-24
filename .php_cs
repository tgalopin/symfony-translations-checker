<?php

$header = <<<'EOF'
This file is part of the Translations Checker project.

(c) Titouan Galopin <galopintitouan@gmail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;


return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'phpdoc_annotation_without_dot' => false,
        'header_comment' => ['header' => $header],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()->in(['bin', 'src', 'tests'])
    )
;
