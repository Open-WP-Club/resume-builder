<?php
/*
Author: Nick Haskins
Author URI: http://nickhaskins.co
Plugin Name: Resume Page
Plugin URI: http://nickhaskins.co
Version: 1.0
Description: Turns any Wordpress page into a beautiful Resume Page with built in Gihub activity and integrated lightbox portfolio.
*/

class ba_Resume_Page_Pimpin {

	public function __construct() {

		$this->dir  = plugin_dir_path( __FILE__ );


		if( !class_exists( 'CMB_Meta_Box' ) ) {
    		require_once(dirname( __FILE__ ) .'/libs/custom-meta-boxes/custom-meta-boxes.php' );
    	}

    	require_once('inc/meta.php' );
    	require_once('inc/load.php' );
    	require_once('inc/feed.php' );
    	require_once('inc/gallery.php' );
    	require_once('inc/load.php' );

		add_action( 'init', 	array($this,'textdomain'));
		add_filter( 'template_include', array($this,'template_loader'));
	}

	public function textdomain() {
		load_plugin_textdomain( 'resumepage_translation', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	// let a themer override our template if put into a child theme
	public function template_loader($template) {

		$resume = get_post_meta(get_the_ID(),'ba_make_resume_page', true) ? get_post_meta(get_the_ID(),'ba_make_resume_page', true) : false;

	    // override single
	    if ( $resume ):

	    	if ( $overridden_template = locate_template( 'resume-page-template.php', true ) ) {

			   $template = load_template( $overridden_template );

			} else {

			    $template = $this->dir.'templates/resume-page-template.php';
			}

	    endif;

	    return $template;

	}
}
new ba_Resume_Page_Pimpin;