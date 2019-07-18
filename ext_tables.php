<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function ($extKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'EHAERER.' . $extKey, 'Feupex', 'Frontend file upload example'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_feuploadexample_domain_model_project',
        'EXT:fe_upload_example/Resources/Private/Language/locallang_csh_tx_feuploadexample_domain_model_project.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_feuploadexample_domain_model_project');

    /* load flexform for backend config */
    $pluginSignature = str_replace('_', '', $extKey) . '_' . 'feupex';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature,
        'FILE:EXT:' . $extKey . '/Configuration/FlexForm/ControllerActions.xml');
}, 'fe_upload_example');


