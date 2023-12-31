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
                <?php if ($this->session->userdata('id_role') == 1) : ?>
                    <a href="<?= base_url($link . '/new'); ?>" class="btn btn-primary btn-sm mb-2">Tambah</a>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        Kelola <?= $title; ?>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>foto sangar</th>
                                    <th>nama sangar</th>
                                    <th>lokasi sanggar</th>
                                    <th>tentang sanggar</th>
                                    <?php if ($this->session->userdata('id_role') == 1) : ?>
                                        <th>no rek</th>
                                    <?php endif; ?>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $a = 1;
                                foreach ($data as $d) : ?>
                                    <tr>
                                        <td><?= $a++; ?></td>
                                        <td>
                                            <img width="70" src="<?= base_url(); ?>/assets/uploads/galleri/<?= $d['foto_sanggar']; ?>" alt="">
                                        </td>
                                        <td><?= $d['nama_sanggar']; ?></td>
                                        <td><?= $d['lokasi_sanggar']; ?></td>
                                        <td><?= $d['tentang_sanggar']; ?></td>
                                        <?php if ($this->session->userdata('id_role') == 1) : ?>
                                            <td><?= $d['no_rek']; ?></td>
                                        <?php endif; ?>
                                        <td>
                                            <a class="btn btn-success btn-sm mb-2" href="<?= base_url($link . '/' . $d['id']); ?>">Detail</a>
                                            <?php if ($this->session->userdata('id_role') == 1) : ?>
                                                <a class="btn btn-primary btn-sm mb-2" href="<?= base_url($link . '/galleri/' . $d['id']); ?>">Galleri</a>
                                                <a class="btn btn-info btn-sm mb-2" href="<?= base_url($link . '/paket/' . $d['id']); ?>">Paket</a>
                                                <a class="btn btn-warning btn-sm mb-2" href="<?= base_url($link . '/' . $d['id'] . '/edit'); ?>">Edit</a>
                                                <a class="btn btn-danger btn-sm mb-2 del-tombol" href="<?= base_url($link . '/' . $d['id'] . '/delete'); ?>">Delete</a>
                                            <?php endif; ?>
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