	<!-- =========================== MENU =========================== -->

	<!-- Left side column. contains the sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">

			<!-- search form -->
			<form action="<?php echo base_url('inventory/search') ?>" method="post" class="sidebar-form" autocomplete="off">
				<div class="input-group">
					<input type="text" name="keyword" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
						</button>
					</span>
				</div>
			</form>

			<!-- /.search form -->
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">

				<li class="header">Main Navigation</li>

					<li>
						<a href="<?php echo base_url() ?>">
							<i class="fa fa-home"></i> <span>Home</span>
						</a>
					</li>

				<?php if ($this->ion_auth->logged_in()){ ?>

					<li class="treeview">

						<a href="#"><i class="fa fa-archive"></i> <span>Master Data</span>
							<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>

						<ul class="treeview-menu">
								
							<li>
								<a href="<?php echo base_url('locations') ?>">
									<i class="fa fa-map-marker"></i> <span>Area</span>
								</a>
							</li>

							<li>
								<a href="<?php echo base_url('unit') ?>">
									<i class="fa fa-building-o"></i> <span>Unit</span>
								</a>
							</li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-archive"></i> <span>Transaksi</span>
							<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>

						<ul class="treeview-menu">
								
							<li>
								<a href="<?php echo base_url('ticket') ?>">
									<i class="fa fa-ticket"></i> <span>Ticket</span>
								</a>
							</li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-archive"></i> <span>Laporan</span>
							<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>

						<ul class="treeview-menu">
								
							<li>
								<a href="<?php echo base_url('laporan') ?>">
									<i class="fa fa-tv"></i> <span>Rekap Tiket</span>
								</a>
							</li>

						</ul>

					</li>

					<?php if ($this->ion_auth->is_admin()){ ?>

						<!-- Menu Admin -->
						<li class="header">Settings</li>
					
							<li>
								<a href="<?php echo base_url('auth') ?>">
									<i class="fa fa-users"></i> <span>Users</span>
								</a>
							</li>

					<?php } ?>

						<li class="header">Options</li>

							<li>
								<a href="<?php echo base_url('auth/logout') ?>">
									<i class="fa fa-sign-out"></i> <span>Logout</span>
								</a>
							</li>

						</li>

					<?php } else { ?>

						<li>
							<a href="<?php echo base_url('auth/login') ?>">
								<i class="fa fa-sign-in"></i> <span>Login</span>
							</a>
						</li>

				<?php } ?>

			</ul>

		</section>
		<!-- /.sidebar -->
	</aside>

	<!-- =========================== / MENU =========================== -->