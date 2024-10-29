<?php
/*
	Plugin Name: Amazing Widgets
	Plugin URI: http://www.gabfirethemes.com
	Description: This plugin adds a bundle of the most commonly used widgets to your site.
	Author: Gabfire Themes
	Version: 1.0.0
	Author URI: http://www.gabfirethemes.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

/* Block direct requests
 ***********************************************************************************/
if ( !defined('ABSPATH') ) { die('-1'); }

/* Setup Constants
 ***********************************************************************************/
define( 'AW_WIDGETS_DIR', dirname(__FILE__) );
define( 'AW_WIDGETS_URL', plugins_url().'/amazing-widgets' );

/* Init Plugin
 ***********************************************************************************/
function aw_load_textdomain() {
	
	$domain = 'awesome-widgets';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	
}
add_action( 'init', 'aw_load_textdomain' );


/* Load style file for wp-admin/widgets.php
 ***********************************************************************************/
function aw_widgetpage_adminstyle() {
	wp_enqueue_style('aw-adminstyle', AW_WIDGETS_URL .'/lib/settings/admin-style.css' );
}
add_action('admin_head-widgets.php', 'aw_widgetpage_adminstyle');

/* Load Front-end style and font-awesome
 ***********************************************************************************/
function aw_social_widget_css() {
	$settings = wpsf_get_settings( 'aw' );

	wp_register_style('aw-style', AW_WIDGETS_URL .'/style.css');
	wp_enqueue_style('aw-style');
	
	if ( ( isset( $settings['aw_general_fontawesome'] ) && ( $settings['aw_general_fontawesome'] == 0 ) ) ) {			
		wp_register_style('font-awesome', AW_WIDGETS_URL .'/lib/font-awesome/css/font-awesome.min.css');
		wp_enqueue_style('font-awesome');
	}
}			
add_action( 'wp_enqueue_scripts', 'aw_social_widget_css' );	
	
	
/* Admin Settings
 ***********************************************************************************/
class Aw_Admin_Settings {

    private $plugin_path;
    private $wpsf;

    function __construct()
    {
        $this->plugin_path = plugin_dir_path( __FILE__ );
        add_action( 'admin_menu', array( $this, 'aw_init_settings' ), 99 );

        // Include and create a new WordPressSettingsFramework
        require_once( $this->plugin_path .'lib/settings/wp-settings-framework.php' );
        $this->wpsf = new WordPressSettingsFramework( $this->plugin_path .'lib/settings/aw-settings.php', 'aw' );
        
        // Add an optional settings validation filter (recommended)
        add_filter( $this->wpsf->get_option_group() .'_settings_validate', array(&$this, 'aw_validate_settings') );
    }

    function aw_init_settings() {
        
        $this->wpsf->add_settings_page( array(
            'parent_slug' => 'options-general.php',
            'page_title'  => __( 'Amazing Widgets', 'amazing-widgets' ),
            'menu_title'  => __( 'Amazing Widgets', 'amazing-widgets' ),
        ) );
        
    }

    function aw_validate_settings( $input ) {
        // Settings validation http://codex.wordpress.org/Function_Reference/register_setting
    	return $input;
    }

}
$aw_settings = new Aw_Admin_Settings();


/* Load Widgets
 ***********************************************************************************/
$settings = wpsf_get_settings( 'aw' );

if ( isset( $settings['aw_general_social'] )) {
	
	($settings['aw_general_social'] !== '1') ?         require_once ( AW_WIDGETS_DIR . '/inc/class-social-widget.php') : '' ;
	($settings['aw_general_twitter'] !== '1') ?        require_once ( AW_WIDGETS_DIR . '/inc/class-twitter-widget.php') : '' ;
	($settings['aw_general_post_tabs'] !== '1') ?      require_once ( AW_WIDGETS_DIR . '/inc/class-post-tabs-widget.php') : '' ;
	($settings['aw_general_content_slider'] !== '1') ? require_once ( AW_WIDGETS_DIR . '/inc/class-content-slider-widget.php') : '' ;
	($settings['aw_general_timeline'] !== '1') ?       require_once ( AW_WIDGETS_DIR . '/inc/class-timeline-posts-widget.php') : '' ;
	($settings['aw_general_instagram'] !== '1') ?      require_once ( AW_WIDGETS_DIR . '/inc/class-instagram-widget.php') : '' ;

}