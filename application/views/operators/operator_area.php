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
                background-image: url("<?= site_url("library/images/hotel_background05.jpg") ?>"); 
            }
        </style>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Hotel Software</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="<?= site_url('admins/logout')?>">(<?=$loggedDisplay?>)</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="<?=site_url('companies')?>">Companies List</a></li>
            <li><a href="<?=site_url('hotels/hotels')?>">Hotels</a></li>
            <li><a href="<?=site_url('hotel_rooms/master')?>">Hotel's Room Types</a></li>
            <li><a href="<?=site_url('rooms/master')?>">Room's Master</a></li>
            <li><a href="<?=site_url('Amenities/amenity_list')?>">Amenity Master</a></li>
            <li><a href="<?=site_url('room_items/master')?>">Room Items Master</a></li>
            <li><a href="<?=site_url('hotel_items/master')?>">Hotel Items Master</a></li>
            <li><a href="<?=site_url('restaurants/restaurant_list')?>">Restaurant Master</a></li>
           </ul>
          <ul class="nav nav-sidebar"></ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
        </div>
        
      </div>
    </div>
      
 <script src="<?= site_url("library/js/jquery.min.js") ?>" type="text/javascript"></script>
    <script src="<?= site_url("library/js/bootstrap.min.js") ?>" type="text/javascript"></script>
    <script src="<?= site_url("library/js/jquery.validate.min.js") ?>" type="text/javascript"></script>
    <script>
        $(function(){
            window.history.forward(-1);
        });
    </script>
  </body>
</html>
