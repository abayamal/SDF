      <!-- Sidebar Menu -->
      <nav class="mt-2" class="">
        <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item active">
            <a href="index.php" class="nav-link">
            <i class="fas fa-home"></i>
              <p>
                Home 
              </p>
            </a>
          </li>
          

          <li class="nav-item active">
            <a href="saving_acc_management_page.php" class="nav-link">
            <i class="fas fa-money-check-alt"></i>
              <p>
                Saving Accounts 
              </p>
            </a>
          </li>

          <li class="nav-item active">
            <a href="account_hold.php" class="nav-link">
            <i class="far fa-pause-circle"></i>
              <p>
                Account Hold 
              </p>
            </a>
          </li>

          <li class="nav-item active">
            <a href="account_closed.php" class="nav-link">
            <i class="far fa-times-circle"></i>
              <p>
                Account Closed 
              </p>
            </a>
          </li>

          <li class="nav-item active">
            <a href="transaction_page.php" class="nav-link">
            <i class="fas fa-coins"></i>
              <p>
                Trancations
              </p>
            </a>
          </li>

          <li class="nav-item active">
            <a href="loan_page.php" class="nav-link">
            <i class="fas fa-house-user"></i>
              <p>
                Loan
              </p>
            </a>
          </li>

        <?php
          if($_SESSION["uu"]['stf_designation']=="Admin" || $_SESSION["uu"]['stf_designation']=="Manager" || $_SESSION["uu"]['stf_designation']=="Assistant Manager"){//only display Admin,Manager,Assistant manager
        ?>
          <li class="nav-item active">
            <a href="staff_management_page.php" class="nav-link">
            <i class="fas fa-user-friends"></i>
              <p>
                Staff Managenent
              </p>
            </a>
          </li>
        <?php
          }
        ?>

          <li class="nav-item active">
            <a href="internet_banking_register.php" class="nav-link">
            <i class="fas fa-globe-europe"></i>
              <p>
                Internet Banking Register
              </p>
            </a>
          </li>


          <?php
          if($_SESSION["uu"]['stf_designation']=="Admin"){// Display for only admin
          ?>
          <li class="nav-item active">
            <a href="admin_page.php" class="nav-link">
            <i class="fas fa-user-cog"></i>
              <p>
                Admin
              </p>
            </a>
          </li>
          <?php
          }
          ?>

          <li class="nav-item active">
            <a href="report_page.php" class="nav-link">
            <i class="far fa-file-alt"></i>
              <p>
                Reports
              </p>
            </a>
          </li>

          <li class="nav-item active">  
            <a href="logout.php" class="nav-link">
            <i class="fas fa-sign-out-alt"></i>
              <p>
                log out
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>