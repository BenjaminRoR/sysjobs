<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Benjamin Amir <benjamin.amir@sysinf.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 ***************************************************************/
class tx_sysjobs_requirements_model
{

    var $prefixId      = 'tx_sysjobs_jobs_model';                // Same as class name
    var $scriptRelPath = 'pi1/models/class.tx_sysjobs_jobs_model.php';        // Path to this script relative to the extension dir.
    var $extKey        = 'sysjobs';        // The extension key.
    var $tableName = 'tx_sysjobs_jobs';
    var $uid;
    static $tableJobs = 'tx_sysjobs_jobs'; // tabelle ihn varibale
    static $tableRequirements = 'tx_sysjobs_requirements';


    function __construct($uid){
        $this->uid = $uid;
    }


    static function getUid($uid, $field){
        $cObj = $GLOBALS['TSFE']->cObj; // beihnhaltet das typoscript contentobject
        $whereQuery = 'uid =' . $uid . $cObj->enableFields(self::$tableJobs);


        $selectRow = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            $field,
            self::$tableJobs,
            $whereQuery);

        $array_result = mysql_fetch_array($selectRow);
        $requirementUids = explode(',',$array_result[$field]);


        return $requirementUids;


    }






    /**
     * Liest die Anforderungen aus der Datenbank aus
     *
     * @static
     * @param $uid
     * @return Array mit Anforderungen
     */

    static function getRequirementTitleByUid($uid, $field){
        $cObj = $GLOBALS['TSFE']->cObj; // beihnhaltet das typoscript contentobject
        $whereQuery = 'uid =' . $uid . $cObj->enableFields(self::$tableJobs);


        $selectRow = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            $field,
            self::$tableJobs,
            $whereQuery);

        $array_result = mysql_fetch_array($selectRow);
        $requirementUids = explode(',',$array_result[$field]);


        $result = array();
        foreach ($requirementUids as $titleUid) {
            $whereQuery = 'uid =' . $titleUid . $cObj->enableFields(self::$tableRequirements);

            $selectTitle = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                'title',
                self::$tableRequirements,
                $whereQuery);


            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($selectTitle)){
                $title = $row;
                array_push($result, $title);
            }

        }
        return $result;
    }




}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sysjobs/pi1/class.tx_sysjobs_pi1.php'])	{
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sysjobs/pi1/class.tx_sysjobs_pi1.php']);
}

?>
