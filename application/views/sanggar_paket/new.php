<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">New <?= $title; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                    <li class="breadcrumb-item">Kelola <?= $title; ?></li>
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
                        New <?= $title; ?>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url($link); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_sanggar" value="<?= $id_sanggar; ?>">
                            <div class="form-group">
                                <label for="nama_paket">Nama paket</label>
                                <input type="text" class="form-control" id="nama_paket" name="nama_paket" placeholder="Nama paket" value="<?= set_value('nama_paket'); ?>">
                            </div>
                            <?= form_error('nama_paket', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                            <div class="form-group">
                                <label for="keterangan_paket">Keterangan Paket</label>
                                <textarea type="text" class="form-control" id="keterangan_paket" name="keterangan_paket" placeholder="Keterangan Paket"><?= set_value('keterangan_paket'); ?></textarea>
                            </div>
                            <?= form_error('keterangan_paket', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>



                            <div class="form-group">
                                <label for="harga_paket">Harga Paket</label>
                                <input type="number" class="form-control" id="harga_paket" name="harga_paket" placeholder="no rek" value="<?= set_value('harga_paket'); ?>">
                            </div>
                            <?= form_error('harga_paket', '<div class="error text-danger mb-2" style="margin-top: -15px">', '</div>'); ?>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?= base_url($link . '/' . $id_sanggar); ?>" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>