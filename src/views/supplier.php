<?php
    require 'src/views/component/header.php';
?>
<div class="container">
    <table class="table" style="border-top: #CD853F 4px solid;">
        <thead class="thead">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Supplier</th>
            <th scope="col">Merk</th>
            <th scope="col">Kontak</th>
            <th scope="col"><a type="button" class="btn btn-sm ml-2" onclick="modalSupplier()" style="background-color: #CD853F"><i class="fa fa-plus" style="color: #fff"></i></a></th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1;
        foreach ($supplier as $datasupplier) { ?>
            <tr>
                <th scope="row"><?php echo $no; ?></th>
                <td><?php echo $datasupplier['supplier_motor_nama']; ?></td>
                <td><?php echo $datasupplier['supplier_motor_merk']; ?></td>
                <td><?php echo $datasupplier['supplier_motor_kontak']; ?></td>
                <td>
                    <a href="javascript:void(0)" onclick="editSupplier('<?php echo $datasupplier['supplier_motor_id'] ?>')" class="btn btn-sm bg-warning" title="Edit"><i class="fa fa-pencil" style="color: #fff"></i></a>
                    <a href="processsupplier.php?do=delete&id=<?php echo $datasupplier['supplier_motor_id'] ?>" class="btn btn-sm bg-danger" title="Hapus!"><i class="fa fa-trash" style="color: #fff"></i></a>
                </td>
            </tr>
            <?php $no++;
        } ?>
        </tbody>
    </table>
</div>

<div class="footer">
    <p align="center">&copy; TOKO KODRATT</p>
</div>

<div class="modal" id="form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="form_supplier_title">Tambah Supplier</h5>
                <button type="button" class="close" onclick="closeModal('form')">×</button>
            </div>
            <div class="modal-body">
                <form action="processsupplier.php?do=" id="proses_form_supplier" method="POST">
                    <div class="form-group">
                        <label for="supplier_motor_nama">Nama Supplier</label>
                        <input type="text" class="form-control" placeholder="Nama Supplier" id="supplier_motor_nama" name="supplier_motor_nama">
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_merk">Merk</label>
                        <input type="text" class="form-control" placeholder="Merk Supplier" id="supplier_motor_merk" name="supplier_motor_merk">
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_kontak">Kontak</label>
                        <input type="text" class="form-control" placeholder="Kontak Supplier" id="supplier_motor_kontak" name="supplier_motor_kontak">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('form')">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

<script>
    document.getElementById("form_supplier_title").addEventListener('submit', (event) => {
        const formOrder = document.getElementById('form_order').value;
        event.target.action += formOrder.includes('Edit') ? 'edit' : 'add';
        console.log(event.target.action);
    });
</script>

</html>