<?php
/*
* pulls in the users github feed
* this portion was borred from from Aleks King's github activity 
* https://github.com/alexkingorg/wp-github-activity
*/


if(!function_exists('ba_resume_page_github_feed')){
	function ba_resume_page_github_feed( $username, $excluded = array(), $count = 5){

		$feed = fetch_feed('https://github.com/'.$username.'.atom');

        if (is_wp_error($feed)) {
                return '';
        }

        $out = '';

        $i = 0;
        foreach ($feed->get_items() as $item) {
            if ($i == $count) {
                    break;
            }
            $content = $item->data['child']['http://www.w3.org/2005/Atom']['content'][0]['data'];

            $skip = false;
            if (!empty($excluded)) {
                    foreach ($excluded as $exclude) {
                            if (strpos($content, '<!-- '.$exclude.' -->') !== false) {
                                    $skip = true;
                                    break;
                            }
                    }
            }
            if (!$skip) {
                $out .= '<li class="github-activity-item">'.$content.'</li>';
                $i++;
            }

        }
        $out .= ba_resume_page_fix_urls();
        return $out;
	}
}

if(!function_exists('ba_resume_page_fix_urls')){
	function ba_resume_page_fix_urls() {
        ob_start();
			?>
			<script>
			jQuery(document).ready(function(){
		        jQuery('.github-activity-item a').each(function() {
		                var href = jQuery(this).attr('href');
		                if (href.indexOf('https://') == -1) {
		                        jQuery(this).attr('href', 'https://github.com' + href);
		                }
		        });
			});
			</script>
			<?php
        return ob_get_clean();
	}
}