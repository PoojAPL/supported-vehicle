<?php 
$chip_value = "";
if(isset($this->session->userdata['chips_filter_session'])){
	$session_data = $this->session->userdata('chips_filter_session');
	$chip_value = $session_data['chips_filter_val'];
}
$show_chips_filter_array = array('all' => 'All Chips', '1' => 'Standard Chips Only','2' => 'Cloning Chip Only');
?>
<div id="right-container">
  <div class="row">
    <div class="col-sm-24">
      <section class="white-box">
        <?php if($this->session->flashdata('message_display')){?>
    	    <?php echo $this->session->flashdata('message_display');?>
        <?php }?>
        <div class="row">
            <div class="col-sm-12">
                <form class="site-form" method ="post"  action="<?php echo adm_base_url();?>home/save_import_file" enctype="multipart/form-data">
                    <!--<h2 class="titleheadng">Add Key Type</h2>-->
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="labelcol">
                            <label class="control-label">File</label>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="inputcol">
                            <input type="file" class="form-control" name="file">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="labelcol">
                            <label class="control-label"></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="sumit" name="Import" class="btn btn-success" name="post">Submit</button>
                            <a href="<?php echo adm_base_url();?>home/import_xls" class="btn btn-danger">Cancel</a>
                        </div>   
                    </div>
                </form>
            </div>
            <div class="col-sm-12">
                <div class="table-responsive make_users chips_data">
                        <table class="table table-striped table-data mar0">
                        <thead>
                            <tr>                  
                            <th>File Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($function_tables as $key => $value){
                                foreach($value as $key1 => $value1){?>
                                    <tr>
                                        <td><?php echo $value1;?></td>
                                    </tr>
                                <?php }
                            } ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>  
      </section>
    </div>
  </div>
</div>

<!-- right container start here -->