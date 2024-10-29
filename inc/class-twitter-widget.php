<?php
/* Block direct requests
 ***********************************************************************************/
if ( !defined('ABSPATH') ) { die('-1'); }

/* Start Widget
 ***********************************************************************************/
class Aw_Tweets extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'aw_twitter',
			__( 'AW Twitter Widget' , 'amazing-widgets' ),
			array( 'description' => __( 'Display most recent tweets of a hasthtag or username.' , 'amazing-widgets') )
		);

	}

    public function form($instance) {
		$defaults	= array(
			'title' => 'Twitter Widget',
			'tweets_base' => 'username',
			'profile_photo' => 'display',
			'tweets_nr' => 5,
			'tweets_of' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title','amazing-widgets'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<div class="aw_settings_container">
			<p class="aw_gray">
				<?php esc_html_e('Configure API Keys on Settings -> Amazing Widgets page', 'amazing-widgets'); ?>
			</p>
				
			<p>
				<label for="<?php echo $this->get_field_id( 'tweets_base' ); ?>"><?php esc_html_e('Tweets based on:', 'amazing-widgets'); ?></label>
				<select id="<?php echo $this->get_field_id( 'tweets_base' ); ?>" name="<?php echo $this->get_field_name( 'tweets_base' ); ?>">
					<option value="username" <?php if ( 'username' == $instance['tweets_base'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Username','amazing-widgets'); ?></option>
					<option value="hashtag" <?php if ( 'hashtag' == $instance['tweets_base'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Hashtag','amazing-widgets'); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'profile_photo' ); ?>"><?php esc_html_e('Twitter profile photo:', 'amazing-widgets'); ?></label>
				<select id="<?php echo $this->get_field_id( 'profile_photo' ); ?>" name="<?php echo $this->get_field_name( 'profile_photo' ); ?>">
					<option value="display" <?php if ( 'display' == $instance['profile_photo'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Display','amazing-widgets'); ?></option>
					<option value="hide" <?php if ( 'hide' == $instance['profile_photo'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Hide','amazing-widgets'); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'tweets_nr' ); ?>"><?php esc_html_e('Number of Tweets?','amazing-widgets'); ?></label>
				<select id="<?php echo $this->get_field_id( 'tweets_nr' ); ?>" name="<?php echo $this->get_field_name( 'tweets_nr' ); ?>">
				<?php
					for ( $i = 1; $i <= 10; ++$i )
					echo "<option value='$i' " . selected( $instance['tweets_nr'], $i, false ) . ">$i</option>";
				?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('tweets_of'); ?>"><?php esc_html_e('Enter Username or Hashtag (without @ or #)','amazing-widgets'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('tweets_of'); ?>" name="<?php echo $this->get_field_name('tweets_of'); ?>" type="text" value="<?php echo esc_attr($instance['tweets_of']); ?>" />
			</p>
		</div>
		<?php
	}	
	
	public function update($new_instance, $old_instance) {
		$instance['title']	=  sanitize_text_field( $new_instance['title'] );
		$instance['tweets_base'] = sanitize_text_field($new_instance['tweets_base']);
		$instance['tweets_of'] =  sanitize_text_field($new_instance['tweets_of']);
		$instance['profile_photo'] =  sanitize_text_field($new_instance['profile_photo']);
		$instance['tweets_nr'] = (int) sanitize_text_field($new_instance['tweets_nr']);
		
		return $instance;
	}
	
	
    public function widget($args, $instance) {

		echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'];
				echo esc_html( $instance['title'] );
				echo $args['after_title'];
			}

			if ($instance['tweets_base'] == 'username'){
				echo $this->aw_get_twitter_data($instance,'username');
			} else {
				echo $this->aw_get_twitter_data($instance,'hashtag');
			}

		echo $args['after_widget'];
    }

	private function aw_get_twitter_data($options, $tweets_base) {
		
		$settings = wpsf_get_settings( 'aw' );
		
		if(isset($settings['twitter_aw_ck'])) {

			if ($settings['twitter_aw_ck'] == '' || $settings['twitter_aw_cs'] == '' || $settings['twitter_aw_tk'] == '' || $settings['twitter_aw_ts'] == '') {
				return __('Twitter Authentication data is incomplete','amazing-widgets');
			}

			if (!class_exists('Codebird')) {
				require_once ( AW_WIDGETS_DIR . '/lib/codebird/codebird.php');
			}

			\Codebird\Codebird::setConsumerKey($settings['twitter_aw_ck'], $settings['twitter_aw_cs']);
			$cb = \Codebird\Codebird::getInstance();
			$cb->setToken($settings['twitter_aw_tk'], $settings['twitter_aw_ts']);
			$cb->setReturnFormat(CODEBIRD_RETURNFORMAT_ARRAY);

			$count = 0;
			$target = 'target="_blank"';

			
				if ($tweets_base == 'hashtag') {
					
					$out = '<ul>';
					
					$reply = get_transient('aw_socialmashup_widget_twitter_search_transient');
					if (false === $reply){
						try {
							$reply = $cb->search_tweets(array(
										'q'=>'#'.$options['tweets_of'],
										'count'=> $options['tweets_nr']
								));
						} catch (Exception $e) {
							return __('Error retrieving tweets','amazing-widgets');
						}
						if (isset($reply['errors'])) {
							//error_log(serialize($reply['errors']));
						}
						
						set_transient('aw_socialmashup_widget_twitter_search_transient',$reply,300);
					}
					
					if (empty($reply) or count($reply)<1) {
						return __('No public tweets with' . $reply . ' hashtag','amazing-widgets');
					}

					if (isset($reply['statuses']) && is_array($reply['statuses'])) {
						foreach($reply['statuses'] as $message) {
							if ($count>=$options['tweets_nr']) {
								break;
							}

							if (!isset($message['text'])) {
								continue;
							}

							$msg = $message['text'];

							$out .= '<li class="aw_tweets_hashtag">';
							if ($options['profile_photo'] == 'display') {
								$out .= '<img class="alignright" src="'.$message['user']['profile_image_url_https'].'" alt="" />';
							}

							/* Code from really simpler twitter widget */

							$msg = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\" ".$target.">$1</a>", $msg);

							$msg = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\" ".$target.">$1</a>", $msg);

							$msg = preg_replace('/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i',"<a href=\"mailto://$1\" class=\"twitter-link\" ".$target.">$1</a>", $msg);

							$msg = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="//twitter.com/#!/search/%23\2" class="twitter-link" '.$target.'>#\2</a>', $msg);

							$msg = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\" ".$target.">@$2</a>$3 ", $msg);

							$out .= $msg;
							$out .= '</li>';
							$count++;
						}
					}
					
					$out .= '</ul>';
					
				} elseif ($tweets_base == 'username') {
					
					$out = '<ul class="aw_user_tweets">';
					
					$reply = get_transient('aw_socialmashup_widget_twitter_username_transient');

					if (false === $reply){
						try {
							$twitter_data =  $cb->statuses_userTimeline(array(
										'screen_name'=>$options['tweets_of'],
										'count'=> $options['tweets_nr']
								));
						} catch (Exception $e) {
							return __('Error retrieving tweets','amazing-widgets');
						}

						if (isset($reply['errors'])) {
							//error_log(serialize($reply['errors']));
						}

						set_transient('aw_socialmashup_widget_twitter_username_transient',$reply,300);
					}

					if (empty($twitter_data) or count($twitter_data)<1) {
						return __('No public tweets','amazing-widgets');
					}

					if (isset($twitter_data) && is_array($twitter_data)) {
						foreach($twitter_data as $message) {
							if ($count>=$options['tweets_nr']) {
								break;
							}

							if (!isset($message['text'])) {
								continue;
							}

							$msg = $message['text'];

							$out .= '<li>';
							$out .= '<i class="fa fa-twitter fa-2x"></i>';
							
							/* Code from really simpler twitter widget */

							$msg = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\" ".$target.">$1</a>", $msg);

							$msg = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\" ".$target.">$1</a>", $msg);
							$msg = preg_replace('/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i',"<a href=\"mailto://$1\" class=\"twitter-link\" ".$target.">$1</a>", $msg);

							$msg = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="//twitter.com/#!/search/%23\2" class="twitter-link" '.$target.'>#\2</a>', $msg);

							$msg = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\" ".$target.">@$2</a>$3 ", $msg);

							$out .= $msg;
							$out .= '</li>';
							$count++;
						}
					}
					
					$out .= '</ul>';
				}

			return $out;
		}
	}
}

// Register the widget
add_action('widgets_init',
     create_function('', 'return register_widget("Aw_Tweets");')
);