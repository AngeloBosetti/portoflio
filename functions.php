<?php
// Activer les vignettes
add_theme_support('post-thumbnails');


add_theme_support('custom-logo');

function register_my_menus()
{
    register_nav_menus(array(
        'header-menu' => __('Header Menu'),
    ));
}
add_action('init', 'register_my_menus');



//ajoute de fonts

function charger_styles_theme()
{
    wp_enqueue_style('style-principal', get_stylesheet_uri());
    wp_add_inline_style('style-principal', "
        @font-face {
            font-family: 'TAN PEARL';
            src: url('" . get_template_directory_uri() . "/media/fonts/TAN-PEARL.otf') format('opentype');
        }
    ");
}
add_action('wp_enqueue_scripts', 'charger_styles_theme');




//sprict pour le bouton volume on/off
function enqueue_custom_scripts() {
    wp_enqueue_script(
        'volume-toggle', 
        get_template_directory_uri() . '/js/volume-toggle.js', 
        array(), 
        false, 
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


// Ajouter une vidéo de fond venant de Wordpress
function theme_customize_register($wp_customize)
{
    // Ajouter une section pour la vidéo
    $wp_customize->add_section('background_video_section', array(
        'title' => __('Vidéo de fond', 'textdomain'),
        'priority' => 30,
    ));

    // Ajouter un réglage pour la vidéo
    $wp_customize->add_setting('background_video', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // Ajouter un contrôle pour uploader la vidéo
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'background_video_control', array(
        'label' => __('Vidéo de fond', 'textdomain'),
        'section' => 'background_video_section',
        'mime_type' => 'video',
        'settings' => 'background_video',
    )));
}
add_action('customize_register', 'theme_customize_register');
