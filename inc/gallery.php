<?php

if (!function_exists('ba_resume_page_portfolio')) {
	function ba_resume_page_portfolio(){

		$lightbox = get_post_meta(get_the_ID(),'rp_do_lightbox', true);
		// get the post via ID so we can access data and print it within an array to fetch
		$post = get_post(get_the_ID(), ARRAY_A);

		// Get the gallery shortcode out of the post content, and parse the ID's in teh gallery shortcode
		$shortcode_args = shortcode_parse_atts(ba_resume_page_portfolio_getmatch('/\[gallery\s(.*)\]/isU', $post['post_content']));

		// set gallery shortcode image id's
		$ids = $shortcode_args["ids"];

		// setup some args so we can pull only images from this content
		$args = array(
            'include'        => $ids,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => 'menu_order ID',
            'orderby'        => 'post__in', //required to order results based on order specified the "include" param
        );

		// fetch the image id's that the user has within the gallery shortcode
		$images = get_posts($args);

		$out = '';

		// action
		$out .= sprintf('%s', do_action('rp-portfolio-box_before'));

		// print the shortcode
		$out .= sprintf('<section class="clearfix rp-portfolio-boxes rp-portfolio-boxes-%s">',get_the_ID());

			foreach($images as $image):

				$getimage 		= wp_get_attachment_image($image->ID, 'medium', false, array('class' => 'rp-portfolio-box-box-image'));
				$getimgsrc 		= wp_get_attachment_image_src($image->ID,'large');
				$img_title 	  	= $image->post_title;

				if ($lightbox) {
					$image 		= sprintf('<a class="swipebox" href="%s" title="%s">%s</a>',$getimgsrc[0],$img_title,$getimage);
				} else {
					$image 		= wp_get_attachment_image($image->ID, 'medium', false, array('class' => 'rp-portfolio-box-box-image'));
				}

               	$out 			.= sprintf('<figure class="rp-portfolio-box">%s</figure>',$image);

            endforeach;

        $out .= sprintf('</section>');

        // action
		$out .= sprintf('%s', do_action('rp-portfolio-box_after'));

		return apply_filters('space_boxes_output',$out);
	}
}


if (!function_exists('ba_resume_page_portfolio_getmatch')){
   	function ba_resume_page_portfolio_getmatch( $regex, $content ) {
        preg_match($regex, $content, $matches);
        return $matches[1];
    }
}