<?php
/**
* register and enqueue our scripts and instantiations
* add user styles to head
* deregisters scripts and styles not needed on resume page
* cleans up wp head on resume page
* @since version 1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class ba_resume_page_run_and_cleans {

	const version = '1.0';

	function __construct() {

		add_action('wp_print_styles', array($this,'clean_head'));
		add_action('wp_enqueue_scripts',	array($this,'run_clean'));
		add_action('wp_head', array($this,'script_init'));
		add_action('wp_head', array($this,'user_styles'), 2);
	}

	// set user set styles and custom css in head
	function user_styles(){

		$resume 				= get_post_meta(get_the_ID(),'ba_make_resume_page', true) ? get_post_meta(get_the_ID(),'ba_make_resume_page', true) : false;

		$customcss 				= get_post_meta(get_the_ID(), 'rp_custom_css', true) ? get_post_meta(get_the_ID(), 'rp_custom_css', true) : false;
		$txtcolor 				= get_post_meta(get_the_ID(),'rp_txt_color', true) ? get_post_meta(get_the_ID(),'rp_txt_color', true) : '#333333';
		$link_color				= get_post_meta(get_the_ID(),'rp_accent_color', true) ? get_post_meta(get_the_ID(),'rp_accent_color', true) : '#07A1CD';
		$container_opacity 		= get_post_meta(get_the_ID(), 'rp_container_opacity', true) ? get_post_meta(get_the_ID(), 'rp_container_opacity', true) : '1.0';

		$get_container_color 	= get_post_meta(get_the_ID(),'rp_container_color', true) ? get_post_meta(get_the_ID(),'rp_container_color', true) : '#FFFFFF';
		$container_to_rgba 		= $get_container_color ? $this->hex2rgb($get_container_color) : false;
		$container_rgba 		= $get_container_color ? sprintf('%s,%s,%s',$container_to_rgba['red'],$container_to_rgba['green'],$container_to_rgba['blue']) : false;
		$final_container_color 	= $get_container_color ? sprintf('background:%s;background:rgba(%s,%s);',$get_container_color,$container_rgba,$container_opacity) : false;

		if ( ($resume) && ($txtcolor || $get_container_color || $link_color)): ?>
		<!-- Resume Page - User Set Styles -->
		<style>
		.resume-wrap a i,.resume-wrap {color:<?php echo $txtcolor;?>;}
		.resume-inner {<?php echo $final_container_color;?>;}
		.label-resume {background:<?php echo $link_color;?>;}
		.resume-bio-social a:hover i,.resume-wrap a {color:<?php echo $link_color;?>;}
		</style>
		<?php endif;

		if ( $resume && $customcss ):
			?><!-- Resume Page - User Custom CSS --><style><?php echo $customcss;?></style><?php
		endif;
	}

	// load script instantations for the portfolio area
	function script_init(){

		$hide_portfolio 		= get_post_meta(get_the_ID(),'rp_disable_portfolio', true);
		$resume 				= get_post_meta(get_the_ID(),'ba_make_resume_page', true) ? get_post_meta(get_the_ID(),'ba_make_resume_page', true) : false;
		$lightbox 				= get_post_meta(get_the_ID(),'rp_do_lightbox', true);
		$txtcolor 				= get_post_meta(get_the_ID(),'rp_txt_color', true) ? get_post_meta(get_the_ID(),'rp_txt_color', true) : '#333333';
		$get_container_color 	= get_post_meta(get_the_ID(),'rp_container_color', true) ? get_post_meta(get_the_ID(),'rp_container_color', true) : '#FFFFFF';
		$link_color				= get_post_meta(get_the_ID(),'rp_accent_color', true) ? get_post_meta(get_the_ID(),'rp_accent_color', true) : '#07A1CD';

		if ($resume && !'on' == $hide_portfolio): ?>
			<!-- Resume Page - Script Instantiations -->
			<script>
				jQuery(document).ready(function(){
				    jQuery('.rp-portfolio-boxes.rp-portfolio-boxes-<?php echo get_the_ID();?>').imagesLoaded(function() {
				        var options = {
				          	autoResize: true,
				          	container: jQuery('.rp-portfolio-boxes.rp-portfolio-boxes-<?php echo get_the_ID();?>'),
				          	offset: 5,
				          	flexibleWidth:195
				        };
				        var handler = jQuery('.rp-portfolio-boxes.rp-portfolio-boxes-<?php echo get_the_ID();?> figure');
				        jQuery(handler).wookmark(options);
				    });

				    <?php if ($lightbox): ?>
						jQuery('.rp-portfolio-boxes.rp-portfolio-boxes-<?php echo get_the_ID();?> .swipebox').swipebox();
					<?php endif; ?>
					//tinycolor
					accentcolor = tinycolor('<?php echo $get_container_color; ?>');
					txtcolor = tinycolor('<?php echo $txtcolor; ?>');

					jQuery('.resume-wrap small, .resume-wrap .text-muted').css({'color':  tinycolor.darken(txtcolor, 25).toRgbString() });
					jQuery('.resume-wrap hr').css({'border-top-color':  tinycolor.darken(accentcolor, 5).toRgbString() });
				});
			</script>
		<?php endif;
	}

	// remove unncessary kruft from wphead when on resume page and resume page is activated
	function clean_head(){

		$resume = get_post_meta(get_the_ID(),'ba_make_resume_page', true) ? get_post_meta(get_the_ID(),'ba_make_resume_page', true) : false;

		if ( $resume ) {

			// remove 2012 stuff
	    	wp_deregister_script('twentytwelve-navigation');
	    	wp_dequeue_script(	'twentytwelve-navigation');
	    	wp_deregister_style( 'twentytwelve-style' );
	    	wp_dequeue_style(	'twentytwelve-style');

	    	// clean up wp head on the resume page
	    	remove_action('wp_head', 'rsd_link');
			remove_action('wp_head', 'wlwmanifest_link');
			remove_action('wp_head', 'index_rel_link');
			remove_action('wp_head', 'parent_post_rel_link', 10, 0);
			remove_action('wp_head', 'start_post_rel_link', 10, 0);
			remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
			remove_action('wp_head', 'wp_generator');
	    }

	}

	// load our scripts and stuff on demand
	function run_clean(){

		$resume 		= get_post_meta(get_the_ID(),'ba_make_resume_page', true) ? get_post_meta(get_the_ID(),'ba_make_resume_page', true) : false;
		$lightbox 		= get_post_meta(get_the_ID(),'rp_do_lightbox', true);
		$hide_portfolio = get_post_meta(get_the_ID(),'rp_disable_portfolio', true);

	    if ( $resume ) {

	    	wp_enqueue_script('jquery');
	    	wp_enqueue_style( 'resume-page-style', plugins_url( '../css/style.css' , __FILE__ ) , self::version, true);
	    	wp_enqueue_script('resume-page-color', plugins_url( '../libs/tinycolor-min.js' , __FILE__ ), array('jquery'), self::version, true);

	    	// remove comment reply script on resume page
	    	wp_deregister_script( 'comment-reply' );

	    	if ( !'on' == $hide_portfolio) {
	    		wp_enqueue_script('resume-page-wookmark', plugins_url( '../libs/wookmark/jquery.wookmark.min.js', __FILE__ ), array('jquery'), self::version, true);

	    		if ( $lightbox) {
	    			wp_enqueue_script('resume-page-lightbox',   plugins_url( '../libs/swipebox/jquery.swipebox.min.js', __FILE__ ), array('jquery'), self::version, true);
	    		}
	    	}

	    }

	}

	// helper functioun for convering hex to rgba
    function hex2rgb( $colour ) {
        if ( $colour[0] == '#' ) {
                $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
                return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array( 'red' => $r, 'green' => $g, 'blue' => $b );
	}

}
new ba_resume_page_run_and_cleans;