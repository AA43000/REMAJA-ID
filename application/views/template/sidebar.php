<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
          <i class="fas fa-users"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Remaja <sup>ID</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      <?php if($this->session->userdata("user_type") == 1) { ?>
      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengaturan" aria-expanded="true" aria-controls="pengaturan">
          <i class="fas fa-fw fa-cog"></i>
          <span>Pengaturan</span>
        </a>
        <div id="pengaturan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Pengaturan:</h6>
            <a class="collapse-item" href="<?= base_url('User') ?>">User</a>
            <a class="collapse-item" href="<?= base_url('User_type') ?>">User Type</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tampilan" aria-expanded="true" aria-controls="tampilan">
          <i class="fas fa-fw fa-tv"></i>
          <span>Tampilan</span>
        </a>
        <div id="tampilan" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Tampilan:</h6>
            <a class="collapse-item" href="<?= base_url('aplikasi/') ?>">Aplikasi</a>
            <a class="collapse-item" href="<?= base_url('slide/') ?>">Slide</a>
            <a class="collapse-item" href="<?= base_url('about/') ?>">About</a>
            <a class="collapse-item" href="<?= base_url('service/') ?>">service</a>
            <!-- <a class="collapse-item" href="<?= base_url('portfolio/') ?>">Portfolio</a> -->
            <a class="collapse-item" href="<?= base_url('team/') ?>">Team</a>
            <a class="collapse-item" href="<?= base_url('contact/') ?>">Contact Us</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <?php } ?>

      <?php if ($this->session->userdata("user_type") == 2 || $this->session->userdata("user_type") == 1) { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bendahara" aria-expanded="true" aria-controls="bendahara">
          <i class="fas fa-fw fa-dollar-sign"></i>
          <span>Bendahara</span>
        </a>
        <div id="bendahara" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Bendahara:</h6>
            <a class="collapse-item" href="utilities-color.html">Iuran</a>
            <a class="collapse-item" href="utilities-border.html">Pengeluaran</a>
          </div>
        </div>
      </li>
      <?php } 
      if($this->session->userdata("user_type") == 4 || $this->session->userdata("user_type") == 1) { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#petugas" aria-expanded="true" aria-controls="petugas">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Petugas</span>
        </a>
        <div id="petugas" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Tampilan:</h6>
            <a class="collapse-item" href="utilities-color.html">Aplikasi</a>
            <a class="collapse-item" href="utilities-border.html">Slide</a>
            <a class="collapse-item" href="utilities-animation.html">About</a>
            <a class="collapse-item" href="utilities-other.html">Team</a>
            <a class="collapse-item" href="utilities-other.html">Contact Us</a>
            <a class="collapse-item" href="utilities-other.html">Portfolio</a>
          </div>
        </div>
      </li>

      <?php } ?>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>