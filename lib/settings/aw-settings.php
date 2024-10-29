<?php
/**
 * WordPress Settings Framework
 *
 * @author Gilbert Pellegrom, James Kemp
 * @link https://github.com/gilbitron/WordPress-Settings-Framework
 * @license MIT
 */

/**
 * Define settings
 * 
 * Your "options_group" is the second param you use when running new WordPressSettingsFramework()
 * from your init function. It's importnant as it differentiates your options from others.
 * 
 * To use the tabbed example, simply change the second param in the filter below to 'aw_tabbed_settings'
 * and check out the tabbed settings function on line 156.
 */

// Block direct requests
if ( !defined('ABSPATH') ) { die('-1'); }
 
add_filter( 'wpsf_register_settings_aw', 'aw_tabbed_settings' );

/* Tabbed settings */
function aw_tabbed_settings( $aw_settings ) {
    
    // Tab 1
    $aw_settings['tabs'][] = array(
		'id' => 'general',
		'title' => esc_html__('General'),
	);    
	
    // Tab 2
    $aw_settings['tabs'][] = array(
		'id' => 'socialsites',
		'title' => esc_html__('Social Sites'),
	);
	
	// Tab 3
	$aw_settings['tabs'][] = array(
		'id' => 'twitter_settings',
		'title' => esc_html__('Twitter'),
	);
	
	// Tab 3
	$aw_settings['tabs'][] = array(
		'id' => 'instagram_settings',
		'title' => esc_html__('Instagram'),
	);
	
    // Settings Section
    $aw_settings['sections'][] = array(
        'tab_id' => 'general',
        'section_id' => 'aw_general',
        'section_title' => esc_html__('Enable & Disable Widgets', 'amazing-widgets'),
        'section_order' => 10,
        'fields' => array(
            array(
                'id' => 'social',
                'title' => esc_html__('Disable Social Widget', 'amazing-widgets'),
                'desc' => esc_html__('Disable Social Widget', 'amazing-widgets'),
                'type' => 'checkbox',
                'std' => ''
            ),
            array(
                'id' => 'twitter',
                'title' => esc_html__('Disable Twitter Widget', 'amazing-widgets'),
                'desc' => esc_html__('Disable Twitter Widget', 'amazing-widgets'),
                'type' => 'checkbox',
                'std' => ''
            ),
            array(
                'id' => 'post_tabs',
                'title' => esc_html__('Disable Post Tabs Widget', 'amazing-widgets'),
                'desc' => esc_html__('Disable Post Tabs Widget', 'amazing-widgets'),
                'type' => 'checkbox',
                'std' => ''
            ),
            array(
                'id' => 'content_slider',
                'title' => esc_html__('Disable Content Slider Widget', 'amazing-widgets'),
                'desc' => esc_html__('Disable Content Slider Widget', 'amazing-widgets'),
                'type' => 'checkbox',
                'std' => ''
            ),
            array(
                'id' => 'timeline',
                'title' => esc_html__('Disable Timeline Posts Widget', 'amazing-widgets'),
                'desc' => esc_html__('Disable Timeline Posts Widget', 'amazing-widgets'),
                'type' => 'checkbox',
                'std' => ''
            ),
            array(
                'id' => 'instagram',
                'title' => esc_html__('Disable Instagram Widget', 'amazing-widgets'),
                'desc' => esc_html__('Disable Instagram Widget', 'amazing-widgets'),
                'type' => 'checkbox',
                'std' => ''
            ),
            array(
                'id' => 'fontawesome',
                'title' => esc_html__('Disable Font-Awesome', 'amazing-widgets'),
                'desc' => esc_html__('Its built-in my theme. Do not load it for the second time', 'amazing-widgets'),
                'type' => 'checkbox',
                'std' => ''
            ),
        )
    );
	
    $aw_settings['sections'][] = array(
        'tab_id' => 'socialsites',
        'section_id' => 'aw_social',
        'section_title' => esc_html__('Social Site Links', 'awesome-widgets'),
        'section_order' => 10,
        'fields' => array(
            array(
                'id' => 'facebook',
                'title' => esc_html__('Facebok', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Facebook Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'twitter',
                'title' => esc_html__('Twitter', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Facebook Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'google',
                'title' => esc_html__('Google Plus', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Google Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'linkedin',
                'title' => esc_html__('LinkedIn', 'awesome-widgets'),
                'desc'  => esc_html__('URL to LinkedIn Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'instagram',
                'title' => esc_html__('Instagram', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Instagram Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'pinterest',
                'title' => esc_html__('Pinterest', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Pinterest Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'vimeo',
                'title' => esc_html__('Vimeo', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Vimeo Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'youtube',
                'title' => esc_html__('Youtube', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Youtube Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'flickr',
                'title' => esc_html__('Flickr', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Flickr Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'vk',
                'title' => esc_html__('VKontakte', 'awesome-widgets'),
                'desc'  => esc_html__('URL to VKontakte Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'odnoklassniki',
                'title' => esc_html__('Odnoklassniki ', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Odnoklassniki Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'soundcloud',
                'title' => esc_html__('Soundcloud', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Soundcloud Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'dribbble',
                'title' => esc_html__('Dribbble', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Dribbble Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'github',
                'title' => esc_html__('Github', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Github Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'tumblr',
                'title' => esc_html__('Tumblr', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Tumblr Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'behance',
                'title' => esc_html__('Behance', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Behance Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'deviantart',
                'title' => esc_html__('Deviantart', 'awesome-widgets'),
                'desc'  => esc_html__('URL to Deviantart Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            ),
            array(
                'id'    => 'foursquare',
                'title' => esc_html__('Foursquare', 'awesome-widgets'),
                'desc'  => esc_html__('URL to VKontakte Account.', 'awesome-widgets'),
                'type'  => 'text',
				'std'   => ''
            )
        )
    );
    
    $aw_settings['sections'][] = array(
        'tab_id' => 'twitter_settings',
        'section_id' => 'twitter',
        'section_title' => esc_html__('Twitter Authentication', 'awesome-widgets'),
        'section_order' => 10,
        'fields' => array(
            array(
                'id' => 'aw_ck',
                'title' => esc_html__('Consumer Key', 'awesome-widgets'),
                'desc' => esc_html__('Consumer Key', 'awesome-widgets'),
                'type' => 'password',
                'std' => ''
            ),
            array(
                'id' => 'aw_cs',
                'title' => esc_html__('Consumer Secret', 'awesome-widgets'),
                'desc' => esc_html__('Consumer Secret', 'awesome-widgets'),
                'type' => 'password',
                'std' => ''
            ),
            array(
                'id' => 'aw_tk',
                'title' => esc_html__('Token Key', 'awesome-widgets'),
                'desc' => esc_html__('Token Key', 'awesome-widgets'),
                'type' => 'password',
                'std' => ''
            ),
            array(
                'id' => 'aw_ts',
                'title' => esc_html__('Token Secret', 'awesome-widgets'),
                'desc' => esc_html__('Token Secret', 'awesome-widgets'),
                'type' => 'password',
                'std' => ''
            )
        )
    );

    $aw_settings['sections'][] = array(
        'tab_id' => 'instagram_settings',
        'section_id' => 'aw_instagram',
        'section_title' => esc_html__('Instagram Authentication', 'awesome-widgets'),
        'section_order' => 10,
        'fields' => array(
            array(
                'id' => 'userid',
                'title' => esc_html__('User ID', 'awesome-widgets'),
                'desc' => esc_html__('Check your User ID at http://jelled.com/instagram/lookup-user-id', 'awesome-widgets'),
                'type' => 'text',
                'std' => ''
            ),		
            array(
                'id' => 'clientid',
                'title' => esc_html__('Client ID', 'awesome-widgets'),
                'desc' => esc_html__('Client ID', 'awesome-widgets'),
                'type' => 'password',
                'std' => ''
            ),
            array(
                'id' => 'accesstoken',
                'title' => esc_html__('Token Key', 'awesome-widgets'),
                'desc' => esc_html__('Check your Access Token at http://instagram.pixelunion.net', 'awesome-widgets'),
                'type' => 'password',
                'std' => ''
            ),
        )
    );

    return $aw_settings;
}




/**
 * Tabless example
function wpsf_tabless_settings( $aw_settings ) {

    // General Settings section
    $aw_settings[] = array(
        'section_id' => 'general',
        'section_title' => 'General Settings',
        'section_description' => 'Some intro description about this section.',
        'section_order' => 5,
        'fields' => array(
            array(
                'id' => 'text',
                'title' => esc_html__('Text',
                'desc' => esc_html__('This is a description.',
                'placeholder' => 'This is a placeholder.',
                'type' => 'text',
                'std' => 'This is std'
            ),
            array(
                'id' => 'password',
                'title' => esc_html__('Password',
                'desc' => esc_html__('This is a description.',
                'placeholder' => 'This is a placeholder.',
                'type' => 'password',
                'std' => 'Example'
            ),
            array(
                'id' => 'textarea',
                'title' => esc_html__('Textarea',
                'desc' => esc_html__('This is a description.',
                'placeholder' => 'This is a placeholder.',
                'type' => 'textarea',
                'std' => 'This is std'
            ),
            array(
                'id' => 'select',
                'title' => esc_html__('Select',
                'desc' => esc_html__('This is a description.',
                'type' => 'select',
                'std' => 'green',
                'choices' => array(
                    'red' => 'Red',
                    'green' => 'Green',
                    'blue' => 'Blue'
                )
            ),
            array(
                'id' => 'radio',
                'title' => esc_html__('Radio',
                'desc' => esc_html__('This is a description.',
                'type' => 'radio',
                'std' => 'green',
                'choices' => array(
                    'red' => 'Red',
                    'green' => 'Green',
                    'blue' => 'Blue'
                )
            ),
            array(
                'id' => 'checkbox',
                'title' => esc_html__('Checkbox',
                'desc' => esc_html__('This is a description.',
                'type' => 'checkbox',
                'std' => 1
            ),
            array(
                'id' => 'checkboxes',
                'title' => esc_html__('Checkboxes',
                'desc' => esc_html__('This is a description.',
                'type' => 'checkboxes',
                'std' => array(
                    'red',
                    'blue'
                ),
                'choices' => array(
                    'red' => 'Red',
                    'green' => 'Green',
                    'blue' => 'Blue'
                )
            ),
            array(
                'id' => 'color',
                'title' => esc_html__('Color',
                'desc' => esc_html__('This is a description.',
                'type' => 'color',
                'std' => '#ffffff'
            ),
            array(
                'id' => 'file',
                'title' => esc_html__('File',
                'desc' => esc_html__('This is a description.',
                'type' => 'file',
                'std' => ''
            ),
            array(
                'id' => 'editor',
                'title' => esc_html__('Editor',
                'desc' => esc_html__('This is a description.',
                'type' => 'editor',
                'std' => ''
            )
        )
    );

    // More Settings section
    $aw_settings[] = array(
        'section_id' => 'more',
        'section_title' => 'More Settings',
        'section_order' => 10,
        'fields' => array(
            array(
                'id' => 'more-text',
                'title' => esc_html__('More Text',
                'desc' => esc_html__('This is a description.',
                'type' => 'text',
                'std' => 'This is std'
            ),
        )
    );

    return $aw_settings;
}
*/