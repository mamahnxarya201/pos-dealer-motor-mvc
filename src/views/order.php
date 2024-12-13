<?php
require 'src/views/component/header.php';
?>
<div class="container">
    <table class="table" style="border-top: #CD853F 4px solid;">
        <thead class="thead">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Motor</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Supplier</th>
            <th scope="col">Order Terlayani</th>
            <th scope="col"><a type="button" class="btn btn-sm ml-2" onclick="modalOrder()" style="background-color: #CD853F"><i class="fa fa-plus" style="color: #fff"></i></a></th>
        </tr>
        </thead>
        <tbody>
        <?php $no = 1;
        /**
         * @var $order \Model\Order
         */
        foreach ($listOrder as $order) { ?>
            <tr>
                <th scope="row"><?php echo $no; ?></th>
                <td><?php echo $order->order_name; ?></td>
                <td><?php echo $order->order_motor->name; ?></td>
                <td><?php echo $order->order_jumlah; ?></td>
                <td><?php echo $order->order_supplier->nama ?></td>
                <td><?php echo $order->order_dilayani ?></td>
                <td>
                    <a href="javascript:void(0)" onclick="editOrder('<?php echo $order->order_id ?>')" class="btn btn-sm bg-warning" title="Edit"><i class="fa fa-pencil" style="color: #fff"></i></a>
                    <a href="javascript:void(0)" onclick="deleteMotor('<?php echo $order->order_id ?>')" class="btn btn-sm bg-danger" title="Hapus!">
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
                <h5 class="modal-title" id="form_order_title">Tambah Order</h5>
                <button type="button" class="close" onclick="closeModal('form')">×</button>
            </div>
            <div class="modal-body">
                <form id="proses_form_order">
                    <div class="form-group" style="display: none">
                        <input type="text" class="form-control" placeholder="id order" id="order_id" name="order_id">
                    </div>
                    <div class="form-group">
                        <label for="order_name">Nama Motor</label>
                        <input type="text" class="form-control" placeholder="Nama Order" id="order_name" name="order_name" required>
                    </div>
                    <div class="form-group">
                        <label for="order_motor_id">Motor</label>
                        <select class="form-control" id="order_motor_id" name="order_motor_id" required>
                            <option value="">Select Motor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order_jumlah">Jumlah Order</label>
                        <input type="number" class="form-control" placeholder="Jumlah Order" id="order_jumlah" name="order_jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="order_dilayani">Order Dilayani</label>
                        <input type="number" class="form-control" placeholder="Order Dilayani" id="order_dilayani" name="order_dilayani" required>
                    </div>
                    <div class="form-group">
                        <label for="supplier_order">Supplier</label>
                        <select class="form-control" id="supplier_order" name="supplier_order" required>
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
                const supplierDropdown = document.getElementById('supplier_order')
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

        fetch('/api/get_motor')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch suppliers')
                }
                return response.json();
            })
            .then(data => {
                const motorDropdown = document.getElementById('order_motor_id')
                data.forEach(motor => {
                    let option = document.createElement('option')
                    option.value = motor.id
                    option.textContent = motor.name
                    motorDropdown.appendChild(option)
                });
            })
            .catch(error => {
                console.error('Error:', error)
                alert('Failed to load suppliers')
            });
    });

    document.getElementById('proses_form_order').addEventListener('submit', function(event) {
        event.preventDefault()

        let form = document.getElementById('proses_form_order')
        let formData = new FormData(form);
        let url = document.getElementById('form_order_title').textContent === 'Tambah Order'
            ? '/api/add_order'
            : '/api/edit_order';

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

    function modalOrder() {
        setForm('form', {
            order_id: '',
            order_name: '',
            order_jumlah: 0,
            order_dilayani: 0,
            supplier_order: '',
            order_motor_id: ''
        });
        document.getElementById('form_order_title').textContent = 'Tambah Order'
    }

    async function editOrder(id) {
        fetch(`/api/get_order?id=${id}`)
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
                        order_id: data.order_id,
                        order_name: data.order_name,
                        order_jumlah: data.order_jumlah,
                        order_dilayani: data.order_dilayani,
                        supplier_order: data.order_supplier.id,
                        order_motor_id: data.order_motor.id
                    });
                    document.getElementById('form_order_title').textContent = 'Edit Order'
                }
            })
            .catch(error => {
                console.error('Error:', error)
                alert('Failed to fetch supplier data')
            });
    }

    function deleteMotor(id) {
        fetch(`/api/delete_order?id=${id}`, {
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