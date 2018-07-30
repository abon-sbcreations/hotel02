<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?= site_url("library/images/hotel-flat-icon-vector.jpg") ?>">
        <title>Hotel Admin Login</title>
        <link href="<?= site_url("library/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= site_url("assets/css/custom01.css") ?>" rel="stylesheet">
        <style>
            body{
                background-repeat : no-repeat;
                background-size: 100% ;
                background-color: #a2a2a2;
            }
        </style>
    </head>
    <body>
        <div class="container loginFormCls">
            <?= form_open('admins', ['name' => 'loginForm', 'method' => 'post', 'class' => 'form-signin', 'id' => 'loginForm']); ?>
            <h2 class="form-signin-heading"><span class="glyphicon glyphicon-lock"></span>&nbsp;Administrator Login</h2>
            <div class="form-group">
                <?= form_label('User Name', 'uname', ['class' => 'sr-only', 'id' => '']); ?>
                <?= form_input(['name' => 'uname', 'placeholder' => "User Name", 'class' => 'form-control', 'id' => 'uname']); ?>
                <div class="error" id="unameErr"></div>
            </div>
            <div class="form-group">
                <?= form_label('Password', 'password', ['class' => 'sr-only', 'id' => '']); ?>
                <?= form_password(['name' => 'password', 'placeholder' => "Password", 'class' => 'form-control', 'id' => 'password']); ?>
                <div class="error" id="passwordErr"></div>
            </div>
            <button id="submitBtn" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <?= form_close() ?>
        </div> 
        <script src="<?= site_url("library/js/jquery.min.js") ?>" type="text/javascript"></script>
        <script src="<?= site_url("library/js/bootstrap.min.js") ?>" type="text/javascript"></script>
        <script src="<?= site_url("library/js/jquery.validate.min.js") ?>" type="text/javascript"></script>
        <script>
            $(function () {
               window.history.forward(-1);
                $("#submitBtn").on("click", function (e) {
                    $(".error").html("");
                    var errorNo = 0;
                    if ($("#uname").val().length == 0) {
                        errorNo++;
                        $("#unameErr").html("Required");
                    }
                    if ($("#password").val().length == 0) {
                        errorNo++;
                        $("#passwordErr").html("Required");
                    }
                    if ($("#uname").val().length != 0 && $("#password").val().length != 0) {
                        $.ajax({
                            type: "POST",
                            async: false,
                            url: "<?= site_url('admins/ajaxCheckUnamePass') ?>",
                            data: {
                                uname: $("#uname").val(),
                                password: $("#password").val()
                            },
                            success: function (result) {
                                if (result != 0) {
                                    $("#unameErr").html("Invalid login, please try again.");
                                    $("#passwordErr").html("");
                                    errorNo++;
                                }
                            }
                        });

                    }
                    if(errorNo == 0){
                        $("#loginForm").submit();
                    }
                     e.preventDefault();
                });
            });
        </script>
    </body>
</html>
