<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">New User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item">Kelola User</li>
                    <li class="breadcrumb-item active">New</li>
                </ol>
            </div>
            <!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        New User
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('user'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= set_value('username'); ?>">
                            </div>
                            <?= form_error('username', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <?= form_error('password', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama lengkap" value="<?= set_value('nama_lengkap'); ?>">
                            </div>
                            <?= form_error('nama_lengkap', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?= set_value('email'); ?>">
                            </div>
                            <?= form_error('email', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="email">Role</label>
                                <select name="id_role" id="id_role" class="form-control">
                                    <?php foreach ($role as $d) : ?>
                                        <option value="<?= $d['id']; ?>"><?= $d['nama_role']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?= form_error('id_role', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div id="imagePreview">
                                    <img class="rounded-circle img-thumbnail d-block mb-2" width="120" src="<?= base_url(); ?>assets/uploads/users/user.png" alt="">

                                </div>
                                <input type="file" class="form-control" id="image" name="image" onchange="previewImage(this, '#imagePreview')">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?= base_url('user'); ?>" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>