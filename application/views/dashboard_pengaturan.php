<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan</h1>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    Disini anda bisa mengatur / mengubah aplikasi anda sendiri<br /><br />
 
                    <form method="post" action="<?php echo base_url(); ?>index.php/dashboard/pengaturan_update">
                        <div id="section-field">
                            <div class="form-group">
                                <label>Nama Aplikasi</label>
                                <input type="text" name="data[nama_aplikasi]" class="form-control" placeholder="Nama Aplikasi" value="<?php echo $pengaturan['nama_aplikasi']; ?>" required />
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Aplikasi</label>
                                <textarea name="data[deskripsi_aplikasi]" class="form-control" required /><?php echo $pengaturan['deskripsi_aplikasi']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Intro Aplikasi</label>
                                <input type="text" name="data[intro_aplikasi]" class="form-control" placeholder="Intro Aplikasi" value="<?php echo $pengaturan['intro_aplikasi']; ?>" required />
                            </div>

                            <div class="form-group">
                                <label>Pembuat Aplikasi</label>
                                <input type="text" name="data[pembuat_aplikasi]" class="form-control" placeholder="Pembuat Aplikasi" value="<?php echo $pengaturan['pembuat_aplikasi']; ?>" required />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" value="Update" class="btn btn-md btn-info" />
                        </div>
                    </form>

                    <br /><br />

                </div>
            </div>
        </div>
    </div>
</div>

<div id="clearfix">
    <br /><br />
</div>