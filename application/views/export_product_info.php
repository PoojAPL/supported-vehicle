<div class="container-fluid "> 
<div class="loader_div hide_loader"><div class="loader"></div></div>
<section class="innerUserlogin white-box">
<h3>Product Info </h3> 
<hr style="border-top: 3px solid #eee;">
	<?php if($this->session->flashdata('import_msg')){?>
  <div class="alert alert-success"><?php echo $this->session->flashdata('import_msg');?></div>
  <?php } ?> 
   <?php if($this->session->flashdata('error_import_msg')){?>
  <div class="alert alert-danger"><?php echo $this->session->flashdata('error_import_msg');?></div>
  <?php } ?>  
    <div class="row">
		 <div class="col-sm-8" style="text-align: center;">
			<!--<label class="control-label" style="display: block;font-size: 16px;font-weight: bold;">Export product info </label>-->
			 <a href="<?php echo adm_base_url();?>home/export_all_product_info_table" target="_blank" class="btn btn-primary">Export product info </a> 
		 </div>
		 
		 <div class="col-sm-8" style="text-align: center;border-left: 1px solid #ccc;">
			 <!--<label class="control-label"  style="display: block;font-size: 16px;font-weight: bold;">Import</label>-->
			 	<form method="post" id="product_import_csv" enctype="multipart/form-data" action="<?php echo adm_base_url();?>home/import_product_info_to_database" style="margin:0 auto;width:25%;">
			   <div class="form-group">			
					<input type="file" name="import_csv_file" id="product_info_csv_file" class="inline"  accept=".csv" required />
					<br><span class="prodInfoimportmsg" style="color: #f51616;"></span>
					<br /> <button type="submit" class="btn btn-info" id="prodInfo_btn">Import product info csv to database</button>
			   </div>		  
		  </form>
		 </div>
    </div> 
	</section>

  <hr style="border-top: 3px solid #eee;">
<section class="innerUserlogin white-box">
  <h3>Product Detail</h3><hr style="border-top: 3px solid #eee;">
   <?php if($this->session->flashdata('prod_detail_import_msg')){?>
  <div class="alert alert-success"><?php echo $this->session->flashdata('prod_detail_import_msg');?></div>
  <?php } ?> 
   <?php if($this->session->flashdata('prod_detail_error_import_msg')){?>
  <div class="alert alert-danger"><?php echo $this->session->flashdata('prod_detail_error_import_msg');?></div>
  <?php } ?>
	<div class="row">
		 <div class="col-sm-8" style="text-align: center;">
			<!--<label class="control-label" style="display: block;font-size: 16px;font-weight: bold;">Export product detail </label>-->
			  <a href="<?php echo adm_base_url();?>home/export_all_product_detail_table" target="_blank" class="btn btn-warning">Export product detail</a> 
		 </div>
		 
		 <div class="col-sm-8" style="text-align: center;border-left: 1px solid #ccc;">
			 <!--<label class="control-label"  style="display: block;font-size: 16px;font-weight: bold;">Import</label>-->
			 <form method="post" id="product_detail_import_csv" enctype="multipart/form-data" action="<?php echo adm_base_url();?>home/import_product_detail_to_database" style="margin:0 auto;width:25%;">
			   <div class="form-group">			
					<input type="file" name="prod_detail_import_csv_file" id="product_detail_csv_file" class="inline"  accept=".csv" required />
					<br /><span class="proDetailimportmsg" style="color: #f51616;"></span>
					<br /> <button type="submit" class="btn btn-success" id="prod_detail_btn">Import product detail csv to database</button>
			   </div>		  
		  </form>
			 	
		 </div>
    </div>  
  </section>
 
</div>
