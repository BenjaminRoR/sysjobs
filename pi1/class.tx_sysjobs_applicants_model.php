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
class tx_sysjobs_applicants_model
{
    var $prefixId      = 'tx_sysjobs_applicants_model';                // Same as class name
    var $scriptRelPath = 'pi1/class.tx_sysjobs_applicants_model.php';        // Path to this script relative to the extension dir.
    var $extKey        = 'sysjobs';        // The extension key.
    static $table = 'tx_sysjobs_applicants'; // tabelle ihn varibale
    var $name;
    var $firstname;
    var $adress;
    var $zip;
    var $city;
    var $contact_email;
    var $contact_phone_private;
    var $contact_phone_mobile;
    var $application;
    var $comment;
    var $requirement;


    function __construct($name, $firstname, $adress, $zip, $city, $contact_email, $contact_phone_private, $contact_phone_mobile, $application, $comment, $requirement){
        $this->name = $name;
        $this->firstname = $firstname;
        $this->adress = $adress;
        $this->zip = $zip;
        $this->city = $city;
        $this->contact_email = $contact_email;
        $this->contact_phone_private = $contact_phone_private;
        $this->contact_phone_mobile = $contact_phone_mobile;
        $this->application = $application;
        $this->comment = $comment;
        $this->requirement = $requirement;
    }


     /**
      * Speichert neuen Eintrag in die DB
      * Todo if else abfrage
      *
      * @param $name
      * @param $firstname
      * @param $adress
      * @param $zip
      * @param $city
      * @param $contact_email
      * @param $contact_phone_private
      * @param $contact_phone_mobile
      * @param $application
      * @param $jobUid
      * @param $comment
      * @return Gibt gespeicherten Inhalt zurück
      */
    function saveNewEntry($applicantPID, $crdate, $name, $firstname, $adress, $zip, $city, $contact_email, $contact_phone_private, $contact_phone_mobile, $application, $jobUid, $comment, $requirements){

        $fields = array('crdate'=>$crdate,
                        'name'=>$name,
                        'firstname'=>$firstname,
                        'adress'=>$adress,
                        'zip'=>$zip,
                        'city'=>$city,
                        'contact_email'=>$contact_email,
                        'contact_phone_private'=>$contact_phone_private,
                        'contact_phone_mobile'=>$contact_phone_mobile,
                        'application'=>$application,
                        'job_uid'=>$jobUid,
                        'comment'=>$comment,
                        'requirements' =>$requirements,
                        'pid'=>$applicantPID);




        $insertRow = $GLOBALS['TYPO3_DB']->exec_INSERTquery(
            self::$table,
            $fields
        );

        return $insertRow;
    }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sysjobs/pi1/class.tx_applicants_model.php'])        {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sysjobs/pi1/class.tx_sysjobs_applicants_model.php']);
}

?>

