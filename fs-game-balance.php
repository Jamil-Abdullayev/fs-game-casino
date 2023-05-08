<?php 
class FsGameBalance{
    public function __construct(){
        add_action( 'user_register', array( $this, 'fs_game_give_bonus' ) );
        add_action('wp_ajax_add_to_balance',array($this,'fs_game_add_to_balance'));
        add_action('woocommerce_order_status_completed', array($this,'fs_game_add_to_balance_after_payment'));
    }

    public function fs_game_give_bonus($user_id){
        //there will adding bonus to new user
        add_user_meta( $user_id, 'fs_game', 10 );
    }

    public function fs_game_add_to_balance(){
        if(isset($_POST['value'])){
            global $WC;
            $value = $_POST['value'];
            $product_id = get_option( 'fs_product_id' );

            update_post_meta($product_id,'_price', $value);
            
            $cart = WC()->cart;
            $cart->add_to_cart($product_id);

            wp_send_json_success(wc_get_checkout_url());
            wp_die();
        }
    }

    function fs_game_add_to_balance_after_payment($order_id) {
        $order = wc_get_order($order_id);

        if ($order && $order->get_status() === 'completed') {
            $user_id = $order->get_user_id();

            $changed_price = intval($order->get_total());
    
            $current_balance = intval(get_user_meta($user_id, 'fs_game', true));
            $new_balance = $current_balance + $changed_price;
            update_user_meta($user_id, 'fs_game', $new_balance);
            // var_dump(array('user_id'=>$user_id,'order_id'=>$order_id,'new_balance'=>$new_balance,'line_total'=>$changed_price));
            // wp_die();
        }   
    }
}