<aside class="main-sidebar">



        <!-- sidebar: style can be found in sidebar.less -->

        <section class="sidebar">



          <!-- Sidebar user panel (optional) -->

          <div class="user-panel">

            <div class="pull-left image">

              <img src="../resources/images/logo.png" class="img-circle" alt="User Image">

            </div>

            <div class="pull-left info">

              <p><?php echo ucfirst($_SESSION['adminusername']);?></p>

              <!-- Status -->

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

            </div>

          </div>



          <!-- search form (Optional) -->

          <form action="#" method="get" class="sidebar-form" style="display:none;">

            <div class="input-group">

              <input type="text" name="q" class="form-control" placeholder="Search...">

              <span class="input-group-btn">

                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>

              </span>

            </div>

          </form>

          <!-- /.search form -->



          <!-- Sidebar Menu -->

          <ul class="sidebar-menu">

            <li class="header">HEADER</li>

            <!-- Optionally, you can add icons to the links -->

            <li class="active"><a href="dashboard.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
			<li class="active"><a href="admin-users.php"><i class="fa fa-user-secret"></i> <span>Admin Users</span></a></li>
			<li class="active"><a href="users.php"><i class="fa fa-users"></i> <span>Inspection Users</span></a></li>
			<li class="active"><a href="companies.php"><i class="fa fa-building"></i> <span>Companies</span></a></li>
            <li class="active"><a href="inspecties.php"><i class="fa fa-tasks"></i> <span>Inspecties </span></a></li>
            <li class="active"><a href="defaultquestions.php"><i class="fa fa-link"></i> <span> Default Question</span></a></li>
            <li class="active"><a href="editemail.php?id=1"><i class="fa fa-link"></i> <span> Email Config</span></a></li>
             

          </ul><!-- /.sidebar-menu -->

        </section>

        <!-- /.sidebar -->

      </aside>