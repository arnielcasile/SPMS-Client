<div class="modal fade" id="mod_timeout" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_timeout_label" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
            <!-- <img src="{{ asset('icons/marker.png') }}" style="height:5%; width:5%;" class="rounded"> -->
                <h5 class="modal-title" id="mod_timeout_label">&nbsp;Time Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Range:</label>
                            <select class="custom-select" id="slc_timeout_range" onchange="TIMEOUT.onchange_datepicker();">
                                <option value="" selected hidden> SELECT RANGE</option>
                                <option value="DAILY"> DAILY</option>
                                <option value="MONTHLY"> MONTHLY</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date From:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                    id="txt_timeout_month_date_from" placeholder="Select date from" readonly hidden>
                            <input style="background-color:white;" type="text" class="form-control datepicker_day"
                                id="txt_timeout_date_from" placeholder="Select date from" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Date To:</label>
                            <input style="background-color:white;" class="form-control datepicker_month" type="text"
                                    id="txt_timeout_month_date_to" placeholder="Select date to" readonly hidden>
                            <input style="background-color:white;" type="text" class="form-control datepicker_day" id="txt_timeout_date_to"
                                placeholder="Select date to" readonly>
                        </div>
                        <div class="col-md-3">
                            <button style="margin-top:5%;" class="btn btn-primary btn-xs btn-block"
                                onclick="TIMEOUT.load_timeout_list();"><i class="flaticon-search"></i> SEARCH</button>
                        </div>
                    </div>
                    <br><hr><br>
                    <div class="row">
                        <div class="col-md-5">
                            <Label><i>Note: Incomplete time will reflect as blank. Make sure to input time correctly.</i></Label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="thead_timeout" class="table table-bordered table-hover " style="width: 100%;">
                                    <thead class="thead-dark" align="center">
                                        <tr>
                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Date</th>
                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Time In</th>
                                            <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Time Out</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_timeout" align="center">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-4 pull-right">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-block btn-primary" onclick="TIMEOUT.save_timeout()" id="btn_save_timeout"><i class="fa fa-save"></i>&nbsp; Save Time Logs</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-block btn-danger"  onclick="TIMEOUT.cancel_timeout();"  id="btn_cancel_timeout"><i class="fa fa-ban"></i>&nbsp; Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('custom-script')
    {{-- <script src="../node_modules/datetimepicker-master/build/jquery.datetimepicker.js"></script> --}}
    {{-- <script src="../node_modules/timepicker/js/gijgo.min.js"></script> --}}
    <script src="{{asset('scripts/Admin/leadtime_data.js')}}"></script>
    <script src="{{asset('scripts/Admin/timeout.js')}}"></script>
@endsection

{{-- @section('custom-head')
    <link  rel="stylesheet" href="../node_modules/datetimepicker-master/build/jquery.datetimepicker.css">
    <link  rel="stylesheet" href="../node_modules/timepicker/css/gijgo.min.css">
@endsection --}}