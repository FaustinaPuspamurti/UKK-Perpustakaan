<?php
require('koneksi.php');
session_start();
 
$error = '';
$validate = '';
if( isset($_SESSION['username']) ) header('Location: index.php');
if( isset($_POST['submit']) ){
        
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($con, $password);
        
        if(!empty(trim($username)) && !empty(trim($password))){
 
            $query      = "SELECT * FROM tbl_user WHERE username = '$username'";
            $result     = mysqli_query($con, $query);
            $rows       = mysqli_num_rows($result);
 
            if ($rows != 0) {
                $hash   = mysqli_fetch_assoc($result)['password'];
                if(password_verify($password, $hash)){

                    $_SESSION['username'] = $username;
                    echo "
                    <script> 
                    alert('Login Berhasil!!');
                    document.location.href = 'index.php';
                    </script>
                    ";
                }
            } else {
                $error =  'Username dan password Salah !!';
            }
             
        }else {
            $error =  'Data tidak boleh kosong !!';
        }
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

    <title>Login</title>
</head>

<body>
    <div class="vertical-center">
        <div class="container m-auto">
            <div class="card" style="border-radius: 20px;">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <img class="img-cover" src="gambar/login.jpg" alt="">
                    </div>
                    <div class="col-lg-6 col-md-12 p-5">
                        <h1 class="header-text">Login</h1>
                        <h4 class="secondary-text">Perpustakaan Daerah</h4>
                        <form action="login.php" method="post">
                            <?php if($error != ''){ ?>
                                <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
                                    <?= $error; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php } ?>
                            <?php if(isset($_SESSION['msg'])){ ?>
                                <div class="alert alert-danger alert-dismissible" role="alert" id="liveAlert">
                                    Anda Belumm Login !!!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php } ?>
                           
                            <div class="mb-2">
                                <label for="exampleFormControlInput1" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="exampleFormControlInput1"
                                    placeholder="Username">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Password</label>
                                <input type="password" class="form-control"name="password" id="exampleFormControlInput1"
                                    placeholder="Password">
                                    <br>
                                <p> Belum Punya Account? <a href="register.php">Buat Akun</a></p>
                            </div>
                            <div class="mb-2">
                                <button type="submit" name="submit" class="btn mb-3">Login</button>
                            </div>
                        </form>
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