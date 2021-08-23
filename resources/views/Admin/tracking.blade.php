<div class="modal fade" id="mod_tracking"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_tracking_label" aria-hidden="true">
    <div class="modal-dialog modal-lg moda  modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <img src="{{ asset('icons/truck.png') }}" style="height:5%; width:5%;" class="rounded">
              <h5 class="modal-title" id="mod_edit_dr_label">
                &nbsp;&nbsp;<b>Tracking History</b>&nbsp;</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="container-fluid">
            
                <br>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 text-left">
                        <h3 id="h_track_head">Tracked Data</h3>
                        <small id="sm_track_sub"></small>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                            <div class="col-md-12">
                                <div class="panel-body border">
                                    <table id="tbl_tracking" class="table table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <tr> 	
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Warehouse Class</th>														
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Date</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Process</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR Control</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Checking</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Palletizing</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">DR Making</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">Delivery</th>
                                                <th style="text-align:center;horizontal-align:middle;vertical-align:middle;">PIC</th>
                                            </tr>                      
                                        </thead>
                                    <tbody id="tbody_tracking" style="text-align: center">
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
