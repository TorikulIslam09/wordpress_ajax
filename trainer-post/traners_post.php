<?php
  global $wp_query;
$args = array(
    'post_type'      => 'trainer',
    'posts_per_page' => 3,
);

$trainers_query = new WP_Query( $args );
?>

<div class="container">

    <div class="serac-panel">
    <div class="parents-div">
            <div class="search-input">
                
                    <div class="input-div">
                    <input type="text" id="searchItem" valu="" name="search">
                    </div>
              
            </div>
            <div class="choose-cate">
                <div class="choose">

                <?php
                    $taxonomies = get_terms( array(
                        'taxonomy' => 'categori',
                        'hide_empty' => false
                    ) );
                    
                    if ( !empty($taxonomies) ) :
                        $output = '<select id="test"><option value="">Choose Trainer Category</option>';
                        foreach( $taxonomies as $category ) {
                         
                            $output.='<option value="'. esc_attr( $category->slug ) .'" id="' . esc_attr($category->term_id) . '" class="option-select" >' . $category->name . '</option>';
                        }
                        $output.='</select>';
                        echo $output;
                    endif;
            ?>
                </div>
            </div>
        </div>
    </div>

    <div class="post-parents">
            <?php
            if ( $trainers_query->have_posts() ) :
                while ( $trainers_query->have_posts() ) : $trainers_query->the_post();
                        $designation = get_field('designation');
                        $facebook = get_field('facebook');
                        $youtube = get_field('youtube');
                        $instagram = get_field('instagram');
                        $twetter = get_field('twetter');
                    ?>
                
                        <div class="card-box">
                        <div class="card-img">
                            <?= get_the_post_thumbnail(get_the_ID(), 'full');?>
                        </div>
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
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p><?php esc_html_e( 'No trainers found.', 'your-text-domain' ); ?></p>
            <?php endif;
            ?>

    </div>

<?php
  



?>


</div>


<script>
jQuery(document).ready(function($){

let nonce = '<?= wp_create_nonce('get_filtered_img')?>';
$('#searchItem').on("keyup", function (event) {
    var searchTerm = $(this).val();
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        method: 'POST',
        data: {
            action: 'search_trainer',
            key: searchTerm,
            nonce: nonce,
        },
        success: function(data){
            $('.post-parents').html(data);
        }
    });
});

$('.option-select').on("click", function (event) {
    var Cid = $(this).val();
    console.log(Cid);

    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        method: 'POST',
        data: {
            action: 'test',
            key: Cid,
            nonce: nonce,
        },
        success: function(data){
            $('.post-parents').html(data);
        }
    });


});



});

</script>