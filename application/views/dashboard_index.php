<?php error_reporting(0); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->
<div class="row">
  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Hari Ini Tanggal</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo date("d/m/y"); ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-6 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Data Mahasiswa</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_mahasiswa; ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Column -->
  <div class="col-xl-6 col-md-6 mb-4">

    <!-- Project Card Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Statistik Jumlah Total Mahasiswa Beberapa Tahun Terakhir</h6>
      </div>
      <div class="card-body">
        <?php 
          foreach ($list_mahasiswa as $key => $item) { 
            $total__[] = $item['total_mahasiswa_by_tahun'];
          }

          $total_mahasiswa_per_5_tahun = array_sum($total__);

          foreach ($list_mahasiswa as $key => $item) {
        ?>
            <?php
                $input = array("bg-danger", "bg-info", "bg-primary", "bg-warning", "bg-success", "bg-danger", "bg-info", "bg-primary", "bg-warning", "bg-success", "bg-danger", "bg-info", "bg-primary", "bg-warning", "bg-success");
                $rand_keys = array_rand($input, 2);
                
                $val = $_SESSION['colour'][$key];

                if (empty($val)) {
                    $_SESSION['colour'][$key] = $input[$rand_keys[0]]; 
                }
            ?>
            <h4 class="small font-weight-bold"><?php echo $item['angkatan']; ?></h4>
            <div class="progress mb-4">
            <div 
                class="progress-bar <?php echo $_SESSION['colour'][$key]; ?>"
                role="progressbar" 
                style="width: <?php echo round($item['total_mahasiswa_by_tahun'] / $total_mahasiswa_per_5_tahun * 100, 0); ?>%" 
                aria-valuenow="20" 
                aria-valuemin="0" 
                aria-valuemax="100">
            </div>
            </div>
        <?php } ?>
      </div>
    </div>

    <!-- Color System -->
    <div class="row">
    <?php foreach ($list_mahasiswa as $key => $item) { ?>
      <div class="col-lg-6 mb-4">
        <div class="card <?php echo $_SESSION['colour'][$key]; ?> text-white shadow">
          <div class="card-body">
          <?php echo $item['angkatan']; ?>
            <div class="text-white-50 small"><?php echo $item['total_mahasiswa_by_tahun']; ?> mahasiswa</div>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>

  </div>

  <div class="col-xl-6 col-md-6 mb-4">

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Tentang Aplikasi</h6>
      </div>
      <div class="card-body">
        
        <strong>Nama Aplikasi</strong><br />
        <?php echo $pengaturan['nama_aplikasi']; ?>

        <br /><br /><!-- clearfix -->

        <strong>Deskripsi Aplikasi</strong><br />
        <?php echo $pengaturan['intro_aplikasi']; ?><br /><a href="#" data-toggle="modal" data-target="#deskripsi_aplikasi">Lihat Lebih Lanjut</a>

        <br /><br /><!-- clearfix -->

        <strong>Pembuat Aplikasi</strong><br />
        <?php echo $pengaturan['pembuat_aplikasi']; ?>

        <br /><br /><!-- clearfix -->        
      </div>
    </div>

  </div>
</div>

</div>

<!-- Deskripsi Aplikasi Modal-->
<div class="modal fade" id="deskripsi_aplikasi" tabindex="-1" role="dialog" aria-labelledby="deskripsi_aplikasi" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deskripsi_aplikasi">Deskripsi Aplikasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><?php echo $pengaturan['deskripsi_aplikasi']; ?></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div id="clearfix">
    <br /><br />
</div>

