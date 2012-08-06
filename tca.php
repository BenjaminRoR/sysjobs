<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


$TCA['tx_sysjobs_jobs'] = array (
	'ctrl' => $TCA['tx_sysjobs_jobs']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,starttime,endtime,title,company_name,company_info,leadin,description,contact_name,contact_phone,contact_email,requirements'
	),
	'feInterface' => $TCA['tx_sysjobs_jobs']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(3, 14, 7, 1, 19, 2038),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'company_name' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.company_name',		
			'config' => array (
				'type' => 'input',	
				'size' => '48',
			)
		),
		'company_info' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.company_info',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
		'leadin' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.leadin',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
		'description' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.description',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
		'contact_name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.contact_name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'contact_phone' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.contact_phone',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'contact_email' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.contact_email',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'requirements' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.requirements',		
			'config' => array (
				'type' => 'select',	
				'internal_type' => 'db',	
				'allowed' => 'tx_sysjobs_requirements',	
                                'foreign_table' => 'tx_sysjobs_requirements',
                                'foreign_table_where' => ' ORDER BY tx_sysjobs_requirements.title',
				'size' => 10,	
				'minitems' => 0,
				'maxitems' => 99,
			)
		),

        'must_requirements' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.must_requirements',
            'config' => array (
                'type' => 'select',
                'internal_type' => 'db',
                'allowed' => 'tx_sysjobs_requirements',
                'foreign_table' => 'tx_sysjobs_requirements',
                'foreign_table_where' => ' ORDER BY tx_sysjobs_requirements.title',
                'size' => 10,
                'minitems' => 6,
                'maxitems' => 6,
                'eval' => 'required',
            )
        ),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2,contact_name, contact_phone, contact_email, requirements, company_name;;;;3-3-3, company_info;;;richtext[]:rte_transform[mode=ts_css|imgpath=uploads/tx_sysjobs/rte/], leadin;;;richtext[]:rte_transform[mode=ts_css|imgpath=uploads/tx_sysjobs/rte/], description;;;richtext[]:rte_transform[mode=ts_css|imgpath=uploads/tx_sysjobs/rte/], must_requirements')
	),
	'palettes' => array (
		'1' => array('showitem' => 'starttime, endtime')
	)
);



$TCA['tx_sysjobs_requirements'] = array (
	'ctrl' => $TCA['tx_sysjobs_requirements']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,title'
	),
	'feInterface' => $TCA['tx_sysjobs_requirements']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_requirements.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '48',	
				'eval' => 'required',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);

$TCA['tx_sysjobs_applicants'] = array (
    'ctrl' => $TCA['tx_sysjobs_applicants']['ctrl'],
    'interface' => array (
        'showRecordFieldList' => 'name,firstname,comment'
    ),
    'feInterface' => $TCA['tx_sysjobs_applicants']['feInterface'],
    'columns' => array (
        'hidden' => array (
            'exclude' => 1,
            'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config'  => array (
                'type'    => 'check',
                'default' => '0'
            )
        ),

        'job_uid' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.title',
            'config' => array (
                'type' => 'select',
                'internal_type' => 'db',
                'allowed' => 'tx_sysjobs_jobs',
                'foreign_table' => 'tx_sysjobs_jobs',
                'foreign_table_where' => ' ORDER BY tx_sysjobs_jobs.title',
            )
        ),

        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.name',
            'config' => array (
                'type' => 'input',
                'size' => '15',
            )
        ),

        'firstname' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.firstname',
            'config' => array (
                'type' => 'input',
                'size' => '15',
            )
        ),

        'adress' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.adress',
            'config' => array(
                'type' => 'text',
                'cols' => 20,
                'rows' => 2,
            )
        ),

        'zip' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.zip',
            'config' => array (
                'type' => 'input',
                'size' => '15',
            )
        ),

        'city' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.city',
            'config' => array (
                'type' => 'input',
                'size' => '15',
            )
        ),

        'contact_email' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.contact_email',
            'config' => array (
                'type' => 'input',
                'size' => '15',
            )
        ),

        'contact_phone_private' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.contact_phone_private',
            'config' => array (
                'type' => 'input',
                'size' => '15',
            )
        ),

        'contact_phone_mobile' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.contact_phone_mobile',
            'config' => array (
                'type' => 'input',
                'size' => '15',
            )
        ),

        'requirements' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_jobs.requirements',
            'config' => array (
                'type' => 'select',
                'internal_type' => 'db',
                'allowed' => 'tx_sysjobs_requirements',
                'foreign_table' => 'tx_sysjobs_requirements',
                'foreign_table_where' => ' ORDER BY tx_sysjobs_requirements.title',
                'size' => 10,
                'minitems' => 0,
                'maxitems' => 99,
            )
        ),

        'application' => array (
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.application',
            'config' => array (
                'type' => 'group',
                'internal_type' => 'file',
                'allowed' => 'pdf',
                'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
                'uploadfolder' => '',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            )
        ),

        'comment' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:sysjobs/locallang_db.xml:tx_sysjobs_applicants.comment',
            'config' => array(
                'type' => 'text',
                'cols' => 20,
                'rows' => 3,
            )
        ),
    ),
    'types' => array (
        '0' => array('showitem' => 'hidden, job, name, firstname, adress, zip, city, contact_email, contact_phone_private, contact_phone_mobile, application, requirements, comment')
    ),
);
?>