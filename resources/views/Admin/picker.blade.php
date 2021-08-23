@extends('template')

@section('content-page')
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <h4 class="header-title">Picker Menu</h4><br>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <label>Range:</label>
                        <select class="custom-select" id="slc_picker_range" onchange="PICKER.onchange_datepicker();">
                            <option value="" selected hidden> SELECT RANGE</option>
                            <option value="DAILY"> DAILY</option>
                            <option value="MONTHLY"> MONTHLY</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Date From:</label>
                        <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_picker_month_date_from" placeholder="Select date from" readonly hidden>
                        <input style="background-color:white;" type="text" class="form-control datepicker_day"
                            id="txt_picker_date_from" placeholder="Select date from" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Date To:</label>
                        <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                id="txt_picker_month_date_to" placeholder="Select date to" readonly hidden>
                        <input style="background-color:white;" type="text" class="form-control datepicker_day" id="txt_picker_date_to"
                            placeholder="Select date to" readonly>
                    </div>
                    <div class="col-md-3">
                        <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                            onclick="PICKER.load_picker_list()"><i class="flaticon-search"></i> SEARCH</button>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="thead_picker" class="table table-bordered table-hover">
                            <thead class="thead-dark" align="center">
                                <tr>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Date</th>
                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Picker Count</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_picker" align="center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="container-fluid md-2">
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-xs btn-block" onclick="PICKER.save_picker()"><i class="fa fa-save"></i> SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script src="{{asset('scripts/Admin/picker.js')}}"></script>
@endsection