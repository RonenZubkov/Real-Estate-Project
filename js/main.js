'use strict';


$(function() {
    console.log( "ready!" );
    /* Register */
    $('#register-form').submit(function (e){
        /*Todo on Succseful Submmission what is going to happen? JS / Php*/
        let form = $(this);
        let data = form.serialize();
        let url = '../php/api.php';

        e.preventDefault();

        $.ajax({
            type: "POST",
            url : url,
            data: data,
            dataType : 'json',
            success: function (data) {
                console.log('Register Submission was successful.');
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    });

    /* Login */

    $('#login-form').submit(function (e) {
        let form = $(this);
        let data = form.serialize();
        let url = '../php/api.php';

        e.preventDefault();

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            success: function (data) {
                console.log('Login Submission was successful.');
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    });

    /* Ends here */
});

