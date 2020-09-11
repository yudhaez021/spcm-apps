<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Akses</h1> <br />
        <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#add_modal">
            <i class="fas fa-plus text-gray-400"></i> Tambahkan User Hak Akses
        </a>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    Disini anda bisa mengatur / mengubah manajemen akses administrator untuk aplikasi ini<br /><br />

                    <table class="table">
                        <thead>
                            <th>No</th>
                            <th>Profil</th>
                            <th>Status</th>
                            <th>Ditambahkan Pada</th>
                            <th>Terakhir Login</th>
                            <th>Aksi</th>
                        </thead>    

                        <?php foreach ($list_ma as $key => $item_ma) { ?>

                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $item_ma['nama_lengkap']; ?> (@<?php echo $item_ma['username']; ?>)</td>
                            <td><?php if($item_ma['primary'] == '0') { echo 'Bukan utama'; } else { echo 'Utama'; } ?></td>
                            <td><?php echo $item_ma['added']; ?></td>
                            <td><?php if($item_ma['last_login']) { echo $item_ma['last_login']; } else { echo 'Tidak Pernah'; } ?></td>
                            <td><a href="#up=<?php echo $item_ma['id']; ?>" data-toggle="modal" data-target="#update_modal_<?php echo $item_ma['id']; ?>" class="btn btn-sm btn-info">Ubah</a> <br /> <a style="margin-top: 5px;" href="#del=<?php echo $item_ma['id']; ?>" data-toggle="modal" data-target="#del_modal_<?php echo $item_ma['id']; ?>" class="btn btn-sm btn-danger">Hapus</a></td>
                        </tr>

                        <!-- Update Data Modal-->
                        <div class="modal fade" id="update_modal_<?php echo $item_ma['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="update_modal_<?php echo $item_ma['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="update_modal_<?php echo $item_ma['id']; ?>">Perbarui Data</h5>
                                        
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form method="post" action="<?php echo base_url(); ?>index.php/dashboard/manajemen_akses_update" enctype="multipart/form-data">
                                            <div id="section-field">
                                                <input type="hidden" name="_data[id]" value="<?php echo $item_ma['id']; ?>" />

                                                <div class="form-group">
                                                    <label>Nama Lengkap <font color="red">*</font></label>
                                                    <input type="text" name="_data[nama_lengkap]" class="form-control" placeholder="" value="<?php echo $item_ma['nama_lengkap']; ?>" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Username <font color="red">*</font></label>
                                                    <input type="text" name="_data[username]" class="form-control" placeholder="" value="<?php echo $item_ma['username']; ?>" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Password <font color="red">*</font></label>
                                                    <input type="password" name="_data[password]" class="form-control" placeholder="" value="123456" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Foto saat ini</label><br />
                                                    <img src="<?php echo base_url(); ?>profile_imgs/<?php echo $item_ma['foto']; ?>" height="200px" width="200px" /><br /><br />

                                                    <label>Foto <span class="small">*Max 200kb</span></label><br />
                                                    <input type="file" name="foto" class="btn btn-md btn-primary" />

                                                    <!-- old foto from databse -->
                                                    <input type="hidden" name="_data[foto_old]" value="<?php echo $item_ma['foto']; ?>" />
                                                </div>

                                                <div class="form-group">
                                                    <label>Status Akun</label>
                                                    <select class="form-control" name="_data[primary]" />
                                                        <option value="0" <?php if ($item_ma['primary'] == 0) { echo " selected='selected' "; } ?>>Bukan Utama</option>
                                                        <option value="1" <?php if ($item_ma['primary'] == 1) { echo " selected='selected' "; } ?>>Utama</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                        <!-- </form> -->
                                    </div>

                                    <div class="modal-footer">
                                        <a href="#" class="btn btn-secondary" data-dismiss="modal">Batal</a>
                                        <input type="submit" class="btn btn-info" value="Perbarui Data"></form>
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>        
    </div>
</div>

<?php foreach ($list_ma as $key => $item_ma) { ?>

    <!-- Confirm Delete Modal-->
    <div class="modal fade" id="del_modal_<?php echo $item_ma['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="del_modal_<?php echo $item_ma['id']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="del_modal_<?php echo $item_ma['id']; ?>">Anda yakin ingin menghapus data ini?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Data yang sudah terhapus, tidak bisa dikembalikan lagi.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/dashboard/manajemen_akses_update?del_id=<?php echo $item_ma['id']; ?>&status=<?php if($item_ma['primary'] == '0') { echo 'BUKAN_UTAMA'; } else { echo 'UTAMA'; } ?>">Hapus</a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<!-- Add Data Modal -->
<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_modal">Tambahkan User Hak Akses</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url(); ?>index.php/dashboard/manajemen_akses_update" enctype="multipart/form-data">
                    <div id="section-field">
                        <input type="hidden" name="data[id]" value="0" />

                        <div class="form-group">
                            <label>Nama Lengkap <font color="red">*</font></label>
                            <input type="text" name="data[nama_lengkap]" class="form-control" placeholder="" required />
                        </div>

                        <div class="form-group">
                            <label>Username <font color="red">*</font></label>
                            <input type="text" name="data[username]" class="form-control" placeholder="" required />
                        </div>

                        <div class="form-group">
                            <label>Password <font color="red">*</font></label>
                            <input type="password" name="data[password]" class="form-control" placeholder="" required />
                        </div>

                        <div class="form-group">
                            <label>Foto <span class="small">*Max 200kb</span></label>
                            <input type="file" name="foto" class="btn btn-md btn-primary" />
                        </div>
                    </div>
                <!-- </form> -->
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-secondary" data-dismiss="modal">Batal</a>
                <input type="submit" value="Tambahkan User" class="btn btn-md btn-info" /></form>
            </div>
        </div>
    </div>
</div>

<div id="clearfix">
    <br /><br />
</div>

