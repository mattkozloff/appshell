//Globals
var currentUser = null;

//change nav bar
$(document).ready(function() {
    toggleLoginLogoffItems(false);
});

// change nav bar
function toggleLoginLogoffItems(loggedin) {
    if(loggedin == true){
        $('.loggedOn').show();
        $('.loggedOff').hide();
    } else {// login = false 
        $('.loggedOn').hide();
        $('.loggedOff').show();
    }
};

// delete cookie
$('#logoutNavItem').on("click", function() {
    currentUser = null;
    toggleLoginLogoffItems(false);
    setCookie("token","",-1);
});



//----------------------------------------------------------------------//
//login
$('#loginButton').on('click', function(){
    
    if ($('#rememberMe').prop('checked')) 
        var login_Token = generateRandomToken(25);
   

    $.ajax({
        url: 'login.php',
        type: 'POST',
        data:	{
            username:   $("#loginusername").val(),
            password:   $("#loginpassword").val(),
            rememberMe: $('#rememberMe').prop('checked'),
            //send rememberme flag and token
            loginToken: login_Token
            
                }, 
        dataType: 'html',
        success:	function(data){

            try {
                data = JSON.parse(data);
                //alert("success");
                currentUser = data.user; // set the currentUser to the global variable
                    
                    $("#loginusername").val("");
                    $("#loginpassword").val("");
                    $("#loginUser").text("Welcome back, " + currentUser[0].username + ".");

                    if ($('#rememberMe').prop('checked')) 
                        setCookie("token",login_Token,30);
                    
                               
                    toggleLoginLogoffItems(true);
                $("#homeNavItem").click();
            } catch (ex) {
                alert(ex);
            }
        },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                alert("-ERROR:" + xhr.responseText + " - " + 
                thrownError + " - Options" + ajaxOptions);
            }
        });
    });


//----------------------------------------------------------------------------------//
// signup and login
$('#signUpButton').on('click', function() {
    if($('#signUpPassword').val() != $('#signUpConfirmPassword').val()) {
        alert("Passwords must match");
         // evt.preventDefault();
        return ;
    }

    $.ajax({
        url: 'signup.php',
        type: 'POST',
        data:	{
                    username:   $("#signUpUsername").val(), 
                    name:       $("#signUpName").val(),
                    email:      $("#signUpEmail").val(),
                    password:   $("#signUpPassword").val()
                },
        dataType: 'html',
        success:	function(data){

                        try {
                            data = JSON.parse(data);
                           // alert("success");
                            currentUser = data.user; // set the currentUser to the global variable
                                $("#signUpUsername").val("");
                                $("#signUpName").val("");
                                $("#signUpEmail").val("");
                                $("#signUpPassword").val("");
                                $("#signUpConfirmPassword").val("");
                                $("#loginUser").text("Welcome, " + currentUser[0].username + ".");
                            toggleLoginLogoffItems(true);
                            $("#homeNavItem").click();
                        } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    }
    });    		
});


//----------------------------------------------------------------------//
// get login cookie
$(document).ready(function(){

    if(getCookie('token')){
        attemptAutoLogin(getCookie('token'));
    }else{
        toggleLoginLogoffItems(false);
    }

    //login to signup link 
$("#loginToSignUp").on("click", function(){
    $("#signupNavItem").click();
})
});


// auto login with token cookie
function attemptAutoLogin(login_Token){
    
    
    $.ajax({
        url: 'auto_login.php',
        type: 'POST',
        data:	{
            
            loginToken: login_Token
            
                }, 
        dataType: 'html',
        success:	function(data){

            try {
                data = JSON.parse(data);
               // alert("success");
                currentUser = data.user; // set the currentUser to the global variable
                    
                    $("#loginusername").val("");
                    $("#loginpassword").val("");
                    $("#loginUser").text("Welcome back, " + currentUser[0].username + ".");

                    if ($('#rememberMe').prop('checked')) 
                        setCookie("token",login_Token,30);
                    
                               
                    toggleLoginLogoffItems(true);
                $("#homeNavItem").click();
            } catch (ex) {
                alert(ex);
            }
        },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                alert("-ERROR:" + xhr.responseText + " - " + 
                thrownError + " - Options" + ajaxOptions);
            }
        });
    };


//-------------------------------------------------------------------------------------//
//Get and update user data
//populate form fields for manage acccount

$("#manageAccountNavItem").on("click", function(){

    $("#manageUsername").val(currentUser[0].username);
    $("#manageName").val(currentUser[0].name);
    $("#manageEmail").val(currentUser[0].email);
    $("#manageid").val(currentUser[0].ID);

});

$("#Modal").on("click", function(){

    $("#changePasswordUsername").val(currentUser[0].username);
})

$('#logoutNavItem').on("click", function() {
    currentUser = null;
    toggleLoginLogoffItems(false);
});










// -----------------------------------------------------------------------------------//
// generate cookie
function generateRandomToken(n){
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    var date = new Date();
    var dateInMilliseconds = date.getTime();

    for(var i=0; i < n; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return dateInMilliseconds + text;
}

// set cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

// get cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return ""
};

