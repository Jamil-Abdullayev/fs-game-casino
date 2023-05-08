jQuery(document).ready(function($){
    
    //bet event start
    $('.bet').click(function(event){
        event.preventDefault();
        var bet = $(this).data('bet');//bet value

        var data ={
            'action': 'fs_game_win_or_lose',
            'bet': bet,
            'nonce': fs_game_vars.nonce
        };
        $.post(fs_game_vars.ajax_url, data, function(response) {
                var responseArray = JSON.parse(response);
                console.log(responseArray);
                //{ success: true, status: 3, message: "You lose :(", balance: "45" }
                $('#user-balance').text(responseArray.balance + '$');
                $('#message').text(responseArray.message);
        });
    });
    //bet event end

    //add to balance event start
    $('#add-button').click(function(event){
        event.preventDefault();
        var value = $('#add-input').val();
        
        var data = {
            'action': 'add_to_balance',
            'value': value,
            'nonce': fs_game_vars.nonce
        };

        $.post(fs_game_vars.ajax_url,data, function(response){
            if (response.success) {
                window.location.href = response.data;
            }
        });
    });
});