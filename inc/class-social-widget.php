<?php
/* Block direct requests
 ***********************************************************************************/
if ( !defined('ABSPATH') ) { die('-1'); }

/* Start Widget
 ***********************************************************************************/
class AW_Social_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'aw_social',
			__( 'AW Social Widget' , 'amazing-widgets' ),
			array( 'description' => __( ' Displays a list of social media website icons and a link to your profile.' , 'amazing-widgets') )
		);		
	}
	
	public function form( $instance ) {
		$defaults = array(
			'title'                => '',
			'brand_color'          => 'brand_active',
			'enable_facebook'      => '',
			'enable_twitter'       => '',
			'enable_google'        => '',
			'enable_linkedin'      => '',
			'enable_instagram'     => '',
			'enable_pinterest'     => '',
			'enable_vimeo'         => '',
			'enable_youtube'       => '',
			'enable_flickr'        => '',
			'enable_vk'            => '',
			'enable_odnoklassniki' => '',
			'enable_soundcloud'    => '',
			'enable_dribbble'      => '',
			'enable_github'        => '',
			'enable_tumblr'        => '',
			'enable_behance'       => '',
			'enable_deviantart'    => '',
			'enable_foursquare'    => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' , 'akismet'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
	
		<div class="aw_settings_container">
			<p>
			<label for="<?php echo $this->get_field_id( 'brand_color' ); ?>"><?php esc_html_e('When to show Brand Colors (hover or active icons)?','awesome-widgets'); ?></label><br />
			<select id="<?php echo $this->get_field_id( 'brand_color' ); ?>" name="<?php echo $this->get_field_name( 'brand_color' ); ?>" style="width:235px">
				<option value="brand_active" <?php if ( 'brand_active' == $instance['brand_color'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Show brand colors on active icons','awesome-widgets'); ?></option>
				<option value="brand_hover" <?php if ( 'brand_hover' == $instance['brand_color'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Show brand colors on hovered icons','awesome-widgets'); ?></option>
			</select>
			</p>	
			
			<p class="aw_gray">
				<?php esc_html_e('Configure Social Sites URLs on Settings -> Amazing Widgets page', 'amazing-widgets'); ?>
			</p>

		
			<div class="aw_left">
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_facebook'], 'on'); ?> id="<?php echo $this->get_field_id('enable_facebook'); ?>" name="<?php echo $this->get_field_name('enable_facebook'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_facebook'); ?>"><?php esc_html_e('Enable Facebook Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_twitter'], 'on'); ?> id="<?php echo $this->get_field_id('enable_twitter'); ?>" name="<?php echo $this->get_field_name('enable_twitter'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_twitter'); ?>"><?php esc_html_e('Enable Twitter Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_google'], 'on'); ?> id="<?php echo $this->get_field_id('enable_google'); ?>" name="<?php echo $this->get_field_name('enable_google'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_google'); ?>"><?php esc_html_e('Enable Google+ Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_linkedin'], 'on'); ?> id="<?php echo $this->get_field_id('enable_linkedin'); ?>" name="<?php echo $this->get_field_name('enable_linkedin'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_linkedin'); ?>"><?php esc_html_e('Enable LinkedIn Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_instagram'], 'on'); ?> id="<?php echo $this->get_field_id('enable_instagram'); ?>" name="<?php echo $this->get_field_name('enable_instagram'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_instagram'); ?>"><?php esc_html_e('Enable Instagram Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_pinterest'], 'on'); ?> id="<?php echo $this->get_field_id('enable_pinterest'); ?>" name="<?php echo $this->get_field_name('enable_pinterest'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_pinterest'); ?>"><?php esc_html_e('Enable Pinterest Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_vimeo'], 'on'); ?> id="<?php echo $this->get_field_id('enable_vimeo'); ?>" name="<?php echo $this->get_field_name('enable_vimeo'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_vimeo'); ?>"><?php esc_html_e('Enable Vimeo Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_youtube'], 'on'); ?> id="<?php echo $this->get_field_id('enable_youtube'); ?>" name="<?php echo $this->get_field_name('enable_youtube'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_youtube'); ?>"><?php esc_html_e('Enable Youtube Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_flickr'], 'on'); ?> id="<?php echo $this->get_field_id('enable_flickr'); ?>" name="<?php echo $this->get_field_name('enable_flickr'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_flickr'); ?>"><?php esc_html_e('Enable Flickr Icon', 'gabfire'); ?></label>
				</p>
			</div>
			
			<div class="aw_right">
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_vk'], 'on'); ?> id="<?php echo $this->get_field_id('enable_vk'); ?>" name="<?php echo $this->get_field_name('enable_vk'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_vk'); ?>"><?php esc_html_e('Enable VK Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_odnoklassniki'], 'on'); ?> id="<?php echo $this->get_field_id('enable_odnoklassniki'); ?>" name="<?php echo $this->get_field_name('enable_odnoklassniki'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_odnoklassniki'); ?>"><?php esc_html_e('Enable Odnoklassniki Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_soundcloud'], 'on'); ?> id="<?php echo $this->get_field_id('enable_soundcloud'); ?>" name="<?php echo $this->get_field_name('enable_soundcloud'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_soundcloud'); ?>"><?php esc_html_e('Enable SoundCloud Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_dribbble'], 'on'); ?> id="<?php echo $this->get_field_id('enable_dribbble'); ?>" name="<?php echo $this->get_field_name('enable_dribbble'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_dribbble'); ?>"><?php esc_html_e('Enable Dribbble Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_github'], 'on'); ?> id="<?php echo $this->get_field_id('enable_github'); ?>" name="<?php echo $this->get_field_name('enable_github'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_github'); ?>"><?php esc_html_e('Enable Github Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_tumblr'], 'on'); ?> id="<?php echo $this->get_field_id('enable_tumblr'); ?>" name="<?php echo $this->get_field_name('enable_tumblr'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_tumblr'); ?>"><?php esc_html_e('Enable Tumblr Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_behance'], 'on'); ?> id="<?php echo $this->get_field_id('enable_behance'); ?>" name="<?php echo $this->get_field_name('enable_behance'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_behance'); ?>"><?php esc_html_e('Enable Behance Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_deviantart'], 'on'); ?> id="<?php echo $this->get_field_id(enable_deviantart); ?>" name="<?php echo $this->get_field_name('enable_deviantart'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_deviantart'); ?>"><?php esc_html_e('Enable DeviantArt Icon', 'gabfire'); ?></label>
				</p>
				
				<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['enable_foursquare'], 'on'); ?> id="<?php echo $this->get_field_id('enable_foursquare'); ?>" name="<?php echo $this->get_field_name('enable_foursquare'); ?>" />
				<label for="<?php echo $this->get_field_id('enable_foursquare'); ?>"><?php esc_html_e('Enable FourSquare Icon', 'gabfire'); ?></label>
				</p>
			</div>
		</div>

<?php
	}

	public function update( $new_instance, $old_instance ) {
		
		$instance['title']                = strip_tags( $new_instance['title'] );
		$instance['brand_color']          = $new_instance['brand_color'];
		$instance['enable_facebook']      = $new_instance['enable_facebook'];
		$instance['enable_twitter']       = $new_instance['enable_twitter'];
		$instance['enable_google']        = $new_instance['enable_google'];
		$instance['enable_linkedin']      = $new_instance['enable_linkedin'];
		$instance['enable_instagram']     = $new_instance['enable_instagram'];
		$instance['enable_pinterest']     = $new_instance['enable_pinterest'];
		$instance['enable_vimeo']         = $new_instance['enable_vimeo'];
		$instance['enable_youtube']       = $new_instance['enable_youtube'];
		$instance['enable_flickr']        = $new_instance['enable_flickr'];
		$instance['enable_vk']            = $new_instance['enable_vk'];
		$instance['enable_odnoklassniki'] = $new_instance['enable_odnoklassniki'];
		$instance['enable_soundcloud']    = $new_instance['enable_soundcloud'];
		$instance['enable_dribbble']      = $new_instance['enable_dribbble'];
		$instance['enable_github']        = $new_instance['enable_github'];
		$instance['enable_tumblr']        = $new_instance['enable_tumblr'];
		$instance['enable_behance']       = $new_instance['enable_behance'];
		$instance['enable_deviantart']    = $new_instance['enable_deviantart'];
		$instance['enable_foursquare']    = $new_instance['enable_foursquare'];
		
		return $instance;
	}

	public function widget( $args, $instance ) {
		$settings = wpsf_get_settings( 'aw' );

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'];
			echo esc_html( $instance['title'] );
			echo $args['after_title'];
		}
		
		$class = '';
		if (isset($instance['brand_color'])) {
			$class = $instance['brand_color'];
		}
		
		echo "<div class='$class'>";
		
		if (isset($settings['aw_social_facebook'])) {
			
			if ( $instance['enable_facebook'] == 'on' ) {
				echo '<a title="'. __('Facebook', 'awesome-widgets') .'" class="aw-facebook" href="'.$settings['aw_social_facebook'].'" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a>' . "\n";
			}
			
			if ( $instance['enable_twitter'] == 'on') {
				echo '<a title="'. __('Twitter', 'awesome-widgets') .'" class="aw-twitter" href="'.$settings['aw_social_twitter'].'" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>' . "\n";
			}
			
			if ( $instance['enable_google'] == 'on') {
				echo '<a title="'. __('Google+', 'awesome-widgets') .'" class="aw-google" href="'.$settings['aw_social_google'].'" target="_blank" rel="nofollow"><i class="fa fa-google"></i></a>' . "\n";
			}
			
			if ( $instance['enable_instagram'] == 'on') {
				echo '<a title="'. __('Instagram', 'awesome-widgets') .'" class="aw-instagram" href="'.$settings['aw_social_instagram'].'" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i></a>' . "\n";
			}
			
			if ( $instance['enable_pinterest'] == 'on') {
				echo '<a title="'. __('Pinterest', 'awesome-widgets') .'" class="aw-pinterest" href="'.$settings['aw_social_pinterest'].'" target="_blank" rel="nofollow"><i class="fa fa-pinterest"></i></a>' . "\n";
			}
			
			if ( $instance['enable_vimeo'] == 'on') {
				echo '<a title="'. __('Vimeo', 'awesome-widgets') .'" class="aw-vimeo" href="'.$settings['aw_social_vimeo'].'" target="_blank" rel="nofollow"><i class="fa fa-vimeo"></i></a>' . "\n";
			}
			
			if ( $instance['enable_youtube'] == 'on') {
				echo '<a title="'. __('Youtube', 'awesome-widgets') .'" class="aw-youtube" href="'.$settings['aw_social_youtube'].'" target="_blank" rel="nofollow"><i class="fa fa-youtube"></i></a>' . "\n";
			}
			
			if ( $instance['enable_flickr'] == 'on') {
				echo '<a title="'. __('Flickr', 'awesome-widgets') .'" class="aw-flickr" href="'.$settings['aw_social_flickr'].'" target="_blank" rel="nofollow"><i class="fa fa-flickr"></i></a>' . "\n";
			}
			
			if ( $instance['enable_vk'] == 'on') {
				echo '<a title="'. __('VKontakte', 'awesome-widgets') .'" class="aw-vk" href="'.$settings['aw_social_vk'].'" target="_blank" rel="nofollow"><i class="fa fa-vk"></i></a>' . "\n";
			}
			
			if ( $instance['enable_odnoklassniki'] == 'on') {
				echo '<a title="'. __('Odnoklassniki', 'awesome-widgets') .'" class="aw-odnoklassniki" href="'.$settings['aw_social_odnoklassniki'].'" target="_blank" rel="nofollow"><i class="fa fa-odnoklassniki"></i></a>' . "\n";
			}
			
			if ( $instance['enable_soundcloud'] == 'on') {
				echo '<a title="'. __('SoundCloud', 'awesome-widgets') .'" class="aw-soundcloud" href="'.$settings['aw_social_soundcloud'].'" target="_blank" rel="nofollow"><i class="fa fa-soundcloud"></i></a>' . "\n";
			}
			
			if ( $instance['enable_dribbble'] == 'on') {
				echo '<a title="'. __('Dribbble', 'awesome-widgets') .'" class="aw-dribbble" href="'.$settings['aw_social_dribbble'].'" target="_blank" rel="nofollow"><i class="fa fa-dribbble"></i></a>' . "\n";
			}
			
			if ( $instance['enable_github'] == 'on') {
				echo '<a title="'. __('Github', 'awesome-widgets') .'" class="aw-github" href="'.$settings['aw_social_github'].'" target="_blank" rel="nofollow"><i class="fa fa-github"></i></a>' . "\n";
			}
			
			if ( $instance['enable_tumblr'] == 'on') {
				echo '<a title="'. __('Tumblr', 'awesome-widgets') .'" class="aw-tumblr" href="'.$settings['aw_social_tumblr'].'" target="_blank" rel="nofollow"><i class="fa fa-tumblr"></i></a>' . "\n";
			}
			
			if ( $instance['enable_behance'] == 'on') {
				echo '<a title="'. __('Behance', 'awesome-widgets') .'" class="aw-behance" href="'.$settings['aw_social_behance'].'" target="_blank" rel="nofollow"><i class="fa fa-behance"></i></a>' . "\n";
			}
			
			if ( $instance['enable_deviantart'] == 'on') {
				echo '<a title="'. __('DeviantArt', 'awesome-widgets') .'" class="aw-deviantart" href="'.$settings['aw_social_deviantart'].'" target="_blank" rel="nofollow"><i class="fa fa-deviantart"></i></a>' . "\n";
			}
			
			if ( $instance['enable_foursquare'] == 'on') {
				echo '<a title="'. __('FourSquare', 'awesome-widgets') .'" class="aw-foursquare" href="'.$settings['aw_social_foursquare'].'" target="_blank" rel="nofollow"><i class="fa fa-foursquare"></i></a>' . "\n";
			}
			
		}
		
		echo '</div>';
		
		echo $args['after_widget'];
	}
}

// Register the widget
add_action('widgets_init',
     create_function('', 'return register_widget("AW_Social_Widget");')
);