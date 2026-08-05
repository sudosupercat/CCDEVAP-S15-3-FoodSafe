document.addEventListener("DOMContentLoaded", () => {
    function sendAddRequest(formData){
        event.preventDefault();

        fetch('controller/Inspection.controller.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            showToast(data.type.toLowerCase(), data.type, data.message);
            // location.reload();
            form.reset();
            console.log(formData);
        })
        .catch(error => console.error('Error:', error));
    }

    //Toast functions
    function showToast(type, title, message) {
        const toast = document.getElementById('toast');

        document.getElementById('toast-title').textContent = title;
        document.getElementById('toast-message').textContent = message;

        // Clear background properties to avoid overlapping state values
        toast.classList.remove('success', 'error');
        toast.classList.remove('hidden');
        toast.classList.add(type);

        clearTimeout(toastTimeout);

        toastTimeout = setTimeout(() => {
            toast.classList.add('hidden');
            toast.classList.remove(type);
        }, 5000);
    }

    function hideToast() {
        const toast = document.getElementById('toast');

        toast.classList.add('hidden');
        toast.classList.remove('success', 'error');

        clearTimeout(toastTimeout);
    }

    let toastTimeout;
    const form = document.getElementById("form-add-inspection");

    document.getElementById('add-inspection-final').addEventListener('click', () => {
        const formData = new FormData(form);

        if(form.checkValidity()){
            sendAddRequest(formData);
        }
        else{
            form.reportValidity();
            return;
        }
    });

    document.getElementById('toast-close').addEventListener('click', () => {
        hideToast();
    });

    //Set date max attribute to current day
    const maxDate = document.getElementById('inspection-date');
    const day = new Date().toISOString().split('T')[0]; 
    maxDate.max = day;

    //Initialize Select2
    $('#food-business').select2({
        placeholder: "Select a restaurant",
        width: '100%',
        theme: "bootstrap-5"
    });

    $('#violations').select2({
        placeholder: "Select violation/s",
        width: '100%',
        theme: "bootstrap-5"
    });
});