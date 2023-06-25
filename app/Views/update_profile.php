<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<div id="wrapper">
<?php include APPPATH.'views/layouts/sidebar.php';?>
<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
    <?php include APPPATH.'views/layouts/breadcrumb.php';?>  
    <!-- Page Content -->
    <h1>My Profile</h1>
    <!---- Success Message ---->
<?php if (session()->getFlashdata('response') !== NULL) : ?>
  <p style="color:green; font-size:18px;"><?php echo session()->getFlashdata('response'); ?></p>
</div>
<?php endif; ?>
<?php if (isset($validation)) : ?>
                <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('validatecheck') ?></p>
            <?php endif; ?>
      <!-- Icon Cards-->
    <hr>

    <form class="" action="<?= base_url('updateprofile') ?>" method="post">
     <?php if(isset($userdata['created_at'])) { ?> <p> <strong>Reg Date :</strong> <?php echo $userdata['created_at']; ?> <?php  } ?>
  <?php 
  // $id = set_value('id') == false ? $userdata['id']: set_value('id');
  $firstname = set_value('firstname') == false ? $userdata['firstname']: set_value('firstname');
  $lastname = set_value('lastname') == false ? $userdata['lastname'] : set_value('lastname');
  $email = set_value('email') == false ? $userdata['email'] : set_value('email');
  $phone_no = set_value('phone_no') == false ? $userdata['phone_no'] : set_value('phone_no');

   ?>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6">
            <div class="form-label-group">
            <!-- <input type="hidden" class="form-control" name="id" id="id" value=""> -->

              <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
              <label for="firstname">Enter your first name</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('firstname') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
     
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6">
            <div class="form-label-group">
                <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $lastname; ?>">
                <label for="lastname">Enter your Last name</label>
                <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('lastname') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6">
            <div class="form-label-group">
              <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>">
              <label for="email">Email</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('email') ?></div><?php endif; ?>
            </div>
            </div>
          </div>
        </div>


      
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6">
            <div class="form-label-group">
                <input type="text" class="form-control" name="phone_no" id="phone_no" value="<?php echo $phone_no; ?>">
                <label for="phone_no">phone_no</label>
                <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('phone_no') ?></div><?php endif; ?>
            </div>
            </div>
          </div>
        </div>
      
      <div class="form-group">          
      <div class="form-row">
        <div class="col-md-6"> 
          <button type="submit" class="btn btn-primary btn-block">Update</button>
        </div>
      </div>
      </div>


    </form>
</div>

</div>

<?= $this->endSection() ?>  