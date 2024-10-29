<?php
/* Block direct requests
 ***********************************************************************************/
if ( !defined('ABSPATH') ) { die('-1'); }

/* Start Widget
 ***********************************************************************************/
class Aw_Content_Slider extends WP_Widget {
	
	public function __construct() {

		parent::__construct(
			'aw_content_slider',
			__( 'AW Content Slider' , 'amazing-widgets' ),
			array( 'description' => __( 'AW Content Slider Widget.' , 'amazing-widgets') )
		);
		
		/* Widget front end styles */
		function aw_slider_widget_resources() {

			wp_register_style('aw-flexslider', AW_WIDGETS_URL .'/lib/flexslider/flexslider.css');
			wp_enqueue_style('aw-flexslider');
			
			wp_register_script('flexslider',  AW_WIDGETS_URL .'/lib/flexslider/jquery.flexslider-min.js', array( 'jquery' ));		
			wp_register_script('flexslider-dom',  AW_WIDGETS_URL .'/lib/scripts.js', array( 'jquery' ));		
			wp_enqueue_script('jquery');
			wp_enqueue_script('flexslider');
			wp_enqueue_script('flexslider-dom');

		}		
		
		/* If Activated: Extract widget style*/
		if ( is_active_widget( false, false, $this->id_base ) ) {
			
			add_action( 'wp_enqueue_scripts', 'aw_slider_widget_resources' );	
			
		}	
	}

    public function form($instance) {
		$defaults	= array(
			'title' => '', 
			'nr_of_slides' => '',
			'category' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title','amazing-widgets'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<div class="aw_settings_container">			
			<p>
				<label for="<?php echo $this->get_field_name( 'nr_of_slides' ); ?>"><?php esc_html_e('Number of Slides','amazing-widgets'); ?></label>
				<select id="<?php echo $this->get_field_id( 'nr_of_slides' ); ?>" name="<?php echo $this->get_field_name( 'nr_of_slides' ); ?>">
				<?php
					for ( $i = 1; $i <= 10; ++$i )
					echo "<option value='$i' " . selected( $instance['nr_of_slides'], $i, false ) . ">$i</option>";
				?>
				</select>
			</p>
			
			<p class="aw_gray">
				<?php 
				$link = 'https://wordpress.org/plugins/gabfire-media-module/';
				printf(__('You need to have <a href="%1$s" target="_blank">Gabfire Media Module</a> installed to be able use "Slide Only Videos" option.', 'amazing-widgets'), $link); ?>
			</p>
			
			<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e('Slide Categories or Videos?','awesome-widgets'); ?></label><br />
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat">
				<option value="0" <?php if ( 0 == $instance['category'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Slide only Videos','awesome-widgets'); ?></option>
				<option value="-1" <?php if ( -1 == $instance['category'] ) echo 'selected="selected"'; ?>><?php esc_html_e('All Categories','awesome-widgets'); ?></option>
				<?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
				<option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo intval($term->term_id); ?>">- <?php echo esc_attr($term->name); ?></option>
				<?php } ?>      
			</select>
			</p>			
		</div>
		<?php
	}	
	
	public function update($new_instance, $old_instance) {
		$instance['title']	      = sanitize_text_field( $new_instance['title'] );
		$instance['category']     = $new_instance['category'];
		$instance['nr_of_slides'] = (int) sanitize_text_field($new_instance['nr_of_slides']);
		
		return $instance;
	}

    public function widget($args, $instance) {

		echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'];
				echo esc_html( $instance['title'] );
				echo $args['after_title'];
			} ?>
			
			<style>				

				
			</style>
			<div class="flexslider">
			
				<div class="aw-custom-navigation">
					<a href="javascript:void(0)" class="aw-next"><i class="fa fa-angle-right"></i></a>
					<a href="javascript:void(0)" class="aw-prev"><i class="fa fa-angle-left"></i></a>
				</div>
				
				<?php
					if ($instance['category'] == 0) {
						$args = array(
						  'meta_key' => 'iframe',
						  'posts_per_page' => $instance['nr_of_slides']
						);
					} 
					
					else {
						$args = array(
						  'cat' => $instance['category'],
						  'posts_per_page' => $instance['nr_of_slides']
						);
					}
					
					$wp_query = new WP_Query( $args );
				?>
				
				<ul class="slides">
					<?php
					if ( $wp_query->have_posts() ) {
						while ( $wp_query->have_posts() ) {
						$wp_query->the_post();
						
							if ( function_exists( 'gabfire_mediaplugin' ) ) { ?>
								<li>
									<?php
									if ($instance['category'] == 0) {
										
										gabfire_mediaplugin(array(
											'name' => 'gabfire_video', 
											'imgtag' => 0,
											'link' => 1,		
											'enable_thumb' => 0,
											'enable_video' => 1, 
											'resize_type' => 'c', 
											'media_width' => 1280, 
											'media_height' => 720, 
											'thumb_align' => 'aligncenter gabfire_video',
											'enable_default' => 0,
										));
									}
									
									else {
										echo get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'aligncenter'));
										
									}
									?>
									<h2 class="entry-title">
										<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpnewspaper' ), the_title_attribute( 'echo=0' ) ); ?>" ><?php the_title(); ?></a>
									</h2>
									
									<meta content="<?php echo get_the_date('Y-m-d') . 'T' . get_the_time('H:i'); ?>" itemprop="datePublished">
								</li>
								<?php
							}
						} // endwhile
					} // endif
					// reset loop
					wp_reset_postdata();
					?>
				</ul>
				
			</div>

			<?php

		echo $args['after_widget'];
    }
}

// Register the widget
add_action('widgets_init',
     create_function('', 'return register_widget("Aw_Content_Slider");')
);