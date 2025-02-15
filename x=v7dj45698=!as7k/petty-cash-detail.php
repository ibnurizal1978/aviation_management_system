<?php 
require_once 'header.php';
//require_once 'components.php';
$sql  = "SELECT a.user_id as engineer_user_id, project_master_id,full_name,deposit FROM tbl_user a INNER JOIN tbl_project_engineer_team b ON a.user_id = b.engineer_user_id WHERE project_master_id = '".$ntf[1]."' AND engineer_user_id = '".$ntf[2]."'";
$h    = mysqli_query($conn,$sql);
$row  = mysqli_fetch_assoc($h);
$project_master_id  = $row['project_master_id'];
$engineer_user_id   = $row['engineer_user_id'];
?>

<!-- Side Overlay-->
<aside id="side-overlay">
    <!-- Side Overlay Scroll Container -->
    <div id="side-overlay-scroll">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow">
            <div class="content-header-section align-parent">
                <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                    <i class="fa fa-times text-danger"></i>
                </button>

                <div class="content-header-item">
                    <a class="align-middle link-effect text-primary-dark font-w600" href="#">Filter</a>
                </div>
                <!-- END User Info -->
            </div>
        </div>
        <!-- END Side filter -->

        <!-- side kanan -->
        <div class="content-side">
            <!-- Search -->
            <div class="block pull-t pull-r-l">
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <form action="petty-cash.php" method="post">
                        <input type="hidden" name="s" value="1091vdf8ame151">
                        <div class="input-group">
                            <input type="text" class="form-control" id="side-overlay-search" name="txt_search" placeholder="Search..">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary px-10">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Search -->

            <!-- Profile -->
            <div class="block pull-r-l">
                <div class="block-header bg-body-light">
                    <h3 class="block-title">
                        <i class="fa fa-fw fa-pencil font-size-default mr-5"></i>Sort by
                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                    </div>
                </div>
                <div class="block-content">
                    <form action="petty-cash.php" method="post">
                        <div class="form-group mb-15">
                            <div class="form-material floating">
                                <select class="form-control" id="material-select2" name="s">
                                    <option></option><!-- Empty value for demostrating material select box -->
                                    <option value="1">By Name A-Z</option>
                                </select>
                                <label for="material-select2">Please Select</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-block btn-alt-primary">
                                    <i class="fa fa-refresh mr-5"></i> View
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END filter -->
        </div>
        <!-- END Side filter -->
    </div>
    <!-- END Side Overlay Scroll Container -->
</aside>
<!-- END Side Overlay -->

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content">    
        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Ledger Data for User: <?php echo $row['full_name'] ?></h3>
                Current Amount: <?php echo 'IDR '.number_format($row['deposit'],0,",",".") ?>
                <div class="block-options">
                    <div class="block-options-item">
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-sm table-vcenter">
                    <thead>
                        <tr>
                            <th>Status</th><th>Date</th><th>Type</th><th>Amount</th><th>Notes</th><th>Created by</th><th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT b.full_name,project_ledger_id,project_ledger_notes,project_ledger_type,project_ledger_amount,project_ledger_paid_status,date_format(project_ledger_date, '%d/%m/%Y') as project_ledger_date,project_ledger_file FROM tbl_project_ledger a INNER JOIN tbl_user b USING (user_id) WHERE project_master_id = '".$project_master_id."' AND engineer_user_id = '".$engineer_user_id."' ORDER BY created_date DESC";
                          $h2   = mysqli_query($conn,$sql2);
                        while($row2 = mysqli_fetch_assoc($h2)) {
                        ?>
                        <tr>
                            <td>
                                <?php if($row2['project_ledger_type']=='INVOICE' && $row2['project_ledger_paid_status']==0) { ?>
                                <input type="hidden" name="project_ledger_id" value="<?php echo $row2['project_ledger_id'] ?>"><a href="petty-cash-pay.php?act=29dvi59&ntf=29dvi59-<?php echo $row2["project_ledger_id"]?>-94dfvj!sdf-1-<?php echo $engineer_user_id ?>-349ffuaw" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" onclick="return confirm('Are you sure you want to approve this item?');"><i class="fa fa-thumbs-o-up"></i></a> 
                                <a href="petty-cash-pay.php?act=29dvi59&ntf=29dvi59-<?php echo $row2["project_ledger_id"]?>-94dfvj!sdf-3-<?php echo $engineer_user_id ?>-349ffuaw" class="btn btn-sm btn-circle btn-alt-danger mr-5 mb-5" onclick="return confirm('Are you sure you want to reject this item?');"><i class="fa fa-thumbs-o-down"></i></a>
                                <?php 
                                }else{ 
                                if($row2['project_ledger_paid_status']==1) { 
                                    echo '<label class=text-success>approved</label>';
                                }elseif($row2['project_ledger_paid_status']==3) {
                                    echo '<label class=text-danger>rejected</label>';
                                }else{
                                    echo '<label class=text-info>deposit</label>';                 
                                }} 
                                ?>
                            </td>                    
                            <td><?php echo $row2['project_ledger_date'] ?></td>
                            <td><?php echo $row2['project_ledger_type'] ?></td>
                            <td><?php echo 'IDR '.number_format($row2['project_ledger_amount'],0,",","."); ?></td>
                            <td><?php echo $row2['project_ledger_notes'] ?></td>
                            <td><?php echo $row2['full_name'] ?></td>
                            <td>
                                <?php if($row2['project_ledger_file']<>'') {
                                echo '<a href='.$base_url.'uploads/petty-cash/'.$row2['project_ledger_file'].' target=_blank><i class="si si-paper-clip"></i></a></a>';
                                }else{
                                echo '';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php } mysqli_free_result($h2); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Small Table -->


        <div class="block table-responsive">
            <div class="block-header block-header-default">
                <h3 class="block-title">Print</h3>
            </div>
            <div class="block-content">            
                <form method="POST" action="petty-cash-print.php">
                    <input type="hidden" name="project_master_id" value="<?php echo $row['project_master_id'] ?>">
                    <input type="hidden" name="engineer_user_id" value="<?php echo $engineer_user_id ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">From Date (dd/mm/yyyy) </label>
                                <input type="text" class="form-control" name="date_from" id="date_from" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">To Date (dd/mm/yyyy)</label>
                                <input type="text" class="form-control" name="date_to" id="date_to" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data">Print</button>
                            </div>
                        </div>            
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
<?php require_once 'footer.php' ?>

<script>  
$(document).ready(function(){
  $("#button").html('<a class="btn btn-info pull-right" href="petty-cash-new.php?act=29dvi59&ntf=29dvi59-<?php echo $row["project_master_id"]?>-94dfvj!sdf-349ffuaw">Back</a> <button class="btn btn-danger pull-right" onclick="javascript:window.print();">Print</button>');
  $('#submit_data').click(function(){  
    $('#form_simpan').submit(); 
    $("#results").html('<img width=50 src=<?php echo $base_url ?>assets/img/loading.gif>');
    $("#button").html('<button type="submit" class="btn btn-success pull-right" id="submit_data">Loading...</button>'); 
  });  
  $('#form_simpan').on('submit', function(event){  
    event.preventDefault();  
    $.ajax({  
      url:"petty-cash-pay.php",  
      method:"POST",  
      data:new FormData(this),  
      contentType:false,  
      processData:false,  
      success:function(data){ 
        $('#results').html(data);  
        $('#submit_data').val('');
        $("#button").html('<a class="btn btn-info pull-right" href="petty-cash-new.php?act=29dvi59&ntf=29dvi59-<?php echo $row["project_master_id"]?>-94dfvj!sdf-349ffuaw">Back</a> <button class="btn btn-danger pull-right" onclick="javascript:window.print();">Print</button>');  
      }  
    });  
  });

  $("#date_from").attr("maxlength", 10);
  $("#date_from").keyup(function(){
      if ($(this).val().length == 2){
          $(this).val($(this).val() + "/");
      }else if ($(this).val().length == 5){
          $(this).val($(this).val() + "/");
      }
  });

  $("#date_to").attr("maxlength", 10);
  $("#date_to").keyup(function(){
      if ($(this).val().length == 2){
          $(this).val($(this).val() + "/");
      }else if ($(this).val().length == 5){
          $(this).val($(this).val() + "/");
      }
  });

}); 
</script>