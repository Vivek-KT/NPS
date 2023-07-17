<nav class="sidebar">
        <header>
            <div class="image-text">
                <div class="text logo-text">
                <?php $imageProperties = ['src' => 'images/logo.png','class' => 'img-fluid', 'alt' => 'Hair Component']; 
                            echo img($imageProperties); ?>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="menu-head ">
                    <h6>Customer Satisfaction
                        Survey </h6>
                </li>

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="<?php echo site_url('admin'); ?>">
                            <?php $imageProperties = ['src' => 'images/majesticons_home.svg','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <?php if (session()->get('tenant_id') == 1) { ?>
                    <li class="nav-link">
                        <a href="<?php echo site_url('createtenant'); ?>">
                            <?php $imageProperties = ['src' => 'images/majesticons_home.svg','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                            <span class="text nav-text">Create Tenant</span>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="nav-link">
                        <a href="<?php echo site_url('questionList'); ?>">
                        <?php $imageProperties = ['src' => 'images/Answers.png','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                            <span class="text nav-text">View Question</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?php echo site_url('surveyList'); ?>">
                        <?php $imageProperties = ['src' => 'images/Answers.png','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                            <span class="text nav-text">View Survey</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                        <?php $imageProperties = ['src' => 'images/Investment Portfolio.png','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                            <span class="text nav-text">Reports</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="#">
                        <?php $imageProperties = ['src' => 'images/World.png','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                            <span class="text nav-text">Geo-Matrix</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?php echo site_url('SurveyResponse'); ?>">
                        <?php $imageProperties = ['src' => 'images/Answers.png','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                            <span class="text nav-text">Survey Report</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="<?php echo site_url('emailtemplate'); ?>">
                        <?php $imageProperties = ['src' => 'images/Send Email.png','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                            <span class="text nav-text">send E-mail</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="<?php echo site_url('userpermission'); ?>">
                        <?php $imageProperties = ['src' => 'images/Search Client.png','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                            <span class="text nav-text">Customer Details</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <hr>
                <li class="nav-link">
                    <a href="#">
                    <?php $imageProperties = ['src' => 'images/Technical Support.png','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                        <span class="text nav-text">Support</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                    <?php $imageProperties = ['src' => 'images/Settings.svg','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                        <span class="text nav-text">Setting</span>
                    </a>
                </li>
                <li class="Username">
                    <a href="<?php echo site_url('userprofile'); ?>">
                    <?php $imageProperties = ['src' => 'images/user-icon.png','class' => 'img-fluid']; 
                            echo img($imageProperties); ?>
                        <span class="text nav-text">
                            <h6>
                                <?= session()->get('firstname')." ".session()->get('lastname') ?>
                            </h6>
                            <h6>
                            <?= session()->get('email'); ?>
                            </h6>
                        </span>
                        </a>    
                        <a class="btn bx bx-log-out icon" href="<?php echo site_url('logout'); ?>"></a>
                    
                </li>
    
                <!-- <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li> -->

            </div>
        </div>

    </nav>
      
<!--       
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

      </ul> -->