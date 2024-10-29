<?php
/* Block direct requests
 ***********************************************************************************/
if ( !defined('ABSPATH') ) { die('-1'); }

/* Start Widget
 ***********************************************************************************/
class Aw_Instagram extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'aw_instagram',
			__( 'AW Instagram Widget' , 'amazing-widgets' ),
			array( 'description' => __( 'Instagram Photos.' , 'amazing-widgets') )
		);

	}

    public function form($instance) {
		$defaults	= array(
			'title'         => __('Instagram', 'amazing-widgets'),
			'photos_of'     => __('username', 'amazing-widgets'),
			'instagram_tag' => '',
			'photo_count'   => 6,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title','amazing-widgets'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		
		<div class="aw_settings_container">	
	
			<p>
				<label for="<?php echo $this->get_field_id( 'photos_of' ); ?>"><?php esc_html_e('Display photos by','amazing-widgets'); ?></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'photos_of' ); ?>" name="<?php echo $this->get_field_name( 'photos_of' ); ?>">
					<option value="username" <?php if ( 'username' == $instance['photos_of'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Username','amazing-widgets'); ?></option>
					<option value="hashtag" <?php  if ( 'hashtag' == $instance['photos_of'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Hashtag','amazing-widgets'); ?></option>
				</select>
			</p>
			
			<p class="aw_gray">
				<?php esc_html_e('Configure API Keys on Settings -> Amazing Widgets page', 'amazing-widgets'); ?>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'instagram_tag' ); ?>"><?php esc_html_e('Hashtag - If hashtag selected above','amazing-widgets'); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'instagram_tag' ); ?>" name="<?php echo $this->get_field_name( 'instagram_tag' ); ?>" value="<?php echo esc_attr( str_replace('#', '', $instance['instagram_tag'])); ?>" class="widefat" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_name( 'photo_count' ); ?>"><?php esc_html_e('Number of photos','amazing-widgets'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'photo_count' ); ?>" name="<?php echo $this->get_field_name( 'photo_count' ); ?>">			
				<?php
					for ( $i = 1; $i <= 20; ++$i )
					echo "<option value='$i' " . selected( $instance['photo_count'], $i, false ) . ">$i</option>";
				?>
				</select>
			</p>			
		</div>

		<?php
	}	
	
	public function update($new_instance, $old_instance) {
		$instance['title']         = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['photos_of']     = ( ! empty( $new_instance['photos_of'] ) ) ? sanitize_text_field( $new_instance['photos_of'] ) : '';
		$instance['instagram_tag'] = ( ! empty( $new_instance['instagram_tag'] ) ) ? sanitize_text_field( $new_instance['instagram_tag'] ) : '';
		$instance['photo_count']   = ( ! empty( $new_instance['photo_count'] ) ) ? (int)$new_instance['photo_count'] : '';
		
		return $instance;
	}
	
	
    public function widget($args, $instance) {
		$settings = wpsf_get_settings( 'aw' );
		$title 			= apply_filters('widget_title', $instance['title']);
		$photos_of      = esc_attr($instance['photos_of']);
		$instagram_tag  = esc_attr($instance['instagram_tag']);
		$photo_count    = (int)($instance['photo_count']);
		
		$user_id = $settings['aw_instagram_userid']; 
		$clientid = $settings['aw_instagram_clientid'];
		$accesstoken = $settings['aw_instagram_accesstoken'];
		
		echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'];
				echo esc_html( $instance['title'] );
				echo $args['after_title'];
			}
			
			$randomSalt = "xMThpz";
			$preSalt  = substr($randomSalt, 0,3);
			$postSalt = substr($randomSalt, 3,3);
			$widgetid = md5(md5($preSalt.$this->id.$postSalt));			

			function gabfire_instagramphoto($value)
			{
				$time1         = date("d/m/y", $value["created_time"]);
				$time2         = date("F j, Y", $value['caption']['created_time']);
				$time3         = date("F j, Y", strtotime($time2 . " +1 days"));					
				$nickname      = $value["user"]["username"];
				$user_avatar   = $value["user"]["profile_picture"];
				$pic_text      = $value['caption']['text'];
				$like_count    = $value['likes']['count'];
				$comment_count = $value['comments']['count'];

				$thumb   = $value["images"]["thumbnail"]["url"];
				$link    = $value["link"];					
				
				return "<div class='gabfire_instagram_thumb'><a href='$link' target='_blank' rel='nofollow'><img itemprop='image' src='$thumb' alt=''/></a></div>";
			}

			if ($photos_of == 'username')
			{
				$contents = file_get_contents("https://api.instagram.com/v1/users/$user_id/media/recent/?access_token=$accesstoken&count=$photo_count");
			}

			else {	
				$contents = file_get_contents("https://api.instagram.com/v1/tags/$instagram_tag/media/recent?client_id=$clientid&count=$photo_count");
			}

			$obj = json_decode($contents, true);
			foreach ($obj["data"] as $value)
			{
				echo gabfire_instagramphoto( $value );
			}

			echo '<div class="cf"></div>';

		echo $args['after_widget'];
    }
}

// Register the widget
add_action('widgets_init',
     create_function('', 'return register_widget("Aw_Instagram");')
);