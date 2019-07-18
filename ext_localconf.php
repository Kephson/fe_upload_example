<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function ($extKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'EHAERER.' . $extKey, 'Feupex', array(
        'Project' => 'list, listShared, show, new, create, edit, update, delete',
    ),
        // non-cacheable actions
        array(
            'Project' => 'create, update, delete',
        )
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    feupex {
                        iconIdentifier = fe-upload-example-icon
                        title = LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:' . $extKey . '.name
                        description = LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:' . $extKey . '.description
                        tt_content_defValues {
                            CType = list
                            list_type = feuploadexample_feupex
                        }
                    }
                }
                show = *
            }
       }'
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

    $iconRegistry->registerIcon(
        'fe-upload-example-icon',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/Example.svg']
    );
}, 'fe_upload_example');