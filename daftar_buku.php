<?php

require('koneksi.php');
session_start();



if( !isset($_SESSION['username']) ){
  $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
  header('Location: login.php');
}

if(isset($_POST['simpan'])){
    $judul =  $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $gambar  = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    
    $path = "gambar/".$gambar;

    // Proses upload
    if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
        // Proses simpan ke Database
        $query = "INSERT INTO `tbl_buku` (`judul`, `pengarang`, `penerbit`, `gambar`) VALUES ('".$judul."', '".$pengarang."', '".$penerbit."', '".$gambar."');";
   
        $sql = mysqli_query($con, $query); // Eksekusi/ Jalankan query dari variabel $query
        if($sql){ // Cek jika proses simpan ke database sukses atau tidak
        // Jika Sukses, Lakukan :
            echo "<script> 
                    alert('Data berhasil Di Tambahkan!');
                    document.location.href = 'daftar_buku.php';
                </script>
            ";
        }else{
        // Jika Gagal, Lakukan :
        echo "<script> 
                    alert('Gagal ditambahkan dalam database!');
                    document.location.href = 'daftar_buku.php';
                </script>
            ";
        }
    }else{
        // Jika gambar gagal diupload, Lakukan :
        echo "<script> 
                alert('Gagal di upload!');
                document.location.href = 'daftar_buku.php';
            </script>
        ";
    }
}


if(isset($_POST['ubah'])){
    $id_buku = $_POST['id_buku'];
    $judul =  $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];

    $date = date('Y-m-d H:i:s');

    // Proses upl
    $query = "UPDATE `tbl_buku` SET `judul`='".$judul."',`pengarang`='".$pengarang."',`penerbit`='".$penerbit."', `update_at` = '".$date."' WHERE id_buku = '".$id_buku."'";

    $sql = mysqli_query($con, $query); 
    // Eksekusi/ Jalankan query dari variabel $query
    if($sql){ // Cek jika proses simpan ke database sukses atau tidak
    // Jika Sukses, Lakukan :
        echo "<script> 
                alert('Data berhasil Di Ubah!');
                document.location.href = 'daftar_buku.php';
            </script>
        ";
    }else{
    // Jika Gagal, Lakukan :
    echo "<script> 
                alert('Gagal ditambahkan dalam database!');
                document.location.href = 'daftar_buku.php';
            </script>
        ";
    }
}


if(isset($_POST['hapus'])){
    $id_buku = $_POST['id_buku'];
    // Proses upl
    $query = "DELETE FROM `tbl_buku` WHERE id_buku = '".$id_buku."'";

    $sql = mysqli_query($con, $query); 
    // Eksekusi/ Jalankan query dari variabel $query
    if($sql){ // Cek jika proses simpan ke database sukses atau tidak
    // Jika Sukses, Lakukan :
        echo "<script> 
                alert('Data berhasil Di Hapus!');
                document.location.href = 'daftar_buku.php';
            </script>
        ";
    }else{
    // Jika Gagal, Lakukan :
    echo "<script> 
                alert('Gagal ditambahkan dalam database!');
                document.location.href = 'daftar_buku.php';
            </script>
        ";
    }
}

if(isset($_GET['cari'])){
	$cari = $_GET['cari'];
}

include('header.php');
include('navbar.php');
?>

<style>
    .card{
        height : 100%;
    }
</style>
<div class="container">
    <center><h4 class="header-text mt-5 mb-5">Daftar Buku</h4></center>
    <div class="row">
        <div class="col-md-6">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Tambah Data
            </button>
        </div>
        <div class="col-md-6 text-right">
            <form action="daftar_buku.php" method="get">
                <label>Cari :</label>
                <input type="text" name="cari">
                <input type="submit" value="Cari">
            </form>
        </div>
    </div>
    
    
    <div class="row row-cols-1 row-cols-md-3 g-3 shadow mt-3 pt-4 pb-5">
        <?php 
        if(isset($_GET['cari'])){
            $cari = $_GET['cari'];
            $query = "SELECT * FROM tbl_buku where judul like '%".$cari."%'";				
        }else{
            $query = "SELECT * FROM tbl_buku";		
        }

        $sql = mysqli_query($con, $query);
        while ($dt = mysqli_fetch_array($sql)) {
        
        ?>
        <div class="col-md-3">
            <div class="card">
                <img
                    src="gambar/<?= $dt['gambar']?>"
                    class="card-img-top" width = "50%"
                    alt="..."
                />
                <div class="card-body shadow">
                    <h5 class="card-title"><?= $dt['judul']?></h5>
                    <p class="card-text pb-4">
                        Buku ini di karang oleh <?= $dt['pengarang']?> dan di terbitkan oleh <?= $dt['penerbit']?>
                    </p>
                </div>

                <div class="row">
                    <div class="col-md-6 text-center mt-2 mb-2">
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#update<?= $dt['id_buku']?>">
                            Ubah Data
                        </button>
               
                    </div>
                    <div class="col-md-6 text-center  mt-2 mb-2">
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $dt['id_buku']?>">
                        Hapus Data
                        </button>
                    </div>
                </div>
                <div class="modal" id="update<?= $dt['id_buku']?>">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">

                        <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Ubah Data</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                        <!-- Modal body -->
                            <form action="daftar_buku.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input name="id_buku" value="<?php echo $dt['id_buku']; ?>" hidden />
                                    <div class="form-group">
                                        <label for="">Judul</label>
                                        <input class="form-control" type="text" name="judul" autofocus="" required="" value="<?php echo $dt['judul'];?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Pengarang</label>
                                        <input class="form-control" type="text" name="pengarang" required="" value="<?php echo $dt['pengarang'];?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="">Penerbit</label>
                                        <input class="form-control" type="text" name="penerbit" required="" required="" value="<?php echo $dt['penerbit'];?>" />
                                    </div>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <input type="submit" name = "ubah" class = "btn btn-primary" value = "Ubah">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal" id="hapus<?= $dt['id_buku']?>">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">


                        <!-- Modal body -->
                            <form action="daftar_buku.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">    
                                    <input type="hidden" name = "id_buku" class = "form-control" value = "<?= $dt['id_buku']?>">
                                    <h5>Apakah anda yakin untuk menghapus data ini??</h5>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <input type="submit" name = "hapus" class = "btn btn-primary" value = "Hapus">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<!-- Button to Open the Modal -->


<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <form action="daftar_buku.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">    
            <div class="form-group">
                <label for="">Judul</label>
                <input type="text" name="judul" class ="form-control" required>
            </div>
            <div class="form-group">
                <label for="">Pengarang</label>
                <input type="text" name="pengarang" class ="form-control" required>
            </div>
            <div class="form-group">
                <label for="">Penerbit</label>
                <input type="text" name="penerbit" class ="form-control" required>
            </div>
            <div class="form-group">
                <label for="">Gambar</label>
                <input type="file" name="gambar" class ="form-control" required>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <input type="submit" name = "simpan" class = "btn btn-primary" value = "Save">
        </div>
      </form>
    </div>
  </div>
</div>





<?php include('footer.php')?>