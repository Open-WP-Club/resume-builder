<?php
class WP_Resume_Builder_Settings
{
  private $options;

  public function init()
  {
    add_action('admin_menu', array($this, 'add_plugin_page'));
    add_action('admin_init', array($this, 'page_init'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
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

  public function enqueue_admin_scripts($hook)
  {
    if ('toplevel_page_wp-resume-builder' !== $hook) {
      return;
    }
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_style('wp-resume-builder-admin', plugin_dir_url(__FILE__) . '../css/admin-style.css', array(), '1.0.0');
    wp_enqueue_script('wp-resume-builder-admin', plugin_dir_url(__FILE__) . '../js/admin-script.js', array('jquery', 'jquery-ui-tabs', 'wp-color-picker'), '1.0.0', true);
  }

  public function create_admin_page()
  {
    $this->options = get_option('wp_resume_builder_options');
?>
    <div class="wrap">
      <h1>WP Resume Builder Settings</h1>
      <div class="wp-resume-builder-shortcode-info">
        <h2>Shortcode</h2>
        <p>Use the following shortcode to display your resume on any page or post:</p>
        <code>[wp_resume]</code>
      </div>
      <form method="post" action="options.php">
        <?php
        settings_fields('wp_resume_builder_option_group');
        ?>
        <div id="wp-resume-builder-tabs">
          <ul>
            <li><a href="#tab-personal">Personal Info</a></li>
            <li><a href="#tab-objective">Objective</a></li>
            <li><a href="#tab-experience">Experience</a></li>
            <li><a href="#tab-education">Education</a></li>
            <li><a href="#tab-skills">Skills</a></li>
            <li><a href="#tab-design">Design</a></li>
          </ul>
          <div id="tab-personal">
            <?php $this->render_personal_info_fields(); ?>
          </div>
          <div id="tab-objective">
            <?php $this->render_objective_fields(); ?>
          </div>
          <div id="tab-experience">
            <?php $this->render_experience_fields(); ?>
          </div>
          <div id="tab-education">
            <?php $this->render_education_fields(); ?>
          </div>
          <div id="tab-skills">
            <?php $this->render_skills_fields(); ?>
          </div>
          <div id="tab-design">
            <?php $this->render_design_fields(); ?>
          </div>
        </div>
        <?php submit_button(); ?>
      </form>
    </div>
<?php
  }

  private function render_personal_info_fields()
  {
    $fields = array(
      'name' => 'Name',
      'tagline' => 'Tagline',
      'email' => 'Email',
      'phone' => 'Phone',
      'website' => 'Website',
      'linkedin' => 'LinkedIn',
      'twitter' => 'Twitter',
      'github' => 'GitHub'
    );

    foreach ($fields as $field => $label) {
      $this->render_text_field($field, $label);
    }
  }

  private function render_objective_fields()
  {
    $this->render_checkbox_field('disable_objective', 'Disable Objective Section');
    $this->render_text_field('objective_title', 'Objective Title');
    $this->render_textarea_field('objective_text', 'Objective Text');
  }

  private function render_experience_fields()
  {
    $this->render_checkbox_field('disable_experience', 'Disable Experience Section');
    $this->render_text_field('experience_title', 'Experience Title');
    $this->render_repeater_field('experience_entries', 'Experience Entries', array(
      'title' => 'Job Title',
      'company' => 'Company',
      'dates' => 'Dates',
      'description' => 'Description'
    ));
  }

  private function render_education_fields()
  {
    $this->render_checkbox_field('disable_education', 'Disable Education Section');
    $this->render_text_field('education_title', 'Education Title');
    $this->render_repeater_field('education_entries', 'Education Entries', array(
      'degree' => 'Degree',
      'school' => 'School',
      'dates' => 'Dates',
      'description' => 'Description'
    ));
  }

  private function render_skills_fields()
  {
    $this->render_checkbox_field('disable_skills', 'Disable Skills Section');
    $this->render_text_field('skills_title', 'Skills Title');
    $this->render_textarea_field('skills', 'Skills (one per line)');
  }

  private function render_design_fields()
  {
    $this->render_color_field('primary_color', 'Primary Color');
    $this->render_color_field('secondary_color', 'Secondary Color');
    $this->render_color_field('text_color', 'Text Color');
    $this->render_color_field('background_color', 'Background Color');
    $this->render_select_field('font_family', 'Font Family', array(
      'Arial, sans-serif' => 'Arial',
      'Helvetica, sans-serif' => 'Helvetica',
      'Georgia, serif' => 'Georgia',
      'Times New Roman, serif' => 'Times New Roman',
      'Courier New, monospace' => 'Courier New'
    ));
  }

  private function render_text_field($field, $label)
  {
    $value = isset($this->options[$field]) ? esc_attr($this->options[$field]) : '';
    echo "<div class='wp-resume-builder-field'>";
    echo "<label for='$field'>$label</label>";
    echo "<input type='text' id='$field' name='wp_resume_builder_options[$field]' value='$value' />";
    echo "</div>";
  }

  private function render_textarea_field($field, $label)
  {
    $value = isset($this->options[$field]) ? esc_textarea($this->options[$field]) : '';
    echo "<div class='wp-resume-builder-field'>";
    echo "<label for='$field'>$label</label>";
    echo "<textarea id='$field' name='wp_resume_builder_options[$field]'>$value</textarea>";
    echo "</div>";
  }

  private function render_checkbox_field($field, $label)
  {
    $checked = isset($this->options[$field]) && $this->options[$field] ? 'checked' : '';
    echo "<div class='wp-resume-builder-field'>";
    echo "<label for='$field'>";
    echo "<input type='checkbox' id='$field' name='wp_resume_builder_options[$field]' value='1' $checked />";
    echo " $label</label>";
    echo "</div>";
  }

  private function render_color_field($field, $label)
  {
    $value = isset($this->options[$field]) ? esc_attr($this->options[$field]) : '';
    echo "<div class='wp-resume-builder-field'>";
    echo "<label for='$field'>$label</label>";
    echo "<input type='text' id='$field' name='wp_resume_builder_options[$field]' value='$value' class='wp-resume-builder-color-picker' />";
    echo "</div>";
  }

  private function render_select_field($field, $label, $options)
  {
    $value = isset($this->options[$field]) ? esc_attr($this->options[$field]) : '';
    echo "<div class='wp-resume-builder-field'>";
    echo "<label for='$field'>$label</label>";
    echo "<select id='$field' name='wp_resume_builder_options[$field]'>";
    foreach ($options as $option_value => $option_label) {
      $selected = $value === $option_value ? 'selected' : '';
      echo "<option value='$option_value' $selected>$option_label</option>";
    }
    echo "</select>";
    echo "</div>";
  }

  private function render_repeater_field($field, $label, $sub_fields)
  {
    echo "<div class='wp-resume-builder-field wp-resume-builder-repeater' data-field='$field'>";
    echo "<label>$label</label>";
    echo "<div class='wp-resume-builder-repeater-items'>";

    if (isset($this->options[$field]) && is_array($this->options[$field])) {
      foreach ($this->options[$field] as $index => $item) {
        $this->render_repeater_item($field, $sub_fields, $index, $item);
      }
    }

    echo "</div>";
    echo "<button type='button' class='wp-resume-builder-add-item button'>Add Item</button>";
    echo "</div>";

    // Template for new items
    echo "<script type='text/template' id='tmpl-wp-resume-builder-$field-item'>";
    $this->render_repeater_item($field, $sub_fields, '{{data.index}}');
    echo "</script>";
  }

  private function render_repeater_item($field, $sub_fields, $index, $item = array())
  {
    echo "<div class='wp-resume-builder-repeater-item'>";
    foreach ($sub_fields as $sub_field => $sub_label) {
      $value = isset($item[$sub_field]) ? esc_attr($item[$sub_field]) : '';
      echo "<div class='wp-resume-builder-sub-field'>";
      echo "<label for='{$field}_{$index}_{$sub_field}'>$sub_label</label>";
      if ($sub_field === 'description') {
        echo "<textarea id='{$field}_{$index}_{$sub_field}' name='wp_resume_builder_options[$field][$index][$sub_field]'>$value</textarea>";
      } else {
        echo "<input type='text' id='{$field}_{$index}_{$sub_field}' name='wp_resume_builder_options[$field][$index][$sub_field]' value='$value' />";
      }
      echo "</div>";
    }
    echo "<button type='button' class='wp-resume-builder-remove-item button'>Remove</button>";
    echo "</div>";
  }

  public function page_init()
  {
    register_setting(
      'wp_resume_builder_option_group',
      'wp_resume_builder_options',
      array($this, 'sanitize')
    );
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
}
