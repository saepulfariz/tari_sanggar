<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="<?= base_url(); ?>auth/proses_register" method="post">
          <div class="input-group">
            <input type="text" class="form-control" name="nama_lengkap" placeholder="Full name" value="<?= set_value('nama_lengkap'); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="mb-3"><?= form_error('nama_lengkap', '<div class="ml-2 text-danger">', '</div>'); ?></div>
          <div class="input-group">
            <input type="text" class="form-control" name="username" placeholder="Username" value="<?= set_value('username'); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="mb-3"><?= form_error('username', '<div class="ml-2 text-danger">', '</div>'); ?></div>
          <div class="input-group">
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?= set_value('email'); ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="mb-3"><?= form_error('email', '<div class="ml-2 text-danger">', '</div>'); ?></div>
          <div class="input-group">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="mb-3"><?= form_error('password', '<div class="ml-2 text-danger">', '</div>'); ?></div>
          <div class="input-group">
            <input type="password" class="form-control" name="confirm_password" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="mb-3"><?= form_error('confirm_password', '<div class="ml-2 text-danger">', '</div>'); ?></div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                  I agree to the <a href="#">terms</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


        <a href="<?= base_url(); ?>auth" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->