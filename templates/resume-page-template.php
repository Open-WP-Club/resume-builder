<?php

wp_head();

// setup variables - if you're overriding in a child template be sure to keep these here! only chnage the markup below and use these to fill in dynamic info

$name 				= get_post_meta(get_the_ID(),'rp_name', true);
$tagline 			= get_post_meta(get_the_ID(),'rp_tagline', true);
$email 				= get_post_meta(get_the_ID(),'rp_email', true);
$website 			= get_post_meta(get_the_ID(),'rp_website', true);
$phone 				= get_post_meta(get_the_ID(),'rp_phone', true);

$twitter 			= get_post_meta(get_the_ID(),'rp_twitter', true);
$facebook			= get_post_meta(get_the_ID(),'rp_facebook', true);
$github 			= get_post_meta(get_the_ID(),'rp_github', true);

$hide_objective 	= get_post_meta(get_the_ID(),'rp_disable_objective', true);
$hide_experience 	= get_post_meta(get_the_ID(),'rp_disable_experience', true);
$hide_github 		= get_post_meta(get_the_ID(),'rp_disable_github', true);
$hide_skills 		= get_post_meta(get_the_ID(),'rp_disable_skills', true);
$hide_education 	= get_post_meta(get_the_ID(),'rp_disable_education', true);
$hide_portfolio 	= get_post_meta(get_the_ID(),'rp_disable_portfolio', true);

$objective_title 	= get_post_meta(get_the_ID(),'rp_objective_title', true) ? get_post_meta(get_the_ID(),'rp_objective_title', true) : __('Objective','resume-page');
$objective_content 	= get_post_meta(get_the_ID(),'rp_objective_content', true) ? get_post_meta(get_the_ID(),'rp_objective_content', true) : __('What is your objective?','resume-page');

$experience_title 	= get_post_meta(get_the_ID(),'rp_experience_title', true) ? get_post_meta(get_the_ID(),'rp_experience_title', true) : __('Experience','resume-page');
$github_title 		= get_post_meta(get_the_ID(),'rp_github_title', true) ? get_post_meta(get_the_ID(),'rp_github_title', true) : __('Github Activity','resume-page');
$skills_title 		= get_post_meta(get_the_ID(),'rp_skills_title', true) ? get_post_meta(get_the_ID(),'rp_skills_title', true) : __('Skills','resume-page');
$education_title 	= get_post_meta(get_the_ID(),'rp_education_title', true) ? get_post_meta(get_the_ID(),'rp_education_title', true) : __('Education','resume-page');
$portfolio_title 	= get_post_meta(get_the_ID(),'rp_portfolio_title', true) ? get_post_meta(get_the_ID(),'rp_portfolio_title', true) : __('Portfolio','resume-page');

$skills 			= get_post_meta(get_the_ID(),'rp_single_skill', false);
$schools 			= get_post_meta(get_the_ID(),'rp_school_places', false);
$companies 			= get_post_meta(get_the_ID(),'rp_work_places', false);

$themeclass 		= get_post_meta(get_the_ID(),'rp_theme', true) ? get_post_meta(get_the_ID(),'rp_theme', true) : 'paper';

$getbgimgid 		= get_post_meta(get_the_ID(),'rp_bg_img', true);
$getbgimg 			= $getbgimgid ? wp_get_attachment_url( $getbgimgid ) : false;
$bgimg 				= $getbgimgid ? sprintf('background:url(\'%s\');',$getbgimg) : false;

$bgcolor			= get_post_meta(get_the_ID(),'rp_bg_color', true) ? get_post_meta(get_the_ID(),'rp_bg_color', true) : '#FFFFFF';

$styles 			= $bgimg || $bgcolor ? sprintf('style="%sbackground-color:%s;"',$bgimg,$bgcolor) : false;

do_action('ba_resume_page_before'); // action

	?>
		<section class="resume-wrap <?php echo $themeclass;?>" <?php echo $styles;?>>
			<div class="resume-container">
				<div class="resume-inner">

					<?php do_action('ba_resume_page_inside_top_container'); //action ?>

					<!-- start resume header -->
					<header class="row resume-section-header">
						<div class="col-sm-3">
							<?php the_post_thumbnail(array(400,400), array('class'=>'resume-avatar'));?>
						</div>
						<div class="col-sm-7 resume-bio">
							<h1 class="zmt resume-bio-title"><?php echo $name;?></h1>
							<?php if ($tagline): ?>
								<h2 class="zmt resume-bio-tag"><small><?php echo $tagline;?></small></h2>
							<?php endif; ?>
							<ul class="resume-bio-meta">
								<?php if ($email): ?>
									<li><a href="mailto:<?php echo $email;?>" class="resume-bio-email"><i class="resumecon resumecon-envelope"></i> <?php echo $email;?></a></li>
								<?php endif;
								if ($website): ?>
									<li><a href="<?php echo $website;?>" target="_blank" class="resume-bio-site"><i class="resumecon resumecon-globe"></i> <?php echo $website;?></a></li>
								<?php endif;
								if ($phone): ?>
									<li><i class="resumecon resumecon-phone-square"></i> <?php echo $phone;?></li>
								<?php endif; ?>
							</ul>
						</div>
						<?php if ($twitter || $facebook || $github): ?>
							<div class="col-sm-2 resume-social-wrap tar">
								<ul class="resume-bio-social unstyled">
									<?php if ($twitter): ?>
										<li><a href="http://twitter.com/<?php echo $twitter;?>" target="_blank"><i class="resumecon resumecon-twitter-square"></i></a></li>
									<?php endif;
									if ($facebook): ?>
										<li><a href="http://facebook.com/<?php echo $facebook;?>" target="_blank"><i class="resumecon resumecon-facebook-square"></i></a></li>
									<?php endif;
									if ($github): ?>
										<li><a href="http://github.com/<?php echo $github;?>" target="_blank"><i class="resumecon resumecon-github-square"></i></a></li>
									<?php endif; ?>
								</ul>
							</div>
						<?php endif ;?>
					</header>
					<!-- end resume header -->

					<?php do_action('ba_resume_page_after_header'); //action ?>

					<!-- start main -->
					<main class="resume-section-main">

						<?php if (!$hide_objective) { ?>
							<!-- start objective -->
							<section class="row resume-objective-wrap">
								<div class="col-sm-3">
									<h4 class="zmt resume-item-title"><?php echo $objective_title;?></h4>
								</div>
								<div class="col-sm-9 resume-objective lead">
									<?php echo $objective_content;?>
								</div>
							</section>
							<hr />
							<!-- end objective -->
						<?php }

						do_action('ba_resume_page_after_objective'); //action


						if (!$hide_experience) { ?>
							<!-- start work experience wrap -->
							<section class="row resume-work-wrap">
								<div class="col-sm-3">
									<h4 class="zmt resume-item-title"><?php echo $experience_title;?></h4>
								</div>
								<div class="col-sm-9">

									<?php foreach($companies as $company): ?>
										<!-- company -->
										<div class="row resume-company-item">
											<div class="col-sm-9">
												<h4 class="zmt resume-company-title"><?php echo $company['rp_work_title'];?></h4>
												<h4 class="zmt"><small><?php echo $company['rp_work_company'];?></small></h4>
												<p><?php echo $company['rp_work_desc'];?></p>
											</div>
											<div class="col-sm-3 tar">
												<p class="label label-resume"><?php echo $company['rp_work_dates'];?></p>
											</div>
										</div>
										<!-- end company -->
									<?php endforeach; ?>

								</div>
							</section>
							<hr />
							<!-- end work experience wrap -->
						<?php }

						do_action('ba_resume_page_after_experience'); //action

						if (!$hide_skills) { ?>
							<!-- start skillset wrap -->
							<section class="row resume-skillset-wrap">
								<div class="col-sm-3">
									<h4 class="zmt resume-item-title"><?php echo $skills_title;?></h4>
								</div>
								<div class="col-sm-9 resume-skillset-list-wrap">

									<!-- skillset 1 -->
									<div class="row">
										<div class="col-sm-12">

											<ul class="unstyled resume-skillset-list">
												<?php foreach($skills as $skill):
													printf('<li><i class="resumecon resumecon-check"></i> %s</li>',$skill);
												endforeach; ?>
											</ul>
										</div>
									</div>
									<!-- end skillset -->

								</div>
							</section>
							<hr />
							<!-- end skillset wrap -->
						<?php }

						do_action('ba_resume_page_after_skillset'); //action

						if (!$hide_education) { ?>
							<!-- start education wrap -->
							<section class="row resume-education-wrap">
								<div class="col-sm-3">
									<h4 class="zmt resume-item-title"><?php echo $education_title;?></h4>
								</div>
								<div class="col-sm-9">

									<?php foreach($schools as $school): ?>
										<!-- skillset 1 -->
										<div class="row resume-education-item">
											<div class="col-sm-12">
												<h4 class="zmt resume-education-title"><?php echo $school['rp_school_name'];?></h4>
												<h4 class="zmt resume-education-tag"><small><?php echo $school['rp_school_course'];?></small></h4>
												<p><?php echo $school['rp_school_desc'];?></p>
											</div>
										</div>
										<!-- end skillset -->
									<?php endforeach; ?>

								</div>
							</section>
							<hr />
							<!-- end education wrap -->
						<?php }

						do_action('ba_resume_page_after_education'); //action

						if (!$hide_github) { ?>
							<!-- start github activity stream -->
							<section class="row resume-github-wrap no-print">
								<div class="col-sm-3">
									<h4 class="zmt resume-item-title"><?php echo $github_title;?></h4>
								</div>
								<div class="col-sm-9 github-stream-wrap">
									<ul class="github-stream unstyled">
										<?php echo ba_resume_page_github_feed( $github , $excluded = array(), $count = 5);?>
									</ul>
								</div>
							</section>
							<hr />
							<!-- end github activity stream -->
						<?php }

						do_action('ba_resume_page_after_github'); //action

						if (!$hide_portfolio) { ?>
							<!-- start portfolio -->
							<section class="row resume-portfolio-wrap no-print">
								<div class="col-sm-3">
									<h4 class="zmt resume-item-title"><?php echo $portfolio_title;?></h4>
								</div>
								<div class="col-sm-9 resume-porfolio">
									<?php echo ba_resume_page_portfolio();?>
								</div>
							</section>
							<!-- end portfolio -->
						<?php } ?>

					</main>
					<!-- end main -->
					<?php do_action('ba_resume_page_inside_bottom_container'); //action ?>

				</div>
			</div>
		</section>
	<?php

do_action('ba_resume_page_after'); // action

wp_footer();
