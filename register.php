<?php
require('koneksi.php');
session_start();
 
$error = '';
$validate = '';
if( isset($_POST['submit']) ){
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $nama     = stripslashes($_POST['nama']);
        $nama     = mysqli_real_escape_string($con, $nama);
        $alamat    = stripslashes($_POST['alamat']);
        $alamat    = mysqli_real_escape_string($con, $alamat);
        $no_hp    = stripslashes($_POST['no_hp']);
        $no_hp    = mysqli_real_escape_string($con, $no_hp);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $repass   = stripslashes($_POST['repassword']);
        $repass   = mysqli_real_escape_string($con, $repass);
        if(!empty(trim($nama)) && !empty(trim($username)) && !empty(trim($alamat)) && !empty(trim($no_hp)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))){
            if($password == $repass){
                if( cek_nama($nama,$con) == 0 ){
                    $pass  = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO tbl_user(nama, username, password, email, alamat, no_hp) VALUES ('$nama','$username','$pass','$email', '$alamat', '$no_hp')";
                    $result   = mysqli_query($con, $query);
                    if ($result) {
                        $_SESSION['username'] = $username;
        
                        echo "
                            <script> 
                            alert('Registrasi Berhasil !!');
                            document.location.href = 'index.php';
                            </script>
                            ";

                    } else {
                        $error =  'Register User Gagal !!';
                    }
                }else{
                        $error =  'Username sudah terdaftar !!';
                }
            }else{
                $validate = 'Password tidak sama !!';
            }
             
        }else {
            $error =  'Data tidak boleh kosong !!';
            
        }
    } 
    function cek_nama($username,$con){
        $nama = mysqli_real_escape_string($con, $username);
        $query = "SELECT * FROM users WHERE username = '$nama'";
        if( $result = mysqli_query($con, $query) ) return mysqli_num_rows($result);
    }
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <title>Register</title>
</head>

<body>
    <div class="vertical-center">
        <div class="container m-auto">
            <div class="card" style="border-radius: 20px;">
                <div class="row">
                    <div class="col-lg-6 col-md-12 ">
                        <h1 class="header-text">Register</h1>
                        <h4 class="secondary-text">Pepustakaan Daerah</h4>
                        <form action="register.php" method = "POST">
                            <?php if($error != ''){ ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"><?= $error; ?> <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button></div>
                            <?php } ?>
                            <div class="mb-2 form-group">
                                <label >Nama Lengkap</label>
                                <input type="text" class="form-control" name = "nama" id=""
                                    placeholder="Nama Lengkap" required>
                            </div>
                            <div class="mb-2 form-group">
                                <label for="" class="form-label">Username</label>
                                <input type="text" class="form-control" name = "username" id=""
                                    placeholder="Username">
                            </div>
                            <div class="mb-2 form-group">
                                <label for="" class="form-label">Nomer Hp</label>
                                <input type="number" class="form-control" name = "no_hp" id=""
                                    placeholder="Nomer Hp">
                            </div>
                            <div class="mb-2 form-group">
                                <label for="" class="form-label">Password</label>
                                <input type="password" class="form-control" name = "password" id=""
                                    placeholder="Nomer Hp">
                            </div>
                            <div class="form-group">
                                <label for="InputPassword">Re-Password</label>
                                <input type="password" class="form-control" id="InputRePassword" name="repassword" placeholder="Re-Password">
                                <?php if($validate != '') {?>
                                    <p class="text-danger"><?= $validate; ?></p>
                                <?php }?>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="exampleFormControlInput1" class="form-label">Alamat</label>
                                <textarea name="alamat" id="" class = "form-control" cols="30" rows="10"></textarea>
                                <p> Sudah Punya Account? <a href="login.php">Login</a></p>
                            </div>
                            <div class="mb-2 form-group">
                                <button type="submit" name = "submit" class="btn mb-3">Register</button>
                            </div>    
                        </form>
                        </div>
                        <div class="col-lg-6 col-md-12 mt-5 pt-5">
                            <img class="img-cover" src="gambar/login.jpg" alt="">
                        </div>
                        
                       

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous">
    </script>
</body>

</html>