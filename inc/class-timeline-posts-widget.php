<?php
/* Block direct requests
 ***********************************************************************************/
if ( !defined('ABSPATH') ) { die('-1'); }

/* Start Widget
 ***********************************************************************************/
class AW_Random_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'aw_random_recent',
			__( 'AW Timeline Posts' , 'amazing-widgets' ),
			array( 'description' => __( 'Display a list of Recent or Random posts in a timeline format.' , 'amazing-widgets') )
		);
	}
	
	public function form( $instance ) {
		$defaults = array(
			'title'         => '',
			'what_to_query' => 'random_posts',
			'category'      => '',
			'nr_of_posts'   => 4
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 	
		?>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' , 'akismet'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>		

		<div class="aw_settings_container">
		
			<p>
			<label for="<?php echo $this->get_field_id( 'what_to_query' ); ?>"><?php esc_html_e('Show Random or Recent Posts?','awesome-widgets'); ?></label><br />
			<select id="<?php echo $this->get_field_id( 'what_to_query' ); ?>" name="<?php echo $this->get_field_name( 'what_to_query' ); ?>" style="width:235px">
				<option value="rand" <?php if ( 'rand' == $instance['what_to_query'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Random Posts','awesome-widgets'); ?></option>
				<option value="date" <?php if ( 'date' == $instance['what_to_query'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Recent Posts','awesome-widgets'); ?></option>
			</select>
			</p>	
			
			<p>
				<label for="<?php echo $this->get_field_name( 'nr_of_posts' ); ?>"><?php _e('Number of entries to display','aw-widgets'); ?></label>
				<select id="<?php echo $this->get_field_id( 'nr_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'nr_of_posts' ); ?>">
				<?php
					for ( $i = 1; $i <= 10; ++$i )
					echo "<option value='$i' " . selected( $instance['nr_of_posts'], $i, false ) . ">$i</option>";
				?>
				</select>
			</p>
		
			<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e('Show Random or Recent Posts?','awesome-widgets'); ?></label><br />
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat" style="width:100%;">
				<option value="-1" <?php if ( '-1' == $instance['category'] ) echo 'selected="selected"'; ?>><?php esc_html_e('All Categories','awesome-widgets'); ?></option>
				<?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
				<option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo intval($term->term_id); ?>"><?php echo esc_attr($term->name); ?></option>
				<?php } ?>      
			</select>
			</p>			

		</div>

<?php
	}

	public function update( $new_instance, $old_instance ) {
		
		$instance['title']         = strip_tags( $new_instance['title'] );
		$instance['what_to_query'] = $new_instance['what_to_query'];
		$instance['category']      = $new_instance['category'];
		$instance['nr_of_posts']   = (int) ($new_instance['nr_of_posts']);
		
		return $instance;
	}

	public function widget( $args, $instance ) {

		function aw_bydate() {
			global $post;
			$author_id=$post->post_author;
			printf(esc_attr__('By %1$s on %2$s','aw-widgets'), get_the_author_meta( 'display_name', $post->post_author ), get_the_date());
		}	
	
		echo $args['before_widget'];
		
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'];
				echo esc_html( $instance['title'] );
				echo $args['after_title'];
			}
			
			echo "<ul> \n";
			
				if( false === ( $wp_query = get_transient( 'aw_random_recent' ) ) ) {
					
					$wp_query = new WP_Query(
						array(
						  'cat' => $instance['category'],
						  'orderby' => $instance['what_to_query'],
						  'posts_per_page' => $instance['nr_of_posts']
						)
					);

					set_transient( 'aw_random_recent', $wp_query, 4 * HOUR_IN_SECONDS );
				}
				
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
				
				?>
				
				<li class='clearfix'>
					
					<span class="timeline-posttime"><a href="javascript:void(0)" class="tooltiped"><i class="fa fa-circle"></i><span><?php echo aw_bydate(); ?></a></span>
					
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignright' ) ); ?>
					</a>
					
					<header>
						<h2 itemprop="headline" class="entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
								<?php the_title(); ?>
							</a>
						</h2>
						
						<p class="aw_postmeta">
						
							<span class="aw_meta comments">
								<i class="fa fa-comments-o"></i><?php comments_popup_link(__('No Comment','aw-widgets'), __('1 Comment','aw-widgets'), __('% Comments','aw-widgets')); ?>
							</span>		
							
							<meta content="<?php echo get_the_date('Y-m-d') . 'T' . get_the_time('H:i'); ?>" itemprop="datePublished">
						</p>
					</header>

				</li>
						
				<?php
				endwhile; wp_reset_query();
			echo "</ul> \n";
			
		echo $args['after_widget'];
	}
}

// Register the widget
add_action('widgets_init',
     create_function('', 'return register_widget("AW_Random_Widget");')
);

if ( ! function_exists( 'aw_delete_random_recent' ) ) {
	add_action( 'save_post', 'aw_delete_random_recent' );	
	function aw_delete_random_recent() {
		delete_transient( 'aw_random_recent' );
	}
}