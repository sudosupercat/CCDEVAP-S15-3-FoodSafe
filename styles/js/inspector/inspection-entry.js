document.addEventListener("DOMContentLoaded", () => {
    function sendAddRequest(formData){
        event.preventDefault();

        fetch('controller/Inspection.controller.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Server says:', data);
            // location.reload();
        })
        .catch(error => console.error('Error:', error));
        console.log(formData);
    }

    document.getElementById('add-inspection-final').addEventListener('click', () => {
        const form = document.getElementById("form-add-inspection");
        const formData = new FormData(form);

        if(form.checkValidity()){
            sendAddRequest(formData);
        }
        else{
            form.reportValidity();
            return;
        }
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