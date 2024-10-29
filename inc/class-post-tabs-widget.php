<?php
/* Block direct requests
 ***********************************************************************************/
if ( !defined('ABSPATH') ) { die('-1'); }

/* Start Widget
 ***********************************************************************************/
class Aw_Post_Tabs extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'aw_tabbed_posts',
			__( 'AW Post Tabs Widget' , 'amazing-widgets' ),
			array( 'description' => __( 'Display recent, most commented and recently commented entries.' , 'amazing-widgets') )
		);

	}

    public function form($instance) {
		$defaults	= array(
			'title'                => 'Featured Posts',
			'nr_posts'             => 5,
			'color_scheme'         => 'light_colors',
			'disable_recent'       => '',
			'disable_popular'      => '',
			'disable_comments'     => '',
			'disable_commentsmeta' => '',
			'disable_datemeta'     => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' , 'akismet'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
	
		<div class="aw_settings_container">
			<p>
				<label for="<?php echo $this->get_field_id( 'color_scheme' ); ?>"><?php esc_html_e('Select a color scheme', 'amazing-widgets'); ?></label>
				<select id="<?php echo $this->get_field_id( 'color_scheme' ); ?>" name="<?php echo $this->get_field_name( 'color_scheme' ); ?>">
					<option value="light_colors" <?php if ( 'light_colors' == $instance['color_scheme'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Light Colors','amazing-widgets'); ?></option>
					<option value="dark_colors" <?php if ( 'dark_colors' == $instance['color_scheme'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Dark Colors','amazing-widgets'); ?></option>
				</select>
			</p>	
		
			<p>
				<label for="<?php echo $this->get_field_name( 'nr_posts' ); ?>"><?php esc_html_e('Number of Posts?','amazing-widgets'); ?></label>
				<select id="<?php echo $this->get_field_id( 'nr_posts' ); ?>" name="<?php echo $this->get_field_name( 'nr_posts' ); ?>">
				<?php
					for ( $i = 1; $i <= 10; ++$i )
					echo "<option value='$i' " . selected( $instance['nr_posts'], $i, false ) . ">$i</option>";
				?>
				</select>
			</p>
			
			<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['disable_recent'], 'on'); ?> id="<?php echo $this->get_field_id('disable_recent'); ?>" name="<?php echo $this->get_field_name('disable_recent'); ?>" />
			<label for="<?php echo $this->get_field_id('disable_recent'); ?>"><?php esc_html_e('Disable Recent Posts tab', 'gabfire'); ?></label>
			</p>
			
			<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['disable_popular'], 'on'); ?> id="<?php echo $this->get_field_id('disable_popular'); ?>" name="<?php echo $this->get_field_name('disable_popular'); ?>" />
			<label for="<?php echo $this->get_field_id('disable_popular'); ?>"><?php esc_html_e('Disable Popular Posts tab', 'gabfire'); ?></label>
			</p>
			
			<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['disable_comments'], 'on'); ?> id="<?php echo $this->get_field_id('disable_comments'); ?>" name="<?php echo $this->get_field_name('disable_comments'); ?>" />
			<label for="<?php echo $this->get_field_id('disable_comments'); ?>"><?php esc_html_e('Disable Recent Comments tab', 'gabfire'); ?></label>
			</p>
			
			<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['disable_commentsmeta'], 'on'); ?> id="<?php echo $this->get_field_id('disable_commentsmeta'); ?>" name="<?php echo $this->get_field_name('disable_commentsmeta'); ?>" />
			<label for="<?php echo $this->get_field_id('disable_commentsmeta'); ?>"><?php esc_html_e('Disable post comment count', 'gabfire'); ?></label>
			</p>

			<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['disable_datemeta'], 'on'); ?> id="<?php echo $this->get_field_id('disable_datemeta'); ?>" name="<?php echo $this->get_field_name('disable_datemeta'); ?>" />
			<label for="<?php echo $this->get_field_id('disable_datemeta'); ?>"><?php esc_html_e('Disable post date', 'gabfire'); ?></label>
			</p>			
		</div>
	
		<?php
	}	
		
	public function update($new_instance, $old_instance) {
		$instance['title']	          = sanitize_text_field( $new_instance['title'] );
		$instance['color_scheme']     = sanitize_text_field($new_instance['color_scheme']);
		$instance['nr_posts']         = (int) sanitize_text_field($new_instance['nr_posts']);
		$instance['disable_recent']   = $new_instance['disable_recent'];
		$instance['disable_popular']  = $new_instance['disable_popular'];
		$instance['disable_comments'] = $new_instance['disable_comments'];
		$instance['disable_commentsmeta'] = $new_instance['disable_commentsmeta'];
		$instance['disable_datemeta'] = $new_instance['disable_datemeta'];
		
		return $instance;
	}
	
	
    public function widget($args, $instance) {

		 // Lets create a function for the loop
		 if ( ! function_exists( 'aw_tab_content' ) ) {
			function aw_tab_content($postdate, $commentsmeta) {
				
				$title           = get_the_title();
				$link            = get_the_permalink();
				$comments_link   = get_comments_link();
				$comments_number = get_comments_number();
				
				echo get_the_post_thumbnail(get_the_ID(), 'thumbnail', array( 'class' => 'alignright', 'itemprop' => 'image' ) );
				echo "<h3 class='entry-title'><a href='$link' title='$title' rel='bookmark' class='block'>$title</a></h3> \n";

				if ( ($commentsmeta == '') or ($postdate == '') ) {
				echo "<p class='aw_postmeta'> \n";
					if ( $postdate !== 'on') {
						echo "<time class='published updated' itemprop='datePublished' datetime='" . get_the_date('Y-m-d') . 'T' . get_the_time('H:i') . "'> \n";
							echo "<i class='fa fa-clock-o'></i>" . get_the_date() . " \n";
						echo "</time>";
					}
					
					if ( ( comments_open() ) && ($commentsmeta !== 'on')) {
						echo "<span class='comments'>";
							echo "<a href='$comments_link'><i class='fa fa-comments'></i>$comments_number</a> \n";
						echo "</span> \n";
					}
				}
				echo "</p>";
			}
		 }

		echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'];
				echo esc_html( $instance['title'] );
				echo $args['after_title'];
			}
			?>
			
			<div class="<?php echo esc_attr($instance['color_scheme']); ?>">
			
				<?php if ( $instance['disable_recent'] !== 'on') { ?>
					<input id="aw-tab1" type="radio" name="tabs" checked>
					<label for="aw-tab1"><?php esc_html_e('Recent', 'awesome-widgets'); ?></label>
				<?php } ?>
				
				<?php if ( $instance['disable_popular'] !== 'on') { ?>
					<input id="aw-tab2" type="radio" name="tabs">
					<label for="aw-tab2"><?php esc_html_e('Popular', 'awesome-widgets'); ?></label>
				<?php } ?>
				
				<?php if ( $instance['disable_comments'] !== 'on') { ?>
					<input id="aw-tab3" type="radio" name="tabs">
					<label for="aw-tab3"><?php esc_html_e('Comments', 'awesome-widgets'); ?></label>
				<?php } ?>
				
				<div class="aw-tabs-content">

					<?php if ( $instance['disable_recent'] !== 'on') { ?>
						<div class="aw-content1">
							<ul>
								<?php
								$count = 1;
								if( false === ( $wp_query = get_transient( 'aw_recent_posts' ) ) ) {
									
									$wp_query = new WP_Query(
										array(
											'posts_per_page'=> (int)($instance['nr_posts']),
											'ignore_sticky_posts' => 1 
										)
									);

									set_transient( 'aw_recent_posts', $wp_query, 4 * HOUR_IN_SECONDS );
								}
								
								while ( $wp_query->have_posts() ) : $wp_query->the_post();
								
									echo '<li class="cf">';
										aw_tab_content($instance['disable_datemeta'], $instance['disable_commentsmeta']);
									echo '</li>';
								
								$count++; endwhile; wp_reset_postdata(); ?>
							</ul>			  
						</div>
					<?php } ?>
					
					<?php if ( $instance['disable_popular'] !== 'on') { ?>
						<div class="aw-content2">
							<ul>							
								<?php
								$count = 1;
								if( false === ( $wp_query = get_transient( 'aw_popular_posts' ) ) ) {
									
									$wp_query = new WP_Query(
										array(
											'posts_per_page'=> (int)($instance['nr_posts']),
											'orderby' => 'comment_count',
											'ignore_sticky_posts' => 1 
										)
									);

									set_transient( 'aw_popular_posts', $wp_query, 4 * HOUR_IN_SECONDS );
								}
								
								while ( $wp_query->have_posts() ) : $wp_query->the_post();	
								
									echo '<li class="cf">';
										aw_tab_content($instance['disable_datemeta'], $instance['disable_commentsmeta']);
									echo '</li>';
									
								$count++; endwhile; wp_reset_postdata(); ?>
							</ul>
						</div>
					<?php } ?>
					
					<?php if ( $instance['disable_comments'] !== 'on') { ?>
						<div class="aw-content3">
							<ul>
								<?php
								$query_args = array(
									'status' => 'approve',
									'number' => (int)($instance['nr_posts']),
								);
									
								$comments = get_comments($query_args);
								foreach($comments as $comment) :
								
									echo '<li class="cf">';
										echo get_avatar( $comment->comment_author_email, 35 );
										echo ('<strong>' . $comment->comment_author . '</strong>: <a href="' . get_permalink($comment->comment_post_ID) . '" rel="bookmark">' . get_the_title($comment->comment_post_ID) . '</a>');
									echo '</li>';
									
								endforeach;
								?>
							</ul>
						</div>
					<?php } ?>
					
				</div>
			</div>
		<?php
		echo $args['after_widget'];
    }

}

// Register the widget
add_action('widgets_init',
     create_function('', 'return register_widget("Aw_Post_Tabs");')
);

if ( ! function_exists( 'aw_delete_posttabs_transient' ) ) {
	add_action( 'save_post', 'aw_delete_posttabs_transient' );	
	function aw_delete_posttabs_transient() {
		delete_transient( 'aw_recent_posts' );
		delete_transient( 'aw_popular_posts' );
	}
}
