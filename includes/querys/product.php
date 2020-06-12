<?php

function listAllProducts(){
    global $wpdb;

    $sql = "SELECT 	POST.ID,
            POST.post_title
        FROM wp_posts POST
        INNER JOIN wp_wc_product_meta_lookup PRODUCT
        ON PRODUCT.product_id = POST.ID
        ORDER BY POST.post_title";
    
    return $wpdb->get_results($sql, OBJECT );
}

?>