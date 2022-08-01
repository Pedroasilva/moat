<aside class="sidebar" style="display: block;">
	<a href="{{ route('admin.home') }}" class="logo">
		<img src="{{ asset('assets/images/logo.png') }}" alt=""> <b>{{ config('app.name', 'Painel') }}</b>
	</a>
	<nav>
		<ul class="sidebar-list">
			<li><span class="sidebar-list-header">{{ __('Navegação') }}</span></li>
			<li><a class="sidebar-list-item" href="{{ route('admin.home') }}"><i class="fe fe-bar-chart-2"></i> <span>{{ __('Dashboard') }}</span></a></li>
			<li><a class="sidebar-list-item" href="{{ route('admin.establishments') }}"><i class="fe fe-briefcase"></i> <span>{{ __('Empresas') }}</span></a></li>
			<li><a class="sidebar-list-item" href="{{ route('admin.users') }}"><i class="fe fe-users"></i> <span>{{ __('Usuários') }}</span></a></li>
		</ul>
	</nav>
</aside>