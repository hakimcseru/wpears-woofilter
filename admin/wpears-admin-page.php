<?php 

// require __DIR__ . '/vendor/autoload.php';

// use Automattic\WooCommerce\Client;

function main_page(){
?>
	<div class="wrap wpsp-dashboard-body">
		<div class="wpsp-header">
			<h1>Wpears Product Filter Options</h1>
		</div>
	</div>
<?php
	

	 $args = array(
                'post_type'        => 'product',
                'numberposts'      => -1,
                'post_status'      => 'publish',
                'fields'           => 'ids',
                'tax_query'      => array( array(
                        'taxonomy'        => 'pa_color',
                        'field'           => 'slug',
                        'terms'           =>  array('blue'),
                        'operator'        => 'IN',
                    ) )
            );

            $filtered_posts = get_posts( $args );


           $wp_query = new WP_Query( $args );

           if( class_exists('WC_Query') &&  method_exists('WC_Query', 'product_query') ) {

           	echo $result = wc()->query->product_query($wp_query);
            
        	}

        	//add_filter( 'loop_shop_post_in', array( __CLASS__, 'price_filter' ) );
        	// global $wpdb, $wp_query;
        	// $result =  $wpdb->get_results( $wpdb->prepare("
         //        SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
         //        INNER JOIN $wpdb->postmeta ON ID = post_id
         //        WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish'
         //    " ) );
         //    echo "hh";
        	// echo "<pre>";
        	// print_r( $result );
        	// echo "</pre>";
        	
	
}


