<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit <?= $title; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item">Kelola <?= $title; ?></li>
                    <li class="breadcrumb-item active">Edit</li>
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
        <form action="<?= base_url($link . '/' . $data['id']); ?>" method="post" enctype="multipart/form-data">
            <input type='hidden' name='_method' value='PUT' />
            <div class="row">
                <div class="col-md-5 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Konsumen</label>
                                <select name="id_user" id="id_user" class="form-control">
                                    <?php foreach ($konsumen as $d) : ?>
                                        <?php if ($d['id'] == $data['id_user']) : ?>
                                            <option selected value="<?= $d['id']; ?>"><?= $d['nama_lengkap']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $d['id']; ?>"><?= $d['nama_lengkap']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?= form_error('nama_lengkap', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="nama_sanggar">Nama Sanggar</label>
                                <select name="id_sanggar" id="id_sanggar" class="form-control">
                                    <?php foreach ($sanggar as $d) : ?>
                                        <?php if ($d['id'] == $data['id_sanggar']) : ?>
                                            <option selected value="<?= $d['id']; ?>"><?= $d['nama_sanggar']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $d['id']; ?>"><?= $d['nama_sanggar']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?= form_error('id_sanggar', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                            <div class="form-group">
                                <label for="id_paket">Nama Paket</label>
                                <select name="id_paket" id="id_paket" class="form-control" disabled>
                                    <?php foreach ($paket as $d) : ?>
                                        <?php if ($d['id'] == $data['id_paket']) : ?>
                                            <option selected value="<?= $d['id']; ?>"><?= $d['nama_paket']; ?> | Rp.<?= $d['harga_paket']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $d['id']; ?>"><?= $d['nama_paket']; ?> | Rp.<?= $d['harga_paket']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?= form_error('id_paket', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="harga_paket">Harga Paket</label>
                                <input type="text" class="form-control" id="harga_paket" name="harga_paket" disabled placeholder="harga_paket" value="<?= $data['harga_paket']; ?>">
                            </div>
                            <?= form_error('harga_paket', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" required class="form-control">
                                    <?php foreach ($status as $d) : ?>
                                        <?php if ($d == $data['status']) : ?>
                                            <option selected><?= $d; ?></option>
                                        <?php else : ?>
                                            <option><?= $d; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="image">Bukti TF1</label>
                                <p>(MANDIRI - 32134 - A.N PUAN PULAN)</p>
                                <div id="imagePreview">
                                    <img class="img-thumbnail d-block mb-2" width="120" src="<?= base_url(); ?>assets/uploads/bukti/<?= $data['bukti_tf1']; ?>" alt="">
                                </div>
                                <input type="file" class="form-control" id="bukti_tf1" name="bukti_tf1" onchange="previewImage(this, '#imagePreview')">
                            </div>
                            <div class="form-group">
                                <label for="bayar1">Bayar1</label>
                                <input type="number" class="form-control" id="bayar1" name="bayar1" placeholder="bayar1" value="<?= $data['bayar1']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="image">Bukti TF2</label>
                                <p>(MANDIRI - 32134 - A.N PUAN PULAN)</p>
                                <div id="imagePreview">
                                    <img class="img-thumbnail d-block mb-2" width="120" src="<?= base_url(); ?>assets/uploads/bukti/<?= $data['bukti_tf2']; ?>" alt="">
                                </div>
                                <input type="file" class="form-control" id="bukti_tf2" name="bukti_tf2" onchange="previewImage(this, '#imagePreview')">
                            </div>
                            <div class="form-group">
                                <label for="bayar2">Bayar2</label>
                                <input type="number" class="form-control" id="bayar2" name="bayar2" placeholder="bayar2" value="<?= $data['bayar2']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="sisa">Sisa</label>
                                <input type="number" class="form-control" id="sisa" name="sisa" disabled placeholder="sisa" value="<?= $data['sisa']; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?= base_url($link); ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_acara">Nama Acara</label>
                                <input type="text" class="form-control" id="nama_acara" name="nama_acara" placeholder="nama_acara" value="<?= $data['nama_acara']; ?>">
                            </div>
                            <?= form_error('nama_acara', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="tanggal_acara">Tanggal Acara</label>
                                <input type="date" class="form-control" id="tanggal_acara" name="tanggal_acara" placeholder="tanggal_acara" value="<?= $data['tanggal_acara']; ?>">
                            </div>
                            <?= form_error('tanggal_acara', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="waktu_mulai">Waktu Mulai</label>
                                <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" placeholder="waktu_mulai" value="<?= $data['waktu_mulai']; ?>">
                            </div>
                            <?= form_error('waktu_mulai', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="domisili">Domisili</label>
                                <input type="text" class="form-control" id="domisili" name="domisili" placeholder="domisili" value="<?= $data['domisili']; ?>">
                            </div>
                            <?= form_error('domisili', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="alamat"><?= $data['alamat']; ?></textarea>
                            </div>
                            <?= form_error('alamat', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>
                            <div class="form-group">
                                <label for="catatan_patner">Catatan Patner</label>
                                <textarea type="text" class="form-control" id="catatan_patner" name="catatan_patner" placeholder="catatan_patner"><?= $data['catatan_patner']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="is_dp">Bayar di muka(DP) <input type="checkbox" <?= ($data['is_dp'] == 1) ? 'checked' : ''; ?> name="is_dp" value="1"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </div>
</section>