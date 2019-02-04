$( document ).ready(function() {
    checkIfJWT();
});

// function to make form values to json format
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function checkIfJWT(){

    // validate jwt to verify access
    let jwt = getCookie('jwt');

    $.post("api/validate_token.php", JSON.stringify({ jwt:jwt })).done(function(result) {
        console.log('JWT is done');
        // if valid, show homepage
        // let html = `
        //     <div class="card">
        //         <div class="card-header">Welcome to Home!</div>
        //         <div class="card-body">
        //             <h5 class="card-title">You are logged in.</h5>
        //             <p class="card-text">You won't be able to access the home and account pages if you are not logged in.</p>
        //         </div>
        //     </div>
        //     `;
        //
        // $('#content').html(html);
        // // showLoggedInMenu(result.data.access_level);
    })



    // show login page on error
        .fail(function(result){
            // showLoginPage();
            console.log('fail');
            $('#myModal').css("show");
            $('#response').append("<div class='alert alert-danger'>Please login to access the home page.</div>");
        });
}

// function to set cookie
function setCookie(cname, cvalue, exdays) {
    let d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

// get or read cookie
function getCookie(cname){
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' '){
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
