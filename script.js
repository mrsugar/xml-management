$(function(){
    $("#loginModal .btn-primary").on('click', function(){
        $("#LoginAlert, #LoginFail").slideUp();
        $.post( "/login.php", { username: $("#usernameInput").val(), password: $("#passwordInput").val() }, function( data ) {
            if(parseInt(data) == 1){
                $("#LoginAlert").slideDown();
                window.setTimeout( function(){
                    window.location = "/";
                }, 1000 );
            }else {
                $("#LoginFail").slideDown();
            }
        }); 
    });
});