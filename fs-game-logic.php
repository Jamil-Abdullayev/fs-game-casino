<?php
class FsGameLogic{
    public function __construct(){
        add_action('wp_ajax_fs_game_win_or_lose',array($this,'fs_game_win_or_lose'));
    }

    public function fs_game_win_or_lose(){
        if(isset($_POST['bet'])){
            $bet = $_POST['bet'];
            //echo $bet;
            $balance = get_user_meta( get_current_user_id(), 'fs_game', true );

            if($bet > $balance){
                $message = 'You have not enough balance!';
                $status = 1;
            }
            else{
                $random_number = rand(0,99);

                if($random_number <= 40){
                    update_user_meta(get_current_user_id(), 'fs_game', $balance + $bet );
                    $message = 'You  win! Your balance will x2!';
                    $status = 2;
                }
                else{
                    update_user_meta(get_current_user_id(), 'fs_game', $balance - $bet);
                    $message = 'You lose :(';
                    $status = 3;
                }
            }
            $balance = get_user_meta( get_current_user_id(), 'fs_game', true );
            ob_start();
            echo json_encode(array("success" => true,"status"=>$status,"message" => $message,"balance" => $balance));
        
            wp_die();
        }
    }
}