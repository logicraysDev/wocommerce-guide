<?php

/* Add Product to WooCommerce Cart Automatically On Visit */

add_action( 'template_redirect', 'logicrays_add_product_to_cart_automatically' );
   
function logicrays_add_product_to_cart_automatically() {
           
   // select product ID
   $product_id = 150;
           
   // if cart empty, add it to cart
   if ( WC()->cart->get_cart_contents_count() == 0 ) {
      WC()->cart->add_to_cart( $product_id );
   }
     
}

/* PHP Snippet: Remove Item from Cart Automatically */

add_action( 'template_redirect', 'logicrays_remove_product_from_cart_programmatically' );
 
function logicrays_remove_product_from_cart_programmatically() {
   if ( is_admin() ) return;
   $product_id = 282;
   $product_cart_id = WC()->cart->generate_cart_id( $product_id );
   $cart_item_key = WC()->cart->find_product_in_cart( $product_cart_id );
   if ( $cart_item_key ) WC()->cart->remove_cart_item( $cart_item_key );
}

/*  Set Min, Max, Increment & Start Value Add to Cart Quantity @ WooCommerce Single Product Page & Cart Page (Simple Products) */

add_filter( 'woocommerce_quantity_input_args', 'logicrays_woocommerce_quantity_changes', 10, 2 );
   
function logicrays_woocommerce_quantity_changes( $args, $product ) {
   
   if ( ! is_cart() ) {
  
      $args['input_value'] = 4; // Start from this value (default = 1) 
      $args['max_value'] = 10; // Max quantity (default = -1)
      $args['min_value'] = 4; // Min quantity (default = 0)
      $args['step'] = 2; // Increment/decrement by this value (default = 1)
  
   } else {
  
      // Cart's "min_value" is already 0 and we don't need "input_value"
      $args['max_value'] = 10; // Max quantity (default = -1)
      $args['step'] = 2; // Increment/decrement by this value (default = 0)
      // COMMENT OUT FOLLOWING IF STEP < MIN_VALUE
      // $args['min_value'] = 4; // Min quantity (default = 0)
  
   }
   
   return $args;
   
}

/* Set Min Add to Cart Quantity @ WooCommerce Single Product Page (Variable Products -> Single Variation) */

add_filter( 'woocommerce_available_variation', 'logicrays_woocommerce_quantity_min_variation', 9999, 3 );
 
function logicrays_woocommerce_quantity_min_variation( $args, $product, $variation ) {
   $args['min_qty'] = 5;
   return $args;
}

/* Validation on the Update Cart button on Cart page */

// This code goes on function.php file of your active child theme (or theme). Tested and works.

add_action( 'woocommerce_after_cart_item_quantity_update', 'logicrays_limit_cart_item_quantity', 20, 4 );
function logicrays_limit_cart_item_quantity( $cart_item_key, $quantity, $old_quantity, $cart ){
    if( ! is_cart() ) return; // Only on cart page

    // Here the quantity limit
    $limit = 10;

    if( $quantity > $limit ){
        // Change the quantity to the limit allowed
        $cart->cart_contents[ $cart_item_key ]['quantity'] = $limit;
        // Add a custom notice
        wc_add_notice( __('Quantity limit reached for this item'), 'notice' );
    }
}