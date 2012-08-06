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

class tx_sysjobs_jobs_model
{
    var $prefixId      = 'tx_sysjobs_jobs_model';                // Same as class name
    var $scriptRelPath = 'pi1/models/class.tx_sysjobs_jobs_model.php';        // Path to this script relative to the extension dir.
    var $extKey        = 'sysjobs';        // The extension key.
    var $tableName = 'tx_sysjobs_jobs';
    var $uid;
    var $title;
    var $company_name;
    var $company_info;
    var $leadin;
    var $description;
    var $contact_name;
    var $contact_phone;
    var $contact_email;
    var $requirements;
    static $tableJobs = 'tx_sysjobs_jobs'; // tabelle ihn varibale
    static $tableRequirements = 'tx_sysjobs_requirements';


    function __construct($title, $company_name, $company_info, $leadin, $description, $contact_name, $contact_phone, $contact_email, $requirements, $uid){
        $this->title = $title;
        $this->company_name = $company_name;
        $this->company_info = $company_info;
        $this->leadin = $leadin;
        $this->description = $description;
        $this->contact_name = $contact_name;
        $this->contact_phone = $contact_phone;
        $this->contact_email = $contact_email;
        $this->requirements = $requirements;
        $this->uid = $uid;
    }




    function formValidation($name, $firstname, $adress, $zip, $city, $contact_email, $contact_phone_private, $contact_phone_mobile){



        $nameRegex = "/^[a-zA-ZàáâäãåèéêëìíîïòóôöõøùúûüÿýñçčšžÀÁÂÄÃÅÈÉÊËÌÍÎÏÒÓÔÖÕØÙÚÛÜŸÝÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";
        $firstnameRegex = "/^[a-zA-ZàáâäãåèéêëìíîïòóôöõøùúûüÿýñçčšžÀÁÂÄÃÅÈÉÊËÌÍÎÏÒÓÔÖÕØÙÚÛÜŸÝÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";
        $zipRegex = "/[+0-9]+/";
        $cityRegex = "/^[a-zA-ZàáâäãåèéêëìíîïòóôöõøùúûüÿýñçčšžÀÁÂÄÃÅÈÉÊËÌÍÎÏÒÓÔÖÕØÙÚÛÜŸÝÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";
        $contactEmailRegex = "/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/";
        $contactPhoneRegex = "/^[0-9]{1,10}$/";


        $nValid = array();

        if(0 < strlen($name)=== false){
            $nValid[] = "name";
        }

        if(0 < strlen($firstname)=== false){
            $nValid[] = "firstname";
        }

        if(0 < strlen($adress)=== false){
            $nValid[] = "adress";
        }

        if(4 <= strlen($zip)=== false){
            $nValid[] = "zip";
        }

        if(3 <= strlen($city)=== false){
            $nValid[] = "city";
        }

        if(!preg_match($contactEmailRegex, $contact_email)){
            $nValid[] = "email";
        }

        if(8 <= strlen($contact_phone_private)=== false){
            $nValid[] = "contact_phone_private";
        }

        if(9 < strlen($contact_phone_mobile)=== false){
            $nValid[] = "contact_phone_mobile";
        }


        return $nValid;
    }




    /**
     * Sucht nach allen Datenbank einträgen in der Tabelle
     *
     * @static
     * @return Array mit den gefunden Stellenangeboten zurück
     */
    static function findAll($jobsPID){
        $cObj = $GLOBALS['TSFE']->cObj; // beihnhaltet das typoscript contentobject
        $whereQuery = $cObj->enableFields(self::$tableJobs);


        if(is_null($jobsPID)){
            $where = substr($whereQuery, 5);
        }
        else{
            $where = 'pid =' . $jobsPID . $whereQuery;
        }

        $selectRows = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'title, company_name, company_info, leadin, description, contact_name, contact_phone, contact_email, requirements, uid',
            self::$tableJobs ,
            $where);


        $result =array();
        while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($selectRows)){
            $job = t3lib_div::makeInstance('tx_sysjobs_jobs_model', $row["title"], $row["company_name"],
                                            $row["company_info"], $row["leadin"], $row["description"], $row["contact_name"],
                                            $row["contact_phone"], $row["contact_email"],
                                            $row["requirements"], $row["uid"]);
            array_push($result, $job);
        }
        return $result;
    }

    /**
     * Sucht einen Eintrag mit der UID
     * und gibt ein Objekt mit dem Inhalt eines Stelleninserat zurück.
     *
     * @static
     * @param $uid
     * @return STelleninserat mit vorgegebener UID
     */
    static function findByUid($uid){
        $cObj = $GLOBALS['TSFE']->cObj;
        $whereQuery = 'uid =' . $uid . $cObj->enableFields(self::$tableJobs);

        $selectRowWhereUid = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
            'title, company_name, company_info, leadin, description, contact_name, contact_phone, contact_email, requirements',
            self::$tableJobs ,
            $whereQuery);


        $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($selectRowWhereUid);
        $job = t3lib_div::makeInstance('tx_sysjobs_jobs_model', $row["title"], $row["company_name"],
            $row["company_info"], $row["leadin"], $row["description"], $row["contact_name"],
            $row["contact_phone"], $row["contact_email"],
            $row["requirements"]);
        return $job;

    }

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sysjobs/pi1/class.tx_sysjobs_pi1.php'])	{
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sysjobs/pi1/class.tx_sysjobs_pi1.php']);
}

?>
