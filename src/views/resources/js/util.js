async function fetchData(url, errorMessage) {
    try {
        const response = await fetch(url);
        return await response.json();
    } catch (error) {
        console.error(errorMessage, error);
    }
}

async function mutasi_barang(id) {
    const data = await fetchData(`processmutasi.php?do=wantadd&id=${id}`, 'Error fetching mutation data:');
    if (data) {
        document.getElementById('formtitle').textContent = 'Mutasi Barang';
        document.querySelector('[name="kodemutasibarang"]').value = data.item_id;
        document.querySelector('[name="mutasiquantity"]').max = data.item_quantity;
        document.getElementById('formmutasi').classList.add('show');
        document.getElementById('formmutasiform').setAttribute('action', `processmutasi.php?do=add&id=${id}`);
    }
}

function closeModal(formId) {
    const form = document.getElementById(formId);
    form.style.display = 'none';
}

function setForm(formId, formData) {
    const form = document.getElementById(formId);
    Object.keys(formData).forEach(key => {
        document.querySelector(`[name="${key}"]`).value = formData[key];
    });
    form.style.display ='block'
}

function modal_barang() {
    setForm('formbarang', {
        kodebarang: '',
        namabarang: '',
        quantity: '',
        harga: '',
        supplier: 1
    }, 'processbarang.php?do=add');
    document.getElementById('formjudul').textContent = 'Tambah Barang';
}

function modal_order() {
    setForm('form_order', {
        namabarang: '',
        jumlahbarang: '',
        namasupplier: ''
    }, 'prosesorder.php?do=add');
    document.getElementById('form_order').textContent = 'Order Barang';
}

async function edit_barang(id) {
    const data = await fetchData(`processbarang.php?do=wantedit&id=${id}`, 'Error fetching barang data:');
    if (data) {
        setForm('formbarang', {
            kodebarang: data.item_code,
            namabarang: data.item_name,
            quantity: data.item_quantity,
            harga: data.item_price,
            supplier: data.item_supplier_id
        }, `processbarang.php?do=edit&id=${id}`);
        document.getElementById('formjudul').textContent = 'Edit Barang';
    }
}

async function edit_order(id) {
    const data = await fetchData(`prosesorder.php?do=wantedit&id=${id}`, 'Error fetching order data:');
    if (data) {
        setForm('form_order', {
            namabarang: data.order_barang,
            namasupplier: data.order_supplier,
            jumlahbarang: data.order_jumlah
        }, `prosesorder.php?do=edit&id=${id}`);
        document.getElementById('form_order').textContent = 'Edit Order';
    }
}
