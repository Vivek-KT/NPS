<?= $this->extend("layouts/app_before"); ?>
<?php //print_r($userdata); exit; ?>
<?= $this->section("body") ?>
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">forget Password</div>
            <?php if (session()->getFlashdata('response') !== NULL) : ?>
                <p style="color:green; font-size:18px;"  align="center"><?php echo session()->getFlashdata('response'); ?></p>
            <?php endif; ?>

            <?php if (isset($validation)) : ?>
                <p style="color:red; font-size:18px;" align="center"><?= $validation->showError('validatecheck') ?></p>
            <?php endif; ?>
            <?php if (isset($valid)) : ?>
                <p style="color:red; font-size:18px;" align="center"><?= $valid ?></p>
            <?php endif; ?>
            <div class="card-body">
                <?php $action= 'resetpwd?id='.$_GET['id']."&t_id=".$_GET['t_id']; ?>
        <form class="" action="<?= base_url($action); ?>" method="post">
            <input type="text" class="form-control" name="userId" id="userId" value="<?php echo $_GET['id']; ?>">
    <input type="text" class="form-control" name="tenant_id" id="tenant_id" value="<?php echo $_GET['t_id']; ?>">
                <div class="form-group">
                    <div class="form-label-group">                        
                        <input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>">
                        <label for="password">Enter Password</label>
                        <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('password') ?></div><?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label-group">                        
                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" value="<?php echo set_value('confirmpassword'); ?>">
                        <label for="password">Confirm Password</label>
                        <?php if (isset($validation)) : ?> <div style="color:red"><?= $validation->showError('confirmpassword') ?></div><?php endif; ?>
                    </div>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a class="d-block small mt-3" href="<?php echo site_url('login'); ?>">Back to Login</a>
                </div>
                
                </form>
            </div>
        </div>
    </div> 


<?= $this->endSection() ?>