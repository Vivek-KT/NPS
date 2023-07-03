<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<div id="wrapper">
<?php include APPPATH.'views/layouts/sidebar.php';?>
<?php echo script_tag('js/jquery.min.js'); ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
    <?php include APPPATH.'views/layouts/breadcrumb.php';?>  
    <!-- Page Content -->
    <h1>Email Template Option</h1>
    <hr>    
    <?php if (isset($validation)) : ?>
                <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('validatecheck') ?></p>
            <?php endif; ?>

    <form class="form-horizontal" action="<?= base_url('sendEmail') ?>" method="post">
    <div id="dynamic_field">
    <div class="form-group">
      <label class="control-label col-sm-2 offset-1" for="Campaign Name">Enter Survey/Campaign Name:</label>
      <div class="col-sm-5 offset-1">
      <select class="custom-select custom-select-sm" class="custom-select custom-select-sm" aria-label="Default select example" name="quest_2" >
          <?php foreach($getSurvey as $getSurveylist) { ?> 
            <option value="<?php echo $getSurveylist['campign_id'] ; ?>"><?php echo $getSurveylist['campain_name'] ; ?></option>
          <?php  } ?>
        </select>
      </div>
    </div>
    
        <div class="form-group">
            <label class="control-label col-sm-2 offset-1" for="Send Email">Send Email to:</label>
            <div class="col-sm-5 offset-1">
                <input type="text" class="form-control" id="sendemail" placeholder="Send Email to" name="sendemail" autocomplete="off" >
            </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-5 offset-1">
                <div class="input-group custom-file-button">
                    <label class="input-group-text" for="inputGroupFile">Upload Email data:</label>
                    <input type="file" name="file" class="form-control" id="inputGroupFile" onChange="chkFile(this)">
                </div>
            </div>
        </div>



    
     
    <div class="form-group">          
      <div class="form-row">
        <div class="col-md-5 offset-1"> 
     <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="Send Email" /> 
</div></div></div>
</div> 
  </form>

    </div>
</div>
</div>
<script type="text/javascript">
function chkFile(file1) {
    console.log(file1);

    var file = file1.files[0];
    console.log(file);

    var formData = new FormData();
    formData.append('formData', file);
        console.log(formData);
    $.ajax({  
      url:'<?php echo base_url('uploadFile'); ?>',
      type: 'post',
      dataType:'json',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response){
        console.log(response.query);
        $("#sendemail").val(response.query);
      },
      error: function(response){
        console.log(response);
      } 
    });
}
    </script>
<?= $this->endSection() ?>