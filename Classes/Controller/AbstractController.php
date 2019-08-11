<?php

namespace EHAERER\FeUploadExample\Controller;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2019 Ephraim Härer <mail@ephra.im>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use \TYPO3\CMS\Core\Resource\ResourceFactory;
use \TYPO3\CMS\Core\Messaging\FlashMessage;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\DebugUtility;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use \TYPO3\CMS\Extbase\Error\Message;
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * AbstractController
 */
class AbstractController extends ActionController
{

    /**
     * frontendUserRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository = null;

    /**
     * feUser
     *
     * @var array
     */
    protected $feUser = [];

    /**
     * config
     *
     * @var array
     */
    protected $config = [
        'languageFilePath' => 'LLL:EXT:fe_upload_example/Resources/Private/Language/locallang.xlf:',
        'extKey' => 'fe_upload_example',
        'translations' => [],
    ];

    /**
     * public constructor
     */
    public function __construct()
    {
        parent::__construct();

        if ($GLOBALS['TSFE']->fe_user->user['uid'] && (int)$GLOBALS['TSFE']->fe_user->user['uid'] > 0) {
            $this->feUser = $GLOBALS['TSFE']->fe_user->user;
        }
    }

    /**
     * Function to get search values from a request
     *
     * @param string $argument Required to find values
     * @param string $field Optional to get special search field, default is 'value'
     * @return string
     * @throws
     */
    protected function getSearchValue($argument = '', $field = 'value')
    {
        $value = '';
        if (!empty($argument) && $this->request->hasArgument($argument)) {
            $searchArguments = $this->request->getArgument($argument);
            if (!empty($field) && isset($searchArguments[$field])) {
                $value = $searchArguments[$field];
            }
        }
        return $value;
    }

    /**
     * overwrite default error messages
     *
     * @return string
     */
    protected function getErrorFlashMessage()
    {
        switch ($this->actionMethodName) {
            case 'createAction' :
            case 'updateAction' :
                return LocalizationUtility::translate('error_message_01', $this->config['extKey']);
            default:
                return parent::getErrorFlashMessage();
        }
    }

    /**
     * check for actual logged in FeUser for Admin rights
     * defined in Flexform in TYPO3 Backend
     *
     * @return boolean
     */
    protected function isUserAdmin()
    {
        $isAdmin = false;
        $userGroups = explode(',', $this->feUser['usergroup']);
        $adminGroups = explode(',', $this->settings['adminusergroup']);
        foreach ($adminGroups as $k => $value) {
            if (in_array($value, $userGroups, false)) {
                $isAdmin = true;
            }
        }
        return $isAdmin;
    }

    /**
     * read the mail receiver name and email from Flexform
     * format it as array
     *
     * @param string $setting mailreceiver|mailsender
     * @return array
     */
    protected function getMailSettings($setting = 'mailreceiver')
    {
        $receiver = [];
        if (isset($this->settings[$setting])) {
            $allReceiver = explode('|', $this->settings[$setting]);
            if (!empty($allReceiver)) {
                foreach ($allReceiver as $v) {
                    $r = explode('=', $v);
                    if (isset($r[0], $r[1])) {
                        $receiver[$r[1]] = $r[0];
                    }
                }
            }
        }
        return $receiver;
    }

    /**
     * clear cache for given pages as array or comma separated string
     *
     * @param mixed $pids
     * @return void
     */
    protected function clearCacheForPids($pids)
    {
        if (is_int($pids) || is_array($pids)) {
            $this->cacheService->clearPageCache($pids);
        }
        if (is_string($pids)) {
            $pidsToClear = explode(',', $pids);
            if (is_array($pidsToClear)) {
                $this->cacheService->clearPageCache($pidsToClear);
            }
        }
    }
}
