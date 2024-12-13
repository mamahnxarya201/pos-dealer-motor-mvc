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
        /**
         * @var $supplier \Model\Supplier
         */
        foreach ($listSupplier as $supplier) { ?>
            <tr>
                <th scope="row"><?php echo $no; ?></th>
                <td><?php echo $supplier->nama; ?></td>
                <td><?php echo $supplier->merk; ?></td>
                <td><?php echo $supplier->kontak; ?></td>
                <td>
                    <a href="javascript:void(0)" onclick="editSupplier('<?php echo $supplier->id ?>')" class="btn btn-sm bg-warning" title="Edit"><i class="fa fa-pencil" style="color: #fff"></i></a>
                    <a href="javascript:void(0)" onclick="deleteSupplier('<?php echo $supplier->id ?>')" class="btn btn-sm bg-danger" title="Hapus!">
                        <i class="fa fa-trash" style="color: #fff"></i>
                    </a>
                </td>
            </tr>
            <?php $no++;
        } ?>
        </tbody>
    </table>
</div>

<div class="footer">
    <p align="center">&copy; DEALER PEDA HEREK CAK MUJI</p>
</div>

<div class="modal" id="form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="form_supplier_title">Tambah Supplier</h5>
                <button type="button" class="close" onclick="closeModal('form')">×</button>
            </div>
            <div class="modal-body">
                <form id="proses_form_supplier">
                    <div class="form-group" style="display: none">
                        <input type="text" class="form-control" placeholder="id Supplier" id="supplier_motor_id" name="supplier_motor_id" required>
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_nama">Nama Supplier</label>
                        <input type="text" class="form-control" placeholder="Nama Supplier" id="supplier_motor_nama" name="supplier_motor_nama" required>
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_merk">Merk</label>
                        <input type="text" class="form-control" placeholder="Merk Supplier" id="supplier_motor_merk" name="supplier_motor_merk" required>
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_kontak">Kontak</label>
                        <input type="text" class="form-control" placeholder="Kontak Supplier" id="supplier_motor_kontak" name="supplier_motor_kontak" required>
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
    document.getElementById('proses_form_supplier').addEventListener('submit', function(event) {
        event.preventDefault()

        let form = document.getElementById('proses_form_supplier');
        let formData = new FormData(form);
        let url = document.getElementById('form_supplier_title').textContent === 'Tambah Supplier'
            ? '/api/add_supplier'
            : '/api/edit_supplier';


        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    return response.json()
                } else {
                    throw new Error('Failed to add supplier')
                }
            })
            .then(data => {
                console.log('Success:', data)
                alert('Supplier updated successfully')
                window.location.reload()
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add supplier')
            })
    })

    function modalSupplier() {
        setForm('form', {
            supplier_motor_nama: '',
            supplier_motor_merk: '',
            supplier_motor_kontak: ''
        }, 'processsupplier.php?do=add');
        document.getElementById('form_supplier_title').textContent = 'Tambah Supplier'
    }

    async function editSupplier(id) {
        fetch(`/api/get_supplier?id=${id}`)
            .then(response => {
                if   (!response.ok) {
                    throw new Error('Error fetching supplier data')
                }
                return response.json()
            })
            .then(data => {
                console.log(data)
                if (data) {
                    console.log(data)
                    setForm('form', {
                        supplier_motor_id: data.id,
                        supplier_motor_nama: data.nama,
                        supplier_motor_merk: data.merk,
                        supplier_motor_kontak: data.kontak,
                    });
                    document.getElementById('form_supplier_title').textContent = 'Edit Supplier'
                }
            })
            .catch(error => {
                console.error('Error:', error)
                alert('Failed to fetch supplier data')
            });
    }

    function deleteSupplier(id) {
        fetch(`/api/delete_supplier?id=${id}`, {
            method: 'GET'
        })
            .then(response => {
                if (response.ok) {
                    window.location.reload()
                } else {
                    alert('The operation was not successful')
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('The operation was not successful')
            })
    }

</script>

</html>