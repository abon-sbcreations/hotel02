<?php
$activeMenu = empty($activeMenu) ? "" : $activeMenu;
?>
<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li class="<?=$activeMenu=="module_masters"?"active":"" ?>" ><a href="<?= site_url('module_masters') ?>">Module Management</a></li>
        <li class="<?=$activeMenu=="companies"?"active":"" ?>"><a href="<?= site_url('companies') ?>">Company Management</a></li>
        <li class="<?=$activeMenu=="hotels/hotels"?"active":"" ?>"><a href="<?= site_url('hotels/hotels') ?>">Hotel Management</a></li>
        <li class="<?=$activeMenu=="rooms/master"?"active":"" ?>"><a href="<?= site_url('rooms/master') ?>">Room Management</a></li>
        <li class="<?=$activeMenu=="amenities/amenity_list"?"active":"" ?>"><a href="<?= site_url('amenities/amenity_list') ?>">Amenity Management</a></li>            
        <li class="<?=$activeMenu=="hotel_admins/admins"?"active":"" ?>"><a href="<?= site_url('hotel_admins/admins') ?>">Hotel Admin Management</a></li>
    </ul>
    <ul class="nav nav-sidebar"></ul>
    <!--ul class="nav nav-sidebar">
      <li><a href="">Nav item again</a></li>
      <li><a href="">One more nav</a></li>
      <li><a href="">Another nav item</a></li>
    </ul-->
</div>
