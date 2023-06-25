<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Register an Account</div>
        <div class="card-body">
            <!---- Success Message ---->
    
    <!---- Error Message ---->
    
    <?php if (isset($validation)) { ?>
    <p style="color:red; font-size:18px;"><?php echo $validation->showError('validatecheck');?></p>
    
    <?php } ?>  

    <form class="" action="<?= base_url('signup') ?>" method="post">
        <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                    <div class="form-label-group">
                    <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo set_value('firstname'); ?>">
                        <label for="firstname">Enter your first name</label>
                        <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('firstname') ?></div><?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                    <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo set_value('lastname'); ?>">
                        <label for="lastname">Enter your Last name</label>
                        <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('lastname') ?></div><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
            <input type="text" class="form-control" name="tenantname" id="tenantname" value="<?php echo set_value('tenantname'); ?>">
                <label for="tenantname">Tenant Details</label>
                <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('tenantname') ?></div><?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
            <input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username'); ?>">
                <label for="username">Username</label>
                <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('username') ?></div><?php endif; ?>
            </div>
        </div>        
        <div class="form-group">
            <div class="form-label-group">
            <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>">
                <label for="email">Email</label>
                <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('email') ?></div><?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
            <input type="text" class="form-control" name="phone_no" id="phone_no" value="<?php echo set_value('phone_no'); ?>">
                <label for="phone_no">phone_no</label>
                <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('phone_no') ?></div><?php endif; ?>
            </div>
        </div>

        <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="password" class="form-control" name="password" id="password">
                        <label for="password">Password</label>
                        <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('password') ?></div><?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group">
                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword">
                        <label for="confirmpassword">Confirm Password</label>
                        <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('confirmpassword') ?></div><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
            <a class="d-block small mt-3" href="<?php echo site_url('login'); ?>">Back to Login</a>
        </div>
    </form>

            </div>
        </div>
        </div>
    </div>

            <?= $this->endSection() ?>