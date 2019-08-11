<?php
/* * *************************************************************
 * Extension Manager/Repository config file for ext: "fe_upload_example"
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 * ************************************************************* */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Frontend file upload example',
    'description' => 'An example extension to show upload of files in TYPO3 frontend.',
    'category' => 'plugin',
    'author' => 'Ephraim Härer',
    'author_email' => 'mail@ephra.im',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => true,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
            'media_upload' => '*',
            'php' => '7.0.0-7.3.99',
        ],
        'conflicts' => [],
        'suggests' => [
            'fal_securedownload' => '2.2.0-2.99.99',
        ],
    ],
];
