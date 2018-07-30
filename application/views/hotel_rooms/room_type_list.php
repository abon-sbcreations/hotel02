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
        <title>Hotel Room Types</title>
        <link href="<?= site_url("library/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= site_url("library/css/datatables.min.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= site_url("assets/css/custom02.css") ?>" rel="stylesheet">
        <style>
            #modalDialog{
                width:50%;
            }
        </style>
    </head>
    <body>
        <?=$head02Temp?>
        <div class="container-fluid">
            <div class="row">
                <?=$leftmenu02Temp?>
                <div class="col-md-10 col-lg-offset-2">
                    <div class="h3"><span>Manage Room Types</span><span class="addbttn"><button onclick="addHotelRoomType()" class="btn btn-info">Add Hotel Room Type</button></span></div>
                    <table id="roomType_list" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Room Type</th>
                                <th>Room Rent</th>
                                <th>Description</th>
                                <th>Facilities</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="roomTypeDetails" class="modal fade" role="dialog">
            <div id="modalDialog" class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Manage Room Types</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" name="roomTypeDetailEdit" id="roomTypeDetailEdit" >
                            <div class="row">
                                <div class="form-group col-md-6 mb-6">                                    
                                    <label for="hotel_room_type">Room Type</label>
                                    <input type="hidden" name="hotel_room_master_id" id="hotel_room_master_id" value="0" class="form-control">
                                    <select class="custom-select d-block w-100 form-control" id="hotel_room_type" name="hotel_room_type"></select>
                                    <div id="errRoomType" class="errorlabel"></div>
                                    <label for="hotel_room_rent">Room Rent</label>
                                    <input type="number" min="0" name="hotel_room_rent" id="hotel_room_rent" class="form-control">
                                    <div id="errRoomRent" class="errorlabel"></div>
                                </div>
                                <div class="form-group col-md-6 mb-6">
                                    <label for="hotel_room_amenities">Room Facilities</label>
                                    <div id="roomAmenities"></div>
                                </div>
                            </div>
                                                        
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="hotel_room_desc">Room Description</label>
                                    <textarea name="hotel_room_desc" class="form-control" rows="5" cols="" id="hotel_room_desc"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mb-6">
                                    <input id="submitBtn" type="button" class="btn btn-info" value="submit" >
                                </div>
                            </div>                            
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
        <script src="<?= site_url("library/js/jquery.min.js") ?>" type="text/javascript"></script>
        <script src="<?= site_url("library/js/bootstrap.min.js") ?>" type="text/javascript"></script>
        <script src="<?= site_url("library/js/jquery.validate.min.js") ?>" type="text/javascript"></script>
        <script src="<?= site_url("library/js/datatables.min.js") ?>" type="text/javascript"></script>
        <script type="text/javascript">
                        var dataTableRoomType = "<?= site_url("hotel_rooms/ajaxAllHotelRoomTypeDataTable") ?>";
                        var roomTypeDetails = $("#roomTypeDetails");
                        var hotelList;var roomTypeList;var amenityOptions;
                        $(document).ready(function () {
                            window.history.forward(-1);
                            roomTypeList = "<?= addslashes(json_encode($roomTypeOptions))?>";
                            hotelList = "<?= addslashes(json_encode($hotelOptions))?>";
                            amenityOptions = "<?= addslashes(json_encode($amenityOptions))?>";
                            var table1 = $('#roomType_list').DataTable({
                                "ajax": {
                                    url: dataTableRoomType,
                                    type: 'GET'
                                },
                                "aoColumns": [
                                    {mData: 'room_type' , sWidth: "200px"},                                    
                                    {mData: 'hotel_room_rent', sWidth: "80px"},
                                    {mData: 'hotel_room_desc'},
                                    {mData: 'hotel_room_amenities'},
                                    {mData: "hotel_room_master_id", bSortable: false, sWidth: "80px",
                                        mRender: function (data, type, full) {
                                            var editBtn = "<button class=\"btn btn-info btn-xs\" onclick=\"editHotelRoomType(" + data + ")\">Edit</button>";
                                            var delBtn = "<button class=\"btn btn-danger btn-xs\" onclick=\"deleteHotelRoomType(" + data + ")\">Delete</button>";
                                            return editBtn + "&nbsp;&nbsp;&nbsp;&nbsp;" + delBtn;
                                        }
                                    }
                                ]
                            });
                            $("[type='number']").keypress(function (evt) {
                                evt.preventDefault();
                            });
                        });
                        function addHotelRoomType(){
                            $("#roomTypeDetailEdit input:not(#submitBtn)").val("");
                            $("#roomTypeDetailEdit textarea").html("");
                            $("#roomTypeDetailEdit")[0].reset();
                            popOptions(roomTypeList,"#hotel_room_type");
                            popOptions(hotelList,"#hotel_id");
                            popRoomAmenities();
                            roomTypeDetails.modal("show");
                        }
                        function editHotelRoomType(hotel_room_master_id){
                            $.ajax({
                                type: "POST",
                                url: "<?= site_url('hotel_rooms/ajaxHotelRoomDetails') ?>",
                                data: {hotel_room_master_id: hotel_room_master_id},
                                success: function (result) {
                                    var data = $.parseJSON(result);
                                    popOptions(roomTypeList,"#hotel_room_type",data['hotel_room_type']);
                                    popOptions(hotelList,"#hotel_id",data['hotel_id']);
                                    $("input[name*='hotel_room_master_id']").val(data['hotel_room_master_id']);
                                    $("input[name*='hotel_room_rent']").val(data['hotel_room_rent']);
                                    $("input[name*='comp_reg_no']").val(data['comp_reg_no']);
                                    $("#hotel_room_desc").html(data['hotel_room_desc']);
                                    popRoomAmenities(data['hotel_room_amenities']);
                                    roomTypeDetails.modal("show");
                                }
                            });
                        }
                        function refreshTable() {
                            $.getJSON(dataTableRoomType, null, function (json) {
                                table = $('#roomType_list').dataTable();
                                oSettings = table.fnSettings();
                                table.fnClearTable(this);
                                for (var i = 0; i < json['data'].length; i++) {
                                    table.oApi._fnAddData(oSettings, json['data'][i]);
                                }
                                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                                table.fnDraw();
                            });
                        }
                        function deleteHotelRoomType(hotel_room_master_id) {
                            var r = confirm("Do you really want to delete this record?");
                            if (r == true) {
                                $.ajax({
                                    type: "POST",
                                    url: "<?= site_url('hotel_rooms/ajaxHotelRoomMasterDelete') ?>",
                                    data: {hotel_room_master_id: hotel_room_master_id},
                                    success: function (result) {
                                        roomTypeDetails.modal("hide");
                                        refreshTable();
                                    }
                                });
                            } else {
                                roomTypeDetails.modal("hide");
                            }
                        }
                        $("#submitBtn").on("click", function () {
                         $(".errorlabel").html("");
                         var errorNo = 0;
                         if($("#hotel_room_type").val().length == 0){
                                $("#errRoomType").html("Required");
                                errorNo++;
                         }else{
                             $.ajax({
                                    type: "POST",
                                    async: false,
                                    url: "<?= site_url('hotel_rooms/ajaxUniqueHotelRoomAttr')?>",
                                    data: {
                                        primaryVal: $("#hotel_room_master_id").val(),
                                        attr: "hotel_room_type",
                                        attrVal: $("#hotel_room_type").val()
                                    },
                                    success: function (result) {
                                        if (result > 0) {
                                            $("#errRoomType").html("Room type must be unique.");
                                            errorNo++;
                                        }
                                    }
                                });
                         }
                         if($("#hotel_room_rent").val().length == 0){
                                $("#errRoomRent").html("Required");
                                errorNo++;
                         }else{
                             if(!$.isNumeric($("#hotel_room_rent").val())){
                                 $("#errRoomRent").html("Value contains text.");
                                errorNo++;
                             }
                         } 
                         if(errorNo == 0){
                            $("#roomTypeDetailEdit").submit();
                         }
                        });
                        $("#roomTypeDetailEdit").submit(function (e) {
                                $.ajax({
                                    type: "POST",
                                    url: "<?= site_url('hotel_rooms/ajaxHotelRoomMasterSubmit') ?>",
                                    data: $("#roomTypeDetailEdit").serialize(),
                                    success: function (result) {
                                        $("#roomTypeDetailEdit")[0].reset();
                                        roomTypeDetails.modal("hide");
                                        refreshTable();
                                    }
                                });
                            e.preventDefault();
                        });
                         function popOptions(options, dom_id, sel_id = "") {
                            var optionsList = $.parseJSON(options);
                            var arrCount = 0;
                            $.each(optionsList, function (key, row) { arrCount++;});
                            var option = arrCount > 2 ? "<option value=\"\">Choose...</option>" : "";
                            $.each(optionsList, function (key, row) {
                                var select = sel_id == key ? "selected='selected'" : "";
                                option = option + "<option " + select + " value=\"" + key + "\">" + row + "</option>";
                            });
                            $(dom_id).html(option);
                        }
                        function popRoomAmenities(hotel_room_amenities = ""){
                            $("#roomAmenities").html("");
                            var amenitiesList = $.parseJSON(amenityOptions);
                            var amenitiyArr = hotel_room_amenities.split(",");
                            $.each(amenitiesList,function(id,name){
                                var check = jQuery.inArray(id, amenitiyArr) !== -1 ? "checked='checked'":"";
                                $("#roomAmenities").append("<span><input "+check+" type=\"checkbox\" name=\"amenity["+id+"]\" value=\"1\" >&nbsp;&nbsp;"+name+"</span><br/>");
                            });
                        }
        </script>
    </body>
</html>