<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Some styling -->
    <style>
        .dataTables_filter {
            text-align: right !important;
        }
    </style>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Mahasiswa</h1>
    </div>

    <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#add_modal"><i class="fas fa-user text-gray-400"></i> Tambah Data Mahasiswa</a>
    <a href="#" data-toggle="modal" data-target="#modal_upload" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-upload fa-sm text-white-50"></i> Import Data Mahasiswa</a>
    <br /><br />

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    Disini anda bisa mengatur / mengubah data mahasiswa untuk aplikasi ini<br /><br />

                    <table class="table" id="dataTable">
                        <thead>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Lengkap</th>
                            <th>Jurusan</th>
                            <th>Angkatan / Masuk pada</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </thead>    

                        <tbody>
                        <?php foreach ($list_mahasiswa as $key => $item_ma) { ?>

                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $item_ma['nim']; ?></td>
                            <td><?php echo $item_ma['nama_lengkap']; ?></td>
                            <td><?php echo $item_ma['jurusan']; ?></td>
                            <td><?php echo $item_ma['angkatan']; ?></td>
                            <td><?php if($item_ma['status'] == '0') { echo 'Sudah tidak kuliah/wisuda'; } else { echo 'Masih berkuliah'; } ?></td>
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
                                        <form method="post" action="<?php echo base_url(); ?>index.php/dashboard/data_mahasiswa_update" enctype="multipart/form-data">
                                            <div id="section-field">
                                                <input type="hidden" name="_data[id]" value="<?php echo $item_ma['id']; ?>" />

                                                <div class="form-group">
                                                    <label>NIM <font color="red">*</font></label>
                                                    <input type="text" name="_data[nim]" class="form-control" placeholder="" value="<?php echo $item_ma['nim']; ?>" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Nama Lengkap <font color="red">*</font></label>
                                                    <input type="text" name="_data[nama_lengkap]" class="form-control" placeholder="" value="<?php echo $item_ma['nama_lengkap']; ?>" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Jurusan <font color="red">*</font></label>
                                                    <input type="text" name="_data[jurusan]" class="form-control" placeholder="" value="<?php echo $item_ma['jurusan']; ?>" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Angkatan / Mendaftar pada <font color="red">*</font></label>
                                                    <input type="number" name="_data[angkatan]" class="form-control" placeholder="" value="<?php echo $item_ma['angkatan']; ?>" required />
                                                </div>

                                                <div class="form-group">
                                                    <label>Status Mahasiswa</label>
                                                    <select class="form-control" name="_data[status]" />
                                                        <option value="0" <?php $var = $item_ma['status'] == 0 ? "selected='selected'" : ""; echo $var; ?>>Sudah wisuda/tidak lagi berkuliah</option>
                                                        <option value="1" <?php $var = $item_ma['status'] == 1 ? "selected='selected'" : ""; echo $var; ?>>Masih Kuliah</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                        <!-- </form> -->
                                    </div>

                                    <div class="modal-footer">
                                        <a href="#" class="btn btn-secondary" type="button" data-dismiss="modal">Batal</a>
                                        <input type="submit" class="btn btn-info" value="Perbarui Data"></form>
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>     
    </div>
</div>

<?php foreach ($list_mahasiswa as $key => $item_ma) { ?>

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
                    <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/dashboard/data_mahasiswa_update?del_id=<?php echo $item_ma['id']; ?>">Hapus</a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<!-- Upload Modal-->
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="modal_upload" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_upload">Import data mahasiswa</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="<?php echo base_url(); ?>template/template.xls">Silahkan unduh templatenya disini</a><br /><br />
            
                <form method="post" action="<?php echo base_url(); ?>index.php/dashboard/import_mahasiswa" enctype="multipart/form-data">
                    <input type="file" name="data" /> <span class="small">*Maksimal ukuran file 8MB</span>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-secondary" type="button" data-dismiss="modal">Batal</a>
                <input type="submit" class="btn btn-info" value="Import"></form>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal-->
<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="add_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_modal">Tambah data mahasiswa</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo base_url(); ?>index.php/dashboard/data_mahasiswa_update" enctype="multipart/form-data">
                    <div id="section-field">
                        <input type="hidden" name="data[id]" value="0" />

                        <div class="form-group">
                            <label>NIM <font color="red">*</font></label>
                            <input type="text" name="data[nim]" class="form-control" placeholder="" required />
                        </div>

                        <div class="form-group">
                            <label>Nama Lengkap <font color="red">*</font></label>
                            <input type="text" name="data[nama_lengkap]" class="form-control" placeholder="" required />
                        </div>

                        <div class="form-group">
                            <label>Jurusan <font color="red">*</font></label>
                            <input type="text" name="data[jurusan]" class="form-control" placeholder="" required />
                        </div>

                        <div class="form-group">
                            <label>Angkatan / Mendaftar pada <font color="red">*</font></label>
                            <input type="number" name="data[angkatan]" class="form-control" placeholder="" required />
                        </div>

                        <div class="form-group">
                            <label>Status Mahasiswa</label>
                            <select class="form-control" name="data[status]" />
                                <option "">-- Pilih Status Mahasiswa --</option>
                                <option value="0">Sudah wisuda/tidak lagi berkuliah</option>
                                <option value="1">Masih Kuliah</option>
                            </select>
                        </div>   
                    </div>
                <!-- </form> -->
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-secondary" type="button" data-dismiss="modal">Batal</a>
                <input type="submit" value="Tambah Data Mahasiswa" class="btn btn-md btn-info" /></form>
            </div>
        </div>
    </div>
</div>

<div id="clearfix">
    <br /><br />
</div>

