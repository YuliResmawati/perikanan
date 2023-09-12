<div class="navbar-custom">
	<div class="container-fluid">
		<ul class="list-unstyled topnav-menu float-right mb-0">
			<li class="dropdown d-none d-lg-inline-block">
				<a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
					<i class="fe-maximize noti-icon"></i>
				</a>
			</li>

			<li class="dropdown notification-list topbar-dropdown">
				<a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
					<i class="fe-bell noti-icon"></i>
					<span class="badge badge-danger rounded-circle noti-icon-badge">9</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-lg">

					<!-- item-->
					<div class="dropdown-item noti-title">
						<h5 class="m-0">
							<span class="float-right">
								<a href="" class="text-dark">
									<small>Clear All</small>
								</a>
							</span>Notification
						</h5>
					</div>

					<div class="noti-scroll" data-simplebar>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item active">
							<div class="notify-icon">
								<img src="../assets/images/users/user-1.jpg" class="img-fluid rounded-circle" alt="" /> </div>
							<p class="notify-details">Cristina Pride</p>
							<p class="text-muted mb-0 user-msg">
								<small>Hi, How are you? What about our next meeting</small>
							</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-primary">
								<i class="mdi mdi-comment-account-outline"></i>
							</div>
							<p class="notify-details">Caleb Flakelar commented on Admin
								<small class="text-muted">1 min ago</small>
							</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon">
								<img src="../assets/images/users/user-4.jpg" class="img-fluid rounded-circle" alt="" /> </div>
							<p class="notify-details">Karen Robinson</p>
							<p class="text-muted mb-0 user-msg">
								<small>Wow ! this admin looks good and awesome design</small>
							</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-warning">
								<i class="mdi mdi-account-plus"></i>
							</div>
							<p class="notify-details">New user registered.
								<small class="text-muted">5 hours ago</small>
							</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-info">
								<i class="mdi mdi-comment-account-outline"></i>
							</div>
							<p class="notify-details">Caleb Flakelar commented on Admin
								<small class="text-muted">4 days ago</small>
							</p>
						</a>

						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item notify-item">
							<div class="notify-icon bg-secondary">
								<i class="mdi mdi-heart"></i>
							</div>
							<p class="notify-details">Carlos Crouch liked
								<b>Admin</b>
								<small class="text-muted">13 days ago</small>
							</p>
						</a>
					</div>

					<!-- All-->
					<a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
						View all
						<i class="fe-arrow-right"></i>
					</a>

				</div>
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