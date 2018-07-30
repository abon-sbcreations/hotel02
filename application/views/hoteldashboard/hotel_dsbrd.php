
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
        <title>Admin Dashboard Area</title>
        <link href="<?= site_url("library/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= site_url("assets/css/custom02.css") ?>" rel="stylesheet">
        <style>
            body{
                background-size:cover;
            }
        </style>
  </head>
  <body>
    <?=$head02Temp?>
    <div class="container-fluid">
      <div class="row">
              <div class="col-md-3"><?=$leftmenu02Temp?></div>
              <div class="col-md-9"><div class="dashBoardTitle"><span>Welcome to</span><br><?=$loggedHotelAdmin['hotel_name']?></div></div>
      </div>
    </div>
      
 <script src="<?= site_url("library/js/jquery.min.js") ?>" type="text/javascript"></script>
    <script src="<?= site_url("library/js/bootstrap.min.js") ?>" type="text/javascript"></script>
    <script src="<?= site_url("library/js/jquery.validate.min.js") ?>" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function () {
         window.history.forward(-1);
    });
   </script>
  </body>
</html>
