<div class="container-fluid">
  <div class="row">
    <div class="col-sm-24 col-md-24">                         
    <section class="innerUserlogin white-box">
    <?php if($this->session->flashdata('message_display')){?>
  <div class="alert alert-info"><?php echo $this->session->flashdata('message_display');?></div>
  <?php } ?>
  <form class="site-form " method ="post"  action="<?php echo adm_base_url();?>vehicles/save_machanical_keys" enctype='multipart/form-data' >
  	 <!--<h2 class="titleheadng">Add Key Type</h2>-->
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Name</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="name" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Code Series</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="code_series" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Depth</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="depth" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Ignition</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="ignition" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> MACS</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="macs" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Spaces</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="spaces" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Reserved</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="reserved" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Image</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="file" class="form-control"  name="image" >
        </div>
      </div>
    </div>

     <hr>
    <div class="row">
    <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"></label>
        </div>
      </div>
    <div class="col-md-12">
        <button type="sumit" class="btn btn-success" name="post">Submit</button>
        <a href="<?php echo adm_base_url();?>vehicles/machanical_keys" class="btn btn-danger">Cancel</a>
    </div>   
  </div>
   </form>
  </div>
  </div>
</div>

