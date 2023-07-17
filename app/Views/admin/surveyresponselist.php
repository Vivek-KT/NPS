<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH.'views/layouts/sidebar.php';?>
<?php echo script_tag('js/jquery.min.js'); ?>

<section class="home">
        <div class="container">
        <!-- Breadcrumbs-->
    <?php include APPPATH.'views/layouts/breadcrumb.php';?> 
    <table class="table mt-6 table-striped table-bordered">
  <tbody>
    <?php foreach($getSurveyData as $getSurveylist) { 
        $timestamp = strtotime($getSurveylist["created_at"]);
        ?>
    <tr >
        <td scope="row">
        <div class="d-flex flex-column"> <div class="p-2 bd-highlight"><p>Completed</p></div>
        <div class="p-2 bd-highlight"> <span class="rounded-circle">1</span></div>
        <div class="p-2 bd-highlight"> <span class="rounded-circle">2</span></div>
        </div>
        </td>
        <td scope="row">
        <div class="d-flex flex-column"> <div class="p-2 bd-highlight container"><div class="row">
            <div class="col-xl-2 col-lg-2 col-md-2"> <i class="bi bi-clock"></i><?php echo date("h:m:s",$timestamp); ?></div>
            <div class="col-xl-4 col-lg-4 col-md-4"> <i class="bi bi-calendar"></i><?php echo date("l,m d,Y",$timestamp); ?></div>
            <div class="col-xl-4 col-lg-4 col-md-4"> <i class="bi bi-telephone"></i><?php echo $getSurveylist['userdata']['contact_details']; ?></div>
        </div></div>
        <div class="p-2 bd-highlight"> <span ><?php echo $getSurveylist["questiondata"][0]['question_name']; ?></span></div>
        <div class="p-2 bd-highlight"> <span ><?php echo $getSurveylist["questiondata"][1]['question_name']; ?></span></div>
        </div>
        </td>
        <td scope="row">
        <div class="d-flex flex-column"> <div class="p-2 bd-highlight container"><div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12"> <i class="bi bi-envelope"></i><?php echo $getSurveylist['userdata']['email_id']; ?></div>
        </div></div>
        <div class="p-2 bd-highlight"> <span ><?php echo $getSurveylist["answer_id1"]; ?></span></div>
        <div class="p-2 bd-highlight"> <span ><?php echo $getSurveylist["answer_id2"]; ?></span></div>

        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
    </div>
  </section>
    <?= $this->endSection() ?>