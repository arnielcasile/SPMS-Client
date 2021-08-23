@extends('template')

@section('content-page')
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <div class="m-subheader ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="header-title">Palletizing</h4>
                            <small><label class="text-muted">Please double check your data before updating/
                                    saving.</label></small>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-primary" onclick="$('#mod_parts_status').modal('show');"><i class="m-menu__link-icon flaticon-clipboard"></i>&nbsp;&nbsp;
                                Parts Status</button>
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <div class="card  shadow mb-4">
                    <div class="card-header " style="padding: 0px; 0px; 0px; 0px; ">
                        <button class="accordion bg-light text-dark" data-toggle="collapse" href="#div_for_palletizing">
                            <img src="{{ asset('icons/pallet.png') }}" style="height:2%; width:2%;" class="rounded">
                            &nbsp;&nbsp;<b><label>For Palletizing</label></b>&nbsp;<i><small class="text-muted"></small></i>
                        </button>
                    </div>
                    <div id="div_for_palletizing" class="collapse show" data-parent="#accordion">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="container">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Delivery Type</label>
                                                <select class="form-control-lg custom-select"
                                                    onchange="PALLETIZING.allow_input()" id="slc_delivery_type" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Barcode:</label>
                                                <input type="text" class="form-control form-control-lg" autocomplete="off"
                                                    onkeypress="PALLETIZING.barcode()"
                                                    oninput="this.value = this.value.toUpperCase()" disabled
                                                    id="txt_barcode">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label>Delivery Number</label>
                                                <input type="text" class="form-control form-control-lg"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                    onkeyup="PALLETIZING.allow_input()" id="txt_delivery_number">
                                            </div>
                                            <div class="col-md-6">
                                                <label>OrderDownload No.</label>
                                                <input type="text" class="form-control form-control-lg" disabled
                                                    id="txt_ord_no">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label>Destination Code</label>
                                                <input type="text" readonly class="form-control form-control-lg" disabled
                                                    id="txt_destination_code">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Total Item</label>
                                                <input type="text" readonly class="form-control form-control-lg" disabled
                                                    id="txt_total_item">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label>Manufacturing</label>
                                                <input type="text" readonly class="form-control form-control-lg" disabled
                                                    id="txt_manufacturing">
                                                <input type="hidden" disabled id="txt_pdl">
                                                <!-- <input type="text" id="txt_order_download_no"> -->
                                            </div>
                                            <div class="col-md-6">
                                                <label>Area Code</label>
                                                <input type="text" readonly class="form-control form-control-lg" disabled
                                                    id="txt_area_code_hidden">
                                            </div>
                                            <div class="col-md-6">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <div class="col-md-12 text-left">
                                            <h5>
                                                <img src="{{ asset('icons/normal.png') }}" style="height:3%; width:3%;"
                                                    class="rounded">
                                                &nbsp;&nbsp;
                                                <b>NORMAL&nbsp;&nbsp;
                                                    <span>
                                                        <small>
                                                            <i style="color:green">(</i>
                                                        </small>
                                                    </span>
                                                    <i id="nrm_qty" style="color:green">0</i>
                                                    <span>
                                                        <small>
                                                            <i style="color:green">total item/ s )</i>
                                                        </small>
                                                    </span>
                                                </b>
                                            </h5>
                                        </div>
                                        <div class="panel-body border border-dark" style="padding:10px;">
                                            <table id="tbl_normal_palletizing"
                                                class="table table-bordered table-striped table-hover "
                                                style="width: 100%;">
                                                <thead id="thead_tbl_normal_palletizing" class="thead-dark">
                                                    <tr>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Barcode</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Delivery Type</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Delivery Number</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Part Number</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Quantity</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Order Download Number</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_tbl_normal_palletizing" style="text-align: center"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <div class="col-md-12 text-left">
                                            <h5>
                                                <img src="{{ asset('icons/irreg.png') }}" style="height:3%; width:3%;"
                                                    class="rounded">
                                                &nbsp;&nbsp;
                                                <b>IRREGULARITY&nbsp;&nbsp;
                                                    <span>
                                                        <small>
                                                            <i style="color:green">(</i>
                                                        </small>
                                                    </span>
                                                    <i id="irr_qty" style="color:green">0</i>
                                                    <span>
                                                        <small>
                                                            <i style="color:green">total item/ s )</i>
                                                        </small>
                                                    </span>
                                                </b>
                                            </h5>
                                        </div>
                                        <div class="panel-body border border-dark" style="padding:10px">
                                            <table id="tbl_irreg_palletizing"
                                                class="table table-bordered table-striped table-hover" width=100%;>
                                                <thead id="thead_tbl_irreg_palletizing" class="thead-dark">
                                                    <tr>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Ticket No.</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Delivery Type</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Delivery Number</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Part Number</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Quantity</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Order Download Number</th>
                                                        <th
                                                            style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_tbl_irreg_palletizing" style="text-align: center"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="container-fluid mb-2">
                                <div class="row">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-primary"
                                            onclick="PALLETIZING.data_for_saving();" id="btn_for_palletizing_update">
                                            <i class="fa fa-save"></i>&nbsp; SAVE</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-danger"
                                            onclick="PALLETIZING.clear_tables()"><i class="fa fa-trash"></i>&nbsp;
                                            CLEAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card  shadow mb-4">
                    <div class="card-header " style="padding: 0px; 0px; 0px; 0px; ">
                        <button class="accordion bg-light text-dark" data-toggle="collapse" id='btn_toggle'
                            href="#div_ongoing_palletizing" onclick="PALLETIZING.adjust_ongoing_tab()">
                            <img src="{{ asset('icons/ongoing_palletizing.png') }}" style="height:2%; width:2%;"
                                class="rounded">
                            &nbsp;&nbsp;<b><label>Ongoing Palletizing</label></b>&nbsp;<i><small
                                    class="text-muted"></small></i>
                        </button>
                    </div>
                    <div id="div_ongoing_palletizing" class="collapse show" data-parent=".accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12 text-left">
                                        <h5><img src="{{ asset('icons/masterlist.png') }}" style="height:3%; width:3%;"
                                                class="rounded">&nbsp;&nbsp;<b>MASTERLIST</b></h5>
                                    </div>
                                    <div class="panel-body border border-dark">
                                        <table id="tbl_palletizing_masterlist" class="table table-bordered"
                                            style="width: 100%;">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th
                                                        style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                        Order Download No.</th>
                                                    <th
                                                        style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                        DR Control</th>
                                                    <th
                                                        style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                        Delivery Type</th>
                                                    <th
                                                        style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                        Delivery Number</th>
                                                    <th
                                                        style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                        Delivery Code</th>
                                                    <th
                                                        style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                        Manufacturing No.</th>
                                                    <th
                                                        style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                        Total Items</th>
                                                    <th
                                                        style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_tbl_palletizing_masterlist" style="border: 1px solid black">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card  shadow mb-4" id="div_edit_masterlist" style="display:none">
                    <div class="card-header " style="padding: 0px; 0px; 0px; 0px; ">
                        <button class="accordion bg-light text-dark" data-toggle="collapse">
                            <img src="{{ asset('icons/edit.png') }}" style="height:2%; width:2%;" class="rounded">
                            &nbsp;&nbsp;<b><label>Edit Masterlist</label></b>&nbsp;<i><small class="text-muted"></small></i>
                        </button>
                    </div>
                    <div id="div_edit_palletizing" data-parent="#accordion" hidden>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12 text-left">
                                        <h5><img src="{{ asset('icons/add.png') }}" style="height:2%; width:2%;"
                                                class="rounded">&nbsp;&nbsp;<b>Add New</b></h5>
                                        <hr>
                                    </div>
                                    <div class="container mb-5">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Delivery Type</label>
                                                    <select class="form-control-lg custom-select"
                                                        onchange="PALLETIZING.allow_edit_input()"
                                                        id="slc_edit_delivery_type" required>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Barcode:</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        onkeypress="PALLETIZING.barcode_edit()"
                                                        oninput="this.value = this.value.toUpperCase()" disabled
                                                        id="txt_edit_barcode">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label>Delivery Number</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        onkeyup="PALLETIZING.allow_edit_input()"
                                                        id="txt_edit_delivery_number">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Order Download No.</label>
                                                    <input type="text" class="form-control form-control-lg" disabled
                                                        id="txt_edit_ord_no">
                                                    <!-- <input type="text" class="form-control form-control-lg" disabled id="txt_edit_dest_code"> -->
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label>Destination Code</label>
                                                    <input type="text" readonly class="form-control form-control-lg"
                                                        disabled id="txt_edit_destination_code">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Total Item</label>
                                                    <input type="text" readonly class="form-control form-control-lg"
                                                        disabled id="txt_edit_total_item">
                                                    <input type="hidden" id="txt_edit_dr_control">

                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label>Manufacturing</label>
                                                    <input type="text" readonly class="form-control form-control-lg"
                                                        disabled id="txt_edit_manufacturing">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>DR_Control</label>
                                                    <input type="text" readonly class="form-control form-control-lg"
                                                        disabled id="txt_edit_dr_control_display">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12 text-left">
                                        <h5><img src="{{ asset('icons/check-list.png') }}" style="height:2%; width:2%;"
                                                class="rounded">&nbsp;&nbsp;<b>EDITING LIST</b></h5>
                                    </div>
                                    <div class="panel-body border border-dark" style="padding:10px;">
                                        <table id="tbl_edit_palletizing_masterlist" class="table table-bordered"
                                            style="width: 100%;">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th>Ticket No.</th>
                                                    <th>Delivery Type</th>
                                                    <th>Delivery Number</th>
                                                    <th>Part Number</th>
                                                    <th>Quantity</th>
                                                    <th>Order Download Number</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_tbl_edit_palletizing_masterlist"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="container-fluid mb-2">
                                <div class="row">
                                    <div class="col-md-10"></div>
                                    <div class="col-md-2">
                                        <input type="hidden" id="txt_counter">
                                        <button type="button" class="btn btn-block btn-danger"
                                            onclick="PALLETIZING.cancel_edit_palletizing();"><i
                                                class="fa fa-close"></i>&nbsp; CANCEL</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Start of Modal --}}
    <div class="modal fade" id="mod_palletizing" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="mod_palletizing_label" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('icons/barcode.png') }}" style="height:10%; width:10%;" class="rounded">&nbsp;&nbsp;
                    <center>
                        <h5 class="modal-title" id="mod_palletizing_label">&nbsp;This Barcode has irregularity. What will
                            you transact?</h5>
                    </center>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        id="btn_close_modal_completion" onclick="PALLETIZING.cancel_transaction_modal();">
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-info" style="height: 50px;" id="btn_normal"
                                    onclick="PALLETIZING.onclick_normal();">
                                    <img src="{{ asset('icons/normal.png') }}" style="height:70%; width:15%;"
                                        class="rounded">&nbsp;&nbsp;<b>NORMAL</b></button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success" style="height: 50px;" id="btn_completion"
                                    onclick="PALLETIZING.onclick_completion();">
                                    <img src="{{ asset('icons/irreg.png') }}" style="height:70%; width:15%;"
                                        class="rounded">&nbsp;&nbsp;<b>COMPLETION</b></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    {{-- End of Modal --}}

    {{-- Start of Modal --}}
    <div class="modal fade" id="mod_finish_palletizing" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="mod_finish_palletizing_label" aria-hidden="true">
        <div class="modal-dialog moda  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('icons/racing-flag.png') }}" style="height:5%; width:5%;" class="rounded">
                    <h5 class="modal-title" id="mod_finish_palletizing_label">&nbsp;Finish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="PALLETIZING.finish_palletizing_clear_inputs();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-7">
                                    <label>DR Control No.</label>
                                    <input type="text" id="txt_dr_no" class="form-control form-control-lg" readonly>
                                </div>
                            </div>
                            <!-- <div class="row">
                                                                <div class="col-md-7">
                                                                    <label >Process</label>
                                                                    <input type="text" id="txt_process" class="form-control form-control-lg text-center" readonly>
                                                                </div>
                                                            </div> -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Pallet:</label>
                                    <input type="text" class="form-control form-control-lg" value="0"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        id="txt_pallet" maxlength="3" onkeypress="return onlyNumberKey(event)">
                                </div>
                                <div class="col-md-6">
                                    <label>P-Case:</label>
                                    <input type="text" class="form-control form-control-lg" value="0"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        id="txt_pcase" maxlength="3" onkeypress="return onlyNumberKey(event)">
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Box:</label>
                                    <input type="text" class="form-control form-control-lg" value="0"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        id="txt_box" maxlength="3" onkeypress="return onlyNumberKey(event)">
                                </div>
                                <div class="col-md-6">
                                    <label>Bag:</label>
                                    <input type="text" class="form-control form-control-lg" value="0"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        id="txt_bag" maxlength="3" onkeypress="return onlyNumberKey(event)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-block btn-primary"
                                    onclick="PALLETIZING.finish_palletizing();"><i class="fa fa-save"></i>&nbsp;
                                    UPDATE</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-block btn-danger"
                                    onclick="PALLETIZING.finish_palletizing_clear_inputs();" data-dismiss="modal"><i
                                        class="fa fa-close"></i>&nbsp; CANCEL</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- End of Modal --}}


    <div class="modal fade" id="mod_parts_status" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="mod_parts_status_label" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <img src="{{ asset('icons/racing-flag.png') }}" style="height:5%; width:5%;" class="rounded"> --}}
                    <h5 class="modal-title" id="mod_finish_palletizing_label">&nbsp;Parts Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Range:</label>
                                    <select class="custom-select" id="slc_parts_status_range"
                                        onchange="PARTS_STATUS.onchange_datepicker();">
                                        <option value="" selected hidden> SELECT RANGE</option>
                                        <option value="DAILY"> DAILY</option>
                                        <option value="MONTHLY"> MONTHLY</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Date From:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                        id="txt_parts_status_month_date_from" placeholder="Select date from" readonly
                                        hidden>
                                    <input style="background-color:white;" type="text" class="form-control datepicker_day"
                                        id="txt_parts_status_date_from" placeholder="Select date from" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Date To:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                        id="txt_parts_status_month_date_to" placeholder="Select date to" readonly hidden>
                                    <input style="background-color:white;" type="text" class="form-control datepicker_day"
                                        id="txt_parts_status_date_to" placeholder="Select date to" readonly>
                                </div>
                                <div class="col-md-3">
                                    <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                                        onclick="PARTS_STATUS.load_parts_status_list()"><i class="flaticon-search"></i>
                                        SEARCH</button>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="thead_parts_status" class="table table-bordered table-hover">
                                        <thead class="thead-dark" align="center">
                                            <tr>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    WH_CLASS</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Item No.</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Delivery Quantity</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Stock Address</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Manufacturing No.</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Destination Code</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Payee Name</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Delivery Due Date</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Ticket No.</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Order Download No.</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Ticket Issue</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Status (Normal)</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    DR Control (Normal)</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Delivery (Normal)</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Status (Irreg)</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    DR Control (Irreg)</th>
                                                <th
                                                    style="text-align:center;horizontal-align:middle;vertical-align:middle;">
                                                    Delivery (Irreg)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_parts_status" align="center"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('custom-script')
    <script src="{{ asset('scripts/Admin/parts_status.js') }}"></script>
    <script src="{{ asset('scripts/Transactions/palletizing.js') }}"></script>
@endsection
