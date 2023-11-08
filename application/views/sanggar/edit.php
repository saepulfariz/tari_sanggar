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
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        Edit <?= $title; ?>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url($link . '/' . $data['id']); ?>" method="post" enctype="multipart/form-data">
                            <input type='hidden' name='_method' value='PUT' />

                            <div class="form-group">
                                <label for="nama_sanggar">Nama sanggar</label>
                                <input type="text" class="form-control" id="nama_sanggar" name="nama_sanggar" placeholder="Nama sanggar" value="<?= $data['nama_sanggar']; ?>">
                            </div>
                            <?= form_error('nama_sanggar', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                            <div class="form-group">
                                <label for="lokasi_sanggar">Lokasi Sanggar</label>
                                <textarea type="text" class="form-control" id="lokasi_sanggar" name="lokasi_sanggar" placeholder="lokasi sanggar"><?= $data['lokasi_sanggar']; ?></textarea>
                            </div>
                            <?= form_error('lokasi_sanggar', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                            <div class="form-group">
                                <label for="tentang_sanggar">Tentang Sanggar</label>
                                <textarea type="text" class="form-control" id="tentang_sanggar" name="tentang_sanggar" placeholder="tentang sanggar"><?= $data['tentang_sanggar']; ?></textarea>
                            </div>
                            <?= form_error('tentang_sanggar', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>


                            <div class="form-group">
                                <label for="no_rek">No Rek</label>
                                <input type="text" class="form-control" id="no_rek" name="no_rek" placeholder="no rek" value="<?= $data['no_rek']; ?>">
                            </div>
                            <?= form_error('no_rek', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?= base_url($link); ?>" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>