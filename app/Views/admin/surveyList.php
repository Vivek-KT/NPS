<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH.'views/layouts/sidebar.php';?>
<?php echo script_tag('js/jquery.min.js'); ?>
<section class="home">
        <div class="container">
        <!-- Breadcrumbs-->
    <?php include APPPATH.'views/layouts/breadcrumb.php';?>  
    <!-- Page Content -->
    <h1>Survey List</h1>
    <hr>    
    
    <div class="text-right mb-3"><a class="btn btn-primary float-end" href="<?php echo site_url('createSurvey'); ?>">Create Survey</a>

</div>

    <table class="table mt-6 table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Survery Campain Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($surveryList as $surveryData) { ?>
    <tr>
      <td scope="row"><?php echo $surveryData['campign_id']; ?></td>
      <td><?php echo $surveryData['campain_name']; ?></td>
      <td><a class="btn btn-primary" href="<?php echo site_url('editsurvey/'.$surveryData['campign_id']); ?>">edit</a>
      <a class="btn btn-primary" href="<?php echo site_url('deletesurvey/'.$surveryData['campign_id']); ?>">delete</a></td>
    </tr>
  <?php  } ?>
  </tbody>

  </table>
  </div>
  </section>
    <?= $this->endSection() ?>