	<nav class="pc-sidebar">
		<div class="navbar-wrapper">
			<div class="m-header">
				<div class="b-brand">
					<!-- ========   change your logo hear   ============ -->
					<img src="<?=home_url()?>assets/images/profile-hrchatbot.jpg" alt="" class="logo logo-lg" style="max-width: 100px; max-height: 100px;">
				</div>
			</div>
			<div class="navbar-content">
				<ul class="pc-navbar">
					<li class="pc-item">
						<a href="<?=home_url()?>page/" class="pc-link "><span class="pc-micon"><i class="ti-dashboard"></i></span><span class="pc-mtext">Dashboard</span></a>
					</li>

					<li class="pc-item pc-hasmenu">
						<a href="javascript:void(0)" class="pc-link "><span class="pc-micon"><i data-feather="users"></i></span><span class="pc-mtext">ข้อมูลหัวเรื่อง</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
						<ul class="pc-submenu">
							<li class="pc-item"><a class="pc-link" href="<?=home_url()?>page/users/">หัวเรื่อง</a></li>
						</ul>
					</li>

					<li class="pc-item">
						<a href="javascript:void(0)" class="pc-link " id="user_logout"><span class="pc-micon"><i data-feather="log-out"></i></span><span class="pc-mtext">ออกจากระบบ</span></a>
						<input type="hidden" id="logout_url" value="<?=home_url()?>logout.php?uid=<?=$current_user['user_id']?>" readonly>
					</li>
				</ul>
			</div>
		</div>
	</nav>