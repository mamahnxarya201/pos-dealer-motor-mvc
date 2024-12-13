function closeModal(formId) {
    const form = document.getElementById(formId);
    form.style.display = 'none';
}

function setForm(formId, formData) {
    const form = document.getElementById(formId);
    console.log(form);
    Object.keys(formData).forEach(key => {

        document.querySelector(`[name="${key}"]`).value = formData[key];
    });
    form.style.display ='block'
}
