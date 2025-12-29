<div class="container-fluid "> 
<div class="loader_div hide_loader"><div class="loader"></div></div>
<section class="innerUserlogin white-box">
<h3>Firebase API</h3> 
<hr style="border-top: 3px solid #eee;">
	<?php if($this->session->flashdata('import_msg')){?>
  <div class="alert alert-success"><?php echo $this->session->flashdata('import_msg');?></div>
  <?php } ?> 
   <?php if($this->session->flashdata('error_import_msg')){?>
  <div class="alert alert-danger"><?php echo $this->session->flashdata('error_import_msg');?></div>
  <?php } ?>  
    <div class="row">
		 <div class="col-sm-4">
			<!--<label class="control-label" style="display: block;font-size: 16px;font-weight: bold;">Export product info </label>-->
			 <a href="<?php echo adm_base_url();?>home/firebase_api_update" class="btn btn-primary">Firebase API Updates</a> 
		 </div>
     <div class="col-sm-6">
     <a href="<?php echo adm_base_url();?>home/firebase_export_csv" class="btn btn-success">Export Firebase CSV</a> 
		 </div>
    </div> 
	</section>
</div>

<script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>
<script defer src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>

<script defer src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>
<script defer src="https://www.gstatic.com/firebasejs/8.10.1/firebase-firestore.js"></script>

<script>
  // Initialize Firebase
  const firebaseConfig = {
  apiKey: "AIzaSyAMFcHG6Ml4CYz3aCkaUVlNwARDMOwH9mI",
  authDomain: "supported-vehicle.firebaseapp.com",
  databaseURL: "https://supported-vehicle-default-rtdb.firebaseio.com",
  projectId: "supported-vehicle",
  storageBucket: "supported-vehicle.appspot.com",
  messagingSenderId: "957011944747",
  appId: "1:957011944747:web:ce71e354f84c9fe7ba116e",
  measurementId: "G-NML2GK7C6V"
};

  firebase.initializeApp(firebaseConfig);

  // Access the Realtime Database
  const database = firebase.database();

  // Function to get data
  function fetchData() {
    const dataRef = database.ref('/vdata');

    dataRef.once('value')
      .then((snapshot) => {
        const data = snapshot.val();
        console.log('Retrieved Data:', data);
      })
      .catch((error) => {
        console.error('Error retrieving data:', error);
      });
  }

  // Call the function when needed
  fetchData();
</script>

  <!-- Your HTML content here -->
</body>
</html>
