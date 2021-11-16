<?php
    session_start(); 
    if(session_destroy()) {
        echo "<script> 
        alert('Anda Berhasil Logout !!');
        document.location.href = 'dashboard.php';
        </script> ";
    }
?>