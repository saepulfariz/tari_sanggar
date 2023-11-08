<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kelola User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item">Kelola User</li>
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
            <div class="col-12">
                <a href="<?= base_url('user/new'); ?>" class="btn btn-primary btn-sm mb-2">Tambah</a>
                <div class="card">
                    <div class="card-header">
                        Kelola User
                    </div>
                    <div class="card-body">
                        <table class="table" id="table2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Username</th>
                                    <th>Nama Lengkap</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Is Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $a = 1;
                                foreach ($user as $d) : ?>
                                    <tr>
                                        <td><?= $a++; ?></td>
                                        <td>
                                            <img width="70" src="<?= base_url(); ?>assets/uploads/users/<?= $d['image']; ?>" alt="">
                                        </td>
                                        <td><?= $d['username']; ?></td>
                                        <td><?= $d['nama_lengkap']; ?></td>
                                        <td><?= $d['nama_role']; ?></td>
                                        <td><?= $d['email']; ?></td>
                                        <td>
                                            <?php if ($d['is_active'] == 1) : ?>
                                                <a class="btn btn-success btn-sm" href="<?= base_url('user/active/' . $d['id'] . '/0'); ?>">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            <?php else : ?>
                                                <a class="btn btn-danger btn-sm" href="<?= base_url('user/active/' . $d['id'] . '/1'); ?>">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning btn-sm mb-2" href="<?= base_url('user/' . $d['id'] . '/edit'); ?>">Edit</a>
                                            <a class="btn btn-danger btn-sm mb-2 del-tombol" href="<?= base_url('user/' . $d['id'] . '/delete'); ?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>