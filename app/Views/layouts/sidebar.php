      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <?php if (session()->get('isLoggedIn')) {  ?>
            <?php if (session()->get('role') == "admin") { ?>
              <a class="nav-link" href="<?php echo site_url('admin'); ?>">
            <?php } else { ?> 
              <a class="nav-link" href="<?php echo site_url('user'); ?>">
            <?php } ?>
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
          <?php }  ?>
        </li>
     
         <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('userprofile'); ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>My Profile</span></a>
        </li>
        <?php if (session()->get('isLoggedIn')) {  ?>
          <?php if (session()->get('tenant_id') == 1) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('createtenant'); ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Create Tenant</span></a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('userpermission'); ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>User Permission</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('questionList'); ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Question List</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('surveyList'); ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Survery List</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('emailtemplate'); ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Email Template</span></a>
        </li>
        <?php  } ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('changepassword'); ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Change Pasword</span></a>
        </li>

    <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('logout'); ?>">
      <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span></a>
        </li>

      </ul>