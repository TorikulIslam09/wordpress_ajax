<?php
/**
 * astra child theme Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package astra child theme
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_THEME_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */

function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_THEME_VERSION, 'all' );
	wp_enqueue_style( 'fontawsome','//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' );
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), '1.0', true);

	wp_localize_script('custom-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

// ------------------- add short code ------------

 function trainers_shortcode() {
     ob_start();
 	?>
 		<!-- <div class="parents-div">
 			<div class="search-input">
 				<form action="" action="" method="">
 					<div class="input-div">
 					<input type="text" id="search" valu="" name="search">
 					</div>
 				</form>
 			</div>
 			<div class="choose-cate">
 				<div class="choose">
 					<form action="" method="">
 						<select name="" id="">
 								<option value="" data-origvalue="1" selected="selected">Choose Trainer Category</option>
 								<option value="Athletic Trainer">Athletic Trainer</option>
 								<option value="Bodybuilding Trainer">Bodybuilding Trainer</option>
 								<option value="Exercise Trainer">Exercise Trainer</option>
 								<option value="Fitness Trainer">Fitness Trainer</option>
 								<option value="Health Trainer">Health Trainer</option>
 								<option value="Lifestyle Trainer">Lifestyle Trainer</option>
 								<option value="Personal Trainer">Personal Trainer</option>
 								<option value="Sports Trainer">Sports Trainer</option>
 								<option value="Wellness Trainer">Wellness Trainer</option>
 						</select>
 					</form>
 				</div>
 			</div>
 		</div> -->
 	<?php
     return ob_get_clean();
 }
 add_shortcode('trainers_shortcode', 'trainers_shortcode');

 function trainerspost_shortcode() {
	ob_start();
   get_template_part('/trainer-post/traners_post');
	
   return ob_get_clean();
}
add_shortcode('trainerspost_shortcode', 'trainerspost_shortcode');

// ajax call 

function searchTrainer() {
    $nonce = sanitize_text_field( $_POST['nonce'] ); 
    check_ajax_referer( 'get_filtered_img', 'nonce' ); 
    $trainer = sanitize_text_field( $_POST['key'] ); 


    $args = array(
        'post_type'      => 'trainer',
        'posts_per_page' => -1,
        's'              => $trainer,
    );

    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_title = get_the_title();
            $featured_image_url = get_the_post_thumbnail_url();
			$designation = get_field('designation');
			$facebook = get_field('facebook');
			$youtube = get_field('youtube');
			$instagram = get_field('instagram');
			$twetter = get_field('twetter');
			?>
			<div class="card-box">
				
				<?php
						if ( $featured_image_url ) {
					?>
							<div class="card-img">
							<?= get_the_post_thumbnail(get_the_ID(), 'full');?>
						</div>
						<?php
						}
						?>
                            <div class="card-body">
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <h6> <?= $designation ?> </h6>
                                <?= the_excerpt(  )?> 
                                <div class="social-icon">
                                    <ul>
                                        <li><a href="<?= $facebook ?>"><i class="fa-brands fa-facebook-f"></i></a></li>
                                        <li><a href="<?= $youtube ?>"><i class="fa-brands fa-youtube"></i></a></li>
                                        <li><a href="<?= $instagram ?>"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="<?= $twitter ?>"><i class="fa-brands fa-twitter"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
			<?php
        }
        wp_reset_postdata();
    } else {
        echo '<div style="text-align: center">No posts found</div>';
    }
    wp_die();
}
add_action( 'wp_ajax_search_trainer', 'searchTrainer' );
add_action( 'wp_ajax_nopriv_search_trainer', 'searchTrainer' );


function test_ajax_handler() {
    $nonce = sanitize_text_field($_POST['nonce']);
    check_ajax_referer('get_filtered_img', 'nonce');
    $setCategori = sanitize_text_field($_POST['key']);

    $args = array(
        'post_type'      => 'trainer',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'categori',
                'field'    => 'slug', 
                'terms'    => $setCategori,
            ),
        ),
    );

    $query = new WP_Query( $args );
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_title = get_the_title();
            $featured_image_url = get_the_post_thumbnail_url();
			$designation = get_field('designation');
			$facebook = get_field('facebook');
			$youtube = get_field('youtube');
			$instagram = get_field('instagram');
			$twetter = get_field('twetter');
			?>
			<div class="card-box">
				<?php
						if ( $featured_image_url ) {
					?>
						<div class="card-img">
							<?= get_the_post_thumbnail(get_the_ID(), 'full');?>
						</div>
						<?php
						}
						?>
                            <div class="card-body">
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <h6> <?= $designation ?> </h6>
                                <?= the_excerpt(  )?> 

                                <div class="social-icon">
                                    <ul>
                                        <li><a href="<?= $facebook ?>"><i class="fa-brands fa-facebook-f"></i></a></li>
                                        <li><a href="<?= $youtube ?>"><i class="fa-brands fa-youtube"></i></a></li>
                                        <li><a href="<?= $instagram ?>"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="<?= $twitter ?>"><i class="fa-brands fa-twitter"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
			<?php
        }
        wp_reset_postdata();
    } else {
        echo '<div style="text-align: center">No posts found</div>';
    }
}

add_action('wp_ajax_test', 'test_ajax_handler');
add_action('wp_ajax_nopriv_test', 'test_ajax_handler'); 



