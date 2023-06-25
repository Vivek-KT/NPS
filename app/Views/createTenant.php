<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<div id="wrapper">
<?php include APPPATH.'views/layouts/sidebar.php';?>
<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
    <?php include APPPATH.'views/layouts/breadcrumb.php';?>  
    <!-- Page Content -->
    <h1>Create New Tenant</h1>
    <hr>
<!---- Success Message ---->
<?php if (session()->getFlashdata('response') !== NULL) : ?>
  <p style="color:green; font-size:18px;"><?php echo session()->getFlashdata('response'); ?></p>

<?php endif; ?>
<?php if (isset($validation)) : ?>
                <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('validatecheck') ?></p>
            <?php endif; ?>
      <!-- Icon Cards-->
    <form class="" action="<?= base_url('tenant_data') ?>" method="post">
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6 offset-1">
            <div class="form-label-group">

              <input type="text" class="form-control" name="tenantname" id="tenantname" value="<?php echo set_value('tenantname'); ?>">
              <label for="tenantname">Enter your Tenant Name</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('tenantname') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
     <h1>Create Admin User</h1>
              <hr/>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6 offset-1">
            <div class="form-label-group">

              <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo set_value('firstname'); ?>">
              <label for="firstname">Enter your First Name</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('firstname') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6 offset-1">
            <div class="form-label-group">

              <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo set_value('lastname'); ?>">
              <label for="lastname">Enter your Last Name</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('lastname') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6 offset-1">
            <div class="form-label-group">

              <input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username'); ?>">
              <label for="username">Enter your User Name</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('username') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6 offset-1">
            <div class="form-label-group">

              <input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>">
              <label for="email">Enter your Email</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('email') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6 offset-1">
            <div class="form-label-group">
              <input type="text" class="form-control" name="phone_no" id="phone_no" value="<?php echo set_value('phone_no'); ?>">
              <label for="phone_no">Enter your phone_no</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('phone_no') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6 offset-1">
            <div class="form-label-group">
              <input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>">
              <label for="password">Enter your password</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('password') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6 offset-1">
            <div class="form-label-group">
              <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" value="<?php echo set_value('confirmpassword'); ?>">
              <label for="confirmpassword">Enter your confirm password</label>
              <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('confirmpassword') ?></div><?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group">          
      <div class="form-row">
        <div class="col-md-6 offset-1"> 
          <button type="submit" class="btn btn-primary btn-block">Create Tenant</button>
        </div>
      </div>
      </div>


    </form>
    </div>
</div>

</div>

<?= $this->endSection() ?>