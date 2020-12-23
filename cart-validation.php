<?php

/*
Targeting a particular product in woocommerce add to cart validation hook

To target a specific product ID (that you will define in the code).
*/

add_action( 'woocommerce_add_to_cart_validation', 'logicrays_add_to_cart_validation', 15, 3 ); 

function logicrays_add_to_cart_validation( $passed, $product_id, $quantity ) {
    // HERE below define your specific product ID
    $specific_product_id = 37;

    if ( $quantity > 3 && $product_id == $specific_product_id ){
        wc_add_notice( __( 'Only 3 or less quantities allowed, please contact us on (937) 606-4258.', 'woocommerce' ), 'error' );
        $passed = false;
    }
    return $passed;
}