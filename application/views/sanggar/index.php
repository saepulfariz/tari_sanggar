<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kelola <?= $title; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item">Kelola <?= $title; ?></li>
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
                <a href="<?= base_url($link . '/new'); ?>" class="btn btn-primary btn-sm mb-2">Tambah</a>
                <div class="card">
                    <div class="card-header">
                        Kelola <?= $title; ?>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>nama sangar</th>
                                    <th>lokasi sanggar</th>
                                    <th>tentang sanggar</th>
                                    <th>no rek</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $a = 1;
                                foreach ($data as $d) : ?>
                                    <tr>
                                        <td><?= $a++; ?></td>
                                        <td><?= $d['nama_sanggar']; ?></td>
                                        <td><?= $d['lokasi_sanggar']; ?></td>
                                        <td><?= $d['tentang_sanggar']; ?></td>
                                        <td><?= $d['no_rek']; ?></td>
                                        <td>
                                            <a class="btn btn-warning btn-sm mb-2" href="<?= base_url($link . '/' . $d['id'] . '/edit'); ?>">Edit</a>
                                            <a class="btn btn-danger btn-sm mb-2 del-tombol" href="<?= base_url($link . '/' . $d['id'] . '/delete'); ?>">Delete</a>
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