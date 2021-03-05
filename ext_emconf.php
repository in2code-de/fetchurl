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
    'version' => '4.5.1',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-11.5.99',
            'php' => '5.5.0-0.0.0'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'In2code\\Fetchurl\\' => 'Classes'
        ]
    ],
];
