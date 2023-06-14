<?php include('dashboard_top_menu_header.php'); ?>
  <!-- /.header -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> 88 Innovations Ltd <small>- Dashboard</small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Issue - Consumption List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
        <h3 class="card-title">Issue / Consumption</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool"  onclick="window.location.href='role-add.php';">
          <i class="fas fa-list"></i> New Role Create
          </button>
        </div>
        </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
          <div class="col-md-12">
            <div class="table-responsive data-table-wrapper">
              <?php 
                $delUrl =   "includes/role_process.php?process_type=role_delete";
              ?>
              <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>Role Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                                    $projectsData = getTableDataByTableName('roles');
                                    ;
                                    if (isset($projectsData) && !empty($projectsData)) {
                                        foreach ($projectsData as $data) {
                                            ?>
                  <tr>
                    <td><?php echo $data['name']; ?></td>
                    <td>
                      <?php if(check_permission('role-edit')){ ?>
                      <a href="role-edit.php?id=<?php echo $data['id']; ?>"><i class="fas fa-edit text-success"></i></a>
                    <?php } ?>
                    <?php if(check_permission('role-delete')){ ?>
                      <a href="javascript:void(0)"  onclick="commonDeleteOperation('<?php echo $delUrl ?>', '<?php echo $data['id']; ?>');"><i class="fa fa-trash text-danger"></i></a>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php
                                        }
                                    }
                                    ?>
                </tbody>
              </table>
            </div>
          </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
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
<!-- ./wrapper -->
