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
    <h1>Question List</h1>
    <hr>    
    
    <div class="text-right"><a class="btn btn-primary" href="<?php echo site_url('createquestion'); ?>">Create Question</a>

</div>

    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Question</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <?php foreach($questionlist as $questionData) { ?>
  <tbody>
    <tr>
      <td scope="row"><?php echo $questionData['question_id']; ?></td>
      <td><?php echo $questionData['question_name']; ?></td>
      <td><a class="btn btn-primary" href="<?php echo site_url('editquestion/'.$questionData['question_id']); ?>">edit</a>
      <a class="btn btn-primary" href="<?php echo site_url('deletequestion/'.$questionData['question_id']); ?>">delete</a></td>
    </tr>
  </tbody>
  <?php  } ?>
  </table>

    <?= $this->endSection() ?>