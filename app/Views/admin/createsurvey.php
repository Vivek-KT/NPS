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
    <h1>Create Survey option</h1>
    <hr>    
    <?php if (isset($validation)) : ?>
                <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('validatecheck') ?></p>
            <?php endif; ?>
    <form class="form-horizontal" action="<?= base_url('create_survey') ?>" method="post">
    <div id="dynamic_field">
    <div class="form-group">
      <label class="control-label col-sm-2 offset-1" for="Surveyname">Enter Survey/Campaign Name:</label>
      <div class="col-sm-5 offset-1">
        <input type="text" class="form-control" id="suerveyname" placeholder="Enter Survey/Campaign Name" name="suerveyname" autocomplete="off">
        <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('suerveyname') ?></div><?php endif; ?>

      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2 offset-1" for="Answer">Select Question 1:</label>
      <div class="col-sm-5 nopadding offset-1">
  <div class="form-group">
    <div class="input-group">         
        <select class="custom-select custom-select-sm" class="custom-select custom-select-sm" aria-label="Default select example" name="quest_1" >
          <?php foreach($getQuestData as $getQuestlist) { ?> 
            <option value="<?php echo $getQuestlist['question_id'] ; ?>"><?php echo $getQuestlist['question_name'] ; ?></option>
          <?php  } ?>
        </select>

        </div>
        </div>   
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2 offset-1" for="Answer">Select Question 2:</label>
      <div class="col-sm-5 nopadding offset-1">
  <div class="form-group">
    <div class="input-group">         
        <select class="custom-select custom-select-sm" class="custom-select custom-select-sm" aria-label="Default select example" name="quest_2" >
          <?php foreach($getQuestData as $getQuestlist) { ?> 
            <option value="<?php echo $getQuestlist['question_id'] ; ?>"><?php echo $getQuestlist['question_name'] ; ?></option>
          <?php  } ?>
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
<?= $this->endSection() ?>