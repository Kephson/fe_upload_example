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
use \EHAERER\FeUploadExample\Controller\AbstractController;
use \TYPO3\CMS\Extbase\Annotation\IgnoreValidation;

/**
 * ProjectController
 */
class ProjectController extends AbstractController
{

    /**
     * @var \Fab\MediaUpload\Service\UploadFileService
     * @inject
     */
    protected $uploadFileService;

    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory
     * @inject
     */
    protected $resourceFactory;

    /**
     * projectRepository
     *
     * @var \EHAERER\FeUploadExample\Domain\Repository\ProjectRepository
     * @inject
     */
    protected $projectRepository = null;

    /**
     * action list
     *
     * @return void
     * @throws
     */
    public function listAction()
    {
        $isUserAdmin = $this->isUserAdmin();
        $searchValue = $this->getSearchValue('projectSearch');
        if ($isUserAdmin) {
            $projects = $this->projectRepository->findWithSearchField($searchValue, true);
        } else {
            $projects = $this->projectRepository->findWithSearchField($searchValue, false, $this->feUser['uid']);
        }
        $files = $this->getMultipleFileData($projects);
        //DebuggerUtility::var_dump($files);
        $this->view->assignMultiple([
            'projects' => $projects,
            'feUser' => $this->feUser,
            'settings' => $this->settings,
            'config' => $this->config,
            'files' => $files,
            'isUserAdmin' => $isUserAdmin,
            'searchValue' => $searchValue,
        ]);
    }

    /**
     * action listShared
     *
     * @return void
     * @throws
     */
    public function listSharedAction()
    {
        $isUserAdmin = $this->isUserAdmin();
        $searchValue = $this->getSearchValue('projectSearch');
        if ($isUserAdmin) {
            $projects = $this->projectRepository->findWithSearchField($searchValue, true);
        } else {
            $projects = $this->projectRepository->findWithSearchField($searchValue, false, $this->feUser['uid'], true);
        }
        $files = $this->getMultipleFileData($projects);
        //DebuggerUtility::var_dump($files);
        $this->view->assignMultiple([
            'projects' => $projects,
            'feUser' => $this->feUser,
            'settings' => $this->settings,
            'config' => $this->config,
            'files' => $files,
            'isUserAdmin' => $isUserAdmin,
            'searchValue' => $searchValue,
        ]);
    }

    /**
     * action show
     *
     * @param integer $project
     * @return void
     * @throws
     */
    public function showAction($project = 0)
    {
        if ((int)$project > 0) {
            $showProject = $this->projectRepository->findByUid((int)$project);

            if (!is_null($showProject)) {
                $fileReferences = $showProject->getFiles();
                //DebuggerUtility::var_dump(count(get_object_vars($fileReferences)));
                $files = $this->getFileData($fileReferences);

                $this->view->assignMultiple([
                    'project' => $showProject,
                    'feUser' => $this->feUser,
                    'settings' => $this->settings,
                    'config' => $this->config,
                    'files' => $files,
                    'isUserAdmin' => $this->isUserAdmin(),
                ]);
            }
        }
    }

    /**
     * Load file references and sort them by type image or document
     *
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $projects
     * @return array
     */
    protected function getMultipleFileData($projects)
    {
        $files = [];
        foreach ($projects as $project) {
            $projectUid = $project->getUid();
            $fileReferences = $project->getFiles();
            $files[$projectUid] = $this->getFileData($fileReferences);
        }
        return $files;
    }

    /**
     * Load file references and sort them by type image or document
     *
     * @param array $fileReferences
     * @return array
     */
    protected function getFileData($fileReferences)
    {
        $files = [
            'images' => [],
            'documents' => [],
        ];

        if (!is_null($fileReferences)) {
            foreach ($fileReferences as $fileReference) {
                /** @var \TYPO3\CMS\Core\Resource\File $fileResource */
                $fileResource = $fileReference->getOriginalResource();
                $properties = $fileResource->getProperties();
                $properties['publicUrl'] = $fileResource->getPublicUrl();
                $properties['fileReferenceUid'] = $fileReference->getUid();

                // check for image
                if (stripos($properties['mime_type'], 'image') === false) {
                    $files['documents'][] = $properties;
                } else {
                    $files['images'][] = $properties;
                }
            }
        }
        if (empty($files['images'])) {
            unset($files['images']);
        }
        if (empty($files['documents'])) {
            unset($files['documents']);
        }

        return $files;
    }

    /**
     * action new
     *
     * @return void
     * @throws
     */
    public function newAction()
    {
        $this->view->assignMultiple([
            'settings' => $this->settings,
        ]);
    }

    /**
     * action initializeCreate
     *
     * @return void
     * @throws
     */
    public function initializeCreateAction()
    {
        if ($this->arguments->hasArgument('project')) {
            $this->arguments->getArgument('project')->getPropertyMappingConfiguration()->skipProperties('files');
        }
    }

    /**
     * action create
     *
     * @param \EHAERER\FeUploadExample\Domain\Model\Project $project
     * @return void
     * @throws
     */
    public function createAction(\EHAERER\FeUploadExample\Domain\Model\Project $project)
    {

        if (isset($this->feUser['uid']) && (int)$this->feUser['uid'] > 0) {
            $project->setFeUserId($this->frontendUserRepository->findByUid($this->feUser['uid']));
        }

        $fileReferences = $this->getUploadedFiles();
        $project->setFiles($fileReferences);

        $this->addFlashMessage(LocalizationUtility::translate('mes_newProject', $this->config['extKey']), '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::NOTICE);
        $this->projectRepository->add($project);
        $this->clearCacheForPids($GLOBALS['TSFE']->id);
        $this->redirect($this->getRedirectListAction());
    }

    /**
     * action edit
     *
     * @param \EHAERER\FeUploadExample\Domain\Model\Project $project
     * @IgnoreValidation("project")
     * @return void
     * @throws
     */
    public function editAction(\EHAERER\FeUploadExample\Domain\Model\Project $project)
    {
        //DebuggerUtility::var_dump($GLOBALS['TSFE']->fe_user->groupData);
        $fileReferences = $project->getFiles();
        //DebuggerUtility::var_dump(count(get_object_vars($fileReferences)));
        $files = $this->getFileData($fileReferences);

        $this->view->assignMultiple([
            'project' => $project,
            'files' => $files,
            'settings' => $this->settings,
        ]);
    }

    /**
     * action initializeUpdate
     *
     * @return void
     * @throws
     */
    public function initializeUpdateAction()
    {
        if ($this->arguments->hasArgument('project')) {
            $this->arguments->getArgument('project')->getPropertyMappingConfiguration()->skipProperties('files');
        }
    }

    /**
     * action update
     *
     * @param \EHAERER\FeUploadExample\Domain\Model\Project $project
     * @return void
     * @throws
     */
    public function updateAction(\EHAERER\FeUploadExample\Domain\Model\Project $project)
    {
        $projectUser = $project->getFeUserId();
        // make sure the project belongs to the user
        if ((int)$projectUser !== (int)$GLOBALS['TSFE']->fe_user->user['uid'] && !$this->isUserAdmin()) {
            $this->redirect($this->getRedirectListAction());
        }

        $oldFileReferences = $project->getFiles();
        $fileReferences = $this->getUploadedFiles($oldFileReferences);
        $project->setFiles($fileReferences);

        $this->addFlashMessage(LocalizationUtility::translate('mes_projectUpdated', $this->config['extKey']), '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::NOTICE);
        $this->projectRepository->update($project);
        $this->clearCacheForPids($GLOBALS['TSFE']->id);
        $this->redirect($this->getRedirectListAction());
    }

    /**
     * action delete
     *
     * @param \EHAERER\FeUploadExample\Domain\Model\Project $project
     * @return void
     * @throws
     */
    public function deleteAction(\EHAERER\FeUploadExample\Domain\Model\Project $project = null)
    {
        if ($project !== null && $this->isUserAdmin()) {
            if ($this->request->hasArgument('reallydelete') && (int)$this->request->getArgument('reallydelete') === 1) {
                $this->addFlashMessage(LocalizationUtility::translate('mes_projectDeleted', $this->config['extKey']),
                    '', \TYPO3\CMS\Core\Messaging\AbstractMessage::NOTICE);
                // possible: delete file references here
                $this->projectRepository->remove($project);
                $this->clearCacheForPids($GLOBALS['TSFE']->id);
                $this->redirect($this->getRedirectListAction());
            } else {
                //DebuggerUtility::var_dump($trip);
                $this->view->assign('project', $project);
            }
        } else {
            $this->redirect($this->getRedirectListAction());
        }
    }

    /**
     * get the uploaded files from media_upload and move them to specified user folder
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $oldFileReferences
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $fileReferences
     * @throws
     */
    protected function getUploadedFiles($oldFileReferences = null)
    {
        /** @var array $uploadedFiles */
        # A property name is needed in case specified in the Fluid Widget
        # <mu:widget.upload property="projectfiles"/>
        $uploadedFiles = $this->uploadFileService->getUploadedFiles('projectfiles');
        if (is_object($oldFileReferences) && count($oldFileReferences) > 0) {
            $fileReferences = $oldFileReferences;
        } else {
            $fileReferences = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class);
        }
        # Process uploaded files and move them into a Resource Storage (FAL)
        foreach ($uploadedFiles as $uploadedFile) {

            // @var \Fab\MediaUpload\UploadedFile $uploadedFile
            $uploadedFileData = [
                'tmp_name' => $uploadedFile->getTemporaryFileNameAndPath(),
                'name' => $uploadedFile->getFileName(),
                'size' => $uploadedFile->getSize(),
            ];

            /* @var $storage \TYPO3\CMS\Core\Resource\ResourceStorage */
            $storage = ResourceFactory::getInstance()->getStorageObject($this->settings['filestorage']);
            $userFolder = 'data_user_' . $this->feUser['uid'];
            if ($storage->hasFolder($userFolder)) {
                $folder = $storage->getFolder($userFolder);
            } else {
                $folder = $storage->createFolder($userFolder);
            }

            //$folder = $storage->getRootLevelFolder();// . 'projects_user_' . $this->feUser['uid'];
            // @var File $file
            $file = $storage->addFile($uploadedFile->getTemporaryFileNameAndPath(), $folder, $uploadedFileData['name']);

            //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($file);
            // Create File Reference
            /* @var $newFileReference \EHAERER\FeUploadExample\File\FileReference */
            $newFileReference = $this->objectManager->get(\EHAERER\FeUploadExample\File\FileReference::class);
            $newFileReference->setFile($file);
            $fileReferences->attach($newFileReference);
        }

        return $fileReferences;
    }

    /**
     * Get the correct action for redirect
     *
     * @return string
     */
    protected function getRedirectListAction()
    {
        $flexFormValue = $this->configurationManager->getContentObject()->getFieldVal('pi_flexform');
        /* @var $flexFormService \TYPO3\CMS\Extbase\Service\FlexFormService */
        $flexFormService = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Service\FlexFormService::class);
        $ffContent = $flexFormService->convertFlexFormContentToArray($flexFormValue);
        $action = 'list';
        if (isset($ffContent['switchableControllerActions']) && strpos($ffContent['switchableControllerActions'],
                'listShared') > -1) {
            $action = 'listShared';
        }
        return $action;
    }
}
