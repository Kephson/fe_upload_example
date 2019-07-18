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
     * city
     *
     * @var string
     * @validate notEmpty
     */
    protected $city = '';

    /**
     * ageOfFacade
     *
     * @var int
     */
    protected $ageOfFacade = 0;

    /**
     * facadeType
     *
     * @var string
     */
    protected $facadeType = '';

    /**
     * facadeSize
     *
     * @var int
     * @validate notEmpty
     * @validate integer
     */
    protected $facadeSize = 0;

    /**
     * facadeColor
     *
     * @var string
     */
    protected $facadeColor = '';

    /**
     * reason
     *
     * @var string
     * @validate notEmpty
     */
    protected $reason = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * files
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $files = null;

    /**
     * visibleAll
     *
     * @var boolean
     */
    protected $visibleAll = false;

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
     * Returns the city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the ageOfFacade
     *
     * @return int $ageOfFacade
     */
    public function getAgeOfFacade()
    {
        return $this->ageOfFacade;
    }

    /**
     * Sets the ageOfFacade
     *
     * @param int $ageOfFacade
     * @return void
     */
    public function setAgeOfFacade($ageOfFacade)
    {
        $this->ageOfFacade = $ageOfFacade;
    }

    /**
     * Returns the facadeType
     *
     * @return string $facadeType
     */
    public function getFacadeType()
    {
        return $this->facadeType;
    }

    /**
     * Sets the facadeType
     *
     * @param string $facadeType
     * @return void
     */
    public function setFacadeType($facadeType)
    {
        $this->facadeType = $facadeType;
    }

    /**
     * Returns the facadeSize
     *
     * @return int $facadeSize
     */
    public function getFacadeSize()
    {
        return $this->facadeSize;
    }

    /**
     * Sets the facadeSize
     *
     * @param int $facadeSize
     * @return void
     */
    public function setFacadeSize($facadeSize)
    {
        $this->facadeSize = $facadeSize;
    }

    /**
     * Returns the facadeColor
     *
     * @return string $facadeColor
     */
    public function getFacadeColor()
    {
        return $this->facadeColor;
    }

    /**
     * Sets the facadeColor
     *
     * @param string $facadeColor
     * @return void
     */
    public function setFacadeColor($facadeColor)
    {
        $this->facadeColor = $facadeColor;
    }

    /**
     * Returns the reason
     *
     * @return string $reason
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Sets the reason
     *
     * @param string $reason
     * @return void
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * Returns the visibleAll
     *
     * @return boolean $visibleAll
     */
    public function getVisibleAll()
    {
        return $this->visibleAll;
    }

    /**
     * Sets the visibleAll
     *
     * @param boolean $visibleAll
     * @return void
     */
    public function setVisibleAll($visibleAll)
    {
        $this->visibleAll = $visibleAll;
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
