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
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */
require_once(PATH_tslib.'class.tslib_pibase.php');
require_once(t3lib_extMgm::extPath('sysjobs').'pi1/class.tx_sysjobs_jobs_model.php');
require_once(t3lib_extMgm::extPath('sysjobs').'pi1/class.tx_sysjobs_requirements_model.php');
require_once(t3lib_extMgm::extPath('sysjobs').'pi1/class.tx_sysjobs_jobs_view.php');
require_once(t3lib_extMgm::extPath('sysjobs').'pi1/class.tx_sysjobs_applicants_model.php');


/**
 * Plugin 'Job offers' for the 'sysjobs' extension.
 *
 * @author	Benjamin Amir <benjamin.amir@sysinf.ch>
 * @package	TYPO3
 * @subpackage	tx_sysjobs
 */
class tx_sysjobs_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_sysjobs_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_sysjobs_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'sysjobs';	// The extension key.
	var $pi_checkCHash = true;
    var $viewMode;

    /**
     * The main method of the PlugIn
     * Gibt das Suchergebnis aus
     * Neues objekt vom typ tx_sysjobs_jobs_view wird instanziert
     * danach wird die funktion showJobsList aufgerufen.
     *
     * @param	string		$content: The PlugIn content
     * @param	array		$conf: The PlugIn configuration
     * @return	Content auf der Page aus
     */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
        $GLOBALS['TSFE']->pSetup['includeCSS.'][$this->extKey] = 'EXT:' . $this->extKey . '/css/tx_sysjobs_pi1.css';
        $this->pi_initPIflexForm();

        $this->viewMode = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'what_to_display');

        $isThereNotValid = $this->checkIfValid();
        $htmlContent = "";

        if($this->viewMode === 'job_apply'){
        if($this->piVars['job_uid'] > 0){
            $this->viewMode = "save_applicant_mode";
            }
        }

        switch($this->viewMode){
            case "job_list":
                $htmlContent .= $this->showList();
                break;
            case "job_detail":
                $htmlContent .= $this->showDetail();
                break;
            case "job_apply":
                $htmlContent .= $this->showForm();
                break;
            case "save_applicant_mode":
                if (!empty($isThereNotValid)){
                    $htmlContent .= $this->returnNotValidValue();
                } else
                    $htmlContent .= $this->confirmation();
                    $htmlContent .= $this->saveNewApplicant();
                break;
            default:
                $htmlContent .= $this->pi_getLL('viewMode_error');
        }

        return $this->pi_wrapInBaseClass($htmlContent);
	}

    /**
     * Sammelt Informationen zur Zusammenstellung der Listenansicht
     * Weist der View die Inhalte der einzelnen MArker zu
     *
     * @return eine unsortierte Liste zurück
     */
    function showList(){
        $allJobs = tx_sysjobs_jobs_model::findAll($this->conf['jobsPID']);

        $jobView = t3lib_div::makeInstance('tx_sysjobs_jobs_view', $this->conf);
        $jobList =  $jobView->showJoblist($allJobs);
        return $jobList;
    }

    /**
     * Stellt Detailansicht dar und weist den einzelnen Marker die Inhalte zu
     *
     *
     * @return gibt die details zurück einer Freien Stelle
     */


    function showDetail(){
        $job = tx_sysjobs_jobs_model::findByUid($this->piVars['showUid']);
        $requirements = tx_sysjobs_requirements_model::getRequirementTitleByUid($this->piVars['showUid'], 'requirements');


        $jobView = t3lib_div::makeInstance('tx_sysjobs_jobs_view', $this->conf);
        $jobDetail = $jobView->showDetails($job, $requirements);

        return $jobDetail;
    }


    /**
     *Generiert Formular
     *
     * @return gibt Formular zurück
     */
    function showForm(){
        $view = t3lib_div::makeInstance('tx_sysjobs_jobs_view', $this->conf);
        $mustRequirements = tx_sysjobs_requirements_model::getRequirementTitleByUid($this->piVars['showUid'],'must_requirements');
        $getUidMustRequirements = tx_sysjobs_requirements_model::getUid($this->piVars['showUid'],'must_requirements');



        $jobForm = $view->showApplicantForm($this->piVars['showUid'],
                                            $requirement_0 = implode("", $mustRequirements[0]),
                                            $requirement_1 = implode("", $mustRequirements[1]),
                                            $requirement_2 = implode("", $mustRequirements[2]),
                                            $requirement_3 = implode("", $mustRequirements[3]),
                                            $requirement_4 = implode("", $mustRequirements[4]),
                                            $requirement_5 = implode("", $mustRequirements[5]),
                                            $getUidMustRequirements[0],
                                            $getUidMustRequirements[1],
                                            $getUidMustRequirements[2],
                                            $getUidMustRequirements[3],
                                            $getUidMustRequirements[4],
                                            $getUidMustRequirements[5]);
        return $jobForm;
    }



    /**
     * Prüft ob gesendete Inhalte valid sind. Gibt einen array
     * zürck mit den nicht validen stellen.
     *
     * @return array[]
     */

    function checkIfValid(){
        $validationObject = t3lib_div::makeInstance('tx_sysjobs_jobs_model');
        $checkValid = $validationObject->formValidation($this->piVars['name'],
            $this->piVars['firstname'],
            $this->piVars['adress'],
            $this->piVars['zip'],
            $this->piVars['city'],
            $this->piVars['contact_email'],
            $this->piVars['contact_phone_private'],
            $this->piVars['contact_phone_mobile']);


        return $checkValid;
    }

    /**
     * Füllt nicht valide und valide Inhalte zurück ins Eingabefeld
     *
     *
     *
     * @return mixed
     */
    function returnNotValidValue(){
        $view = t3lib_div::makeInstance('tx_sysjobs_jobs_view', $this->conf);
        $jobnV = $view->showIfNotValid( $this->checkIfValid(),
                                        $this->piVars['name'],
                                        $this->piVars['firstname'],
                                        $this->piVars['adress'],
                                        $this->piVars['zip'],
                                        $this->piVars['city'],
                                        $this->piVars['contact_email'],
                                        $this->piVars['contact_phone_private'],
                                        $this->piVars['contact_phone_mobile'],
                                        $this->piVars['job_uid']);

        return $jobnV;
    }

    /**
     *Diese Funktion speichert beim Aufruf eine neue Bewerbung mit Bewerbungsdossier
     *und versendet Bestätigungsmail zum Bewerber und Mail mit Bewerberinfos zur verantwortlichen Person.
     */

    function saveNewApplicant(){

        if(isset($_FILES['tx_sysjobs_pi1']['name']['application/pdf'])) {
            $source = $_FILES['tx_sysjobs_pi1']['tmp_name']['application/pdf'];
            $destination = PATH_site.'fileadmin/bewerbungen/'.basename($_FILES['tx_sysjobs_pi1']['name']['application']);
            t3lib_div::upload_copy_move($source, $destination);
        }

        $id = array($this->piVars['mustrequirementid0'],
                    $this->piVars['mustrequirementid1'],
                    $this->piVars['mustrequirementid2'],
                    $this->piVars['mustrequirementid3'],
                    $this->piVars['mustrequirementid4'],
                    $this->piVars['mustrequirementid5']);



        $newObject = t3lib_div::makeInstance('tx_sysjobs_applicants_model');
        $newJob = $newObject->saveNewEntry( $this->conf['applicantsPID'],
                                            $crdate = time(),
                                            $this->piVars['name'],
                                            $this->piVars['firstname'],
                                            $this->piVars['adress'],
                                            $this->piVars['zip'],
                                            $this->piVars['city'],
                                            $this->piVars['contact_email'],
                                            $this->piVars['contact_phone_private'],
                                            $this->piVars['contact_phone_mobile'],
                                            $destination,
                                            $this->piVars['job_uid'],
                                            $this->piVars['comment'],
                                            $mustRequirement = implode(",", $id));



        $job_mail = tx_sysjobs_jobs_model::findByUid($this->piVars['showUid']);

        $to = $this->piVars['contact_email'];
        $toHR = $job_mail->contact_email;
        $jobTitle = $job_mail->title;
        $fromName = "syseca informatik AG";
        $fromMail = "jobs@sysinf.ch";
        $subject = "Bewerbung";
        $text = "Ihre Bewerbung ist bei uns eingegangen. Wir werden uns bei Ihnen melden. <br />"
                . "Vielen Dank für ihre Bewerbung";
        $textHR = "Bewerbung von: <br /><br />" .
                     "Job: " . $jobTitle . "<br />" .
                     "Name: " . $this->piVars['name'] . "<br />" .
                     "Vorname: " . $this->piVars['firstname'] .  "<br />" .
                     "Adresse: " . $this->piVars['adress'] .  "<br />" .
                     "Plz: " . $this->piVars['zip'] .  "<br />" .
                     "Ort: " . $this->piVars['city'] .  "<br />" .
                     "Email: " . $this->piVars['contact_email'] .  "<br />" .
                     "Tel. Privat: " . $this->piVars['contact_phone_private'] .  "<br />" .
                     "Tel. Mobile: " . $this->piVars['contact_phone_mobile'] .  "<br />";

        $file = $destination;
        $typ = "application/pdf";
        $attachment = fread(fopen($file, "r"), filesize($file));
        $attachment = chunk_split(base64_encode($attachment));
        $boundary = md5(uniqid(time()));
        $header = "From: ".$fromMail."\n";
        $header .= "To: " . $toHR . "\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Type: multipart/mixed; boundary=".$boundary."\n\n";
        $header .= "This is a multi-part message in MIME format -- Dies ist eine
                    mehrteilige Nachricht im MIME-Format.\n";
        $header .= "--".$boundary."\n";
        $header .= "Content-Type: text/html\n";
        $header .= "Content-Transfer-Encoding: 8bit\n\n";
        $header .= $textHR."\n";
        $header .= "--".$boundary."\n";
        $header .= "Content-Type: ".$typ."; name=\"".basename($file)."\"\n";
        $header .= "Content-Transfer-Encoding: base64\n";
        $header .= "Content-Disposition: attachment; filename=\"".basename($file)."\"\n\n";
        $header .= $attachment."\n";
        $header .= "--".$boundary."\n";



        mail($to, $subject, $text, "From: $fromName <$fromMail>");
        mail($toHR, $subject, "",$header);



    }


    function confirmation(){
        $view = t3lib_div::makeInstance('tx_sysjobs_jobs_view', $this->conf);
        $confirmation = $view->confirmation();
        return $confirmation;
    }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sysjobs/pi1/class.tx_sysjobs_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sysjobs/pi1/class.tx_sysjobs_pi1.php']);
}

?>