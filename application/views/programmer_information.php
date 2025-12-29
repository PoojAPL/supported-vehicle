<div id="right-container">
  <div class="site-form form-inline">
    <div class="row">
    <div class="col-sm-3">
          <form method="post" action="<?php echo adm_base_url();?>vehicles/exportdata">
              <input type="hidden" name="table_name" value="mechanical_key_information" />
              <button class="btn btn-info" type="submit">Export Data</button>
          </form>
      </div>
      <div class="col-sm-9">
          <form method="post" onsubmit="return confirmSubmit();" action="<?php echo adm_base_url();?>vehicles/importdata" enctype="multipart/form-data">
              <input type="hidden" name="table_name" value="mechanical_key_information" />
              <input type="hidden" name="redirect" value="vehicles/machanical_keys" />
              <input style="width:250px !important;" type="file" required class="form-control" name="import_file" />
              <button type="submit" class="btn btn-success">Import Data</button>
          </form>
      </div>
      <div class="col-sm-12">
        <div class="form-group addCodeSeries">          
          <a href="<?php echo adm_base_url();?>vehicles/add_programmer_information" class="btn btn-danger"  title="Sign Out">Add New Key</a>        
        </div>
      </div>
    </div>
</div>
  <div class="row">
    <div class="col-sm-24">
      <section class="white-box">
      <?php if($this->session->flashdata('message_display')){?>
    	 <div class="alert alert-info"><?php echo $this->session->flashdata('message_display');?></div>	
     <?php } ?>
        <form class="site-form" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
          <div class="table-responsive make_users chips_data">
            <table class="table table-striped table-data mar0">
              <thead>
                <tr>  
                  <th>ID</th> 
                  <th> Vehicle </th>
                  <th> Machine LITE </th>
                  <th> Machine FULL </th>
                  <th> Machine BASIC </th>
                  <th> Machine G2 </th>
                  <th> Machine G2T </th>
                  <th> Machine CORE </th>
                  <th> Machine EVOLUTION </th>
                  <th> Machine PRIME </th>
                  <th> Machine RESERVED </th>
                  <th style="width: 137px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i =1;
                foreach($results as $value){?>
                    <tr> 
                        <td><?php echo $value['id'];?></td>                   
                        <td><?php echo $value['make'];?> <?php echo $value['model'];?> <?php echo $value['year'];?></td>
                        <td><?php echo $value['LITE'];?></td>
                        <td><?php echo $value['FULL'];?></td>
                        <td><?php echo $value['BASIC'];?></td>
                        <td><?php echo $value['G2'];?></td>
                        <td><?php echo $value['G2T'];?></td>
                        <td><?php echo $value['CORE'];?></td>
                        <td><?php echo $value['EVOLUTION'];?></td>
                        <td><?php echo $value['PRIME'];?></td>
                        <td><?php echo $value['RESERVED'];?></td>
                        <td>
                        <a  href="<?php echo adm_base_url();?>vehicles/edit_programmer_information/<?php echo $value['id'];?>" type="button" class="btn btn-success">Edit</a> 
                        <a  href="javascript:void(0)" onClick="DeleteKeytype(<?php echo $value['id'];?>, '<?php echo adm_base_url();?>vehicles/delete_programmer_information/')" type="button"class="btn btn-danger">Delete</a>        </td>
                     
                    </tr> 
                <?php }?>
               </tbody>
            </table>
          </div>
        </form>
      </section>
    </div>
  </div>
</div>

<!-- right container start here -->
<script>
function confirmSubmit() {
    var isConfirmed = confirm("Are you sure you want to submit the form?");
    return isConfirmed;
}
</script>