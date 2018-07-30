<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="<?= site_url('dashboards/admin_area')?>"><?=ucwords($loggedDisplay)?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">&nbsp;</a></li>
            <li><a href="#">&nbsp;</a></li>
            <li><a href="<?= site_url('admins/logout')?>"><span class="glyphicon glyphicon-off"></span>&nbsp;Logout</a></li>
            <li><a href="#">&nbsp;</a></li>
          </ul>
          <!--form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form-->
        </div>
      </div>
    </nav>