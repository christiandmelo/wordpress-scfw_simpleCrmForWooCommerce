<?php

function listOrdersByProduct($stat, $productId){
    global $wpdb;

    $sql = "SELECT 	ORDER_ITEM.order_id,
                    ORDER_ITEM.order_item_name,
                    ORDER_.status,
                    ORDER_PROD.product_qty,
                    ORDER_PROD.product_gross_revenue AS revenue_price,
                    POST.post_title AS name_product,
                    USERS.display_name,
                    USERS.user_email
            FROM {$wpdb->prefix}woocommerce_order_items ORDER_ITEM
            INNER JOIN {$wpdb->prefix}wc_order_stats ORDER_
                ON ORDER_.order_id = ORDER_ITEM.order_id
            INNER JOIN {$wpdb->prefix}wc_customer_lookup CUSTOMER
                ON CUSTOMER.customer_id = ORDER_.customer_id
            INNER JOIN {$wpdb->prefix}users USERS
                ON USERS.ID = CUSTOMER.user_id
            INNER JOIN {$wpdb->prefix}wc_order_product_lookup ORDER_PROD
                ON ORDER_PROD.order_id = ORDER_ITEM.order_id
                AND ORDER_PROD.order_item_id = ORDER_ITEM.order_item_id
                AND ORDER_PROD.customer_id = CUSTOMER.customer_id
            INNER JOIN {$wpdb->prefix}wc_product_meta_lookup PROD
                ON PROD.product_id = ORDER_PROD.product_id
            INNER JOIN {$wpdb->prefix}posts POST
                ON POST.ID = ORDER_PROD.product_id
            WHERE 1 = 1";

    if(isset($stat) && $stat != "0")
        $sql .= " AND ORDER_.status = '".$stat."'";

    if(isset($productId) && $productId != "0")
        $sql .= " AND PROD.product_id = '".$productId."'";

    $sql.= " ORDER BY ORDER_ITEM.order_id";
    
    return $wpdb->get_results($sql, OBJECT );
}

?>