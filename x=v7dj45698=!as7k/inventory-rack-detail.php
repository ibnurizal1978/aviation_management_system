<?php
require_once 'header.php';
$sql  = "SELECT parts_rack_location_id, parts_rack_location_name, parts_warehouse_id FROM tbl_parts_rack_location WHERE parts_rack_location_id = '".$ntf[1]."' AND client_id = '".$_SESSION['client_id']."' LIMIT 1";
$h    = mysqli_query($conn,$sql);
$row  = mysqli_fetch_assoc($h);
?>

<!-- Main Container -->
<main id="main-container">
  <!-- Page Content -->
  <div class="content">
    <!--table-->   
    <div class="block table-responsive">
      <div class="block-header block-header-default">
        <h3 class="block-title">Rack Location Detail</h3>
      </div>
      <div class="block-content">
        <div class="card-body">
          <form id="form_simpan">
            <input type="hidden" class="form-control" name="parts_rack_location_id" autocomplete="off" value="<?php echo $row['parts_rack_location_id'] ?>" />
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Rack Location Name</label>
                  <input type="text" class="form-control" name="parts_rack_location_name" autocomplete="off" value="<?php echo $row['parts_rack_location_name'] ?>" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">On Warehouse</label>
                  <select class="form-control" required name="parts_warehouse_id" style="padding-left: 5px; padding-right: 5px">
                    <option value=""> -- Choose -- </option>
                    <?php
                    $sql1  = "SELECT parts_warehouse_id,parts_warehouse_name FROM tbl_parts_warehouse WHERE client_id = '".$_SESSION['client_id']."'";
                    $h1    = mysqli_query($conn,$sql1);
                    while($row1 = mysqli_fetch_assoc($h1)) {
                      if($row1['parts_warehouse_id'] == $row['parts_warehouse_id']) {
                    ?>
                    <option value="<?php echo $row1['parts_warehouse_id'] ?>" selected="selected"><?php echo $row1['parts_warehouse_name'] ?></option>
                    <?php }else{ ?>
                    <option value="<?php echo $row1['parts_warehouse_id'] ?>"><?php echo $row1['parts_warehouse_name'] ?></option>
                    <?php }} ?>
                  </select>
                </div>
              </div>                                                                           
            </div>            
            <div id="results"></div><div id="button"></div>
            <div class="clearfix"></div>
          </form>

        </div>
      </div>
    </div>
  <!-- END Small Table -->

  <!-- END Page Content -->
  </div>
</main>
<?php require_once 'footer.php' ?>

<script>  
$(document).ready(function(){
  $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="inventory-rack.php"><i class="si si-arrow-left mr-5"></i>Back</a>');  
  $('#submit_data').click(function(){  
    $('#form_simpan').submit(); 
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');
    $("#button").html('<button type="submit" class="btn btn-success pull-right" id="submit_data">Loading...</button>');
  });  
  $('#form_simpan').on('submit', function(event){
    $("#results").html('<i class="fa fa-4x fa-cog fa-spin text-success"></i>');
    $("#button").html('<button type="submit" class="btn btn-success pull-right" id="submit_data">Loading...</button>');    
    event.preventDefault();  
    $.ajax({  
      url:"inventory-rack-edit.php",  
      method:"POST",  
      data:new FormData(this),  
      contentType:false,  
      processData:false,  
      success:function(data){ 
        $('#results').html(data);  
        $('#submit_data').val('');
        $("#button").html('<button type="submit" class="btn btn-success mr-5 mb-5" id="submit_data"><i class="fa fa-check mr-5"></i>Save</button> <a class="btn btn-info mr-5 mb-5" href="inventory-rack.php"><i class="si si-arrow-left mr-5"></i>Back</a>');  
      }  
    });  
  });  
});  
</script>

