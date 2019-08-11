<?php

namespace EHAERER\FeUploadExample\Domain\Model;

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

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Project
 */
class Project extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Relation to the fe_users table
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $feUserId = null;

    /**
     * name
     *
     * @var string
     * @validate notEmpty
     */
    protected $name = '';

    /**
     * files
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $files = null;

    /**
     * crdate
     *
     * @var int
     */
    protected $crdate = null;

    /**
     * constructor for files object
     */
    public function __construct()
    {
        $this->files = new ObjectStorage();
    }

    /**
     * Returns the feUserId
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feUserId
     */
    public function getFeUserId()
    {
        return $this->feUserId;
    }

    /**
     * Sets the feUserId
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feUserId
     * @return void
     */
    public function setFeUserId($feUserId)
    {
        $this->feUserId = $feUserId;
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the files
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Domain\Model\FileReference> $files
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the files
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Domain\Model\FileReference> $files
     * @return void
     */
    public function setFiles($files)
    {
        if (is_a($files, '\TYPO3\CMS\Extbase\Persistence\ObjectStorage')) {
            $this->files = $files;
        }
    }

    /**
     * Returns the creation date
     *
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }
}
