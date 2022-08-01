<header class="header">
	<ul class="header-nav">
		<li>
			<button id="js-toggle-sidebar" class="header-nav-item">
				<i class="fas fa-bars"></i>
			</button>
		</li>
	</ul>

	<ul class="header-nav pull-right">
		<li>
			<a href="#" data-dropdown class="user-panel">
				<div class="user-panel-image">
					<div class="avatar avatar-sm">
						<img src="{{ asset('assets/images/plus.png') }}" alt="{{ Auth::user()->name }}">
					</div>
				</div>
				<div class="user-panel-info">
					<p>{{ Auth::user()->name }}</p>
					<small class="text-black-50">{{ Auth::user()->userRole['label']; }}</small>
				</div>
			</a>
			<ul class="dropdown-menu">
				{{-- <li><a class="dropdown-item" href="page-profile.html"><i class="far fa-user"></i> Profile</a></li>
				<li class="dropdown-divider"></li> --}}
				<li><a class="dropdown-item" href="{{route('logout')}}"><i class="fas fa-power-off"></i> Sair</a></li>
			</ul>
		</li>
	</ul>
</header>
