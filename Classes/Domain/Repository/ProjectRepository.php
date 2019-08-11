<?php

namespace EHAERER\FeUploadExample\Domain\Repository;

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

use \TYPO3\CMS\Extbase\Persistence\Repository;
use \TYPO3\CMS\Extbase\Persistence\QueryInterface;
use \TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * The repository for Projects
 */
class ProjectRepository extends Repository
{

    // default sorting
    protected $defaultOrderings = [
        'crdate' => QueryInterface::ORDER_DESCENDING,
    ];

    /**
     * Find projects with searchfield and user id
     *
     * @param string $searchValue
     * @param boolean $getAll
     * @param integer $userid
     * @param boolean $shared
     * @return QueryResultInterface
     * @throws
     */
    public function findWithSearchField($searchValue = '', $getAll = false, $userid = 0, $shared = false)
    {

        $query = $this->createQuery();

        $constraints = [];
        $searchValueConstraints = [];

        if (!empty($searchValue)) {
            $searchValueLike = '%' . $searchValue . '%';
            $searchValueConstraints[] = $query->like('name', $searchValueLike);
            $constraints[] = $query->logicalOr($searchValueConstraints);
            $query->matching($query->logicalOr($searchValueConstraints));
        }

        return $query->execute();
    }
}
