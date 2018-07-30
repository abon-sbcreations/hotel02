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
        <title>Operator Login</title>
        <link href="<?= site_url("library/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= site_url("assets/css/custom01.css") ?>" rel="stylesheet">
        <style>
            body{
                background-image: url("<?= site_url("library/images/hotel_background02.jpg") ?>");
                background-repeat : no-repeat;
                background-size: 100% ;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?= form_open('authenticate', ['name' => 'loginForm', 'method' => 'post', 'class' => 'form-signin',
                'id' => 'loginForm']); ?>
            <h2 class="form-signin-heading">Please sign in</h2>
            <div class="form-group">
                <?= form_label('User Name', 'uname', ['class' => 'sr-only', 'id' => '']); ?>
                <?= form_input(['name' => 'uname', 'placeholder' => "User Name", 'class' => 'form-control','autocomplete' => "off" ,
                    'id' => 'uname']); ?>
                <?= form_error('uname'); ?>
            </div>
            <div class="form-group">
                <?= form_label('Password', 'password', ['class' => 'sr-only', 'id' => '']); ?>
                <?= form_password(['name' => 'password', 'placeholder' => "Password", 'class' => 'form-control','autocomplete' => "off" ,
                    'id' => 'password']); ?>
                <?= form_error('password'); ?>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <?= form_close() ?>
    </div> 
    <script src="<?= site_url("library/js/jquery.min.js") ?>" type="text/javascript"></script>
    <script src="<?= site_url("library/js/bootstrap.min.js") ?>" type="text/javascript"></script>
    <script src="<?= site_url("library/js/jquery.validate.min.js") ?>" type="text/javascript"></script>
    <script>
        $(function(){
            window.history.forward(-1);
          $("label#error").remove();
            $("#loginForm").validate({
                rules: {
                    uname: {required: "true"},
                    password: {
                        required: "true",
                        remote: {
                            url: "<?= site_url('operators/ajaxCheckOperator') ?>",
                            type: "post",
                            delay: 150,
                            data: {
                                uname: function() {
                                    return $("#uname").val();
                                },
                                password: function() {
                                    return $("#password").val();
                                }
                            }
                        }
                    },
                },
                messages: {
                    uname: {required:"User Name is Required"},
                    password: {required: "Password is Required",
                        remote: "User name and password combination invalid"}

                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>
