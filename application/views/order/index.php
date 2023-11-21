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
                        <div class="table-responsive">
                            <table class="table" id="table2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Status</th>
                                        <th>Nama Konsumen</th>
                                        <th>Nama Sanggar</th>
                                        <th>Nama Paket</th>
                                        <th>Harga Paket</th>
                                        <th>Nama Acara</th>
                                        <th>Tanggal Acara</th>
                                        <th>Waktu Mulai</th>
                                        <th>Domisili</th>
                                        <th>Alamat</th>
                                        <th>Catatan Patner</th>
                                        <th>DP</th>
                                        <th>Bukti TF1</th>
                                        <th>Bukti TF2</th>
                                        <th>Bayar1</th>
                                        <th>Bayar2</th>
                                        <th>Sisa</th>
                                        <th>Waktu Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $a = 1;
                                    foreach ($data as $d) : ?>
                                        <tr>
                                            <td><?= $a++; ?></td>

                                            <td><?= $d['status']; ?></td>
                                            <td><?= $d['nama_lengkap']; ?></td>
                                            <td><?= $d['nama_sanggar']; ?></td>
                                            <td><?= $d['nama_paket']; ?></td>
                                            <td>Rp. <?= number_format($d['harga_paket'], 0); ?></td>
                                            <td><?= $d['nama_acara']; ?></td>
                                            <td><?= $d['tanggal_acara']; ?></td>
                                            <td><?= $d['waktu_mulai']; ?></td>
                                            <td><?= $d['domisili']; ?></td>
                                            <td><?= $d['alamat']; ?></td>
                                            <td><?= $d['catatan_patner']; ?></td>
                                            <td><?= ($d['is_dp'] == 1) ? 'DP' : 'CASH'; ?></td>
                                            <td>
                                                <a href="<?= base_url(); ?>assets/uploads/bukti/<?= $d['bukti_tf1']; ?>" target="_blank">
                                                    <img width="70" src="<?= base_url(); ?>assets/uploads/bukti/<?= $d['bukti_tf1']; ?>" alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= base_url(); ?>assets/uploads/bukti/<?= $d['bukti_tf2']; ?>" target="_blank">
                                                    <img width="70" src="<?= base_url(); ?>assets/uploads/bukti/<?= $d['bukti_tf2']; ?>" alt="">
                                                </a>
                                            </td>
                                            <td>Rp. <?= number_format($d['bayar1'], 0); ?></td>
                                            <td>Rp. <?= number_format($d['bayar2'], 0); ?></td>
                                            <td>Rp. <?= number_format($d['sisa'], 0); ?></td>
                                            <td><?= $d['mulai_order']; ?></td>
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


    </div>
</section>