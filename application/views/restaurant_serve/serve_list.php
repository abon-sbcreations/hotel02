<!DOCTYPE html><html lang="en">    <head>        <meta charset="utf-8">        <meta http-equiv="X-UA-Compatible" content="IE=edge">        <meta name="viewport" content="width=device-width, initial-scale=1">        <meta name="description" content="">        <meta name="author" content="">        <link rel="icon" href="<?= site_url("library/images/hotel-flat-icon-vector.jpg") ?>">        <title>Restaurant's Master List</title>        <link href="<?= site_url("library/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>        <link href="<?= site_url("library/css/datatables.min.css") ?>" rel="stylesheet" type="text/css"/>                <link href="<?= site_url("library/css/bootstrap-datepicker3.standalone.min.css") ?>" rel="stylesheet" type="text/css"/>        <link href="<?= site_url("assets/css/custom02.css") ?>" rel="stylesheet">        <style>            #modalDialog{                width:50%;            }        </style>    </head>    <body>        <?= $head02Temp ?>        <div class="container-fluid">            <div class="row">                <?= $leftmenu02Temp ?>                <div class="col-md-10 col-lg-offset-2">                    <div class="h3"><span>Restaurants Bills List</span><span class="addbttn"><button onclick="addRestaurant()" class="btn btn-info">Add Food Item</button></span></div>                    <table id="restaurant_list" class="table table-bordered table-striped table-hover">                        <thead>                            <tr>                                <th>Customer</th>                                <th>Session</th>                                <th>Served Place Detail</th>                                <th>Served On</th>                                                                <th>Bill Summary</th>                                <th>Is Paid</th>                                <!--th>Is Served</th-->                                <th>Actions</th>                            </tr>                        </thead>                        <tbody>                        </tbody>                    </table>                </div>            </div>        </div>        <div id="restaurantServe" class="modal fade" role="dialog">            <div id="modalDialog" class="modal-dialog  modal-lg">                <!-- Modal content-->                <div class="modal-content">                    <div class="modal-header">                        <button type="button" class="close" data-dismiss="modal">&times;</button>                        <h4 class="modal-title">Restaurants Bills List</h4>                    </div>                    <div class="modal-body">                        <form method="post" name="restaurantServeEdit" id="restaurantServeEdit" >                            <div class="row">                                <div class="form-group col-md-6 mb-6">                                    <input type="hidden" name="resturant_service_id" id="resturant_service_id" value="0" class="form-control">                                    <label for="cust_id">Customer</label>                                                                        <select class="custom-select d-block w-100 form-control" name="cust_id" id="cust_id"></select>                                    <div id="errCust_id" class="errorlabel"></div>                                    <label for="served_on">Served On</label>                                    <input type="text" readonly="readonly" id="served_on" name="served_on" class="form-control">                                    <div id="errServed_on" class="errorlabel"></div>                                                                         <label for="menu_session">Session</label>                                    <select class="custom-select d-block w-100 form-control" id="menu_session" name="menu_session"></select>                                    <div id="errMenu_session" class="errorlabel"></div>                                </div>                                <div class="form-group col-md-6 mb-6">                                    <label for="served_place">Serve Place</label>                                    <select class="custom-select d-block w-100 form-control" name="served_place" id="served_place"></select>                                    <div id="errServed_place" class="errorlabel"></div>                                    <label for="served_place_detail">Place Detail</label>                                    <input type="text" id="served_place_detail" name="served_place_detail" class="form-control">                                    <div id="errServed_place_detail" class="errorlabel"></div>                                    <label for="isPaid">is Paid</label>                                    <select class="custom-select d-block w-100 form-control" id="isPaid" name="isPaid"></select>                                    <div id="errIspaid" class="errorlabel"></div>                                </div>                            </div>                            <div class="row">                                <div class="form-group col-md-12">                                    &nbsp;&nbsp;<button id="newServeItems" class="btn btn-warning">Add Item</button><br>                                    <div id="servedItem" class="errorlabel"></div>                                    <table id="servedItemLists" class="table table-bordered table-striped">                                        <thead>                                            <tr>                                               <th>Name</th>                                               <th>Quantity</th>                                               <th>Action</th>                                            </tr>                                                                                    </thead>                                        <tbody></tbody>                                    </table>                                </div>                            </div>                            <div class="row">                                <div class="form-group col-md-6 mb-6">                                    <input id="submitBtn" type="button" class="btn btn-info" value="submit" >                                </div>                            </div>                        </form>                    </div>                </div>            </div>        </div>        <script src="<?= site_url("library/js/jquery.min.js") ?>" type="text/javascript"></script>        <script src="<?= site_url("library/js/bootstrap.min.js") ?>" type="text/javascript"></script>        <script src="<?= site_url("library/js/jquery.validate.min.js") ?>" type="text/javascript"></script>        <script src="<?= site_url("library/js/datatables.min.js") ?>" type="text/javascript"></script>        <script src="<?= site_url("library/js/bootstrap-datepicker.min.js") ?>" type="text/javascript"></script>        <script type="text/javascript">                        var dataTableRestaurant = "<?= site_url("restaurants_served/ajaxAllRestaurantsServedDataTable") ?>";                        var restaurantDetails = $("#restaurantServe");                        var customerList;                   var servePlaceOption;                        var paidOpion;                      var isAvailable;                        var served;                         var sessionList;                        var restaurantMenuList;                        $(document).ready(function () {                            window.history.forward(-1);                            customerList = "<?= addslashes(json_encode($customerOptions))?>";                            servePlaceOption = "<?= addslashes(json_encode($servePlaceOption))?>";                            paidOpion = "<?= addslashes(json_encode($paidOpion))?>";                            sessionList = "<?= addslashes(json_encode($sessionOption))?>";                            restaurantMenuList = "<?= addslashes(json_encode($restaurantMenuList))?>";                                                        var table1 = $('#restaurant_list').DataTable({                                "ajax": {                                    url: dataTableRestaurant,                                    type: 'GET'                                },                                "oLanguage": {                                    "sEmptyTable": "No Record Found"                                },                                "aoColumns": [                                                                        {mData: 'cust_name',sWidth: "100px"},                  {mData: 'menu_session',sWidth: "40px"},                                    {mData: 'served_place',sWidth: "60px"},                {mData: 'served_on' ,sWidth: "60px"},                                     {mData: 'served_item' ,sWidth: "60px"},                {mData: 'isPaid',sWidth: "10px"},                                     {mData: "resturant_service_id", bSortable: false, sWidth: "80px",                                        mRender: function (data, type, full) {                                            var editY = "disabled='disabled'";                                            if(full.isFinal == "No"){                                                editY = "";                                            }                                            var editBtn = "<button "+editY+" class=\"btn btn-info btn-xs\" onclick=\"editRestaurant(" + data + ")\">Edit</button>";                                                                                        var delBtn = "<button "+editY+" class=\"btn btn-danger btn-xs\" onclick=\"deleteRestaurant(" + data + ")\">Delete</button>";                                            var finalBtn;                                            if(full.isFinal=="No"){                                                finalBtn = "<button  class=\"btn btn-warning btn-xs\" onclick=\"billFinal(" + data + ")\">Order Waiting </button>";                                            }else{                                                finalBtn = "<div class='h5'>This order is Served</div>";                                                                                            }                                            return editBtn + "&nbsp;&nbsp;&nbsp;&nbsp;" + delBtn+"<br><br>&nbsp;"+finalBtn;                                        }                                    }                                ]                            });                        });                        function addRestaurant() {                            $("#servedItemLists").hide();                            $("#restaurantServeEdit")[0].reset();                            $("#restaurantServeEdit input:not(#submitBtn)").val("");                            popOptions(customerList, "#cust_id");                            popOptions(servePlaceOption,"#served_place","room");                                                        popOptions(paidOpion,"#isPaid","N");                            popOptions(sessionList, "#menu_session", 'Lunch');                            restaurantDetails.modal("show");                        }                        function billFinal(resturant_service_id){                            $.ajax({                                type: "POST",                                url: "<?= site_url('restaurants_served/setAjaxFinalBill') ?>",                                data: { resturant_service_id: resturant_service_id },                                success: function () {                                    refreshTable();                                }                            });                        }                        function editRestaurant(resturant_service_id) {                            $("#servedItemLists").hide();                            $.ajax({                                type: "POST",                                url: "<?= site_url('restaurants_served/ajaxRestaurantServeDetails') ?>",                                data: { resturant_service_id: resturant_service_id },                                success: function (result) {                                    var data = $.parseJSON(result);                                    popOptions(customerList, "#cust_id",data['customer_id']);                                    popOptions(servePlaceOption,"#served_place",data['served_place']);                                    popOptions(paidOpion,"#isPaid",data['isPaid']);                                    popOptions(sessionList, "#menu_session", data['menu_session']);                                    $("input[name*='served_on']").val(data['served_on']);                                    $("input[name*='served_place_detail']").val(data['served_place_detail']);                                    var served = $.parseJSON(data['served_item']);                                    $("#servedItemLists tbody").html("");                                    $.each(served, function (key1, row1) {                                        addNewItem(row1['menu_id'],row1['quantity']);                                    });                                    restaurantDetails.modal("show");                                }                            });                        }                        function refreshTable() {                            $.getJSON(dataTableRestaurant, null, function (json) {                                table = $('#restaurant_list').dataTable();                                oSettings = table.fnSettings();                                table.fnClearTable(this);                                for (var i = 0; i < json['data'].length; i++) {                                    table.oApi._fnAddData(oSettings, json['data'][i]);                                }                                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();                                table.fnDraw();                            });                        }                        function deleteRestaurant(resturant_service_id) {                            var r = confirm("Do you really want to delete this record?");                            if (r == true) {                                $.ajax({                                    type: "POST",                                    url: "<?= site_url('restaurants_served/ajaxRestaurantMasterDelete') ?>",                                    data: {resturant_service_id: resturant_service_id},                                    success: function (result) {                                        restaurantDetails.modal("hide");                                        refreshTable();                                    }                                });                            } else {                                restaurantDetails.modal("hide");                            }                        }                        function popOptions(options, dom_id, sel_id = "") {                            var optionsList = $.parseJSON(options);                            var arrCount = 0;                            $.each(optionsList, function (key, row) {                                arrCount++;                            });                            var option = "";                            $.each(optionsList, function (key, row) {                                var select = sel_id == key ? "selected='selected'" : "";                                option = option + "<option " + select + " value=\"" + key + "\">" + row + "</option>";                            });                            $(dom_id).html(option);                        }                        $("#submitBtn").on("click", function () {                            $(".errorlabel").html("");                            var errorNo = 0;                                 if($('#servedItemLists tbody tr').length < 1){                                errorNo++;                                $("#servedItem").html("No Food Item Selected");                            }                            if($("#served_on").val().length < 1){                                errorNo++;                                $("#errServed_on").html("Required");                            }                            if($("#served_place_detail").val().length < 1){                                errorNo++;                                $("#errServed_place_detail").html("Required");                            }                                                        if (errorNo == 0) {                                $("#restaurantServeEdit").submit();                            }                        });                        $("#restaurantServeEdit").submit(function (e) {                            $.ajax({                                type: "POST",                                url: "<?= site_url('restaurants_served/ajaxRestaurantMasterSubmit') ?>",                                data: $("#restaurantServeEdit").serialize(),                                success: function (result) {                                    $("#restaurantServeEdit")[0].reset();                                    restaurantDetails.modal("hide");                                    refreshTable();                                }                            });                            e.preventDefault();                        });                        $(document).on("click","#newServeItems",function(e){                            addNewItem();                            e.preventDefault();                        });                        function addNewItem(menu_id=0,item_count=0){                            $("#servedItemLists").show();                            var session = $("#menu_session").val();                            var menuList = $.parseJSON(restaurantMenuList);                            var selectOption = "<select name='items[]' class='form-control'>";                            var countVal = item_count > 0 ? item_count : 1;                            var  itemCount = "<input type='number' min='1' value='"+countVal+"' name='itemCount[]' class='form-control'>";                            $.each(menuList[session], function (key, row) {                                var menu_selected='';                                menu_selected = menu_id > 0 && key == menu_id ? "selected='selected'" : "";                                 selectOption += "<option "+menu_selected+" value='"+key+"'>"+row+"</option>";                            });                            selectOption += "</select>";                            $("#servedItemLists tbody").append("<tr><td>"+selectOption+"</td><td>"+itemCount+"</td><td><button class='closeFoodItem'>X</button></td></tr>");                        }                        $("#served_on").datepicker({                            format: "dd-mm-yyyy",                            weekStart: 1,                            daysOfWeekHighlighted: "0,6",                            autoclose: true                        });                      $("#menu_session").on("change", function () {                            $("#servedItemLists tbody").html("");                            $("#servedItemLists").hide();                        });                     $(document).on('click',".closeFoodItem",function(e){                        this.closest("tr").remove();                        if($("#servedItemLists tbody tr").length < 1){                            $("#servedItemLists").hide();                        }                        e.preventDefault();                     });        </script>    </body></html>