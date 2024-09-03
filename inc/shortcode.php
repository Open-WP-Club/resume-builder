<?php
class WP_Resume_Builder_Shortcode
{
  private $options;

  public function init()
  {
    $this->options = get_option('wp_resume_builder_options', array());
    add_shortcode('wp_resume', array($this, 'render_resume'));
  }

  public function render_resume($atts)
  {
    // Start output buffering
    ob_start();

    // Personal Information
    $this->render_personal_info();

    // Objective Section
    if (!isset($this->options['objective']['disable_objective']) || !$this->options['objective']['disable_objective']) {
      $this->render_objective();
    }

    // Experience Section
    if (!isset($this->options['experience']['disable_experience']) || !$this->options['experience']['disable_experience']) {
      $this->render_experience();
    }

    // Skills Section
    if (!isset($this->options['skills']['disable_skills']) || !$this->options['skills']['disable_skills']) {
      $this->render_skills();
    }

    // Education Section
    if (!isset($this->options['education']['disable_education']) || !$this->options['education']['disable_education']) {
      $this->render_education();
    }

    // Get the buffered content and return it
    return ob_get_clean();
  }

  private function render_personal_info()
  {
    $personal = $this->options['personal'] ?? array();
?>
    <div class="personal-info">
      <h1><?php echo esc_html($personal['name'] ?? ''); ?></h1>
      <p class="tagline"><?php echo esc_html($personal['tagline'] ?? ''); ?></p>
      <div class="contact-info">
        <?php if (!empty($personal['email'])) : ?>
          <a href="mailto:<?php echo esc_attr($personal['email']); ?>" title="Email">
            <?php echo $this->get_svg_icon('email'); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($personal['phone'])) : ?>
          <a href="tel:<?php echo esc_attr($personal['phone']); ?>" title="Phone">
            <?php echo $this->get_svg_icon('phone'); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($personal['website'])) : ?>
          <a href="<?php echo esc_url($personal['website']); ?>" target="_blank" title="Website">
            <?php echo $this->get_svg_icon('website'); ?>
          </a>
        <?php endif; ?>
      </div>
      <div class="social-links">
        <?php if (!empty($personal['linkedin'])) : ?>
          <a href="https://linkedin.com/in/<?php echo esc_attr($personal['linkedin']); ?>" target="_blank" title="LinkedIn">
            <?php echo $this->get_svg_icon('linkedin'); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($personal['twitter'])) : ?>
          <a href="https://twitter.com/<?php echo esc_attr($personal['twitter']); ?>" target="_blank" title="Twitter">
            <?php echo $this->get_svg_icon('twitter'); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($personal['github'])) : ?>
          <a href="https://github.com/<?php echo esc_attr($personal['github']); ?>" target="_blank" title="GitHub">
            <?php echo $this->get_svg_icon('github'); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  <?php
  }

  private function render_objective()
  {
    $objective = $this->options['objective'] ?? array();
  ?>
    <div class="objective-section">
      <h2><?php echo esc_html($objective['objective_title'] ?? 'Objective'); ?></h2>
      <p><?php echo wp_kses_post($objective['objective_text'] ?? ''); ?></p>
    </div>
  <?php
  }

  private function render_experience()
  {
    $experience = $this->options['experience'] ?? array();
  ?>
    <div class="experience-section">
      <h2><?php echo esc_html($experience['experience_title'] ?? 'Experience'); ?></h2>
      <?php
      if (isset($experience['experience_entries']) && is_array($experience['experience_entries'])) {
        foreach ($experience['experience_entries'] as $entry) {
      ?>
          <div class="experience-entry">
            <h3><?php echo esc_html($entry['title']); ?> at <?php echo esc_html($entry['company']); ?></h3>
            <p class="dates"><?php echo esc_html($entry['dates']); ?></p>
            <p><?php echo wp_kses_post($entry['description']); ?></p>
          </div>
      <?php
        }
      }
      ?>
    </div>
  <?php
  }

  private function render_skills()
  {
    $skills = $this->options['skills'] ?? array();
  ?>
    <div class="skills-section">
      <h2><?php echo esc_html($skills['skills_title'] ?? 'Skills'); ?></h2>
      <ul>
        <?php
        if (isset($skills['skills']) && !empty($skills['skills'])) {
          $skills_list = explode("\n", $skills['skills']);
          foreach ($skills_list as $skill) {
            echo '<li>' . esc_html(trim($skill)) . '</li>';
          }
        }
        ?>
      </ul>
    </div>
  <?php
  }

  private function render_education()
  {
    $education = $this->options['education'] ?? array();
  ?>
    <div class="education-section">
      <h2><?php echo esc_html($education['education_title'] ?? 'Education'); ?></h2>
      <?php
      if (isset($education['education_entries']) && is_array($education['education_entries'])) {
        foreach ($education['education_entries'] as $entry) {
      ?>
          <div class="education-entry">
            <h3><?php echo esc_html($entry['degree']); ?> - <?php echo esc_html($entry['school']); ?></h3>
            <p class="dates"><?php echo esc_html($entry['dates']); ?></p>
            <p><?php echo wp_kses_post($entry['description']); ?></p>
          </div>
      <?php
        }
      }
      ?>
    </div>
<?php
  }

  private function get_svg_icon($icon_name)
  {
    $icon_path = WP_RESUME_BUILDER_PLUGIN_DIR . 'assets/icons/' . $icon_name . '.svg';
    if (file_exists($icon_path)) {
      return file_get_contents($icon_path);
    }
    return '';
  }
}
