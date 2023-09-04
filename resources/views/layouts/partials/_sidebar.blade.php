<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
             
				<img src="/assets/img/elements/logo3.jpg">
                
             
            
        </a>
 
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
 			  
		<li class="menu-item  @if ( request()->is('admin/users*') ) active open @endif">
			<a href="javascript:void(0);" class="menu-link menu-toggle">
				<i class="menu-icon tf-icons ti ti-smart-home"></i>
				<div>Dashboard</div>
			</a>
			<ul class="menu-sub">
				<li class="menu-item @if ( request()->is('/') ) active @endif">
					<a href="{{ route('dashboard') }}" class="menu-link">Talleres</a>
				</li>
				<li class="menu-item @if ( request()->is('/inf') ) active @endif">
					<a href="{{ route('admin.users.index') }}" class="menu-link">Informacion</a>
				</li>
			</ul>
		</li>

       
		<li class="menu-item @if ( request()->is('admin/respuestas') ) active @endif">
						<a href="{{ route('data-full') }}" class="menu-link">
						<i class="menu-icon tf-icons ti ti-lock"></i>
						<div>Inf Siniestros</div>
						</a>
					</li>

			

    </ul>
</aside>
