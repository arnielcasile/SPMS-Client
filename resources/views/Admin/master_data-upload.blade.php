
<div class="modal fade" id="mod_payout_upload"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mod_parts_for_dr_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                      <div class="modal-header">
                          <img src="{{ asset('icons/upload_database.png') }}" style="height:5%; width:5%;" class="rounded">
                          <h5 class="modal-title" id="mod_parts_for_dr_label">&nbsp;Upload to Database</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="container-fluid">
                              <div class="row">
                                  <div class="col-md-6">
                                      <label >Approved By</label>
                                      <select class="custom-select"  required>
                                          <option selected disabled value="">Choose...</option>
                                          <option>RUTH LHEA CAMO</option>
                                          <option>MARIELLE CASTRILLO</option>
                                      </select>
                                      <div class="invalid-tooltip">
                                          Please select a valid name.
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                          <label >Attention To</label>
                                          <input type="text" readonly class="form-control" id="txt_master_attention_to">
                                  </div>
              
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
                                      <div class="panel-body border border-dark">
                                          <table id="tbl_parts_for_dr" class="table table-bordered table-striped table-hover " style="width: 100%;">
                                                  <thead class="thead-dark">
                                                      <tr> 
                                                          <th><input type="checkbox" style="zoom:2"></th>	
                                                          <th>Control No</th>														
                                                          <th>Ticket Count</th>
                                                          <th>w/ Irreg</th>
                                                          <th>Destination</th>
                                                      </tr>                      
                                                  </thead>
                                              <tbody id="tbl_parts_for_dr_body">
                                                  <tr>
                                                      <td><input type="checkbox" style="zoom:2"></td>
                                                      <td>C2-DEL-20-673</td>
                                                      <td>2</td>
                                                      <td>0</td>
                                                      <td>ASSY 1 (BRU)</td>
                                                  </tr>
                                                  <tr>
                                                      <td><input type="checkbox" style="zoom:2"></td>
                                                      <td>C2-DEL-20-673</td>
                                                      <td>2</td>
                                                      <td>0</td>
                                                      <td>ASSY 1 (BRU)</td>
                                                  </tr>
                                              </tbody>
                                              </table>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Close</button>
                          <button type="button" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp; Print selected DR</button>
                      </div>
                      </div>
        </div>
      </div>
      