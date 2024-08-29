<?php
class WP_Resume_Builder_Settings
{
  private $options;

  public function init()
  {
    add_action('admin_menu', array($this, 'add_plugin_page'));
    add_action('admin_init', array($this, 'page_init'));
  }

  public function add_plugin_page()
  {
    add_menu_page(
      'WP Resume Builder',
      'Resume Builder',
      'manage_options',
      'wp-resume-builder',
      array($this, 'create_admin_page'),
      'dashicons-id-alt',
      100
    );
  }

  public function create_admin_page()
  {
    $this->options = get_option('wp_resume_builder_options');
?>
    <div class="wrap">
      <h1>WP Resume Builder Settings</h1>
      <form method="post" action="options.php">
        <?php
        settings_fields('wp_resume_builder_option_group');
        do_settings_sections('wp-resume-builder-admin');
        submit_button();
        ?>
      </form>
    </div>
<?php
  }

  public function page_init()
  {
    register_setting(
      'wp_resume_builder_option_group',
      'wp_resume_builder_options',
      array($this, 'sanitize')
    );

    // Personal Information
    add_settings_section(
      'wp_resume_builder_personal_info',
      'Personal Information',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    add_settings_field(
      'name',
      'Name',
      array($this, 'name_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_personal_info'
    );

    add_settings_field(
      'tagline',
      'Tagline',
      array($this, 'tagline_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_personal_info'
    );

    add_settings_field(
      'email',
      'Email',
      array($this, 'email_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_personal_info'
    );

    add_settings_field(
      'website',
      'Website',
      array($this, 'website_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_personal_info'
    );

    add_settings_field(
      'phone',
      'Phone',
      array($this, 'phone_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_personal_info'
    );

    // Social Media
    add_settings_section(
      'wp_resume_builder_social_media',
      'Social Media',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    add_settings_field(
      'twitter',
      'Twitter Username',
      array($this, 'twitter_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_social_media'
    );

    add_settings_field(
      'facebook',
      'Facebook Username',
      array($this, 'facebook_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_social_media'
    );

    add_settings_field(
      'github',
      'Github Username',
      array($this, 'github_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_social_media'
    );

    // Objective Section
    add_settings_section(
      'wp_resume_builder_objective',
      'Objective Section',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    add_settings_field(
      'disable_objective',
      'Disable Objective Section',
      array($this, 'disable_objective_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_objective'
    );

    add_settings_field(
      'objective_title',
      'Objective Title',
      array($this, 'objective_title_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_objective'
    );

    add_settings_field(
      'objective_text',
      'Objective Text',
      array($this, 'objective_text_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_objective'
    );

    // Experience Section
    add_settings_section(
      'wp_resume_builder_experience',
      'Experience Section',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    add_settings_field(
      'disable_experience',
      'Disable Experience Section',
      array($this, 'disable_experience_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_experience'
    );

    add_settings_field(
      'experience_title',
      'Experience Title',
      array($this, 'experience_title_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_experience'
    );

    add_settings_field(
      'experience_entries',
      'Experience Entries',
      array($this, 'experience_entries_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_experience'
    );

    // Skills Section
    add_settings_section(
      'wp_resume_builder_skills',
      'Skills Section',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    add_settings_field(
      'disable_skills',
      'Disable Skills Section',
      array($this, 'disable_skills_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_skills'
    );

    add_settings_field(
      'skills',
      'Skills',
      array($this, 'skills_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_skills'
    );

    // Education Section
    add_settings_section(
      'wp_resume_builder_education',
      'Education Section',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    add_settings_field(
      'disable_education',
      'Disable Education Section',
      array($this, 'disable_education_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_education'
    );

    add_settings_field(
      'education_entries',
      'Education Entries',
      array($this, 'education_entries_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_education'
    );

    // Github Section
    add_settings_section(
      'wp_resume_builder_github',
      'Github Section',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    add_settings_field(
      'disable_github',
      'Disable Github Section',
      array($this, 'disable_github_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_github'
    );

    // Portfolio Section
    add_settings_section(
      'wp_resume_builder_portfolio',
      'Portfolio Section',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    add_settings_field(
      'disable_portfolio',
      'Disable Portfolio Section',
      array($this, 'disable_portfolio_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_portfolio'
    );

    add_settings_field(
      'enable_portfolio_lightbox',
      'Enable Portfolio Lightbox',
      array($this, 'enable_portfolio_lightbox_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_portfolio'
    );

    // Design Section
    add_settings_section(
      'wp_resume_builder_design',
      'Design',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    add_settings_field(
      'text_color',
      'Text Color',
      array($this, 'text_color_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_design'
    );

    add_settings_field(
      'accent_color',
      'Accent Color',
      array($this, 'accent_color_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_design'
    );

    add_settings_field(
      'background_color',
      'Background Color',
      array($this, 'background_color_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_design'
    );

    add_settings_field(
      'container_color',
      'Container Color',
      array($this, 'container_color_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_design'
    );

    add_settings_field(
      'background_image',
      'Full Screen Background Image',
      array($this, 'background_image_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_design'
    );

    add_settings_field(
      'container_opacity',
      'Container Opacity',
      array($this, 'container_opacity_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_design'
    );
  }

  public function sanitize($input)
  {
    $new_input = array();

    // Sanitize each field
    if (isset($input['name']))
      $new_input['name'] = sanitize_text_field($input['name']);

    if (isset($input['tagline']))
      $new_input['tagline'] = sanitize_text_field($input['tagline']);

    if (isset($input['email']))
      $new_input['email'] = sanitize_email($input['email']);

    if (isset($input['website']))
      $new_input['website'] = esc_url_raw($input['website']);

    if (isset($input['phone']))
      $new_input['phone'] = sanitize_text_field($input['phone']);

    if (isset($input['twitter']))
      $new_input['twitter'] = sanitize_text_field($input['twitter']);

    if (isset($input['facebook']))
      $new_input['facebook'] = sanitize_text_field($input['facebook']);

    if (isset($input['github']))
      $new_input['github'] = sanitize_text_field($input['github']);

    // Add more sanitization for other fields...

    return $new_input;
  }

  public function print_section_info()
  {
    print 'Enter your settings below:';
  }

  // Callback functions for each field
  public function name_callback()
  {
    printf(
      '<input type="text" id="name" name="wp_resume_builder_options[name]" value="%s" />',
      isset($this->options['name']) ? esc_attr($this->options['name']) : ''
    );
  }

  public function tagline_callback()
  {
    printf(
      '<input type="text" id="tagline" name="wp_resume_builder_options[tagline]" value="%s" />',
      isset($this->options['tagline']) ? esc_attr($this->options['tagline']) : ''
    );
  }

  // Add more callback functions for other fields...

  public function experience_entries_callback()
  {
    echo '<div id="experience-entries">';
    if (isset($this->options['experience_entries']) && is_array($this->options['experience_entries'])) {
      foreach ($this->options['experience_entries'] as $key => $entry) {
        echo '<div class="experience-entry">';
        echo '<input type="text" name="wp_resume_builder_options[experience_entries][' . $key . '][title]" value="' . esc_attr($entry['title']) . '" placeholder="Work Title" />';
        echo '<input type="text" name="wp_resume_builder_options[experience_entries][' . $key . '][company]" value="' . esc_attr($entry['company']) . '" placeholder="Company" />';
        echo '<textarea name="wp_resume_builder_options[experience_entries][' . $key . '][description]" placeholder="Job Description">' . esc_textarea($entry['description']) . '</textarea>';
        echo '<input type="text" name="wp_resume_builder_options[experience_entries][' . $key . '][dates]" value="' . esc_attr($entry['dates']) . '" placeholder="Work Dates" />';
        echo '<button type="button" class="remove-experience">Remove</button>';
        echo '</div>';
      }
    }
    echo '</div>';
    echo '<button type="button" id="add-experience">Add New</button>';
  }

  // Add similar functions for skills, education, etc.
}
