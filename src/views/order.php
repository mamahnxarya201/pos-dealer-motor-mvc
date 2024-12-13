<?php
require 'src/views/component/header.php';
?>
<div class="container">
    <table class="table" style="border-top: #CD853F 4px solid;">
        <thead class="thead">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Motor</th>
            <th scope="col">Tipe Motor</th>
            <th scope="col">Jumlah Motor</th>
            <th scope="col">Harga Motor</th>
            <th scope="col">Supplier Motor</th>
            <th scope="col"><a type="button" class="btn btn-sm ml-2" onclick="modalMotor()" style="background-color: #CD853F"><i class="fa fa-plus" style="color: #fff"></i></a></th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1;
        /**
         * @var $motor \Model\Motor
         */
        foreach ($listMotor as $motor) { ?>
            <tr>
                <th scope="row"><?php echo $no; ?></th>
                <td><?php echo $motor->name; ?></td>
                <td><?php echo $motor->type; ?></td>
                <td><?php echo $motor->qty; ?></td>
                <td><?php echo $motor->price ?></td>
                <td><?php echo $motor->supplier->nama ?></td>
                <td>
                    <a href="javascript:void(0)" onclick="editMotor('<?php echo $motor->id ?>')" class="btn btn-sm bg-warning" title="Edit"><i class="fa fa-pencil" style="color: #fff"></i></a>
                    <a href="javascript:void(0)" onclick="deleteMotor('<?php echo $motor->id ?>')" class="btn btn-sm bg-danger" title="Hapus!">
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
                <h5 class="modal-title" id="form_motor_title">Tambah Motor</h5>
                <button type="button" class="close" onclick="closeModal('form')">×</button>
            </div>
            <div class="modal-body">
                <form id="proses_form_motor">
                    <div class="form-group" style="display: none">
                        <input type="text" class="form-control" placeholder="id motor" id="motor_id" name="motor_id">
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_nama">Nama Motor</label>
                        <input type="text" class="form-control" placeholder="Nama Motor" id="motor_name" name="motor_name" required>
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_merk">Tipe Motor</label>
                        <input type="text" class="form-control" placeholder="Tipe Motor" id="motor_tipe" name="motor_tipe" required>
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_kontak">Jumlah Motor</label>
                        <input type="number" class="form-control" placeholder="Jumlah Motor" id="motor_qty" name="motor_qty" required>
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_kontak">Harga Motor</label>
                        <input type="number" class="form-control" placeholder="Harga Motor" id="motor_price" name="motor_price" required>
                    </div>
                    <div class="form-group">
                        <label for="supplier_motor_id">Supplier</label>
                        <select class="form-control" id="supplier_motor_id" name="supplier_motor_id" required>
                            <option value="">Select Supplier</option>
                        </select>
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
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/get_supplier')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch suppliers')
                }
                return response.json();
            })
            .then(data => {
                const supplierDropdown = document.getElementById('supplier_motor_id')
                data.forEach(supplier => {
                    let option = document.createElement('option')
                    option.value = supplier.id
                    option.textContent = supplier.nama
                    supplierDropdown.appendChild(option)
                });
            })
            .catch(error => {
                console.error('Error:', error)
                alert('Failed to load suppliers')
            });
    });

    document.getElementById('proses_form_motor').addEventListener('submit', function(event) {
        event.preventDefault()

        let form = document.getElementById('proses_form_motor')
        let formData = new FormData(form);
        let url = document.getElementById('form_motor_title').textContent === 'Tambah Motor'
            ? '/api/add_motor'
            : '/api/edit_motor';

        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    return response.json()
                } else {
                    throw new Error('Failed to add motor')
                }
            })
            .then(data => {
                console.log('Success:', data)
                alert('Motor updated successfully')
                window.location.reload()
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add motor')
            })
    })

    function modalMotor() {
        setForm('form', {
            motor_id: '',
            motor_name: '',
            motor_tipe: '',
            motor_qty: 0,
            motor_price: 0,
            supplier_motor_id: ''
        });
        document.getElementById('form_motor_title').textContent = 'Tambah Motor'
    }

    async function editMotor(id) {
        fetch(`/api/get_motor?id=${id}`)
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
                        motor_id: data.id,
                        motor_name: data.name,
                        motor_tipe: data.type,
                        motor_qty: data.qty,
                        motor_price: data.price,
                        supplier_motor_id: data.supplier.id
                    });
                    document.getElementById('form_motor_title').textContent = 'Edit Motor'
                }
            })
            .catch(error => {
                console.error('Error:', error)
                alert('Failed to fetch supplier data')
            });
    }

    function deleteMotor(id) {
        fetch(`/api/delete_motor?id=${id}`, {
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