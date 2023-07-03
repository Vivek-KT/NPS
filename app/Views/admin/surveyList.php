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
    <h1>Survey List</h1>
    <hr>    
    
    <div class="text-right"><a class="btn btn-primary" href="<?php echo site_url('createSurvey'); ?>">Create Survey</a>

</div>

    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Survery Campain Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <?php foreach($surveryList as $surveryData) { ?>
  <tbody>
    <tr>
      <td scope="row"><?php echo $surveryData['campign_id']; ?></td>
      <td><?php echo $surveryData['campain_name']; ?></td>
      <td><a class="btn btn-primary" href="<?php echo site_url('editsurvey/'.$surveryData['campign_id']); ?>">edit</a>
      <a class="btn btn-primary" href="<?php echo site_url('deletesurvey/'.$surveryData['campign_id']); ?>">delete</a></td>
    </tr>
  </tbody>
  <?php  } ?>
  </table>

    <?= $this->endSection() ?>