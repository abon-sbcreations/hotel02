<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="<?= site_url("library/images/hotel-flat-icon-vector.jpg") ?>">
        <title>Discounts</title>
        <link href="<?= site_url("library/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= site_url("library/css/datatables.min.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= site_url("library/css/bootstrap-datepicker3.standalone.min.css") ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= site_url("assets/css/custom02.css") ?>" rel="stylesheet">
        <style>
            #modalDialog{
                width:50%;
            }
        </style>
    </head>
    <body>
        <?= $head02Temp ?>
        <div class="container-fluid">
            <div class="row">
                <?= $leftmenu02Temp ?>
                <div class="col-md-10 col-lg-offset-2">
                    <div class="h3"><span>Discounts List</span><span class="addbttn"><button onclick="addDiscounts()" class="btn btn-info">Add Discount</button></span></div>
                    <table id="discount_list" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Type</th>
                                <th>Date From</th>
                                <th>Date To</th>
                                <th>Discount Type</th>
                                <th>Price</th>                                
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="discountDetails" class="modal fade" role="dialog">
            <div id="modalDialog" class="modal-dialog  modal-lg">
                <!-- Modal content-->
                <div class="modal-content ">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Discount Details</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" name="discountDetailEdit" id="discountDetailEdit" >
                            <div class="row">
                                <div class="form-group col-md-6 mb-6">
                                    <label for="discount_sub">Module</label>
                                    <input type="hidden" name="discount_id" id="discount_id" value="0" class="form-control">
                                    <select class="custom-select d-block w-100 form-control" name="discount_sub" id="discount_sub"></select>
                                    <div id='discount_subError' class="errorlabel"></div>
                                    
                                    <label for="discount_sub_id">Type</label>
                                    <select class="custom-select d-block w-100 form-control" name="discount_sub_id" id="discount_sub_id"></select>
                                    <div id='discount_sub_idError' class="errorlabel"></div>
                                    
                                    <label for="discount_type">Discount Type</label>
                                    <select class="custom-select d-block w-100 form-control" name="discount_type" id="discount_type"></select>
                                    <div id='discount_typeError' class="errorlabel"></div>
                                    
                                </div>
                                <div class="form-group col-md-6 mb-6">
                                   <label for="discount_from">Discount From</label>
                                    <input type="text" name="discount_from" id="discount_from" class="form-control" readonly="readonly">   
                                    <div id='discount_fromError' class="errorlabel"></div>
                                    
                                    <label for="discount_to">Discount To</label>
                                    <input type="text" name="discount_to" id="discount_to" class="form-control" readonly="readonly">   
                                    <div id='discount_toError' class="errorlabel"></div>
                                    
                                    <label for="discount_price">Discount Price</label>
                                    <input type="text" name="discount_price" id="discount_price" class="form-control">   
                                    <div id='discount_priceError' class="errorlabel"></div>
                                </div><!--checked="checked"-->
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
        <script src="<?= site_url("library/js/bootstrap-datepicker.min.js") ?>" type="text/javascript"></script>
        <script type="text/javascript">
                        var dataTableDiscounts = "<?= site_url("discounts/ajaxAllDiscountsDataTable") ?>";
                        var discountDetails = $("#discountDetails");
                        var modulesList;
                        var discount_type;
                        $(document).ready(function () {
                            modulesList = "<?= addslashes(json_encode($moduleList)) ?>";
                            discount_type = "<?= addslashes(json_encode($discount_type)) ?>";
                            window.history.forward(-1);
                            var table1 = $('#discount_list').DataTable({
                                "ajax": {
                                    url: dataTableDiscounts,
                                    type: 'GET'
                                },
                                "aoColumns": [
                                    {mData: 'module_name'},                                    {mData: 'sub_display'},
                                    {mData: 'discount_from'},                                    {mData: 'discount_to'},
                                    {mData: 'discount_type'},                                    {mData: 'discount_price'},
                                    {mData: "discount_id", bSortable: false, sWidth: "80px",
                                        mRender: function (data, type, full) {
                                            var editBtn = "<button class=\"btn btn-info btn-xs\" onclick=\"editDiscount(" + data + ")\">Edit</button>";
                                            var delBtn = "<button class=\"btn btn-danger btn-xs\" onclick=\"deleteDiscount(" + data + ")\">Delete</button>";
                                            return editBtn + "&nbsp;&nbsp;&nbsp;&nbsp;" + delBtn;
                                        }
                                    }
                                ]

                            });
                        });                        
                        function popOptions(options, dom_id, sel_id = "") {
                            var optionsList = $.parseJSON(options);
                            var arrCount = 0;
                            $.each(optionsList, function (key, row) {
                                arrCount++;
                            });
                            var option = arrCount > 2 ? "<option value=\"\">Choose...</option>" : "";
                            $.each(optionsList, function (key, row) {
                                var select = sel_id == key ? "selected='selected'" : "";
                                option = option + "<option " + select + " value=\"" + key + "\">" + row + "</option>";
                            });
                            $(dom_id).html(option);
                        }
                        function addDiscounts() {
                            $(".errorlabel").html("");
                            $("#discountDetails input:not(#submitBtn)").val("");                            
                            popOptions(discount_type,"#discount_type");
                            popModule();
                            popSubModule($("#discount_sub").val());
                            discountDetails.modal("show");
                        }

                        function editDiscount(discount_id) {
                            $.ajax({
                                type: "POST",
                                url: "<?= site_url('discounts/ajaxDiscountDetails') ?>",
                                data: {discount_id: discount_id},
                                success: function (result) {
                                    var data = $.parseJSON(result);
                                    popOptions(discount_type,"#discount_type",data['discount_type']);
                                     popModule(data['discount_sub']);
                                     popSubModule(data['discount_sub'],data['discount_sub_id']);
                                     $("#discount_from").val(data['discount_from']);
                                     $("#discount_to").val(data['discount_to']);
                                     $("#discount_price").val(data['discount_price']);
                                     $("#discount_id").val(data['discount_id']);                                     
                                    discountDetails.modal("show");
                                }
                            });
                        }
                        function refreshTable() {
                            $.getJSON(dataTableDiscounts, null, function (json) {
                                table = $('#discount_list').dataTable();
                                oSettings = table.fnSettings();
                                table.fnClearTable(this);
                                for (var i = 0; i < json['data'].length; i++) {
                                    table.oApi._fnAddData(oSettings, json['data'][i]);
                                }
                                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                                table.fnDraw();
                            });
                        }
                        function deleteDiscount(discount_id) {
                            var r = confirm("Do you really want to delete this record?");
                            if (r == true) {
                                $.ajax({
                                    type: "POST",
                                    url: "<?= site_url('discounts/ajaxDiscountDelete') ?>",
                                    data: {discount_id: discount_id},
                                    success: function (result) {
                                        discountDetails.modal("hide");
                                        refreshTable();
                                    }
                                });
                            } else {
                                discountDetails.modal("hide");
                            }
                        }
                        $("#submitBtn").on("click", function () { 
                            var errorNo = 0;
                            $(".errorlabel").html("");
                             if ($("#discount_sub").val().length < 1) {
                                errorNo++;
                                $("#discount_subError").html("Required");
                            }
                            if ($("#discount_sub_id").val().length < 1) {
                                errorNo++;
                                $("#discount_sub_idError").html("Required");
                            }                            
                            if ($("#discount_sub").val().length < 1) {
                                errorNo++;
                                $("#discount_subError").html("Required");
                            }
                            if ($("#discount_from").val().length < 1) {
                                errorNo++;
                                $("#discount_fromError").html("Required");
                            }
                            if ($("#discount_from").val().length < 1) {
                                errorNo++;
                                $("#discount_fromError").html("Required");
                            }
                            if ($("#discount_to").val().length < 1) {
                                errorNo++;
                                $("#discount_toError").html("Required");
                            }
                            if ($("#discount_price").val().length < 1) {
                                errorNo++;
                                $("#discount_priceError").html("Required");
                            }else if($("#discount_price").val() < 1){
                                errorNo++;
                                $("#discount_priceError").html("Can Not Be Zero");
                            }
                            if (errorNo == 0) {
                                $("#discountDetailEdit").submit();
                            }
                        });
                        $("#discountDetailEdit").submit(function (e) {
                            $.ajax({
                                type: "POST",
                                url: "<?= site_url('discounts/ajaxDiscountsMasterSubmit') ?>",
                                data: $("#discountDetailEdit").serialize(),
                                success: function (result) {
                                    $("#discountDetailEdit")[0].reset();
                                    discountDetails.modal("hide");
                                    refreshTable();
                                }
                            });
                            e.preventDefault();
                        });
                        $("#discount_to").datepicker({
                            format: "dd-mm-yyyy",
                            weekStart: 1,
                            daysOfWeekHighlighted: "0,6",
                            autoclose: true
                        });
                        $("#discount_from").datepicker({
                            format: "dd-mm-yyyy",
                            weekStart: 1,
                            daysOfWeekHighlighted: "0,6",
                            autoclose: true
                        });
                        function popModule(id = "") {
                            var modulesListArr = $.parseJSON(modulesList);
                            var option = "<option value=\"\">Choose...</option>";
                            $.each(modulesListArr['moduleList'], function (key, row) {
                              var select = id == key ? "selected='selected'" : "";
                              option = option + "<option " + select + " value=\"" + key + "\">" + row + "</option>";
                            });
                            $("#discount_sub").html(option);
                        }
                        function popSubModule(id = "", opt = "") {
                            var modulesListArr = $.parseJSON(modulesList);                           
                            var option = "";
                            if (id !== "") {
                                $.each(modulesListArr['subModuleList'][id], function (key, row) {
                                    var select = opt == key ? "selected='selected'" : "";
                                    option = option + "<option " + select + " value=\"" + key + "\">" + row + "</option>";
                                });
                            }else{
                                option = "<option value=\"\">Choose...</option>";
                            }
                            $("#discount_sub_id").html(option);
                        }                 
                        $("#discount_sub").on("change", function () {
                            var valueSelected = this.value;
                            popSubModule(valueSelected);
                        });
                        $("#discount_type").on("change", function () {
                            $("#discount_price").val("0.00 ");
                        });
        </script>

    </body>

</html>