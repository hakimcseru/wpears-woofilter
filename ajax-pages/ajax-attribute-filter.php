<?php

function filterby_term(){
	global $wp_query;

	//get product term
	$pterm = $_POST['pterm'];

	//custom query with passing product term
	$wp_query = new WP_Query( array(
	   'post_type'      => array('product'),
	   'post_status'    => 'publish',
	   'posts_per_page' => -1,
	   'tax_query'      => array( array(
	        'taxonomy'        => 'pa_color',
	        'field'           => 'slug',
	        'terms'           =>  array($pterm),
	        'operator'        => 'IN',
	    ) )
	) );

    //rest api code

    //http://localhost/wootest/wp-json/wc/v3/products?attribute=pa_color&attribute_term=17
    $apiResult = $woocommerce->get('http://localhost/wootest/wp-json/wc/v3/products?attribute=pa_color&attribute_term=17');

    // echo "<pre>";
    // print_r( $apiResult );
    // echo "</pre>";
    

	// set query in woocommerce
	if( class_exists('WC_Query') &&  method_exists('WC_Query', 'product_query') ) {
        wc()->query->product_query($wp_query);
    }

    // unset arguments
    unset( $args );

	// custom loop with passing product term
    ob_start();

    if ( $wp_query->have_posts() ) {
        do_action('woocommerce_before_shop_loop');

        woocommerce_product_loop_start();
        if( ! function_exists('woocommerce_maybe_show_product_subcategories') ) {
            woocommerce_product_subcategories();
        }

        while ( have_posts() ) {
            the_post();
            wc_get_template_part( 'content', 'product' );
        }

        woocommerce_product_loop_end();

        do_action('woocommerce_after_shop_loop');

        wp_reset_postdata();

        $_RESPONSE['products'] = ob_get_contents();
    } else {

        $_RESPONSE['no_products'] = ob_get_contents();
    }
    ob_end_clean();

    
	echo json_encode(array( 'rainbow_aj_content' => $apiResult ),JSON_PRETTY_PRINT);
	exit(); 
}

add_action('wp_ajax_filterby_term','filterby_term');
add_action('wp_ajax_nopriv_filterby_term','filterby_term');
