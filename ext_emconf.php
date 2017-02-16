<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "powermail".
 *
 * Auto generated 04-07-2013 17:03
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'fetchurl',
    'description' => 'Fetch an url and show the content in Frontend. 
        This is an alternative to a iframe solution. Contained image or link URIs are rewritten accordingly.',
    'category' => 'plugin',
    'shy' => 0,
    'version' => '3.3.1',
    'dependencies' => 'cms,extbase,fluid',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => 1,
    'lockType' => '',
    'author' => 'Alex Kellner (original Jörg Delker)',
    'author_email' => 'alexander.kellner@in2code.de',
    'author_company' => 'in2code.de',
    'CGLcompliance' => '',
    'CGLcompliance_note' => '',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.99.99',
            'extbase' => '7.6.0-8.99.99',
            'fluid' => '7.6.0-8.99.99',
            'php' => '5.5.0-0.0.0'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    '_md5_values_when_last_written' => '',
];
