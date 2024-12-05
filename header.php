<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div class="wrap">
    <header class="site-header">
      <!-- Conteneur flex pour Logo et Audio -->
      <div class="header-content">
        <!-- Logo -->
        <div class="header-logo">
          <?php if (has_custom_logo()) {
            the_custom_logo();
          } else { ?>
            <a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a>
          <?php } ?>
        </div>

        <!-- Audio personnalisé -->
        <div class="audio-wrapper">
          <audio id="background-audio"
            src="<?php echo get_template_directory_uri(); ?>/media/audio/background-music.mp3" autoplay loop></audio>
          <div class="audio-controls">
            <input id="volume-slider" type="range" min="0" max="1" step="0.01" value="0.5">
            <button id="mute-toggle" aria-label="Mute/Unmute">
              <img src="<?php echo get_template_directory_uri(); ?>/media/icons/volume-on.svg" alt="Volume On"
                class="icon volume-on">
              <img src="<?php echo get_template_directory_uri(); ?>/media/icons/volume-off.svg" alt="Volume Off"
                class="icon volume-off hidden">
            </button>
          </div>
        </div>
      </div>

      <!-- Menu Toggle centré -->
      <div class="menu-toggle">menu</div>
    </header>

    <!-- Navigation Menu -->
    <nav class="site-navigation">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'container_class' => 'menu-container',
        'menu_class' => 'menu-items',
      ));
      ?>
    </nav>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const menuToggle = document.querySelector('.menu-toggle');
      const siteNavigation = document.querySelector('.site-navigation');
      const audio = document.getElementById('background-audio');
      const muteToggle = document.getElementById('mute-toggle');
      const volumeSlider = document.getElementById('volume-slider');
      const volumeOnIcon = document.querySelector('.volume-on');
      const volumeOffIcon = document.querySelector('.volume-off');

      // Toggle menu visibility
      menuToggle.addEventListener('click', function () {
        siteNavigation.classList.toggle('active');
      });

      // Close menu when clicking outside
      document.addEventListener('click', function (event) {
        if (!siteNavigation.contains(event.target) && !menuToggle.contains(event.target)) {
          siteNavigation.classList.remove('active');
        }
      });

      // Initial mute state
      audio.muted = false;

      muteToggle.addEventListener('click', function () {
        audio.muted = !audio.muted;
        volumeOnIcon.classList.toggle('hidden', audio.muted);
        volumeOffIcon.classList.toggle('hidden', !audio.muted);
      });

      volumeSlider.addEventListener('input', function () {
        audio.volume = this.value;
        audio.muted = this.value == 0; // Auto-mute if volume is 0
        volumeOnIcon.classList.toggle('hidden', audio.muted);
        volumeOffIcon.classList.toggle('hidden', !audio.muted);
      });
    });
  </script>

  <?php wp_footer(); ?>
</body>

</html>