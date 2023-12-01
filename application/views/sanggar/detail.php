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
    <div class="container-fluid pb-5">
        <!-- Small boxes (Stat box) -->
        <div class="row justify-content-center mb-2">
            <div class="col-md-5 mb-2 ">
                <div class="text-right">
                    <img class="img-thumbnail mb-3" width="80%" src="<?= base_url(); ?>/assets/uploads/galleri/<?= $data['foto_sanggar']; ?>" alt="">
                </div>

                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php $a = 1;
                        foreach ($galleri as $d) : ?>

                            <div class="carousel-item <?= ($a == 1) ? 'active' : ''; ?>">
                                <img src="<?= base_url(); ?>/assets/uploads/galleri/<?= $d['gambar']; ?>" class="d-block w-100" alt="<?= $data['nama_sanggar'] . $a; ?>">
                            </div>
                            <?php $a++; ?>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5>Detail Sanggar</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Nama Sanggar</td>
                                <td>:</td>
                                <td><?= $data['nama_sanggar']; ?></td>
                            </tr>
                            <tr>
                                <td>Lokasi Sanggar</td>
                                <td>:</td>
                                <td><?= $data['lokasi_sanggar']; ?></td>
                            </tr>
                            <tr>
                                <td>Tentang Sanggar</td>
                                <td>:</td>
                                <td><?= nl2br($data['tentang_sanggar']); ?></td>
                            </tr>
                        </table>

                        <button type="button" class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#modalCalendar" id="modal-calendar">Kalender</button>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php $a = 1;
                    foreach ($paket as $d) : ?>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= ($a == 1) ? 'active' : ''; ?>" id="<?= 'paket' . $a; ?>-tab" data-toggle="tab" data-target="#<?= 'paket' . $a; ?>" type="button" role="tab" aria-controls="<?= 'paket' . $a; ?>" aria-selected="<?= ($a == 1) ? 'true' : 'false'; ?>"><?= 'Paket ' . $a; ?></button>
                        </li>
                        <?php $a++; ?>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <?php $a = 1;
                    foreach ($paket as $d) : ?>
                        <div class="tab-pane fade <?= ($a == 1) ? 'show active' : ''; ?>" id="<?= 'paket' . $a; ?>" role="tabpanel" aria-labelledby="<?= 'paket' . $a; ?>-tab">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <td>Nama Paket</td>
                                            <td>:</td>
                                            <td><?= $d['nama_paket']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Harga Paket</td>
                                            <td>:</td>
                                            <td>Rp. <?= number_format($d['harga_paket'], 0); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan Paket</td>
                                            <td>:</td>
                                            <td><?= nl2br($d['keterangan_paket']); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php $a++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card">
                    <div class="card-header">
                        Order Sanggar
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url($link . '/order'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_sanggar" id="id_sanggar" value="<?= $data['id']; ?>">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="id_paket">Nama Paket</label>
                                        <select name="id_paket" id="id_paket" class="form-control">
                                            <?php foreach ($paket as $d) : ?>
                                                <option value="<?= $d['id']; ?>"><?= $d['nama_paket']; ?> | Rp.<?= number_format($d['harga_paket'], 0); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <?= form_error('id_paket', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                                    <div class="form-group">
                                        <label for="nama_acara">Nama Acara</label>
                                        <input type="text" class="form-control" id="nama_acara" name="nama_acara" placeholder="Nama Acara" value="<?= set_value('nama_acara'); ?>">
                                    </div>
                                    <?= form_error('nama_acara', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                                    <div class="form-group">
                                        <label for="tanggal_acara">Tanggal Acara</label>
                                        <input type="date" class="form-control" id="tanggal_acara" name="tanggal_acara" placeholder="Tanggal Acara" value="<?= set_value('tanggal_acara'); ?>">
                                    </div>
                                    <?= form_error('tanggal_acara', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                                    <div class="form-group">
                                        <label for="waktu_mulai">Waktu Mulai</label>
                                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" placeholder="Waktu Mulai" value="<?= set_value('waktu_mulai'); ?>">
                                    </div>
                                    <?= form_error('waktu_mulai', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                                    <div class="form-group">
                                        <label for="domisili">Domisili</label>
                                        <input type="text" class="form-control" id="domisili" name="domisili" placeholder="Domisili" value="<?= set_value('domisili'); ?>">
                                    </div>
                                    <?= form_error('domisili', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                                </div>

                                <div class="col-md-6 mb-2">

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?= set_value('alamat'); ?></textarea>
                                    </div>
                                    <?= form_error('alamat', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                                    <div class="form-group">
                                        <label for="catatan_patner">Catatan Patner</label>
                                        <textarea type="text" class="form-control" id="catatan_patner" name="catatan_patner" placeholder="catatan_patner"><?= set_value('catatan_patner'); ?></textarea>
                                    </div>
                                    <?= form_error('catatan_patner', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                                    <div class="form-group">
                                        <label for="is_dp">Bayar di muka(DP) <input type="checkbox" name="is_dp" value="1"></label>
                                    </div>

                                    <div class="form-group">
                                        <label for="bukti_tf1">Bukti TF </label>
                                        <p>(MANDIRI - 32134 - A.N PUAN PULAN)</p>
                                        <div id="imagePreview">
                                            <img class=" img-thumbnail d-block mb-2" width="120" src="<?= base_url(); ?>assets/noimage.jpg" alt="">

                                        </div>
                                        <input type="file" required class="form-control" id="bukti_tf1" name="bukti_tf1" onchange="previewImage(this, '#imagePreview')">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>




    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="modalCalendar" tabindex="-1" aria-labelledby="modalCalendarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCalendarLabel">Kalender</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div id='calendar' class="h-100 w-100"></div>
            </div>
        </div>
    </div>
</div>