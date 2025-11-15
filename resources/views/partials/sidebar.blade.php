<!-- Sidebar Start -->
<aside class="left-sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route(auth()->user()->isSuperAdmin() ? 'superadmin.dashboard' : (auth()->user()->isGuru() ? 'guru.dashboard' : 'siswa.dashboard')) }}" class="text-nowrap logo-img">
        <h4 class="fw-bold text-primary mb-0">{{ config('app.name', 'E-Learning') }}</h4>
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>

    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        
        @if(auth()->user()->isSuperAdmin())
          <!-- Super Admin Menu -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">SUPER ADMIN</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('superadmin.dashboard') }}" aria-expanded="false">
              <span><i class="ti ti-layout-dashboard"></i></span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('superadmin.guru.index') }}" aria-expanded="false">
              <span><i class="ti ti-users"></i></span>
              <span class="hide-menu">Kelola Guru</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('superadmin.siswa.index') }}" aria-expanded="false">
              <span><i class="ti ti-school"></i></span>
              <span class="hide-menu">Kelola Siswa</span>
            </a>
          </li>

        @elseif(auth()->user()->isGuru())
          <!-- Guru Menu -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">GURU</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('guru.dashboard') }}" aria-expanded="false">
              <span><i class="ti ti-layout-dashboard"></i></span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('guru.materi.index') }}" aria-expanded="false">
              <span><i class="ti ti-book"></i></span>
              <span class="hide-menu">Kelola Materi</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('guru.kuis.index') }}" aria-expanded="false">
              <span><i class="ti ti-clipboard-list"></i></span>
              <span class="hide-menu">Kelola Kuis</span>
            </a>
          </li>

        @else
          <!-- Siswa Menu -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">SISWA</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('siswa.dashboard') }}" aria-expanded="false">
              <span><i class="ti ti-layout-dashboard"></i></span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('siswa.materi.index') }}" aria-expanded="false">
              <span><i class="ti ti-book"></i></span>
              <span class="hide-menu">Materi</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('siswa.kuis.index') }}" aria-expanded="false">
              <span><i class="ti ti-clipboard-list"></i></span>
              <span class="hide-menu">Kuis</span>
            </a>
          </li>
        @endif

      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!-- Sidebar End -->
