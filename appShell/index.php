<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>App Shell</title>   
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/html/header.html"); ?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/html/home.html"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/html/about.html"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/html/contact.html"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/html/manageAccount.html"); ?>	   
<?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/html/signup.html"); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/html/login.html"); ?>

<?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/html/footer.html"); ?>	   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script src="js/appshell.js"></script>
<script>
    $(document).ready(function() {
	    $('section').eq(0).show(); 
	    $('.navbar-nav').on('click', 'a', function() {
	        $($(this).attr('href')).show().siblings('section:visible').hide();
		    });
	});
</script>

</body>
</html>

