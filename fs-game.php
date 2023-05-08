<?php
/*
Plugin Name: FS Game
Plugin URI: https://www.fs-code.com/
Description: Posts publishing plugin.
Version: 1.0
Author: Jamil
Author URI: https://www.fs-code.com/
License: GPL2
*/
require_once('fs-game-balance.php');
require_once('fs-game-logic.php');
class FsGame{
    public function __construct(){
        add_shortcode('fs_game_short_code',array($this,'fs_game_short_code'));
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
        add_action( 'init', array( $this, 'disable_email_verification' ) );
        add_action( 'register_form',array($this,'add_password_field') );
        add_action( 'user_register', array($this,'save_password_field') );
        add_action( 'woocommerce_init', array($this,'create_fs_product') );
        new FsGameBalance();
        new FsGameLogic();
    }

    public function create_fs_product(){
        $product_sku = 'fs-product-sku';
        $args = array(
            'post_type' => 'product',
            'meta_query' => array(
                array(
                    'key' => '_sku',
                    'value' => $product_sku
                )
            )
        );
        $products = get_posts( $args );
        if ( empty( $products ) ) {
            
            $product = array(
                'post_title'    => 'FS Product',
                'post_status'   => 'publish',
                'post_type'     => 'product',
                'post_author'   => 1,
                'post_content'  => 'FS Product',
                'post_excerpt'  => 'Fs Product',
                'meta_input'    => array(
                    '_regular_price'    => '0',
                    '_price'            => '0',
                    '_stock_status'     => 'instock',
                    '_sku'              => 'fs-product-sku'
                )
            );
            
            $product_id = wp_insert_post( $product );
            update_option( 'fs_product_id', $product_id ); //save in option our product

            WC()->add_to_cart($product_id,1);
        } 
    }

    function save_password_field( $user_id ) {
        if ( isset( $_POST['password'] ) ) {
            wp_set_password( $_POST['password'], $user_id );
        }
    }

    public function add_password_field() {
        ?>
        <p>
            <label for="password">Password<br />
            <input type="password" name="password" id="password" class="input" value="" size="25" /></label>
        </p>
        <?php
    }

    //adding bootstrap styles ,  font awesome and scripts
    public function enqueue_scripts_styles() {
        wp_enqueue_script('jquery');
        wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css' );
        wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), '5.0.0', true );
        wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' );
        
        wp_enqueue_script( 'fs-game', plugin_dir_url( __FILE__ ) . 'assets/js/app.js', array( 'jquery' ) );
        wp_localize_script( 'fs-game', 'fs_game_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'fs_game_nonce' )
        ) );
    }
  
    public function disable_email_verification() {
        add_filter( 'wpmu_signup_user_notification_email', '__return_false' );
    }

    public function fs_game_short_code(){
        if ( ! is_user_logged_in() ) {
            wp_redirect( wp_registration_url() );
        }
        $balance = get_user_meta( get_current_user_id(), 'fs_game', true );
        ob_start();
        include('views/game.php');
        $output = ob_get_clean();

        return $output;
    }
    
}
new FsGame();