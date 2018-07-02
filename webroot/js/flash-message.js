(function ($) {

    $.fn.showFlashMessage = function (error, message) {

        var currentBox = "errorBox";
        $('.message-div').remove();
        if (error == "error" && $('#errorBox').length <= 0) {
            $(".container-fluid").append("<div class='alert alert-danger fade in alert-dismissable danger-msg top-sus message-div' id='errorBox'><span class='image-center'><img src='" + SITE_URL + "/webroot/img/logo-login.png' alt='message'></span><p>" + message + "</p><a href='javascript:void(0)' class='close close-btn' data-dismiss='alert' aria-label='close'> <i class='fa fa-times-circle-o' aria-hidden='true'></i></a></div>");

        } else if (($('#successBox').length <= 0 || document.getElementById("successBox") !== null) && error == "success") {

            currentBox = "successBox";
            $(".container-fluid").append("<div class='alert alert-success fade in alert-dismissable danger-msg top-sus message-div' id='successBox'><span class='image-center'><img src='" + SITE_URL + "/webroot/img/logo-login.png'></span> <p>" + message + "</p><a href='javascript:void(0)' class='close close-btn' data-dismiss='alert' aria-label='close'> <i class='fa fa-times-circle-o' aria-hidden='true'></i></a></div>");
        }

        $('#' + currentBox + " p").html(message);
        $('#' + currentBox).show();

        return this;

    };

}(jQuery));
