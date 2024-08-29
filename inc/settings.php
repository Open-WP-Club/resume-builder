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

    $personal_fields = array(
      'name' => 'Name',
      'tagline' => 'Tagline',
      'email' => 'Email',
      'website' => 'Website',
      'phone' => 'Phone'
    );

    foreach ($personal_fields as $field => $label) {
      add_settings_field(
        $field,
        $label,
        array($this, 'text_field_callback'),
        'wp-resume-builder-admin',
        'wp_resume_builder_personal_info',
        array('field' => $field)
      );
    }

    // Social Media
    add_settings_section(
      'wp_resume_builder_social_media',
      'Social Media',
      array($this, 'print_section_info'),
      'wp-resume-builder-admin'
    );

    $social_fields = array(
      'twitter' => 'Twitter Username',
      'facebook' => 'Facebook Username',
      'github' => 'Github Username'
    );

    foreach ($social_fields as $field => $label) {
      add_settings_field(
        $field,
        $label,
        array($this, 'text_field_callback'),
        'wp-resume-builder-admin',
        'wp_resume_builder_social_media',
        array('field' => $field)
      );
    }

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
      array($this, 'checkbox_field_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_objective',
      array('field' => 'disable_objective')
    );

    add_settings_field(
      'objective_title',
      'Objective Title',
      array($this, 'text_field_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_objective',
      array('field' => 'objective_title')
    );

    add_settings_field(
      'objective_text',
      'Objective Text',
      array($this, 'textarea_field_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_objective',
      array('field' => 'objective_text')
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
      array($this, 'checkbox_field_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_experience',
      array('field' => 'disable_experience')
    );

    add_settings_field(
      'experience_title',
      'Experience Title',
      array($this, 'text_field_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_experience',
      array('field' => 'experience_title')
    );

    add_settings_field(
      'experience_entries',
      'Experience Entries',
      array($this, 'experience_entries_callback'),
      'wp-resume-builder-admin',
      'wp_resume_builder_experience'
    );

    // Add more sections (Skills, Education, etc.) here...
  }

  public function sanitize($input)
  {
    $new_input = array();

    foreach ($input as $key => $value) {
      if (is_array($value)) {
        $new_input[$key] = $this->sanitize($value);
      } else {
        $new_input[$key] = sanitize_text_field($value);
      }
    }

    return $new_input;
  }

  public function print_section_info()
  {
    print 'Enter your settings below:';
  }

  public function text_field_callback($args)
  {
    $field = $args['field'];
    printf(
      '<input type="text" id="%s" name="wp_resume_builder_options[%s]" value="%s" />',
      esc_attr($field),
      esc_attr($field),
      isset($this->options[$field]) ? esc_attr($this->options[$field]) : ''
    );
  }

  public function textarea_field_callback($args)
  {
    $field = $args['field'];
    printf(
      '<textarea id="%s" name="wp_resume_builder_options[%s]">%s</textarea>',
      esc_attr($field),
      esc_attr($field),
      isset($this->options[$field]) ? esc_textarea($this->options[$field]) : ''
    );
  }

  public function checkbox_field_callback($args)
  {
    $field = $args['field'];
    printf(
      '<input type="checkbox" id="%s" name="wp_resume_builder_options[%s]" value="1" %s />',
      esc_attr($field),
      esc_attr($field),
      (isset($this->options[$field]) && $this->options[$field] == 1) ? 'checked' : ''
    );
  }

  public function experience_entries_callback()
  {
    echo '<div id="experience-entries">';
    if (isset($this->options['experience_entries']) && is_array($this->options['experience_entries'])) {
      foreach ($this->options['experience_entries'] as $key => $entry) {
        $this->render_experience_entry($key, $entry);
      }
    }
    echo '</div>';
    echo '<button type="button" id="add-experience">Add New</button>';

    // Add JavaScript to handle dynamic addition and removal of experience entries
    $this->add_experience_entry_js();
  }

  private function render_experience_entry($key, $entry = array())
  {
    $title = isset($entry['title']) ? esc_attr($entry['title']) : '';
    $company = isset($entry['company']) ? esc_attr($entry['company']) : '';
    $description = isset($entry['description']) ? esc_textarea($entry['description']) : '';
    $dates = isset($entry['dates']) ? esc_attr($entry['dates']) : '';

    echo '<div class="experience-entry">';
    echo '<input type="text" name="wp_resume_builder_options[experience_entries][' . $key . '][title]" value="' . $title . '" placeholder="Work Title" />';
    echo '<input type="text" name="wp_resume_builder_options[experience_entries][' . $key . '][company]" value="' . $company . '" placeholder="Company" />';
    echo '<textarea name="wp_resume_builder_options[experience_entries][' . $key . '][description]" placeholder="Job Description">' . $description . '</textarea>';
    echo '<input type="text" name="wp_resume_builder_options[experience_entries][' . $key . '][dates]" value="' . $dates . '" placeholder="Work Dates" />';
    echo '<button type="button" class="remove-experience">Remove</button>';
    echo '</div>';
  }

  private function add_experience_entry_js()
  {
  ?>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        var experienceCount = $('.experience-entry').length;

        $('#add-experience').on('click', function() {
          var newEntry = $('<div class="experience-entry"></div>');
          newEntry.append('<input type="text" name="wp_resume_builder_options[experience_entries][' + experienceCount + '][title]" placeholder="Work Title" />');
          newEntry.append('<input type="text" name="wp_resume_builder_options[experience_entries][' + experienceCount + '][company]" placeholder="Company" />');
          newEntry.append('<textarea name="wp_resume_builder_options[experience_entries][' + experienceCount + '][description]" placeholder="Job Description"></textarea>');
          newEntry.append('<input type="text" name="wp_resume_builder_options[experience_entries][' + experienceCount + '][dates]" placeholder="Work Dates" />');
          newEntry.append('<button type="button" class="remove-experience">Remove</button>');
          $('#experience-entries').append(newEntry);
          experienceCount++;
        });

        $(document).on('click', '.remove-experience', function() {
          $(this).parent('.experience-entry').remove();
        });
      });
    </script>
<?php
  }
}
