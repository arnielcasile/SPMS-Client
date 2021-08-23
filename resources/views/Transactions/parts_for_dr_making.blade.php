
<div class="modal fade" id="mod_parts_for_dr"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_parts_for_dr_label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <img src="{{ asset('icons/paper cartoon.png') }}" style="height:5%; width:5%;" class="rounded">
                    <h5 class="modal-title" id="mod_parts_for_dr_label">&nbsp;Parts for DR Making</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="PARTS_FOR_DR_MAKING.cancel_transaction()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label >Approved By</label>
                                <select class="custom-select" id="slc_transac_approved_by" required></select>
                                <div class="invalid-tooltip">
                                    Please select a valid name.
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                    <label >Attention To</label>
                                    <input type="text" class="form-control" id="txt_dr_attention_to">
                            </div> --}}
        
                        </div>
                        <br><hr>
                       
                        <div class="row">
                            <div class="col-md-12 text-center">
                            <h5>List of Parts</h5>
                            <small class="text-info">Please use the checkbox to indicate the desired print values</small>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body border border-dark p-3">
                                    <table id="tbl_parts_for_dr" class="table table-bordered table-striped table-hover " style="width: 100%;">
                                            <thead class="thead-dark">
                                                <tr> 
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;"><input type="checkbox" style="zoom:2" id='chk_parent' name='chk_parent' onclick="PARTS_FOR_DR_MAKING.table_select_all()"></th>	
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Control No</th>														
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Ticket No</th>
                                                    <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Destination</th>
                                                </tr>                      
                                            </thead>
                                        <tbody id="tbody_tbl_parts_for_dr" align="center">
                                        </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="PARTS_FOR_DR_MAKING.print_selected()"><i class="fa fa-print"></i>&nbsp; Print selected DR</button>
                    <button type="button" class="btn btn-secondary" onclick="PARTS_FOR_DR_MAKING.cancel_transaction()" data-dismiss="modal"><i class="fa fa-times" id="btn_close_dr"></i>&nbsp;Close</button>
                </div>
                </div>
  </div>
</div>

