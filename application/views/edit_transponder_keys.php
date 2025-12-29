<div class="container-fluid">
  <div class="row">
    <div class="col-sm-24 col-md-24">                         
    <section class="innerUserlogin white-box">
    <?php if($this->session->flashdata('message_display')){?>
  <div class="alert alert-info"><?php echo $this->session->flashdata('message_display');?></div>
  <?php } ?>
  <form class="site-form "  id="key_type" method ="post"  action="<?php echo adm_base_url();?>vehicles/update_transponder_keys/<?php echo $result[0]['id'];?>" enctype='multipart/form-data' >
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
         <input type="text" class="form-control" value="<?php echo $result[0]['name'];?>"  name="name" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Chip</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="chip" value="<?php echo $result[0]['chip'];?>" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Reuseable?</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="reuseable" value="<?php echo $result[0]['reuseable'];?>" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Cloneable?</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control" value="<?php echo $result[0]['cloneable'];?>" name="cloneable" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Test Blade</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control" value="<?php echo $result[0]['test_blade'];?>" name="test_blade" >
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
         <input type="text" class="form-control" value="<?php echo $result[0]['reserved'];?>" name="reserved" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Image</label>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="inputcol">
         <input type="file" class="form-control"  name="image" >
        </div>
      </div>
      <div class="col-sm-4 attachments_row" style="position: relative;border: 1px solid #cccccc70;padding: 10px;">
        <?php if($result[0]['image'] !=""){?>
          <input type="hidden" value="<?php echo $result[0]['image'];?>" class="keyimage" name="keyimage" >
          <div class="img-box">
            <img width="100" src="<?php echo $result[0]['image'];?>" alt="">
            <span style="font-size: 20px;color: red;position: absolute;right: 15px;top: 10px;" class="glyphicon glyphicon-trash remove_attachments" aria-hidden="true"></span>
          </div>
        <?php } ?>
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
        <a href="<?php echo adm_base_url();?>vehicles/transponder_keys" class="btn btn-danger">Cancel</a>
    </div>   
  </div>
   </form>
  </div>
  </div>
</div>

