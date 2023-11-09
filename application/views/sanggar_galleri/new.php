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
                                <label for="image">Image</label>
                                <div id="imagePreview">
                                    <img class="rounded-circle img-thumbnail d-block mb-2" width="120" src="<?= base_url(); ?>assets/uploads/galleri/default.jpg" alt="">

                                </div>
                                <input type="file" class="form-control" id="image" name="image" onchange="previewImage(this, '#imagePreview')">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?= base_url($link . '/' . $id_sanggar); ?>" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>