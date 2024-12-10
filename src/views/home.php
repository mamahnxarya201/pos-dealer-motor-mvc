<?php
    require 'src/views/component/header.php';
?>
<div class="container">
    <div class="card-group">
        <div class="card">
            <img class="card-img-top" src="/src/views/resources/img/archive.png" alt="Card image cap" style="max-width: 150px; margin: auto; margin-top:20px;">
            <div class="card-body">
                <h5 class="card-title" align="center">Stock Motor</h5>
                <p class="card-text">Menu ini berisi daftar motor dan menu CRUD motor. Total motor yang saat ini ada yaitu <b><?php echo $banyakmotor; ?> motor</b></p>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="/src/views/resources/img/boy.png" alt="Card image cap" style="max-width: 150px; margin: auto; margin-top:20px;">
            <div class="card-body">
                <h5 class="card-title" align="center">Supplier Motor</h5>
                <p class="card-text">Menu ini berisi daftar supplier dan menu CRUD supplier. Banyak supplier yang sudah terdaftar yaitu <b><?php echo $banyaksupplier; ?> Supplier</b></p>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="/src/views/resources/img/trolley2.png" alt="Card image cap" style="max-width: 150px; margin: auto; margin-top:20px;">
            <div class="card-body">
                <h5 class="card-title" align="center">Order motor</h5>
                <p class="card-text">Menu ini adalah menu mutasi dimana data keluarnya motor dicatat. Total mutasi yang sudah dilakukan yaitu <b><?php echo $banyakmutasi; ?> kali mutasi</b></p>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid  fixed-bottom bg-light" style=" color: #999;">
    <div class="row">
        <div class="col-sm-12">
            <p align="center">&copy; TOKO KODRATT</p>
        </div>
    </div>
</div>

</body>
</html>