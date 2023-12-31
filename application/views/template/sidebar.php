<?php

$segment = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);

$data_user = getProfile();


?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?= base_url(); ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Tenaga Kerja Wedding</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url(); ?>assets/uploads/users/<?= $data_user['image']; ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block text-capitalize"><?= $data_user['username']; ?></a>
      </div>
    </div>



    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="<?= base_url(); ?>dashboard" class="nav-link <?= ($segment == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <?php if ($this->session->userdata('id_role') == 1) : ?>

          <li class="nav-item">
            <a href="<?= base_url('user'); ?>" class="nav-link <?= ($segment == 'user') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Kelola User
              </p>
            </a>
          </li>

        <?php endif; ?>
        <li class="nav-item">
          <a href="<?= base_url('sanggar'); ?>" class="nav-link <?= ($segment == 'sanggar') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Kelola Sanggar
            </p>
          </a>
        </li>
        <?php if ($this->session->userdata('id_role') != 2) : ?>
          <li class="nav-item">
            <a href="<?= base_url('order'); ?>" class="nav-link <?= ($segment == 'order') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Kelola Order
              </p>
            </a>
          </li>
        <?php endif; ?>
        <?php if ($this->session->userdata('id_role') != 3) : ?>
          <li class="nav-item">
            <a href="<?= base_url('laporan'); ?>" class="nav-link <?= ($segment == 'laporan') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Laporan
              </p>
            </a>
          </li>
        <?php endif; ?>
        <li class="nav-item  <?= ($segment == 'profile' || $segment == 'gantipass') ? 'menu-open' : ''; ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Profile
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('profile'); ?>" class="nav-link <?= ($segment == 'profile') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  My Profile
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('gantipass'); ?>" class="nav-link <?= ($segment == 'gantipass') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Ganti Password
                </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= base_url(); ?>auth/logout" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Logout
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>