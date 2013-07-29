var Login = function () {
    
    return {
        init: function () {
        	
            $("#formLOGIN").validationEngine();
            $("#formFORGET").validationEngine();

            jQuery('#forget-password').click(function () {
                jQuery('.login-form').hide();
                jQuery('.forget-form').show();
            });

            jQuery('#back-btn').click(function () {
                jQuery('.login-form').show();
                jQuery('.forget-form').hide();
            });



        }

    };

}();