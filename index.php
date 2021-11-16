<?php

require('koneksi.php');
session_start();

if( !isset($_SESSION['username']) ){
  $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
  header('Location: login.php');
}

include('header.php');
include('navbar.php');
?>
<div class="container">
    <h4 class="header-text">Daftar Siswa</h4>
    <table class="table table-striped table-hover">
        <thead style="background-color: #717FFB; color: white;">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Alamat</th>
                <th>Nomer Hp</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql = mysqli_query($con, "SELECT * FROM tbl_user");
            while ($dt = mysqli_fetch_array($sql)) { ?>
                <tr>
                    <td><?= $no++?></td>
                    <td><?= $dt['nama']?></td>
                    <td><?= $dt['username']?></td>
                    <td><?= $dt['alamat']?></td>
                    <td><?= $dt['no_hp']?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include('footer.php')?>