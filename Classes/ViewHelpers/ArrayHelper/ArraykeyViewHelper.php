<?php

namespace EHAERER\FeUploadExample\ViewHelpers\ArrayHelper;

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

/**
 * ViewHelper to check if array key is set and return it
 * # Example: Basic example
 * <code>
 * {r:arrayHelper.arraykey(array:'{files}',key:'{project.uid}',subkey:'images')}
 * </code>
 * <output>
 * TRUE or FALSE
 * </output>
 *
 * @package TYPO3
 * @subpackage fe_upload_example
 */
class ArraykeyViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('array', 'mixed', 'Array to find in', true);
        $this->registerArgument('key', 'string', 'Key to find', true);
        $this->registerArgument('subkey', 'string', 'Subkey to find', false, '');
    }

    /**
     * check if array key with or without subkey is set and return it
     *
     * @param mixed $array
     * @param string $key
     * @param string $subkey
     * @return array
     */
    public function render($array, $key, $subkey = '')
    {
        if (is_array($array)) {
            if (!empty($subkey) && array_key_exists($key,
                    $array) && isset($array[$key][$subkey]) && !empty($array[$key][$subkey])) {
                return $array[$key][$subkey];
            } else {
                if (array_key_exists($key, $array)) {
                    return $array[$key];
                } else {
                    return array();
                }
            }
        } else {
            return array();
        }
    }
}
