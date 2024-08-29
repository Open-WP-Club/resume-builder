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
    if (!isset($this->options['disable_objective']) || !$this->options['disable_objective']) {
      $this->render_objective();
    }

    // Experience Section
    if (!isset($this->options['disable_experience']) || !$this->options['disable_experience']) {
      $this->render_experience();
    }

    // Skills Section
    if (!isset($this->options['disable_skills']) || !$this->options['disable_skills']) {
      $this->render_skills();
    }

    // Education Section
    if (!isset($this->options['disable_education']) || !$this->options['disable_education']) {
      $this->render_education();
    }

    // Github Section
    if ((!isset($this->options['disable_github']) || !$this->options['disable_github']) && !empty($this->options['github'])) {
      $this->render_github();
    }

    // Portfolio Section
    if (!isset($this->options['disable_portfolio']) || !$this->options['disable_portfolio']) {
      $this->render_portfolio();
    }

    // Get the buffered content and return it
    return ob_get_clean();
  }

  private function render_personal_info()
  {
?>
    <div class="personal-info">
      <h1><?php echo esc_html($this->options['name'] ?? ''); ?></h1>
      <p class="tagline"><?php echo esc_html($this->options['tagline'] ?? ''); ?></p>
      <div class="contact-info">
        <?php if (!empty($this->options['email'])) : ?>
          <a href="mailto:<?php echo esc_attr($this->options['email']); ?>" title="Email">
            <?php echo $this->get_svg_icon('email'); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($this->options['phone'])) : ?>
          <a href="tel:<?php echo esc_attr($this->options['phone']); ?>" title="Phone">
            <?php echo $this->get_svg_icon('phone'); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($this->options['website'])) : ?>
          <a href="<?php echo esc_url($this->options['website']); ?>" target="_blank" title="Website">
            <?php echo $this->get_svg_icon('website'); ?>
          </a>
        <?php endif; ?>
      </div>
      <div class="social-links">
        <?php if (!empty($this->options['linkedin'])) : ?>
          <a href="https://linkedin.com/in/<?php echo esc_attr($this->options['linkedin']); ?>" target="_blank" title="LinkedIn">
            <?php echo $this->get_svg_icon('linkedin'); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($this->options['twitter'])) : ?>
          <a href="https://twitter.com/<?php echo esc_attr($this->options['twitter']); ?>" target="_blank" title="Twitter">
            <?php echo $this->get_svg_icon('twitter'); ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($this->options['github'])) : ?>
          <a href="https://github.com/<?php echo esc_attr($this->options['github']); ?>" target="_blank" title="GitHub">
            <?php echo $this->get_svg_icon('github'); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  <?php
  }

  private function render_objective()
  {
  ?>
    <div class="objective-section">
      <h2><?php echo esc_html($this->options['objective_title'] ?? 'Objective'); ?></h2>
      <p><?php echo wp_kses_post($this->options['objective_text'] ?? ''); ?></p>
    </div>
  <?php
  }

  private function render_experience()
  {
  ?>
    <div class="experience-section">
      <h2><?php echo esc_html($this->options['experience_title'] ?? 'Experience'); ?></h2>
      <?php
      if (isset($this->options['experience_entries']) && is_array($this->options['experience_entries'])) {
        foreach ($this->options['experience_entries'] as $entry) {
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
  ?>
    <div class="skills-section">
      <h2><?php echo esc_html($this->options['skills_title'] ?? 'Skills'); ?></h2>
      <ul>
        <?php
        if (isset($this->options['skills']) && is_array($this->options['skills'])) {
          foreach ($this->options['skills'] as $skill) {
            echo '<li>' . esc_html($skill) . '</li>';
          }
        }
        ?>
      </ul>
    </div>
  <?php
  }

  private function render_education()
  {
  ?>
    <div class="education-section">
      <h2><?php echo esc_html($this->options['education_title'] ?? 'Education'); ?></h2>
      <?php
      if (isset($this->options['education_entries']) && is_array($this->options['education_entries'])) {
        foreach ($this->options['education_entries'] as $entry) {
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

  private function render_github()
  {
    // You would need to implement GitHub API integration here
    // For now, we'll just display a link to the GitHub profile
  ?>
    <div class="github-section">
      <h2>GitHub Activity</h2>
      <p>Check out my latest activity on <a href="https://github.com/<?php echo esc_attr($this->options['github']); ?>" target="_blank">GitHub</a>.</p>
    </div>
  <?php
  }

  private function render_portfolio()
  {
    // Implementation for portfolio section
    // This would typically involve displaying project images and descriptions
  ?>
    <div class="portfolio-section">
      <h2>Portfolio</h2>
      <p>Portfolio implementation goes here.</p>
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
