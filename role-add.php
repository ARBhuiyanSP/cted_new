<?php include('dashboard_top_menu_header.php'); ?>
<?php if(!check_permission('role-add')){ 
        include("404.php");
        exit();
 } ?>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Fixed Assets Management <small></small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Role Entry Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<?php 
// if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['role_create']=='role_create') {
      if (isset($_POST['role_create']) && !empty($_POST['role_create'])) {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
      } else {
        $name = $_POST["name"]; 
      }

    $permissions= $_POST['permissions']; //array data

    // echo "<pre>";
    // print_r($permissions);
    // echo "</pre>";

    //Insert into Roles
    $queryRole = "INSERT INTO `roles` (`name`,`status`) VALUES ('$name','1')";
    $resultRole = $conn->query($queryRole);
    $lastinsertedId =  mysqli_insert_id($conn);

    //Insert into permission_role table
    foreach($permissions as $permission){
        $queryPermission = "INSERT INTO `permission_role` (`permission_id`,`role_id`) VALUES ('$permission','$lastinsertedId')";
        $resultPermission = $conn->query($queryPermission);
    }



}


?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
				<h3 class="card-title">Assets Entry</h3>
				<div class="card-tools">
				  <button type="button" class="btn btn-tool"  onclick="window.location.href='role-list.php';">
					<i class="fas fa-list"></i> Role List
				  </button>
				</div>
			  </div>
          <!-- /.card-header -->
          <div class="card-body">
          	<form action="" method="post" name="add_name" id="Role_entry_form" onsubmit="showFormIsProcessing('Role_entry_form');">
                  <div class="row" id="div1" style="">
										<div class="col-md-12 col-xs-12">
                    	<div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="name" id="name" class="form-control" required >
                        <!-- <input type="hidden" name="role_create" value="role_create"> -->
                      </div>
                    </div>
                    <div class="col-md-12 col-xs-12">
                    	<div class="form-group">
                        <label>Permissions</label>
                      </div>
                    </div>
                    <?php
                      $rearrange = [];
                      $permissionData = getTableDataByTableName('permissions');        
                      if (isset($permissionData) && !empty($permissionData)) {
                          foreach ($permissionData as $data) {
                          $rearrange[$data["permission_category"]][]=$data;
                           }
                          }
                    ?>
                    <div class="row">
                    		<?PHP 
                          foreach ($rearrange as $key=> $data) { ?>
                        <div class="col-md-12"><h3 style="background-color: #35AD6D;color: #fff;"><?php echo $key; ?></h3></div>
                          <?php
                           foreach($data as $key_val){ ?>
                          <div class="col-md-4">
                            <div class="d-flex">
                              <input id="<?php echo $key_val['id']; ?>" type="checkbox" name="permissions[]"  value="<?php echo $key_val['id']; ?>" style="width: 20px;height: 20px;">
                              <label for="<?php echo $key_val['id']; ?>" style="padding-left:5px;"> <?php echo $key_val["display_name"]; ?></label>
                            </div>
                        	</div>   
                            <?php  } } ?>
                    </div>
										<div class="col-md-12">
                    	<div class="form-group">
                      	<input type="submit" name="role_create" id="submit" class="btn btn-block btn-success" style="" value="Save" />   
                    	</div>
                    </div>
                  </div>
                </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

 <?php include('dashboard_top_menu_footer.php'); ?>


<script>

$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      alert( "Form successful submitted!" );
    }
  });
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 5
      },
      terms: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a valid email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>