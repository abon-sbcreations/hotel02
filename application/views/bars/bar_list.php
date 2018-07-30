<!DOCTYPE html><html lang="en">    <head>        <meta charset="utf-8">        <meta http-equiv="X-UA-Compatible" content="IE=edge">        <meta name="viewport" content="width=device-width, initial-scale=1">        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->        <meta name="description" content="">        <meta name="author" content="">        <link rel="icon" href="<?= site_url("library/images/hotel-flat-icon-vector.jpg") ?>">        <title>Bar's Master List</title>        <link href="<?= site_url("library/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>        <link href="<?= site_url("library/css/datatables.min.css") ?>" rel="stylesheet" type="text/css"/>        <link href="<?= site_url("assets/css/custom02.css") ?>" rel="stylesheet">        <style>            #modalDialog{                width:60%;            }        </style>    </head>    <body> <?=$head02Temp?>        <div class="container-fluid">            <div class="row">                 <?=$leftmenu02Temp?>                <div class="col-md-10 col-lg-offset-2">                    <div class="h3"><span>Bar Menu List</span><span class="addbttn"><button onclick="addHotelbar()" class="btn btn-info">Add Bar Item</button></span></div>                    <table id="hotelbar_list" class="table table-bordered table-striped table-hover">                        <thead>                            <tr>                                <th>Category</th>                                <th>Name</th>                                <th>Price</th>                                <th>Available</th>                                 <th>Actions</th>                            </tr>                        </thead>                        <tbody>                        </tbody>                    </table>                </div>            </div>        </div>        <div id="hotelbarDetails" class="modal fade" role="dialog">            <div id="modalDialog" class="modal-dialog  modal-lg">                <!-- Modal content-->                <div class="modal-content ">                    <div class="modal-header">                        <button type="button" class="close" data-dismiss="modal">&times;</button>                        <h4 class="modal-title">Bar Menu List</h4>                    </div>                    <div class="modal-body">                        <form method="post" name="hotelbarDetailEdit" id="hotelbarDetailEdit" >                            <div class="row">                                <input type="hidden" name="menu_id" id="menu_id" value="0" class="form-control">                                <div class="form-group col-md-6 mb-6">                                    <label for="menu_cat">Beverage Category</label>                                    <input type="text" name="menu_cat" id="menu_cat" value="10" class="form-control">                                                                        <div id="errMenu_cat" class="errorlabel"></div>                                    <label for="item_name">Name</label>                                    <input type="text" name="item_name" id="item_name" class="form-control">                                    <div id="errItem_name" class="errorlabel"></div>                                                                    </div>                                <div class="form-group col-md-6 mb-6">                                    <label for="item_price">Price</label>                                    <input type="num" min="0" name="item_price" id="item_price" class="form-control">                                    <div id="errItem_price" class="errorlabel"></div>                                    <label for="item_available">is Available</label>                                    <select class="custom-select d-block w-100 form-control" id="item_available" name="item_available"></select>                                                                        <div id="errItem_available" class="errorlabel"></div>                                </div>                            </div>                            <div class="row">                                <div class="form-group col-md-12  mb-6">                                    <label for="item_desc">Item Description:</label>                                    <textarea  name="item_desc" class="form-control" rows="4" cols="" id="item_desc"></textarea>                                    <div id="errItem_desc" class="errorlabel"></div>                                </div>                                                            </div>                            <div class="row">                                <div class="form-group col-md-4 mb-3">                                    <input id="submitBtn" type="button" class="btn btn-info" value="submit" >                                </div>                            </div>                        </form>                    </div>                </div>            </div>        </div>        <script src="<?= site_url("library/js/jquery.min.js") ?>" type="text/javascript"></script>        <script src="<?= site_url("library/js/bootstrap.min.js") ?>" type="text/javascript"></script>        <script src="<?= site_url("library/js/jquery.validate.min.js") ?>" type="text/javascript"></script>        <script src="<?= site_url("library/js/datatables.min.js") ?>" type="text/javascript"></script>        <script type="text/javascript">                        var dataTableHotelbar = "<?= site_url("bars/ajaxAllBarMasterDataTable") ?>";                        var hotelbarDetails = $("#hotelbarDetails");                        var typeList; var isAvailable;                        $(document).ready(function () {                            window.history.forward(-1);                            typeList = "<?= addslashes(json_encode($menuTypeOption)) ?>";                            isAvailable = "<?= addslashes(json_encode($availableOption)) ?>";                            var table1 = $('#hotelbar_list').DataTable({                                "ajax": {                                    url: dataTableHotelbar,                                    type: 'GET'                                },                                "oLanguage": {                                    "sEmptyTable": "No Record Found"                                },                                "aoColumns": [                                    {mData: 'menu_cat'},                                    {mData: 'item_name'},                                    {mData: 'item_price'},                                    {mData: 'item_available'},                                     {mData: "menu_id", bSortable: false, sWidth: "80px",                                        mRender: function (data, type, full) {                                            var editBtn = "<button class=\"btn btn-info btn-xs\" onclick=\"editHotelbar(" + data + ")\">Edit</button>";                                            var delBtn = "<button class=\"btn btn-danger btn-xs\" onclick=\"deleteHotelbar(" + data + ")\">Delete</button>";                                            return editBtn + "&nbsp;&nbsp;&nbsp;&nbsp;" + delBtn;                                        }                                    }                                ]                            });                        });                        function addHotelbar() {                            $("#hotelbarDetailEdit")[0].reset();                            $("#hotelbarDetailEdit input:not(#submitBtn)").val("");                            $("#hotelbarDetailEdit textarea").html("");                                                         popOptions(typeList, "#menu_type");                            popOptions(isAvailable, "#item_available");                             hotelbarDetails.modal("show");                        }                        function editHotelbar(menu_id) {                            $.ajax({                                type: "POST",                                url: "<?= site_url('bars/ajaxHotelbarMasterDetails') ?>",                                data: {menu_id: menu_id},                                success: function (result) {                                    var data = $.parseJSON(result);                                    popOptions(isAvailable, "#item_available", data['item_available']);                                    $("input[name*='menu_cat']").val(data['menu_cat']);                                    $("input[name*='menu_id']").val(data['menu_id']);                                    $("input[name*='item_name']").val(data['item_name']);                                    $("input[name*='item_price']").val(data['item_price']);                                    $("#item_desc").html(data['item_desc']);                                    hotelbarDetails.modal("show");                                }                            });                        }                        function refreshTable() {                            $.getJSON(dataTableHotelbar, null, function (json) {                                table = $('#hotelbar_list').dataTable();                                oSettings = table.fnSettings();                                table.fnClearTable(this);                                for (var i = 0; i < json['data'].length; i++) {                                    table.oApi._fnAddData(oSettings, json['data'][i]);                                }                                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();                                table.fnDraw();                            });                        }                        function deleteHotelbar(menu_id) {                            var r = confirm("Do you really want to delete this record?");                            if (r == true) {                                $.ajax({                                    type: "POST",                                    url: "<?= site_url('bars/ajaxBarMasterDelete') ?>",                                    data: {menu_id: menu_id},                                    success: function (result) {                                        hotelbarDetails.modal("hide");                                        refreshTable();                                    }                                });                            } else {                                hotelbarDetails.modal("hide");                            }                        }                        $("#submitBtn").on("click", function () {                        $(".errorlabel").html("");                         var errorNo = 0;                            if($("#menu_cat").val().length == 0){                                $("#errMenu_cat").html("Required");                                errorNo++;                         }                         if($("#item_name").val().length == 0){                                $("#errItem_name").html("Required");                                errorNo++;                         }else{                             $.ajax({                                    type: "POST",                                    async: false,                                    url: "<?= site_url('bars/ajaxUniqueHotelBarsAttr')?>",                                    data: {                                        primaryVal: $("#menu_id").val(),                                        attr: "item_name",                                        attrVal: $("#item_name").val()                                    },                                    success: function (result) {                                        if (result > 0) {                                            $("#errItem_name").html("Name must be unique.");                                            errorNo++;                                        }                                    }                                });                         }                         if($("#item_price").val().length == 0){                                $("#errItem_price").html("Required");                                errorNo++;                         }else{                             if(!$.isNumeric($("#item_price").val())){                                 $("#errItem_price").html("Value contains text.");                                 errorNo++;                             }                         }                          if(errorNo == 0){                            $("#hotelbarDetailEdit").submit();                         }                                                   });                        $("#hotelbarDetailEdit").submit(function (e) {                            $.ajax({                                type: "POST",                                url: "<?= site_url('bars/ajaxHotelBarMasterSubmit') ?>",                                data: $("#hotelbarDetailEdit").serialize(),                                success: function (result) {                                    $("#hotelbarDetailEdit")[0].reset();                                    hotelbarDetails.modal("hide");                                    refreshTable();                                }                            });                            e.preventDefault();                        });                        function popOptions(options, dom_id, sel_id = "") {                            var optionsList = $.parseJSON(options);                            var arrCount = 0;                            $.each(optionsList, function (key, row) { arrCount++;});                            var option = arrCount > 2 ? "<option value=\"\">Choose...</option>" : "";                            $.each(optionsList, function (key, row) {                                var select = sel_id == key ? "selected='selected'" : "";                                option = option + "<option " + select + " value=\"" + key + "\">" + row + "</option>";                            });                            $(dom_id).html(option);                        }        </script>    </body></html>