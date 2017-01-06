<?php

/***********************************************************************************************/
/* Add a menu option to link to the customizer */
/***********************************************************************************************/
add_action('admin_menu', 'display_custom_options_link');
function display_custom_options_link() {
    add_theme_page('Theme Revista Options', 'Theme Revista Options', 'edit_theme_options', 'customize.php');
}

/***********************************************************************************************/
/* Add options in the theme customizer page */
/***********************************************************************************************/
add_action('customize_register', 'revista_customize_register');
function revista_customize_register($wp_customize) {
    // Logo Footer
    $wp_customize->add_section('revista_logo', array(
        'title' => __('Logo Footer', THEMEDOMAIN),
        'description' => __('Le permite cargar el logo para el footer.', THEMEDOMAIN),
        'priority' => 35
    ));

    $wp_customize->add_setting('revista_custom_settings[logo_footer]', array(
        'default' => IMAGES . '/logo-footer.jpg',
        'type' => 'option'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_footer', array(
        'label' => __('Logo Móvil', THEMEDOMAIN),
        'section' => 'revista_logo',
        'settings' => 'revista_custom_settings[logo_footer]'
    )));

    // Links Social Media
    $wp_customize->add_section('revista_social', array(
        'title' => __( 'Links Redes Sociales', THEMEDOMAIN),
        'description' => __('Mostrar links a redes sociales', THEMEDOMAIN),
        'priority' => 36
    ));

    $wp_customize->add_setting('revista_custom_settings[display_social_link]', array(
        'default' => 0,
        'type' => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[display_social_link]', array(
        'label' => __('¿Mostrar links?', THEMEDOMAIN),
        'section' => 'revista_social',
        'settings' => 'revista_custom_settings[display_social_link]',
        'type' => 'checkbox'
    ));

    // Facebook
    $wp_customize->add_setting('revista_custom_settings[facebook]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[facebook]', array(
        'label'    => __('Facebook', THEMEDOMAIN),
        'section'  => 'revista_social',
        'settings' => 'revista_custom_settings[facebook]',
        'type'     => 'text'
    ));

    // Twitter
    $wp_customize->add_setting('revista_custom_settings[twitter]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[twitter]', array(
        'label'    => __('Twitter', THEMEDOMAIN),
        'section'  => 'revista_social',
        'settings' => 'revista_custom_settings[twitter]',
        'type'     => 'text'
    ));

    // Youtube
    $wp_customize->add_setting('revista_custom_settings[youtube]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[youtube]', array(
        'label'    => __('Youtube', THEMEDOMAIN),
        'section'  => 'revista_social',
        'settings' => 'revista_custom_settings[youtube]',
        'type'     => 'text'
    ));

    // Information
    $wp_customize->add_section('revista_info', array(
        'title' => __( 'Datos de la empresa', THEMEDOMAIN),
        'description' => __('Configurar información sobre la empresa', THEMEDOMAIN),
        'priority' => 37
    ));

    // Address
    $wp_customize->add_setting('revista_custom_settings[address]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[address]', array(
        'label'    => __('Dirección Postal', THEMEDOMAIN),
        'section'  => 'revista_info',
        'settings' => 'revista_custom_settings[address]',
        'type'     => 'textarea'
    ));

    // Reception
    $wp_customize->add_setting('revista_custom_settings[reception]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[reception]', array(
        'label'    => __('Mesa de partes', THEMEDOMAIN),
        'section'  => 'revista_info',
        'settings' => 'revista_custom_settings[reception]',
        'type'     => 'textarea'
    ));

    // Main Contact
    $wp_customize->add_setting('revista_custom_settings[main_contact]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[main_contact]', array(
        'label'    => __('Contacto principal', THEMEDOMAIN),
        'section'  => 'revista_info',
        'settings' => 'revista_custom_settings[main_contact]',
        'type'     => 'textarea'
    ));

    // Asistance Contact
    $wp_customize->add_setting('revista_custom_settings[asistance_contact]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[asistance_contact]', array(
        'label'    => __('Contacto de asistencia', THEMEDOMAIN),
        'section'  => 'revista_info',
        'settings' => 'revista_custom_settings[asistance_contact]',
        'type'     => 'textarea'
    ));

    // Latitud
    $wp_customize->add_setting('revista_custom_settings[latitud]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[latitud]', array(
        'label'    => __('Ubicación Google Map Latitud', THEMEDOMAIN),
        'section'  => 'revista_info',
        'settings' => 'revista_custom_settings[latitud]',
        'type'     => 'text'
    ));

    // Longitud
    $wp_customize->add_setting('revista_custom_settings[longitud]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[longitud]', array(
        'label'    => __('Ubicación Google Map Longitud', THEMEDOMAIN),
        'section'  => 'revista_info',
        'settings' => 'revista_custom_settings[longitud]',
        'type'     => 'text'
    ));

    // Phone
    $wp_customize->add_setting('revista_custom_settings[phone]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[phone]', array(
        'label'    => __('Central Telefónica', THEMEDOMAIN),
        'section'  => 'revista_info',
        'settings' => 'revista_custom_settings[phone]',
        'type'     => 'text'
    ));

    // Email
    $wp_customize->add_setting('revista_custom_settings[email_contact]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[email_contact]', array(
        'label'    => __('Email de contacto', THEMEDOMAIN),
        'section'  => 'revista_info',
        'settings' => 'revista_custom_settings[email_contact]',
        'type'     => 'text'
    ));

    // Contribute
    $wp_customize->add_section('revista_contribute', array(
        'title' => __( 'Participar con estudios de investigación', THEMEDOMAIN),
        'description' => __('Configurar texto y enlaces de la sección Participar con estudios de investigación', THEMEDOMAIN),
        'priority' => 38
    ));

    // Text contribute
    $wp_customize->add_setting('revista_custom_settings[text_contribute]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[text_contribute]', array(
        'label'    => __('Texto o mensaje', THEMEDOMAIN),
        'section'  => 'revista_contribute',
        'settings' => 'revista_custom_settings[text_contribute]',
        'type'     => 'textarea'
    ));

    // Link contribute
    $wp_customize->add_setting('revista_custom_settings[link_contribute]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('revista_custom_settings[link_contribute]', array(
        'label'    => __('Seleccionar página de enlace', THEMEDOMAIN),
        'section'  => 'revista_contribute',
        'settings' => 'revista_custom_settings[link_contribute]',
        'type'     => 'dropdown-pages',
    ));
}
