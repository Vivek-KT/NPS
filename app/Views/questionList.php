<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH.'Views/layouts/sidebar.php';?>
<?php echo script_tag('js/jquery.min.js'); ?>
<section class="home">
        <div class="container">        <!-- Breadcrumbs-->

        <!-- Breadcrumbs-->
    <?php include APPPATH.'Views/layouts/breadcrumb.php';?>  
    <!-- Page Content -->
    <h1>Question List</h1>
    <hr>    
    
    <div class="text-right "><a class="btn btn-primary float-end" href="<?php echo site_url('createquestion'); ?>">Create Question</a>

</div>

    <table class="table table-striped table-bordered">
  <thead >
    <tr>
      <th scope="col">#</th>
      <th scope="col">Question</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach($questionlist as $questionData) { ?>
    <tr>
      <td scope="row"><?php echo $questionData['question_id']; ?></td>
      <td><?php echo $questionData['question_name']; ?></td>
      <td><a class="btn btn-primary" href="<?php echo site_url('editquestion/'.$questionData['question_id']); ?>">edit</a>
      <a class="btn btn-primary" href="<?php echo site_url('deletequestion/'.$questionData['question_id']); ?>">delete</a></td>
    </tr>
  <?php  } ?>
  </tbody>

  </table>
  </div>
        </section>
    <?= $this->endSection() ?>