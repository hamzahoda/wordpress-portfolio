<?php
/**
 * Certy admin functions
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

Kirki::add_config( 'certy_kirki_config', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'option',
    'option_name'   => 'theme_mods_certy'
) );


//Styling Options
Kirki::add_panel( 'styling_options', array(
    'priority'    => 52,
    'title'       => __( 'Styling', 'certy' ),
) );
//color scheme
Kirki::add_section( 'color_options', array(
    'title'          => __( 'Color Scheme', 'certy' ),
    'description'    => __( 'Here you can customize color scheme', 'certy' ),
    'panel'          => 'styling_options', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'custom',
    'settings'    => 'color_scheme_heading',
    'section'     => 'color_options',
    'default'     => '<h2>' . __( 'Theme Colors', 'certy' ) . '</h2>',
    'priority'    => 10,
) );
//theme colors
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'preset',
    'settings'    => 'color_scheme',
    'label'       => __( 'Select Predefined Color Scheme', 'certy' ),
    'section'     => 'color_options',
    'default'     => 'designer',
    'priority'    => 10,
    'multiple'    => 0,
    'choices'     => array(
        'designer' => array(
            'label'    => __( 'Designer', 'certy' ),
            'settings' => array(
                'primary_color' => '#c0e3e7',
                'primary_text_color' => '#010101',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#e1e1e1',
                'shape_color_right' => '#c0e3e7',
                'body_color' => '#f3f3f3',
                'paper_color' => '#fff',
                'default_buttons_color' => '#c0e3e7',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#041f28',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
        'florist' => array(
            'label'    => __( 'Florist', 'certy' ),
            'settings' => array(
                'primary_color' => '#2EB474',
                'primary_text_color' => '#FFFFFF',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#e1e1e1',
                'shape_color_right' => '#2EB474',
                'body_color' => '#f3f3f3',
                'paper_color' => '#fff',
                'default_buttons_color' => '#F16B1A',
                'default_buttons_text_color' => '#FFFFFF',
                'secondary_buttons_color' => '#F16B1A',
                'secondary_buttons_text_color' => '#FFFFFF',
            ),
        ),
        'architect' => array(
            'label'    => __( 'Architect', 'certy' ),
            'settings' => array(
                'primary_color' => '#2B2B2B',
                'primary_text_color' => '#FFFFFF',
                'main_text_color' => '#010101',
                'muted_text_color' => '#353535',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#EDD78E',
                'shape_color_right' => '#EDD78E',
                'body_color' => '#f3f3f3',
                'paper_color' => '#fff',
                'default_buttons_color' => '#3A79EB',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#2B2B2B',
                'secondary_buttons_text_color' => '#FFFFFF',
            ),
        ),
        'attorney' => array(
            'label'    => __( 'Attorney', 'certy' ),
            'settings' => array(
                'primary_color' => '#223D72',
                'primary_text_color' => '#F4F4F4',
                'main_text_color' => '#000000',
                'muted_text_color' => '#000000',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#A71A1F',
                'shape_color_right' => '#223D72',
                'body_color' => '#F3F3F3',
                'paper_color' => '#FFFFFF',
                'default_buttons_color' => '#c0e3e7',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#041f28',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
        'developer' => array(
            'label'    => __( 'Developer', 'certy' ),
            'settings' => array(
                'primary_color' => '#1FA184',
                'primary_text_color' => '#FFFFFF',
                'main_text_color' => '#FFFFFF',
                'muted_text_color' => '#757575',
                'border_color' => '#2C363B',
                'shape_color_left' => '#0F171B',
                'shape_color_right' => '#1FA184',
                'body_color' => '#121F26',
                'paper_color' => '#313C42',
                'default_buttons_color' => '#DEC746',
                'default_buttons_text_color' => '#000000',
                'secondary_buttons_color' => '#000000',
                'secondary_buttons_text_color' => '#FFFFFF',
            ),
        ),
        'dj' => array(
            'label'    => __( 'DJ', 'certy' ),
            'settings' => array(
                'primary_color' => '#754BCE',
                'primary_text_color' => '#FFFFFF',
                'main_text_color' => '#FFFFFF',
                'muted_text_color' => '#B7B7B7',
                'border_color' => '#2C363B',
                'shape_color_left' => '#322A54',
                'shape_color_right' => '#322A54',
                'body_color' => '#161C1F',
                'paper_color' => '#22292C',
                'default_buttons_color' => '#C69630',
                'default_buttons_text_color' => '#FFFFFF',
                'secondary_buttons_color' => '#000000',
                'secondary_buttons_text_color' => '#FFFFFF',
            ),
        ),
        'doctor' => array(
            'label'    => __( 'Doctor', 'certy' ),
            'settings' => array(
                'primary_color' => '#4EC0F4',
                'primary_text_color' => '#FFFFFF',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#07AAF5',
                'shape_color_right' => '#07AAF5',
                'body_color' => '#f3f3f3',
                'paper_color' => '#FFFFFF',
                'default_buttons_color' => '#C0E3E7',
                'default_buttons_text_color' => '#FFFFFF',
                'secondary_buttons_color' => '#07AAF5',
                'secondary_buttons_text_color' => '#FFFFFF',
            ),
        ),
        'teacher' => array(
            'label'    => __( 'Teacher', 'certy' ),
            'settings' => array(
                'primary_color' => '#F1CA3E',
                'primary_text_color' => '#FFFFFF',
                'main_text_color' => '#393529',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#8E3A5C',
                'shape_color_right' => '#F1CA3E',
                'body_color' => '#F0ECEC',
                'paper_color' => '#FFFFFF',
                'default_buttons_color' => '#F1CA3E',
                'default_buttons_text_color' => '#FFFFFF',
                'secondary_buttons_color' => '#8E3A5C',
                'secondary_buttons_text_color' => '#FFFFFF',
            ),
        ),
        'Color-2' => array(
            'label'    => __( 'Color 2', 'certy' ),
            'settings' => array(
                'primary_color' => '#3a79eb',
                'primary_text_color' => '#ffffff',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#89e06e',
                'shape_color_right' => '#3a79eb',
                'body_color' => '#f3f3f3',
                'paper_color' => '#fff',
                'default_buttons_color' => '#3a79eb',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#89e06e',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
        'Color-3' => array(
            'label'    => __( 'Color 3', 'certy' ),
            'settings' => array(
                'primary_color' => '#f37f9a',
                'primary_text_color' => '#ffffff',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#394567',
                'shape_color_right' => '#f37f9a',
                'body_color' => '#f3f3f3',
                'paper_color' => '#dddddd',
                'default_buttons_color' => '#f37f9a',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#1bbe4d',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
        'Color-4' => array(
            'label'    => __( 'Color 4', 'certy' ),
            'settings' => array(
                'primary_color' => '#f1ca3e',
                'primary_text_color' => '#ffffff',
                'main_text_color' => '#393529',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#8e3a5c',
                'shape_color_right' => '#f1ca3e',
                'body_color' => '#f0ecec',
                'paper_color' => '#fff',
                'default_buttons_color' => '#f1ca3e',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#8e3a5c',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
        'Color-5' => array(
            'label'    => __( 'Color 5', 'certy' ),
            'settings' => array(
                'primary_color' => '#25b4d0',
                'primary_text_color' => '#ffffff',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#f1ca3e',
                'shape_color_right' => '#25b4d0',
                'body_color' => '#f3f3f3',
                'paper_color' => '#fff',
                'default_buttons_color' => '#25b4d0',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#f1ca3e',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
        'Color-6' => array(
            'label'    => __( 'Color 6', 'certy' ),
            'settings' => array(
                'primary_color' => '#205876',
                'primary_text_color' => '#ffffff',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#db9418',
                'shape_color_right' => '#205876',
                'body_color' => '#121f26',
                'paper_color' => '#313c42',
                'default_buttons_color' => '#205876',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#db9418',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
        'Color-7' => array(
            'label'    => __( 'Color 7', 'certy' ),
            'settings' => array(
                'primary_color' => '#05bd9b',
                'primary_text_color' => '#ffffff',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#000000',
                'shape_color_left' => '#47484b',
                'shape_color_right' => '#05bd9b',
                'body_color' => '#303030',
                'paper_color' => '#47484b',
                'default_buttons_color' => '#05bd9b',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#f1ca3e',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
        'Color-8' => array(
            'label'    => __( 'Color 8', 'certy' ),
            'settings' => array(
                'primary_color' => '#ea6a8e',
                'primary_text_color' => '#ffffff',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#1bbe4d',
                'shape_color_right' => '#ea6a8e',
                'body_color' => '#48cc92',
                'paper_color' => '#fff',
                'default_buttons_color' => '#ea6a8e',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#48cc92',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
        'Color-9' => array(
            'label'    => __( 'Color 9', 'certy' ),
            'settings' => array(
                'primary_color' => '#6353a7',
                'primary_text_color' => '#ffffff',
                'main_text_color' => '#010101',
                'muted_text_color' => '#757575',
                'border_color' => '#e1e1e1',
                'shape_color_left' => '#1bbe4d',
                'shape_color_right' => '#6353a7',
                'body_color' => '#ace8f3',
                'paper_color' => '#fafafc',
                'default_buttons_color' => '#6353a7',
                'default_buttons_text_color' => '#010101',
                'secondary_buttons_color' => '#1bbe4d',
                'secondary_buttons_text_color' => '#fff',
            ),
        ),
    ),
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'primary_color',
    'label'       => __( 'Primary Color', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#c0e3e7',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'primary_text_color',
    'label'       => __( 'Primary Text Color', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#010101',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'main_text_color',
    'label'       => __( 'Main Text Color', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#010101',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'muted_text_color',
    'label'       => __( 'Muted Text, Header Nav, Slider Arrows, Pagination etc.', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#757575',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'border_color',
    'label'       => __( 'Borders', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#e1e1e1',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'shape_color_left',
    'label'       => __( 'Left Shape Color', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#e1e1e1',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'shape_color_right',
    'label'       => __( 'Right Shape Color', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#c0e3e7',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'body_color',
    'label'       => __( 'Body Background Color, Inputs Background Color', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#f3f3f3',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'paper_color',
    'label'       => __( 'Papers Background Color & Other White Elements', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#fff',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'custom',
    'settings'    => 'button_color_scheme_heading',
    'section'     => 'color_options',
    'default'     => '<h2>' . __( 'Button Colors', 'certy' ) . '</h2>',
    'priority'    => 10,
) );
//button colors
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'default_buttons_color',
    'label'       => __( 'Default Button Background Color', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#c0e3e7',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'default_buttons_text_color',
    'label'       => __( 'Text Color For Default Buttons', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#010101',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'secondary_buttons_color',
    'label'       => __( 'Secondary Button Background Color', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#041f28',
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'secondary_buttons_text_color',
    'label'       => __( 'Text Color For Secondary buttons', 'certy' ),
    'section'     => 'color_options',
    'priority'    => 10,
    'default'     => '#fff',
) );
//background & paper
Kirki::add_section( 'bg_paper_options', array(
    'title'          => __( 'Background & Paper', 'certy' ),
    'description'    => __( 'Here you can customize the background and paper options', 'certy' ),
    'panel'          => 'styling_options', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'custom',
    'settings'    => 'Background_heading',
    'section'     => 'bg_paper_options',
    'default'     => '<h2>' . __( 'Background', 'certy' ) . '</h2>',
    'priority'    => 10,
) );
//background
Kirki::add_field( 'certy_kirki_config', array(
    'settings' => 'bg_image',
    'label'    => __( 'Image', 'certy' ),
    'section'  => 'bg_paper_options',
    'type'     => 'image',
    'priority' => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'settings' => 'bg_image_style',
    'label'    => __( 'Image Style', 'certy' ),
    'section'  => 'bg_paper_options',
    'type'     => 'radio-buttonset',
    'priority' => 10,
    'default'  => 'cover',
    'choices'     => array(
        'cover'   => __( 'Cover', 'certy' ),
        'fixed' => __( 'Fixed', 'certy' ),
    ),
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'checkbox',
    'settings'    => 'enable_bg_overlay',
    'label'       => __( 'Enable Overlay For Image', 'certy' ),
    'section'     => 'bg_paper_options',
    'default'     => '0',
    'priority'    => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'color',
    'settings'    => 'overlay_color',
    'label'       => __( 'Overlay Color', 'certy' ),
    'section'     => 'bg_paper_options',
    'default'     => 'rgba(0,0,0,0.5)',
    'priority'    => 10,
    'choices'     => array(
        'alpha' => true,
    ),
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'checkbox',
    'settings'    => 'disable_left_shape',
    'label'       => __( 'Disable Left Shape', 'certy' ),
    'section'     => 'bg_paper_options',
    'default'     => '0',
    'priority'    => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'checkbox',
    'settings'    => 'disable_right_shape',
    'label'       => __( 'Disable Right Shape', 'certy' ),
    'section'     => 'bg_paper_options',
    'default'     => '0',
    'priority'    => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'custom',
    'settings'    => 'paper_heading',
    'section'     => 'bg_paper_options',
    'default'     => '<h2>' . __( 'Paper', 'certy' ) . '</h2>',
    'priority'    => 10,
) );
//paper
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'checkbox',
    'settings'    => 'disable_paper_animation',
    'label'       => __( 'Disable Paper Animation', 'certy' ),
    'section'     => 'bg_paper_options',
    'default'     => '0',
    'priority'    => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'settings' => 'paper_layers_count',
    'label'    => __( 'Paper Layers Count', 'certy' ),
    'section'  => 'bg_paper_options',
    'type'     => 'radio-buttonset',
    'priority' => 10,
    'default'  => '1',
    'choices'     => array(
        '1'   => __( '1', 'certy' ),
        '2' => __( '2', 'certy' ),
        '3' => __( '3', 'certy' ),
    ),
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'checkbox',
    'settings'    => 'blog_separate_paper',
    'label'       => __( 'Show Blog Posts In Separate Papers', 'certy' ),
    'section'     => 'bg_paper_options',
    'default'     => '0',
    'priority'    => 10,
) );


//Header Options
Kirki::add_section( 'header_options', array(
    'title'          => __( 'Header', 'certy' ),
    'description'    => __( 'Here you can customize header options', 'certy' ),
    'panel'          => '', // Not typically needed.
    'priority'       => 50,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

Kirki::add_field( 'certy_kirki_config', array(
    'settings' => 'custom_logo',
    'label'    => __( 'Logo', 'certy' ),
    'section'  => 'header_options',
    'type'     => 'image',
    'priority' => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'settings' => 'custom_logo_retina',
    'label'    => __( 'Retina Logo', 'certy' ),
    'section'  => 'header_options',
    'type'     => 'image',
    'priority' => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'text',
    'settings' => 'logo_text',
    'label'    => __( 'Logo Text', 'certy' ),
    'section'  => 'header_options',
    'default'  => __( 'certy', 'certy' ),
    'priority' => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'settings' => 'logo_position',
    'label'    => __( 'Logo Position', 'certy' ),
    'section'  => 'header_options',
    'type'     => 'radio-buttonset',
    'priority' => 10,
    'default'  => 'in',
    'choices'     => array(
        'in'   => __( 'In', 'certy' ),
        'out' => __( 'Out', 'certy' ),
    ),
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'checkbox',
    'settings'    => 'hide_logo_area',
    'label'       => __( 'Hide Logo Area', 'certy' ),
    'section'     => 'header_options',
    'default'     => '0',
    'priority'    => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'settings' => 'menu_position',
    'label'    => __( 'Menu Position', 'certy' ),
    'section'  => 'header_options',
    'type'     => 'radio-buttonset',
    'priority' => 10,
    'default'  => 'left',
    'choices'     => array(
        'left'   => __( 'Left', 'certy' ),
        'center' => __( 'Center', 'certy' ),
        'right' => __( 'Right', 'certy' ),
    ),
) );


//Footer Options
Kirki::add_section( 'footer_options', array(
    'title'          => __( 'Footer', 'certy' ),
    'description'    => __( 'Here you can customize footer options', 'certy' ),
    'panel'          => '', // Not typically needed.
    'priority'       => 51,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'textarea',
    'settings' => 'footer_content',
    'label'    => __( 'Footer Content', 'certy' ),
    'section'  => 'footer_options',
    'priority' => 10,
) );


//Vertical Navigation Options
Kirki::add_section( 'vertical_navigation_options', array(
    'title'          => __( 'Vertical Navigation', 'certy' ),
    'description'    => __( 'Here you can customize vertical navigation', 'certy' ),
    'panel'          => '', // Not typically needed.
    'priority'       => 56,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'checkbox',
    'settings'    => 'enable_sticky',
    'label'       => __( 'Enable Sticky Navigation', 'certy' ),
    'section'     => 'vertical_navigation_options',
    'default'     => '0',
    'priority'    => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'checkbox',
    'settings'    => 'show_vertical_navigation_bg',
    'label'       => __( 'Show Vertical Navigation Background', 'certy' ),
    'section'     => 'vertical_navigation_options',
    'default'     => '0',
    'priority'    => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'checkbox',
    'settings'    => 'show_vertical_navigation_home',
    'label'       => __( 'Show Vertical navigation on home page only', 'certy' ),
    'section'     => 'vertical_navigation_options',
    'default'     => '0',
    'priority'    => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'settings' => 'personal_image',
    'label'    => __( 'Personal Image', 'certy' ),
    'description'    => __( 'Upload the image for the first menu item', 'certy' ),
    'section'  => 'vertical_navigation_options',
    'type'     => 'image',
    'priority' => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'text',
    'settings' => 'link_for_personal_image',
    'label'    => __( 'Link For Personal Image', 'certy' ),
    'section'  => 'vertical_navigation_options',
    'priority' => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'text',
    'settings' => 'tooltip_for_personal_image',
    'label'    => __( 'Tooltip For Personal Image', 'certy' ),
    'section'  => 'vertical_navigation_options',
    'priority' => 10,
) );


//Typography Options
Kirki::add_section( 'typography_options', array(
    'title'          => __( 'Typography', 'certy' ),
    'description'    => __( 'Here you can customize typography options', 'certy' ),
    'panel'          => '', // Not typically needed.
    'priority'       => 53,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'text',
    'settings' => 'google_font_api_key',
    'label'    => __( 'Google Font Api Key', 'certy' ),
    'description'     => __( 'Follow ', 'certy' ).'<a target="_blank" href="https://support.google.com/cloud/answer/6158862">'. __( 'the instructions', 'certy' ) .'</a>'. __( ' to get api key', 'certy' ),
    'section'  => 'typography_options',
    'priority' => 10,
) );
$google_fonts = certy_get_google_fonts();
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'select',
    'settings'    => 'main_font_family',
    'label'       => __( 'Main Font Family', 'certy' ),
    'section'     => 'typography_options',
    'default'     => 'option-1',
    'priority'    => 10,
    'multiple'    => 1,
    'choices'     => $google_fonts
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'select',
    'settings'    => 'heading_font_family',
    'label'       => __( 'Heading Font Family', 'certy' ),
    'section'     => 'typography_options',
    'default'     => 'option-1',
    'priority'    => 10,
    'multiple'    => 1,
    'choices'     => $google_fonts
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'select',
    'settings'    => 'logo_font_family',
    'label'       => __( 'Logo Font Family', 'certy' ),
    'section'     => 'typography_options',
    'default'     => 'option-1',
    'priority'    => 10,
    'multiple'    => 1,
    'choices'     => $google_fonts
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'select',
    'settings'    => 'button_font_family',
    'label'       => __( 'Button Font Family', 'certy' ),
    'section'     => 'typography_options',
    'default'     => 'option-1',
    'priority'    => 10,
    'multiple'    => 1,
    'choices'     => $google_fonts
) );


//Social Options
Kirki::add_section( 'social_options', array(
    'title'          => __( 'Social', 'certy' ),
    'description'    => __( 'Here you can customize social options', 'certy' ),
    'panel'          => '', // Not typically needed.
    'priority'       => 54,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'text',
    'settings'    => 'share_div',
    'section'     => 'social_options',
    'label'    => __( 'Addthis Inline Share Toolbox', 'certy' ),
    'description' => __( 'Put here the addthis div to show the social share', 'certy' ),
    'sanitize_callback' => 'wp_kses_post',
    'priority'    => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'repeater',
    'label'       => __( 'Add Socials', 'certy' ),
    'section'     => 'social_options',
    'priority'    => 10,
    'row_label' => array(
        'type' => 'text',
        'value' => __('Social', 'certy' ),
    ),
    'settings'    => 'social_options',
    'fields' => array(
        'link_text' => array(
            'type'        => 'text',
            'label'       => __( 'Name', 'certy' ),
            'description' => __( 'The social icon name', 'certy' ),
            'default'     => '',
        ),
        'link_url' => array(
            'type'        => 'text',
            'label'       => __( 'Link URL', 'certy' ),
            'description' => __( 'This will be the link URL for social icon', 'certy' ),
            'default'     => '',
        ),
    )
) );


//Other Options
Kirki::add_section( '404_options', array(
    'title'          => __( '404 Options', 'certy' ),
    'panel'          => '', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'        => 'custom',
    'settings'    => '404_heading',
    'section'     => '404_options',
    'default'     => '<h2>' . __( '404 Page', 'certy' ) . '</h2>',
    'priority'    => 10,
) );
//404 page
Kirki::add_field( 'certy_kirki_config', array(
    'settings' => '404_title',
    'label'    => __( 'Title', 'certy' ),
    'section'  => '404_options',
    'type'     => 'text',
    'default'  => __( '404', 'certy' ),
    'priority' => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'textarea',
    'settings' => '404_description',
    'label'    => __( 'description', 'certy' ),
    'section'  => '404_options',
    'default'  => __( 'THE PAGE YOU WERE LOOKING FOR DOESN\'T EXIST', 'certy' ),
    'priority' => 10,
) );
Kirki::add_field( 'certy_kirki_config', array(
    'settings' => '404_button_text',
    'label'    => __( 'Button Text', 'certy' ),
    'section'  => '404_options',
    'type'     => 'text',
    'default'  => __( 'Go Back', 'certy' ),
    'priority' => 10,
) );

//map Options
Kirki::add_section( 'map_options', array(
    'title'          => __( 'Map', 'certy' ),
    'panel'          => '', // Not typically needed.
    'priority'       => 55,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
//google map
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'text',
    'settings' => 'google_map_api_key',
    'label'    => __( 'Google Map Api Key', 'certy' ),
    'description'     => __( 'Follow ', 'certy' ).'<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">'. __( 'the instructions', 'certy' ) .'</a>'. __( ' to get api key', 'certy' ),
    'section'  => 'map_options',
    'priority' => 10,
) );
//google map
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'textarea',
    'settings' => 'google_map_style',
    'label'    => __( 'Google Map Style', 'certy' ),
    'description'     => __( 'Put the json code from here ', 'certy' ).'<a target="_blank" href="https://snazzymaps.com/">'. __( 'snazzymaps', 'certy' ) .'</a>',
    'section'  => 'map_options',
    'priority' => 10,
) );

//other Options
Kirki::add_section( 'other_options', array(
    'title'          => __( 'Other', 'certy' ),
    'panel'          => '', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
//Left Sidebar
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'checkbox',
    'settings' => 'show_left_sidebar_only_for_home',
    'label'    => __( 'Show Left Sidebar Only For Home', 'certy' ),
    'section'  => 'other_options',
    'default'     => '0',
    'priority' => 10,
) );
//excerpt
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'checkbox',
    'settings' => 'hide_excerpts',
    'label'    => __( 'Hide Excerpt Area From Listings', 'certy' ),
    'section'  => 'other_options',
    'default'     => '0',
    'priority' => 10,
) );
//hide go to top
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'checkbox',
    'settings' => 'hide_go_top',
    'label'    => __( 'Hide Go To Top Button', 'certy' ),
    'section'  => 'other_options',
    'default'     => '0',
    'priority' => 10,
) );
//show featured image in single post
Kirki::add_field( 'certy_kirki_config', array(
    'type'     => 'checkbox',
    'settings' => 'show_featured',
    'label'    => __( 'Show Featured Image In Single Posts', 'certy' ),
    'section'  => 'other_options',
    'default'     => '0',
    'priority' => 10,
) );