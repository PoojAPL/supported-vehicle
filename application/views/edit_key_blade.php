<div class="container-fluid">
  <div class="row">
    <div class="col-sm-24 col-md-24">                         
    <section class="innerUserlogin white-box">
    <?php if($this->session->flashdata('message_display')){?>
  <div class="alert alert-info"><?php echo $this->session->flashdata('message_display');?></div>
  <?php } ?>
  <form class="site-form "  method ="post" id="keyBlade" action="<?php echo adm_base_url();?>home/update_key_blade" enctype="multipart/form-data">
  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
     <!--<h2 class="titleheadng">Add New Chip</h2>-->
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Name</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
		<input type="hidden" value="<?php echo $id;?>" name="keyBladeId" >
         <input type="text" class="form-control" placeholder="Name" name="Key_Blade_name" value="<?php echo $getallKeysBladeInfo[0]['Key_Blade_name'];?>">
        </div>
      </div>
    </div>  
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Image upload</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="file" class="form-control"  name="image">
		 <?php if($getallKeysBladeInfo[0]['Key_Blade_Image_url'] !=""){?>
		  <img src="<?php echo aks_img_url().$getallKeysBladeInfo[0]['Key_Blade_Image_url'];?>" width="150">
		 <?php }?>
	   </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label">Description</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <textarea rows="5" cols="5" class="form-control" placeholder="Description" name="Key_Blade_dec" id= "description"><?php echo $getallKeysBladeInfo[0]['Key_Blade_dec'];?></textarea>
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
        <button type="submit" class="btn btn-primary" name="post">Update</button>
        <a href="<?php echo adm_base_url();?>home/key_blade" class="btn btn-danger">Cancel</a>
    </div>   
  </div>
   </form>
  </div>
  </div>
</div>
