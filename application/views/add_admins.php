<style>
  .pages_access li.parent{
      float: left;
      width: 33%;
      min-height: 140px;
  }
  .pages_access li.pageli{
    float: left;
    width: 33%;
  }
</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-24 col-md-24">                         
    <section class="innerUserlogin white-box">
    <?php if($this->session->flashdata('message_display')){?>
  <div class="alert alert-info"><?php echo $this->session->flashdata('message_display');?></div>
  <?php } ?>
  <form class="site-form " method ="post"  action="<?php echo adm_base_url();?>home/save_admins" >
  	 <!--<h2 class="titleheadng">Add Key Type</h2>-->
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Username</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="user_name" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> E-mail</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="email" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Password</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="password" class="form-control"  name="password" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Company</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
         <input type="text" class="form-control"  name="Company" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Type</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
            <select name="type" class="form-control">
                <option selected value="1">User</option>
            </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="labelcol">
          <label class="control-label"> Page Access</label>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="inputcol">
            <ul class="pages_access" style="list-style:none;padding:0px;margin:0px;">
              <?php foreach(pages_access() as $page_key => $page_value){
                if(is_array($page_value)){                  
                    echo '<li class="parent"><b>'.$page_key.'</b><ul style="list-style:none;padding-left: 10px;">';
                    foreach($page_value as $subpage_key => $subpage_value){?>
                      <li><input name="pages_access[]" type="checkbox" value="<?php echo $subpage_key;?>"> <?php echo $subpage_value;?></li>
                    <?php }
                    echo '</ul></li>';
                  }else{?>
                    <li class="pageli"><input name="pages_access[]" type="checkbox" value="<?php echo $page_key;?>"> <?php echo $page_value;?></li>
                <?php }
              }?>
            </ul>
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
        <a href="<?php echo adm_base_url();?>home/admins" class="btn btn-danger">Cancel</a>
    </div>   
  </div>
   </form>
  </div>
  </div>
</div>

