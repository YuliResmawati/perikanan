<div class="navbar-custom">
	<div class="container-fluid">
		<ul class="list-unstyled topnav-menu float-right mb-0">
			<li class="dropdown d-none d-lg-inline-block">
				<a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
					<i class="fe-maximize noti-icon"></i>
				</a>
			</li>
			<li class="dropdown notification-list topbar-dropdown">
				<a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
					<?= generate_avatar($this->session->userdata('silatpendidikan_avatar'), $this->session->userdata('silatpendidikan_display_name'),'rounded-circle') ?>
					<span class="pro-user-name ml-1">
						<?= uc_words(xss_escape($this->session->userdata('silatpendidikan_display_name'))) ?> <i class="mdi mdi-chevron-down"></i> 
					</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
					<div class="dropdown-header noti-title">
						<h6 class="text-overflow m-0">Selamat Datang!</h6>
					</div>
					<a href="<?= base_url('profile') ?>" class="dropdown-item notify-item">
						<i class="fe-user-check"></i>
						<span>Profile Saya</span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="<?= base_url('logout') ?>" class="dropdown-item notify-item">
						<i class="fe-log-out"></i>
						<span>Keluar</span>
					</a>
				</div>
			</li>
		</ul>
		<div class="logo-box">
			<a href="<?= base_url('dashboard') ?>" class="logo logo-dark text-center">
				<span class="logo-sm">
					<img src="<?= base_url('assets/backend') ?>/images/logo-sm.png" alt="Logo" height="22">
				</span>
				<span class="logo-lg">
					<img src="<?= base_url('assets/backend') ?>/images/logo-dark.png" alt="Logo" height="20">
				</span>
			</a>
			<a href="<?= base_url('dashboard') ?>" class="logo logo-light text-center">
				<span class="logo-sm">
					<img src="<?= base_url('assets/backend') ?>/images/small-logo.png" alt="Logo" height="22">
				</span>
				<span class="logo-lg">
					<img src="<?= base_url('assets/backend') ?>/images/silatpen-logo-backend.png" alt="Logo" height="35">
				</span>
			</a>
		</div>
		<ul class="list-unstyled topnav-menu topnav-menu-left m-0">
			<li>
				<button class="button-menu-mobile waves-effect waves-light">
					<i class="fe-menu"></i>
				</button>
			</li>
			<li>
				<a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
					<div class="lines">
						<span></span>
						<span></span>
						<span></span>
					</div>
				</a>
			</li>   
		</ul>
		<div class="clearfix"></div>
	</div>
</div>