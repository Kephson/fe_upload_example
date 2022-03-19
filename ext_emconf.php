<?php /** @noinspection PhpUndefinedVariableInspection */
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
    'clearCacheOnLoad' => false,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
            'media_upload' => '*',
            'php' => '7.2.0-7.4.99',
        ],
        'conflicts' => [],
        'suggests' => [
            'fal_securedownload' => '3.0.0-3.99.99',
        ],
    ],
];
