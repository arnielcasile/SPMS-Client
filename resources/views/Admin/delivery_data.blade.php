@extends('template')

@section('content-page')

<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-body__content">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            {{-- delivery data --}}
            <div class="card  shadow mb-4">
                <div class="card-header" style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark"  data-toggle="collapse" href="#div_deliv_data">
                        <img src="{{ asset('icons/deliv_receipt.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Delivery Data</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_deliv_data" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Range:</label>
                                    <select class="custom-select" id="slc_delivery_data_range" onchange="DELIVERY_DATA.onchange_datepicker();">
                                        <option value="" selected hidden> SELECT RANGE</option>
                                        <option value="DAILY"> DAILY</option>
                                        <option value="MONTHLY"> MONTHLY</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Date From:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                            id="txt_delivery_data_month_date_from" placeholder="Select date from" readonly hidden>
                                    <input style="background-color:white;" type="text"
                                        class="form-control datepicker_day"
                                        id="txt_delivery_data_date_from" placeholder="Select date from" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Date To:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                            id="txt_delivery_data_month_date_to" placeholder="Select date to" readonly hidden>
                                    <input style="background-color:white;" type="text"
                                        class="form-control datepicker_day" id="txt_delivery_data_date_to"
                                        placeholder="Select date to" readonly>
                                </div>
                                <div class="col-md-3">
                                    <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                                        onclick="DELIVERY_DATA.load_delivery_data_list()"><i class="flaticon-search"></i> SEARCH</button>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="thead_delivery_data" class="table table-bordered table-hover" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR Control</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Ticket Count</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Pallet Count</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">P-Case Count</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Box Count</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Bag Count</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Date</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Status</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Destination</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_delivery_data"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- inhouse delivery data --}}
            <div class="card  shadow mb-4">
                <div class="card-header" style="padding: 0px; 0px; 0px; 0px; ">
                    <button class="accordion bg-light text-dark"  data-toggle="collapse" href="#div_inhouse_deliv_data">
                        <img src="{{ asset('icons/deliv_receipt.png') }}" style="height:2%; width:2%;" class="rounded">
                        &nbsp;&nbsp;<b><label>Inhouse Delivery Data</label></b>&nbsp;<i><small class="text-muted"></small></i>
                    </button> 
                </div>
                <div id="div_inhouse_deliv_data" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Range:</label>
                                    <select class="custom-select" id="slc_inhouse_delivery_data_range" onchange="DELIVERY_DATA.onchange_datepicker();">
                                        <option value="" selected hidden> SELECT RANGE</option>
                                        <option value="DAILY"> DAILY</option>
                                        <option value="MONTHLY"> MONTHLY</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Date From:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                            id="txt_inhouse_delivery_data_month_date_from" placeholder="Select date from" readonly hidden>
                                    <input style="background-color:white;" type="text"
                                        class="form-control datepicker_day"
                                        id="txt_inhouse_delivery_data_date_from" placeholder="Select date from" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>Date To:</label>
                                    <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                            id="txt_inhouse_delivery_data_month_date_to" placeholder="Select date to" readonly hidden>
                                    <input style="background-color:white;" type="text" class="form-control datepicker_day" id="txt_inhouse_delivery_data_date_to"
                                        placeholder="Select date to" readonly>
                                </div>
                                <div class="col-md-3">
                                    <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                                        onclick="DELIVERY_DATA.load_inhouse_delivery_data_list();"><i class="flaticon-search"></i> SEARCH</button>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="thead_inhouse_delivery_data" class="table table-bordered table-hover" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Item No.</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Issued Date</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Receipt</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Product No.</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Qty.</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Manufacturing</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Breakdown</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery Date</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Received By</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Received Date</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_inhouse_delivery_data"></tbody>
                                        {{-- <tr>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">1.</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-19</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">12345</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">67890</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">Manufacturing</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">85</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-22</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">Park Seo Joon</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-22</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">There is nothing wrong</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">1.</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-19</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">12345</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">67890</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">Manufacturing</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">85</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-22</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">Park Yong Gyu</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-22</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">What is wrong with this</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">1.</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-19</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">12345</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">67890</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">Manufacturing</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">85</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-22</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">Lee Young Joon</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-22</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">It's okay</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">1.</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-19</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">12345</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">67890</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">Manufacturing</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">85</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-22</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">Lee Seong Hyun</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">2020-06-22</td>
                                            <td style="text-align:center;horizontal-align:middle;vertical-align:middle;">This is it</td>
                                        </tr> --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end of inhouse  --}}
        </div>
    </div>
</div>
@endsection

@section('custom-script')
<script src="{{asset('scripts/Admin/delivery_data.js')}}"></script>
@endsection