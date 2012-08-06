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
require_once(PATH_tslib.'class.tslib_pibase.php');


class tx_sysjobs_jobs_view extends tslib_pibase
{
    var $prefixId      = 'tx_sysjobs_jobs_view';		// Same as class name
    var $scriptRelPath = 'pi1/class.tx_sysjobs_jobs_view.php';	// Path to this script relative to the extension dir.
    var $extKey        = 'sysjobs';	// The extension key.
    var $conf;
    var $cObj;
    var $templateCode;

    function __construct($conf){
        parent::tslib_pibase();
        $this->pi_loadLL();
        $this->conf = $conf;
        $this->cObj = $GLOBALS['TSFE']->cObj; // beihnhaltet das typoscript contentobject
        $this->templateCode = $this->cObj->fileResource($this->conf['templateFile']);
    }

    /**
     * Gibt den Stellentitel in der listeansicht zurück und den Titel in einen Link
     *
     * @param $joblist
     * @return einen oder mehrere Stellentitel
     */
    function showJobList($jobList){

        $jobListTemplate = $this->cObj->getSubpart($this->templateCode, '###JOBLIST###');

        $jobItemTemplate = $this->cObj->getSubpart($jobListTemplate, '###JOBITEM###');

        $htmlJobList = '';


        foreach($jobList as $job){
            $JobTitleLinked = "<a href='index.php?id=" . $this->conf['singlePID'] . "&no_cache=1&tx_sysjobs_pi1%5BshowUid%5D=" . $job->uid . "'>" . $job->title . "</a>";
            $htmlJobList .= $this->cObj->substituteMarkerArray(
                $jobItemTemplate, array(
                    '###JOBTITLE###' => $JobTitleLinked,

                )
            );
        }

        $finalList = $this->cObj->substituteMarkerArrayCached(
            $jobListTemplate, array(), array(
                '###JOBITEM###' => $htmlJobList
            )
        );

        return $finalList;

    }



    /**
     * Weist die einzelnen Eigenschaften den Marker im Frontend für die Detailansicht zu
     *
     * @param $jobDetails
     * @param $requirements
     * @return Zuweisungen einzelner Marker
     */
    function showDetails($jobDetails, $requirements){

            $requirementHtml = '';
            foreach($requirements as $requirement){
                $requirementHtml .= $requirement["title"] . ", " ;
            }

        $jobDetailTemplate = $this->cObj->getSubpart($this->templateCode, '###JOBDETAIL###');

        $jobDetailMarkers = array(
            '###TITLE###' => $jobDetails->title,
            '###ABOUTCOMPANY###' => $this->pi_getLL('tx_sysjobs_jobs_view.aboutus'),
            '###COMPANYINFO###' => $jobDetails->company_info,
            '###LEADINTITLE###' => $this->pi_getLL('tx_sysjobs_jobs_view.leadintitle'),
            '###LEADIN###' => $jobDetails->leadin,
            '###DESCRIPTIONTITLE###' => $this->pi_getLL('tx_sysjobs_jobs_view.discriptiontitle'),
            '###DESCRIPTION###' => $jobDetails->description,
            '###REQUIREMENTSTITLE###' => $this->pi_getLL('tx_sysjobs_jobs_view.requirementstitle'),
            '###REQUIREMENTS###' => $requirementHtml,
            '###CONTACTTITLE###' => $this->pi_getLL('tx_sysjobs_jobs_view.contacttitle'),
            '###CONTACTNAME###' => $jobDetails->contact_name,
            '###CONTACTEMAIL###' => $jobDetails->contact_email,
            '###CONFIRMATIONTITLE###' => $this->pi_getLL('tx_sysjobs_jobs_view.confirmationtitle'),
            '###CONFIRMATIONINFO###' => $this->pi_getLL('tx_sysjobs_jobs_view.confirmationinfo'),
        );


        $details = $this->cObj->substituteMarkerArrayCached(
            $jobDetailTemplate,
            $jobDetailMarkers
        );
        return $details;
    }



    /**
     * Weist die einzelnen Eigenschaften den Marker im Frontend für das Formular.
     *
     *
     * @return weisst Inhalte den Markern zu
     */


    function showApplicantForm($jobUid, $mustRequirement_0, $mustRequirement_1, $mustRequirement_2, $mustRequirement_3, $mustRequirement_4, $mustRequirement_5,
                               $mustRequirement_id_0, $mustRequirement_id_1, $mustRequirement_id_2, $mustRequirement_id_3, $mustRequirement_id_4, $mustRequirement_id_5){

        $jobApplicantFormTemplate = $this->cObj->getSubpart($this->templateCode, '###JOBFORM###');

        $jobApplicantsFormMarkers = array(
            '###NAME###' => $this->pi_getLL('tx_sysjobs_jobs_view.name'),
            '###FIRSTNAME###' => $this->pi_getLL('tx_sysjobs_jobs_view.firstname'),
            '###ADRESS###' => $this->pi_getLL('tx_sysjobs_jobs_view.adress'),
            '###ZIP###' => $this->pi_getLL('tx_sysjobs_jobs_view.zip'),
            '###CITY###' => $this->pi_getLL('tx_sysjobs_jobs_view.city'),
            '###EMAIL###' => $this->pi_getLL('tx_sysjobs_jobs_view.email'),
            '###CONTACTPHONEPRIVATE###' => $this->pi_getLL('tx_sysjobs_jobs_view.contact_phone_private'),
            '###CONTACTPHONEMOBILE###' => $this->pi_getLL('tx_sysjobs_jobs_view.contact_phone_mobile'),
            '###PROFIL###' => $this->pi_getLL('tx_sysjobs_jobs_view.profil'),
            '###MUSTREQUIREMENT0###' => $mustRequirement_0,
            '###REQUIREMENTID0###' => $mustRequirement_id_0,
            '###MUSTREQUIREMENT1###' => $mustRequirement_1,
            '###REQUIREMENTID1###' => $mustRequirement_id_1,
            '###MUSTREQUIREMENT2###' => $mustRequirement_2,
            '###REQUIREMENTID2###' => $mustRequirement_id_2,
            '###MUSTREQUIREMENT3###' => $mustRequirement_3,
            '###REQUIREMENTID3###' => $mustRequirement_id_3,
            '###MUSTREQUIREMENT4###' => $mustRequirement_4,
            '###REQUIREMENTID4###' => $mustRequirement_id_4,
            '###MUSTREQUIREMENT5###' => $mustRequirement_5,
            '###REQUIREMENTID5###' => $mustRequirement_id_5,
            '###APPLICATION###' => $this->pi_getLL('tx_sysjobs_jobs_view.application'),
            '###COMMENT###' => $this->pi_getLL('tx_sysjobs_jobs_view.comment'),
            '###SUBMIT###' => $this->pi_getLL('tx_sysjobs_jobs_view.submit'),
            '###FORMACTION###' => $this->pi_getPageLink($GLOBALS['TSFE']->id),
            '###NOTVALIDNAME###' => "",
            '###NOTVALIDFIRSTNAME###' => "",
            '###NOTVALIDADRESS###' => "",
            '###NOTVALIDZIP###' => "",
            '###NOTVALIDCITY###' => "",
            '###NOTVALIDEMAIL###' => "",
            '###NOTVALIDCONTACTPHONEPRIVATE###' => "",
            '###NOTVALIDCONTACTPHONEMOBILE###' => "",
            '###JOBUID###' => $jobUid,
            '###SHOWUID###' => $jobUid,
            '###NVNAME###' => "",
            '###NVFIRSTNAME###' => "",
            '###NVADRESS###' => "",
            '###NVZIP###' => "",
            '###NVCITY###' => "",
            '###NVEMAIL###' => "",
            '###NVCONTACTPHONEPRIVATE###' => "",
            '###NVCONTACTPHONEMOBILE###' => "",

        );

        $form = $this->cObj->substituteMarkerArrayCached(
            $jobApplicantFormTemplate,
            $jobApplicantsFormMarkers
        );
        return $form;
    }



    function showIfNotValid($nValid, $valueName, $valueFirstname, $valueAdress, $valueZip, $valueCity, $valueEmail, $valueContactPhonePrivate, $valueContactPhoneMobile, $jobUid){


                if (in_array("name", $nValid)){
                    $nVname = $this->pi_getLL('tx_sysjobs_jobs_view.notvalidname');
                }

                if (in_array("firstname", $nValid)){
                    $nVfirstname = $this->pi_getLL('tx_sysjobs_jobs_view.notvalidfirstname');
                }

                if (in_array("adress", $nValid)){
                    $nVadress = $this->pi_getLL('tx_sysjobs_jobs_view.notvalidadress');
                }

                if (in_array("zip", $nValid)){
                    $nVzip = $this->pi_getLL('tx_sysjobs_jobs_view.notvalidzip');
                }

                if (in_array("city", $nValid)){
                    $nVcity = $this->pi_getLL('tx_sysjobs_jobs_view.notvalidcity');
                }

                if (in_array("email", $nValid)){
                    $nVemail = $this->pi_getLL('tx_sysjobs_jobs_view.notvalidemail');
                }

                if (in_array("contact_phone_private", $nValid)){
                    $nVcontactPhonePrivate = $this->pi_getLL('tx_sysjobs_jobs_view.notvalidcontactphoneprivate');
                }

                if (in_array("contact_phone_mobile", $nValid)){
                    $nVcontactPhoneMobile = $this->pi_getLL('tx_sysjobs_jobs_view.notvalidcontactphonemobile');
                }




        $jobApplicantValidForm = $this->cObj->getSubpart($this->templateCode, '###JOBFORM###');

        $jobApplicantsValidFormMarkers = array(
            '###NAME###' => $this->pi_getLL('tx_sysjobs_jobs_view.name'),
            '###FIRSTNAME###' => $this->pi_getLL('tx_sysjobs_jobs_view.firstname'),
            '###ADRESS###' => $this->pi_getLL('tx_sysjobs_jobs_view.adress'),
            '###ZIP###' => $this->pi_getLL('tx_sysjobs_jobs_view.zip'),
            '###CITY###' => $this->pi_getLL('tx_sysjobs_jobs_view.city'),
            '###EMAIL###' => $this->pi_getLL('tx_sysjobs_jobs_view.email'),
            '###CONTACTPHONEPRIVATE###' => $this->pi_getLL('tx_sysjobs_jobs_view.contact_phone_private'),
            '###CONTACTPHONEMOBILE###' => $this->pi_getLL('tx_sysjobs_jobs_view.contact_phone_mobile'),
            '###PROFIL###' => $this->pi_getLL('tx_sysjobs_jobs_view.profil'),
            '###APPLICATION###' => $this->pi_getLL('tx_sysjobs_jobs_view.application'),
            '###COMMENT###' => $this->pi_getLL('tx_sysjobs_jobs_view.comment'),
            '###SUBMIT###' => $this->pi_getLL('tx_sysjobs_jobs_view.submit'),
            '###FORMACTION###' => $this->pi_getPageLink($GLOBALS['TSFE']->id),
            '###NOTVALIDNAME###' => $nVname,
            '###NOTVALIDFIRSTNAME###' => $nVfirstname,
            '###NOTVALIDADRESS###' => $nVadress,
            '###NOTVALIDZIP###' => $nVzip,
            '###NOTVALIDCITY###' => $nVcity,
            '###NOTVALIDEMAIL###' => $nVemail,
            '###NOTVALIDCONTACTPHONEPRIVATE###' => $nVcontactPhonePrivate,
            '###NOTVALIDCONTACTPHONEMOBILE###' => $nVcontactPhoneMobile,
            '###JOBUID###' => $jobUid,
            '###SHOWUID###' => $jobUid,
            '###NVNAME###' => $valueName,
            '###NVFIRSTNAME###' => $valueFirstname,
            '###NVADRESS###' => $valueAdress,
            '###NVZIP###' => $valueZip,
            '###NVCITY###' => $valueCity,
            '###NVEMAIL###' => $valueEmail,
            '###NVCONTACTPHONEPRIVATE###' => $valueContactPhonePrivate,
            '###NVCONTACTPHONEMOBILE###' => $valueContactPhoneMobile,
        );

         $nVForm = $this->cObj->substituteMarkerArrayCached(
             $jobApplicantValidForm,
             $jobApplicantsValidFormMarkers
         );

        return $nVForm;

    }

    function confirmation(){

        $jobConfirmation = $this->cObj->getSubpart($this->templateCode, '###JOBCONFIRMATION###');

        $jobConfirmationMarkers = array(
             '###CONFIRMATIONTITLE###' => $this->pi_getLL('tx_sysjobs_jobs_view.confirmationtitle'),
             '###CONFIRMATIONINFO###' => $this->pi_getLL('tx_sysjobs_jobs_view.confirmationinfo'),
            );

        $confirmation = $this->cObj->substituteMarkerArrayCached(
            $jobConfirmation,
            $jobConfirmationMarkers
        );

        return $confirmation;
    }

}

?>
