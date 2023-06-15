<?php include('dashboard_top_menu_header.php'); 
$mrr_no=$_GET['no'];?>
  <!-- /.navbar -->
<style>
  .table td, .table th {
  padding:3px 10px;
} 
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> CTED Chattogram <small>- Receive Details</small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Receive Details</li>
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
                <h5 class="card-title">Material Receive Report</h5>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool"  onclick="window.location.href='receive_list.php';">
                  <i class="fas fa-list"></i> Receive List
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div style="display: none;" id="hidden-content"><img src="images/<?php echo $rowd['mrr_image']; ?>" /></div>
                  <button class="btn btn-info" data-fancybox data-src="#hidden-content" onclick="javascript:;"><i class="fa fa-eye" aria-hidden="true"></i> View Attached File </button>
                  <button class="btn btn-default" onclick="printDiv('printableArea')" style="float:right;"><i class="fa fa-print" aria-hidden="true" style="font-size: 17px;"> Print</i></button>
              
                <div class="row" id="printableArea" style="padding-top:10px;">
                  <?php
                    $sqld     = "select * from `inv_receive` where `mrr_no`='$mrr_no'";
                    $resultd  = mysqli_query($conn, $sqld);
                    $rowd     = mysqli_fetch_array($resultd);
                  ?>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">  
                        <p>
                        <img src="images/logoMenu.png" height="30px;"/>
                        <h5>CTED Chattogram</h5></p>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-bordered">
                          <tr>
                            <th>Voucher No:</th>
                            <td><?php echo $mrr_no; ?></td>
                          </tr>
                          <tr>
                            <th>Voucher Date:</th>
                            <td><?php
                            echo date("j M y", strtotime($rowd['mrr_date'])); ?></td>
                          </tr>
                          <tr>
                            <th>Project:</th>
                            <td>
                              <?php 
                              $dataresult =   getDataRowByTableAndId('projects', $rowd['project_id']);
                              echo (isset($dataresult) && !empty($dataresult) ? $dataresult->name : '');
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <th>Warehouse:</th>
                            <td>
                              <?php 
                              $dataresult =   getDataRowByTableAndId('inv_warehosueinfo', $rowd['warehouse_id']);
                              echo (isset($dataresult) && !empty($dataresult) ? $dataresult->name : '');
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <th>Supplier:</th>
                            <td>
                              <?php 
                              $supplier_id = $rowd['supplier_id'];
                              $sqlunit  = "SELECT * FROM `suppliers` WHERE `code` = '$supplier_id' ";
                              $resultunit = mysqli_query($conn, $sqlunit);
                              $rowunit=mysqli_fetch_array($resultunit);
                              echo $rowunit['name'];
                              ?>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <center><button class="btn btn-block btn-secondary challan">MATERIAL RECEIVE DETAILS</button></center>
                    <table class="table table-bordered" id="material_receive_list"> 
                      <thead>
                        <tr>
                          <th>SL #</th>
                          <th>Material Name</th>
                          <th>Part No</th>
                          <th>Material Unit</th>
                          <th>Quantity</th>
                          <th>Unit Price</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody id="material_receive_list_body">
                        <?php
                        $transfer_id=$_GET['no'];
                        $sql = "select * from `inv_receivedetail` where `mrr_no`='$mrr_no'";
                        $result = mysqli_query($conn, $sql);
                          for($i=1; $row = mysqli_fetch_array($result); $i++){
                        ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td>
                            <?php 
                              $dataresult =   getDataRowByTableAndId('inv_material', $row['material_name']);
                              echo (isset($dataresult) && !empty($dataresult) ? $dataresult->material_description : '');
                            ?>
                          </td>
                          <td><?php echo $row['part_no']; ?></td>
                          <td>
                            <?php 
                            $dataresult =   getDataRowByTableAndId('inv_item_unit', $row['unit_id']);
                            echo (isset($dataresult) && !empty($dataresult) ? $dataresult->unit_name : '');
                            ?>
                          </td>
                          <td><?php echo $row['receive_qty'] ?></td>
                          <td><?php echo $row['unit_price'] ?></td>
                          <td><?php echo $row['total_receive'] ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td colspan="4" class="grand_total">Grand Total:</td>
                          <td>
                            <?php 
                            $sql2       = "SELECT sum(receive_qty) FROM  `inv_receivedetail` where `mrr_no`='$mrr_no'";
                            $result2    = mysqli_query($conn, $sql2);
                            for($i=0; $row2 = mysqli_fetch_array($result2); $i++){
                            $totalReceived  =$row2['sum(receive_qty)'];
                            echo $totalReceived ;
                            }
                            ?>
                          </td>
                          <td></td>
                          <td>
                          <?php 
                            $sql2     = "SELECT sum(total_receive) FROM  `inv_receivedetail` where `mrr_no`='$mrr_no'";
                            $result2    = mysqli_query($conn, $sql2);
                            for($i=0; $row2 = mysqli_fetch_array($result2); $i++){
                            $totalAmount  = number_format((float)$row2['sum(total_receive)'], 2, '.', '');
                            echo $totalAmount ;
                            }
                            ?>
                          </td>
                        </tr>
                      </tbody>
                    </table> 
                    <b>Total Amount in words: 
                      <span class="amountWords"><?php echo convertNumberToWords($totalAmount).' Only';?></span>
                    </b>
                    <div class="row" style="text-align:center">
                      <div class="col-sm-5"></br><?php 
                            if($rowd['received_by']){
                            $dataresult =   getDataRowByTableAndId('users', $rowd['received_by']);
                            echo (isset($dataresult) && !empty($dataresult) ? $dataresult->first_name . ' ' .$dataresult->last_name : '');  
                            }?></br>--------------------</br>Receiver Signature</div>
                            
                            
                            
                      <div class="col-sm-2">
                        <?php $queryedit  = "SELECT `approval_status` FROM `inv_receive` WHERE `mrr_no`='$mrr_no'";
                        $result   = $conn->query($queryedit);
                        $row    = mysqli_fetch_assoc($result);
                        if($row['approval_status'] == 0){?>
                        <img src="images/pending.png" height="80;" class="authimg"/>
                        <?php } else{?>
                        <img src="images/approved.png" height="80;" class="authimg"/>
                        <?php }?>
                      </div>
                      
                      
                      
                      <div class="col-sm-5"></br><?php 
                            if($rowd['approved_by']){
                            $dataresult =   getDataRowByTableAndId('users', $rowd['approved_by']);
                            echo (isset($dataresult) && !empty($dataresult) ? $dataresult->first_name . ' ' .$dataresult->last_name : '');  
                            }?></br>--------------------</br>Authorised Signature</div>
                    </div></br>
                    <div class="row">
                      <div class="col-sm-12" style="border:1px solid gray;border-radius:5px;padding:10px;color:#f26522;">
                        <h5>Notice***</br><span style="font-size:14px;color:#000000;">Please Check Everything Before Signature</span></h5>
                        
                      </div>
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
<script>
      function printDiv(divName) {
         var printContents = document.getElementById(divName).innerHTML;
         var originalContents = document.body.innerHTML;

         document.body.innerHTML = printContents;

         window.print();

         document.body.innerHTML = originalContents;
      }
      </script>
