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
    <h1>Create Question and Summary</h1>
    <hr>    
    <?php if (isset($validation)) : ?>
                <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('validatecheck') ?></p>
            <?php endif; ?>
            <?php 
  $question_id = $getQuestData['question_id'];
  $question_name = $getQuestData['question_name'];
  $description = $getQuestData['description'];
  $info_details = $getQuestData['info_details'];

   ?>
    <form class="form-horizontal" action="<?= base_url('editquestion/'.$question_id) ?>" method="post">
    <div id="dynamic_field">
    <div class="form-group">
      <label class="control-label col-sm-2 offset-1" for="question">Enter Question:</label>
      <div class="col-sm-5 offset-1">
        <input type="text" class="form-control" id="question" placeholder="Enter question" name="question" autocomplete="off" value="<?php echo $question_name; ?>">
        <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('question') ?></div><?php endif; ?>

      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2 offset-1" for="qinfo">Enter Question Info:</label>
      <div class="col-sm-5 offset-1">
        <input type="text" class="form-control" id="qinfo" placeholder="Enter Question Info" name="qinfo" autocomplete="off" value="<?php echo $description; ?>">
        <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('qinfo') ?></div><?php endif; ?>

      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2 offset-1" for="Answer">Select Answer:</label>
      <div class="col-sm-5 nopadding offset-1">
  <div class="form-group">
    <div class="input-group">         
        <select class="custom-select custom-select-sm" class="custom-select custom-select-sm" aria-label="Default select example" name="amswer" value="<?php echo $info_details; ?>">
            <option value="nps">NPS Answer Type</option>
        </select>

        </div>
        </div>   
      </div>
    </div>

     
    <div class="form-group">          
      <div class="form-row">
        <div class="col-md-5 offset-1"> 
     <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="Submit" /> 
</div></div></div>
</div> 
  </form>

    </div>
</div>
</div>
<!-- 
<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  
      $('#add').click(function(){  
           i++;             
           $('#dynamic_field').append('<div id="row'+i+'"><div class="form-group"><label class="control-label col-sm-2" for="question">Enter Question:</label><div class="col-sm-5"><input type="text" class="form-control"  placeholder="Enter question" name="question[]" autocomplete="off"></div></div><div class="form-group"><label class="control-label col-sm-2" for="qinfo">Enter Question Info:</label><div class="col-sm-5"><input type="text" class="form-control" id="qinfo" placeholder="Enter Question Info" name="qinfo[]" autocomplete="off"></div></div><div class="form-group"><label class="control-label col-sm-2" for="Answer">Select Answer:</label><div class="col-sm-5"><select class="custom-select custom-select-sm" aria-label="Default select example" class="form-select form-select-lg mb-3"  name="amswer[]" ><option value="nps">NPS Answer Type</option></select></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></div>');

     });
     
     $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id"); 
           var res = confirm('Are You Sure You Want To Delete This?');
           if(res==true){
           $('#row'+button_id+'').remove();  
           $('#'+button_id+'').remove();  
           }
      });  
      if(i > 5) {
        console.log(i);
      }
  
    });  
</script> -->
<?= $this->endSection() ?>