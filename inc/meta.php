<?php
/**
* create custom meta boxes for project meta
*
* @since version 1.0
* @param null
* @return custom meta boxes
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'cmb_meta_boxes', 'ba_resumepage_meta' );
function ba_resumepage_meta( array $meta_boxes ) {

	$opts = array(
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
			'desc'			=> __('
				Resume Page is meant to be plug-and-play. Activate Resume Page on any Wordpress page by toggling the box to your right. Then, just fill out the fields below.<br />-  To set the avatar, set a Featured Image. It\'s designed this way so if the page is linked from social networks the avatar shows along with the bio. <br />-  To create a gallery, simply create and insert a Wordpress gallery into the editor above. The order of the ID\'s dictate the order of the images in the gallery. <br /><strong>Note:</strong> Inserting anything else into the editor above won\'t show, only the gallery.
			','resume-page')
		),
		///////
		////// BIO
		//////
		array(
		    'id'   			=> 'rp_name',
		    'name' 			=> __('Name', 'resume-page'),
		    'type' 			=> 'text',
		    'cols'			=> 6
		),
		array(
		    'id'   			=> 'rp_tagline',
		    'name' 			=> __('Tagline', 'resume-page'),
		    'type' 			=> 'text',
		    'cols'			=> 6
		),
		array(
		    'id'   			=> 'rp_email',
		    'name' 			=> __('Email', 'resume-page'),
		    'type' 			=> 'text',
		    'cols'			=> 4
		),
		array(
		    'id'   			=> 'rp_website',
		    'name' 			=> __('Website', 'resume-page'),
		    'type' 			=> 'text',
		    'cols'			=> 4
		),
		array(
		    'id'   			=> 'rp_phone',
		    'name' 			=> __('Phone', 'resume-page'),
		    'type' 			=> 'text',
		    'cols'			=> 4
		),
		///////
		////// BIO SOCIAL
		//////
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __('Bio Social', 'resume-page'),
		    'type' 			=> 'title',
		),
		array(
		    'id'   			=> 'rp_twitter',
		    'name' 			=> __('Twitter Username', 'resume-page'),
		    'type' 			=> 'text',
		    'cols'			=> 4
		),
		array(
		    'id'   			=> 'rp_facebook',
		    'name' 			=> __('Facebook username', 'resume-page'),
		    'type' 			=> 'text',
		    'cols'			=> 4
		),
		array(
		    'id'   			=> 'rp_github',
		    'name' 			=> __('Github Username', 'resume-page'),
		    'type' 			=> 'text',
		    'cols'			=> 4
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 12,
			'desc'			=> __('<span class="ba-help-icon">?</span>If you don\'t enter any links, then the social networks just won\'t show. ','resume-page')
		),
		///////
		////// OBJECTIVE
		//////
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __('Objective Section', 'resume-page'),
		    'type' 			=> 'title',
		),
		array(
			'id' 			=> 'rp_disable_objective',
			'name' 			=> __('Disable the Objective Section', 'resume-page'),
			'type' 			=> 'checkbox',
			'cols'			=> 8
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'			=> __('<span class="ba-help-icon">?</span>Checking this box will deactivate the Objective section. This means the fields below for Objective will have no affect. ','resume-page')
		),
		array(
		    'id'   			=> 'rp_objective_title',
		    'name' 			=> __('Objective Title', 'resume-page'),
		    'type' 			=> 'text',
		    'cols'			=> 4
		),
		array(
			'id'             => 'rp_objective_content',
			'name'           => __('Objective Text', 'resume-page'),
			'type'           => 'textarea',
			'cols'			=> 8,
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 12,
			'desc'			=> __('<span class="ba-help-icon">?</span>The Objective Title is the title. By default it will say <em>Objective</em>. The Objective Text is the actual displayed objective. ','resume-page')
		),
		///////
		////// EXPERIENCE
		//////
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __('Experience Section', 'resume-page'),
		    'type' 			=> 'title',
		),		
		array(
			'id' 			=> 'rp_disable_experience',
			'name' 			=> __('Disable the Experience Section', 'resume-page'),
			'type' 			=> 'checkbox',
			'cols'			=> 8
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'			=> __('<span class="ba-help-icon">?</span>Checking this box will deactivate the Experience section. This means the Experience fields below will have no affect. ','resume-page')
		),
		array(
			'id' 			=> 'rp_experience_title',
			'name' 			=> __('Experience Title', 'resume-page'),
			'type' 			=> 'text',
			'cols'			=> 8
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'			=> __('<span class="ba-help-icon">?</span>By default this will read as <em>Experience</em>. ','resume-page')
		),
		array(
			'id' 			=> 'rp_work_places',
			'type' 			=> 'group',
			'cols' 			=> 8,
			'name' 			=> ' ',
			'repeatable' 	=> true,
			'repeatable_max' => 8,
			'fields' 		=> array(
				array(
                	'id' 	=> 'rp_work_company',
                	'name' 	=> __('Company', 'resume-page'),
                	'type' 	=> 'text'
                ),
                array(
                	'id' 	=> 'rp_work_title',
                	'name' 	=> __('Job Title', 'resume-page'),
                	'type' 	=> 'text'
                ),
                array(
                	'id' 	=> 'rp_work_desc',
                	'name' 	=> __('Job Description', 'resume-page'),
                	'type' 	=> 'textarea'
                ),
                array(
                	'id' 	=> 'rp_work_dates',
                	'name' 	=> __('Job Dates', 'resume-page'),
                	'type' 	=> 'text',
                	'desc'	=> __('Enter as <em>Nov 2011 - Mar 2013</em>','resume-page')
                )
           	)
		),
		array(
		    'id'   			=> 'ppd_help',
		    'name' 			=> __(' ', 'projects-part-deux'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'    		=> __('<span class="ba-help-icon">?</span>Add different work places with the "Add New" button. Fill out the appropriate fields for Work Title, Company, Job Description, and Work Dates.','projects-part-deux')
		),
		///////
		////// SKILLS
		//////
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __('Skills Section', 'resume-page'),
		    'type' 			=> 'title',
		),
		array(
			'id' 			=> 'rp_disable_skills',
			'name' 			=> __('Disable the Skills Section', 'resume-page'),
			'type' 			=> 'checkbox',
			'cols'			=> 8
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'			=> __('<span class="ba-help-icon">?</span>Checking this box will deactivate the Skills section. This means the Skills fields below will have no affect. ','resume-page')
		),
		array(
			'id' 			=> 'rp_single_skill',
			'type' 			=> 'text',
			'cols' 			=> 8,
			'name' 			=> ' ',
			'repeatable' 	=> true,
			'repeatable_max' => 20,
		),
		array(
		    'id'   			=> 'ppd_help',
		    'name' 			=> __(' ', 'projects-part-deux'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'    		=> __('<span class="ba-help-icon">?</span>Generate new skills by clicking the "Add New" button. A skill can be anything like, <em>unicorn wrangler</em>','projects-part-deux')
		),
		///////
		////// EDUCATION
		//////
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __('Education Section', 'resume-page'),
		    'type' 			=> 'title',
		),
		array(
			'id' 			=> 'rp_disable_education',
			'name' 			=> __('Disable the Education Section', 'resume-page'),
			'type' 			=> 'checkbox',
			'cols'			=> 8
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'			=> __('<span class="ba-help-icon">?</span>Checking this box will deactivate the Education section. This means the Education fields below will have no affect. ','resume-page')
		),
		array(
			'id' 			=> 'rp_school_places',
			'type' 			=> 'group',
			'cols' 			=> 8,
			'name' 			=> ' ',
			'repeatable' 	=> true,
			'repeatable_max' => 8,
			'fields' 		=> array(
                array(
                	'id' 	=> 'rp_school_name',
                	'name' 	=> __('School Name', 'resume-page'),
                	'type' 	=> 'text'
                ),
                array(
                	'id' 	=> 'rp_school_course',
                	'name' 	=> __('Studied', 'resume-page'),
                	'type' 	=> 'text'
                ),
                array(
                	'id' 	=> 'rp_school_desc',
                	'name' 	=> __('Small Description', 'resume-page'),
                	'type' 	=> 'textarea'
                )
           	)
		),
		array(
		    'id'   			=> 'ppd_help',
		    'name' 			=> __(' ', 'projects-part-deux'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'    		=> __('<span class="ba-help-icon">?</span>Enter schools by clicking the "Add New" button below.','projects-part-deux')
		),
		///////
		////// GITHUB
		//////
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __('Github Section', 'resume-page'),
		    'type' 			=> 'title',
		),
		array(
			'id' 			=> 'rp_disable_github',
			'name' 			=> __('Disable the Github Section', 'resume-page'),
			'type' 			=> 'checkbox',
			'cols'			=> 8
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'			=> __('<span class="ba-help-icon">?</span>Checking this box will deactivate the Github setion. This means the Github fields below will have no affect.<br /><br /> <strong>Tip:</strong> The Github activity is displayed using the username provided above in Social options. ','resume-page')
		),
		///////
		////// PORTFOLIO
		//////
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __('Portfolio Section', 'resume-page'),
		    'type' 			=> 'title',
		),
		array(
			'id' 			=> 'rp_disable_portfolio',
			'name' 			=> __('Disable the Portfolio Section', 'resume-page'),
			'type' 			=> 'checkbox',
			'cols'			=> 8
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'			=> __('<span class="ba-help-icon">?</span>Checking this box will deactivate the Portfolio portion. This means the Portfolio fields below will have no affect. ','resume-page')
		),
		array(
			'id' 			=> 'rp_do_lightbox',
			'name' 			=> __('Enable Portfolio Lightbox', 'resume-page'),
			'type' 			=> 'checkbox',
			'cols'			=> 8
		),
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __(' ', 'resume-page'),
		    'type' 			=> 'title',
		    'cols'			=> 4,
			'desc'			=> __('<span class="ba-help-icon">?</span>Checking this box will enable each image to open in a lightbox. ','resume-page')
		),
		///////
		////// DESIGN
		//////
		array(
		    'id'   			=> 'rp_help',
		    'name' 			=> __('Design', 'resume-page'),
		    'type' 			=> 'title'
		),
		array(
			'id' 			=> 'rp_txt_color',
			'name' 			=> __('Text Color', 'resume-page'),
			'type' 			=> 'colorpicker',
			'default'		=> '#333333',
			'cols'			=> 3
		),
		array(
			'id' 			=> 'rp_accent_color',
			'name' 			=> __('Accent Color', 'resume-page'),
			'type' 			=> 'colorpicker',
			'default'		=> '#07A1CD',
			'cols'			=> 3
		),
		array(
			'id' 			=> 'rp_bg_color',
			'name' 			=> __('Background Color', 'resume-page'),
			'type' 			=> 'colorpicker',
			'default'		=> '#FFFFFF',
			'cols'			=> 3
		),
		array(
			'id' 			=> 'rp_container_color',
			'name' 			=> __('Container Color', 'resume-page'),
			'type' 			=> 'colorpicker',
			'default'		=> '#FFFFFF',
			'cols'			=> 3
		),
		array(
			'id'			=> 'rp_bg_img',
			'name'			=> __('Full Screen Background Image', 'resume-page'),
			'type'			=> 'image',
			'cols'			=> 6
		),
		array(
			'id' 			=> 'rp_container_opacity',
			'name' 			=> __('Container Opacity', 'resume-page'),
			'type' 			=> 'select',
			'default'		=> '0.8',
			'options'		=> array(
				'0.1'		=> '0.1',
				'0.2'		=> '0.2',
				'0.3'		=> '0.3',
				'0.4'		=> '0.4',
				'0.5'		=> '0.5',
				'0.6'		=> '0.6',
				'0.7'		=> '0.7',
				'0.8'		=> '0.8',
				'0.9'		=> '0.9',
				'1.0'		=> '1.0'
			),
			'cols'			=> 6
		),
        array(
        	'id' 			=> 'rp_custom_css',
        	'name' 			=> __('Custom CSS', 'resume-page'),
        	'type' 			=> 'textarea_code',
        	'desc'			=> __('Enter any custom CSS changes here.', 'resume-page')
        )
	);

	$meta_boxes[] = array(
		'title' 			=> __('Resume Page Options', 'resume-page'),
		'pages' 			=> array('page'),
		'fields' 			=> $opts
	);

	$meta_boxes[] = array(
		'title' 			=> __('Resume Page', 'resume-page'),
		'pages' 			=> array('page'),
		'context'    		=> 'side',
		'fields' 			=> array(
			array(
				'id' 		=> 'ba_make_resume_page',
				'name' 		=> __('Make this page a Resume Page', 'resume-page'),
				'type' 		=> 'checkbox',
			)
		)
	);

	$meta_boxes[] = array(
		'title' 			=> __('Resume Page Theme', 'resume-page'),
		'pages' 			=> array('page'),
		'context'    		=> 'side',
		'fields' 			=> array(
			array(
				'id' 		=> 'rp_theme',
				'name' 		=> ' ',
				'type' 		=> 'select',
				'default'	=> 'paper',
				'options'	=> array(
					'flat'  => __('Flat','showoff'),
					'paper' => __('Paper Stack','showoff'),
				)
			)
		)
	);


	return $meta_boxes;

}

