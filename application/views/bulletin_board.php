<style>
fieldset {
    padding: 5px 20px;
    border: 1px solid #ccc;
    margin-top: 20px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.site-form .form-control {
    border: 1px solid #e3e3e3;
}
legend {
    background: #fff;
    margin-bottom: 10px;
}
</style>
<div id="right-container">
  <form class="site-form form-inline">
    <div class="row">
      
      <div class="col-sm-24">
        <!-- <div class="form-group addCodeSeries">          
          <a href="<?php echo adm_base_url();?>vehicles/add_programmer_information" class="btn btn-danger"  title="Sign Out">Add New Key</a>        
        </div> -->
      </div>
    </div>
  </form>
  <div class="row">
    <div class="col-sm-24">
      <section class="white-box">
      <?php if($this->session->flashdata('message_display')){?>
    	 <div class="alert alert-info"><?php echo $this->session->flashdata('message_display');?></div>	
     <?php } ?>
        <div class="site-form" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
          <div class="row">
                <?php for($i = 1; $i <= 10; $i++){
                $btn_class = array('success','info','danger','warning');
                $randomIndex = array_rand($btn_class);
                $randomClass = $btn_class[$randomIndex];?>
                <div class="col-md-8">
                    <form method="post" action="<?php echo adm_base_url();?>home/save_bulletin_board">
                        <fieldset <?php if($result[0]['bbn'.$i.'_start'] !=""){?>style="background: #DCEDC8;"<?php } ?>>
                            <legend>Notice <?php echo $i;?></legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input value="<?php echo $result[0]['bbn'.$i.'_start'];?>" type="date" name="sdate[bbn<?php echo $i;?>_start]" placeholder="Start Date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input value="<?php echo $result[0]['bbn'.$i.'_end'];?>" type="date"  placeholder="End Date" name="edate[bbn<?php echo $i;?>_end]" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="mesg[bbn<?php echo $i;?>]" class="form-control" placeholder="Message..."><?php echo $result[0]['bbn'.$i];?></textarea>
                            </div>
                            <div class="form-group">
                            <button style="margin-left: 5px;" class="btn btn-<?php echo $randomClass;?>" type="submit">Submit</button>
                            </div>
                        </fieldset> 
                    </form>                   
                </div>
                <?php } ?>
          </div>
                </div>
      </section>
    </div>
  </div>
</div>

<!-- right container start here -->
