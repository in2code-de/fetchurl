<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'fetchurl',
    'description' => 'Fetch an url and show the content in frontend. Inline or iframe display possible',
    'category' => 'plugin',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'author' => 'In2code GmbH',
    'author_email' => 'service@in2code.de',
    'author_company' => 'in2code.de',
    'version' => '6.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'php' => '7.4.0-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'In2code\\Fetchurl\\' => 'Classes',
        ],
    ],
];
