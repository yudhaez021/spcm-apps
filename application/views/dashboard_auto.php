<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Alat Canggih</h1>
    </div>

    <div class="row">
    <?php 
            error_reporting(0);
            $status = !empty($_SESSION['status']) ? $_SESSION['status'] : '';
            if ($status) { 
                $array_end_ = end(array_keys($_SESSION['data']));
    ?>

        <div class="col-xl-6 col-md-6 mb-6">
            <div class="card border-left-primary py-2">
                <div class="card-body">
                    <h3>Moving Average</h3>
                    <table class="table">
                        <thead>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                        </thead>
                       
                        <tbody id="mov_avg_">
                            <tr>
                                <td>f<?php echo $_SESSION['data'][$array_end_ - 2]['no']; ?></td>
                                <td><?php echo $_SESSION['data'][$array_end_ - 2]['tahun_angkatan']; ?></td>
                                <td><?php echo $_SESSION['data'][$array_end_ - 2]['Yt']; ?></td>
                            </tr>

                            <tr>
                                <td>f<?php echo $_SESSION['data'][$array_end_ - 1]['no']; ?></td>
                                <td><?php echo $_SESSION['data'][$array_end_ - 1]['tahun_angkatan']; ?></td>
                                <td><?php echo $_SESSION['data'][$array_end_ - 1]['Yt']; ?></td>
                            </tr>

                            <tr>
                                <td>f<?php echo $_SESSION['data'][$array_end_]['no']; ?></td>
                                <td><?php echo $_SESSION['data'][$array_end_]['tahun_angkatan']; ?></td>
                                <td><?php echo $_SESSION['data'][$array_end_]['Yt']; ?></td>
                            </tr>

                            <tr>
                                <td>f<?php echo $_SESSION['data'][$array_end_]['no'] + 1; ?></td>
                                <td><?php echo $_SESSION['data'][$array_end_]['tahun_angkatan'] + 1; ?></td>
                                <td><?php echo $_SESSION['moving_average']; ?></td>
                            </tr>
                        </tbody>

                    </table>

                    <?php 
                        foreach ($_SESSION['mov_2'] as $item) {
                            $array_end = end(array_keys($_SESSION['data']));
                            
                            if($item['res'] && $item['no'] <= $_SESSION['data'][$array_end]['no']) { 
                                $rma[] = $item['rma'];
                                $res[] = $item['res'];
                            }
                        }
                    ?>

                    Ramalan pada tahun <?php echo $_SESSION['final_tahun_angkatan']; ?> menggunakan metode Moving Average adalah: <?php echo $_SESSION['moving_average']; ?><br />
                    MSE Ramalan Moving Average adalah: <?php echo round(array_sum($rma) / (count($rma) + 1), 5); ?>

                    <br /><br />
                    <form method="post" action="<?php echo base_url(); ?>index.php/dashboard/count">
                        <input type="hidden" value="C" name="validation" />
                        
                        <div class="form-group">
                            <label>Konstanta saat ini</label>
                            <input type="text" value="<?php echo $_SESSION['data'][0]['a']; ?>" name="a" class="form-control" />
                        </div>
                        <a class="btn btn-success btn-md" href="<?php echo base_url(); ?>index.php/dashboard/reset/">Ulangi Perhitungan</a>
                        <input type="submit" value="Merubah Konstanta" class="btn btn-info btn-md" />
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-6">
            <div class="card border-left-primary py-2">
                <div class="card-body">
                    <h3>Exponential Smoothing</h3>
                    <table class="table">
                        <thead>
                            <th>No</th>
                            <th>a</th>
                            <th>Yt</th>
                            <th>a x Yt</th>
                            <th>1-a</th>
                            <th>Ft</th>
                            <th>n+Ft</th>
                        </thead>
                        <?php
                            foreach ($_SESSION['data'] as $item) {
                        ?>
                        
                        <?php if($item['Yt']) { ?>

                        <tr>
                            <td>f<?php echo $item['no']; ?></td>
                            <td><?php echo $item['a']; ?></td>
                            <td><?php echo $item['Yt']; ?></td>
                            <td><?php echo $item['axYt']; ?></td>
                            <td><?php echo $item['1-a']; ?></td>
                            <td><?php echo $item['Ft']; ?></td>
                            <td><?php echo $item['nFt']; ?></td>
                        </tr>

                        <?php } ?>

                        
                        <?php 
                            }
                        ?>
                    </table>
                    Ramalan pada tahun <?php echo $_SESSION['final_tahun_angkatan']; ?> menggunakan metode Exponential Smoothing adalah: <?php echo $_SESSION['final_exponential']; ?><br />
                    MSE Ramalan Moving Average adalah: <?php echo round(array_sum($res) / (count($res) + 1), 5); ?>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-6" style="color: transparent;">.</div>

        <?php } ?>
    
        <div class="col-xl-6 col-md-6 mb-6">
            <?php if($status) { ?><br /><br /><?php } ?>
            <div class="card border-left-primary shadow py-2">
                <div class="card-body">
                    Disini anda bisa menghitung perkiraan calon mahasiswa yang akan datang dengan metode Exponential Smoothing & Moving Average berdasarkan data yang ada di database<br /><br />

                    <?php
                    error_reporting(0);
                    $status = !empty($_SESSION['status']) ? $_SESSION['status'] : '';

                    if (empty($status)) {

                    ?>

                    <form method="post" action="<?php echo base_url(); ?>index.php/dashboard/res_auto_count">
                        <div id="section-field">
                            <div class="form-group">
                                <label>Dari Tahun</label>
                                <select name="dari_tahun" class="form-control" required>
                                    <option value="">-- Silahkan pilih tahun --</option>
                                    <?php foreach ($tahun as $item) { ?>
                                    <option value="<?php echo $item['angkatan']; ?>"><?php echo $item['angkatan']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Sampai Tahun</label>
                                <select name="sampai_tahun" class="form-control" required>
                                    <option value="">-- Silahkan pilih tahun --</option>
                                    <?php foreach ($tahun as $item) { ?>
                                    <option value="<?php echo $item['angkatan']; ?>"><?php echo $item['angkatan']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" value="Kirim" class="btn btn-md btn-info" />
                        </div>
                    </form>
                    
                    <?php } else { ?>
                        Berikut adalah data yang sudah anda kirim:<br /><br />
                        <?php foreach ($_SESSION['data'] as $key => $item) { ?>
                            <div class="form-group">
                                <label>Tahun <?php echo $item['tahun_angkatan']; ?></label>
                                <input type="text" name="tahun[]" class="form-control" value="<?php echo $item['Yt']; ?>" disabled />
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="clearfix">
    <br /><br />
</div>

<?php
if ($status) {

    $tahun_angkatan = !empty($_SESSION['final_tahun_angkatan']) ? $_SESSION['final_tahun_angkatan'] : '';
    $fields = !empty($_SESSION['field_total']) ? $_SESSION['field_total'] : '';

    // unset session after submitting data
    unset($_SESSION['data'],  $_SESSION['mov_1'],  $_SESSION['mov_2'], $_SESSION['status'],  $_SESSION['final_exponential'],  $_SESSION['moving_average'], $tahun_angkatan, $fields);

}
?>