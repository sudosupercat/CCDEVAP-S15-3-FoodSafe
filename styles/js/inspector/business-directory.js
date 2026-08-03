$(document).ready( function () {
    // Initializes the DataTable
    let table = $('#business-directory').DataTable({
            pageLength: 25,
        });
    
    const modalAddEdit = new bootstrap.Modal(document.getElementById('add-edit-modal'));
    const modalDelete = new bootstrap.Modal(document.getElementById('delete-modal'));
    
    // Customizes the buttons in the shared add and delete modal
    function openAddEditModal(mode, button){       
        const title = document.getElementById('title-modal-edit-add');
        const confirmBtn = document.getElementById('confirm-button-modal-edit-add');
        const cancelBtn = document.getElementById('cancel-button-modal-edit-add');
        const inputBusId = document.getElementById('business-id');
        const inputBusImgUpload = document.getElementById('business-establishment-image');
        const inputBusName = document.getElementById('business-name');
        const inputBusLicNo = document.getElementById('business-license-no');
        const inputBusAddress = document.getElementById('business-address');
        const inputBusContact = document.getElementById('contact-number');
        const busImgPreview = document.getElementById('image-preview');
        const inputBusMapsUrl = document.getElementById('business-maps-url');
        const inputBusDistrict = document.getElementById('district');

        // Set elements modified by view block to defaults
        inputBusImgUpload.style.display = "block";
        busImgPreview.style.display = 'block';
        confirmBtn.style.display = 'block';

        inputBusName.disabled = false;
        inputBusLicNo.disabled = false;
        inputBusAddress.disabled = false;
        inputBusContact.disabled = false;
        inputBusMapsUrl.disabled = false;
        inputBusDistrict.disabled = false;

        if(mode === 'add'){
            title.textContent = "Add";
            confirmBtn.classList.remove('btn-info');
            confirmBtn.classList.add('btn-success');
            confirmBtn.textContent = "Add";
            confirmBtn.setAttribute('data-mode', 'add');
            cancelBtn.innerText = 'Cancel';

            inputBusImgUpload.setAttribute("required", "");
            inputBusName.value = "";
            inputBusLicNo.value = "";
            inputBusAddress.value = "";
            inputBusContact.value = "";
            busImgPreview.src = "";
            busImgPreview.style.display = 'none';
            inputBusMapsUrl.value = "";
            inputBusDistrict.value = "";
        }
        else if(mode === 'edit'){
            title.textContent = 'Edit';
            confirmBtn.classList.remove('btn-success');
            confirmBtn.classList.add('btn-info');
            confirmBtn.textContent = "Edit";
            confirmBtn.setAttribute('data-mode', 'edit');
            cancelBtn.innerText = 'Cancel';

            inputBusId.value = button.getAttribute('data-foodBusinessId');
            inputBusImgUpload.removeAttribute("required");
            inputBusName.value = button.getAttribute('data-name');
            inputBusLicNo.value = button.getAttribute('data-licNo');
            inputBusAddress.value = button.getAttribute('data-address');
            inputBusContact.value = button.getAttribute('data-contact');
            busImgPreview.src = "img/" + button.getAttribute('data-image');
            inputBusMapsUrl.value = button.getAttribute('data-maps');
            inputBusDistrict.value = button.getAttribute('data-district');
        }
        else if(mode === 'view'){
            title.textContent = "View details for " + button.getAttribute('data-name');
            confirmBtn.style.display = 'none';
            cancelBtn.innerText = 'Close';
            inputBusImgUpload.style.display = "none";

            inputBusName.disabled = true;
            inputBusLicNo.disabled = true;
            inputBusAddress.disabled = true;
            inputBusContact.disabled = true;
            inputBusMapsUrl.disabled = true;
            inputBusDistrict.disabled = true;

            inputBusName.value = button.getAttribute('data-name');
            inputBusLicNo.value = button.getAttribute('data-licNo');
            inputBusAddress.value = button.getAttribute('data-address');
            inputBusContact.value = button.getAttribute('data-contact');
            busImgPreview.src = "img/" + button.getAttribute('data-image');
            if(!(button.getAttribute('data-maps'))){
                inputBusMapsUrl.value = "N/A";
            }
            inputBusDistrict.value = button.getAttribute('data-district');
        }
        
        modalAddEdit.show();
    }
    
    // Send form data from add/edit modal to controller in the background
    function sendAddEditRequest(mode, formData){
        event.preventDefault();

        fetch('controller/FoodBusiness.controller.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Server says:', data);
            modalAddEdit.hide();
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }

    // Puts the business name in the modal for clarity
    function customizeDeleteMessage(button){
        const businessName = document.getElementById('text-delete-question');
        const messageDelete = "Do you want to delete ";
        const buttonConfirmFinalDelete = document.getElementById('button-delete-business-final');
        businessName.textContent = messageDelete + button.getAttribute('data-name') + "?";
        buttonConfirmFinalDelete.setAttribute('data-foodBusinessId', button.getAttribute('data-foodBusinessId'));
        modalDelete.show();
    }

    // Sends delete request to controller in the background
    function sendDeleteRequest(foodBusinessId){
        event.preventDefault();

        fetch('controller/FoodBusiness.controller.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=delete' +
                  '&foodBusinessId=' + encodeURIComponent(foodBusinessId)
        })
        .then(response => response.text())
        .then(data => {
            console.log('Server says:', data);
            modalDelete.hide();
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
    
    // Event listeners for buttons
    document.querySelectorAll('.button-delete-business').forEach(button => {
        button.addEventListener('click', function() {
            customizeDeleteMessage(this);
        });
    });

    document.getElementById('button-delete-business-final').addEventListener('click', () => {
        const foodBusinessId = document.getElementById('button-delete-business-final').getAttribute('data-foodBusinessId');
        sendDeleteRequest(foodBusinessId);
    });

    document.getElementById('button-add-business').addEventListener('click', () => {
        openAddEditModal('add', this);
    });

    document.getElementById("confirm-button-modal-edit-add").addEventListener("click", function() {
        const form = document.getElementById("form-add-edit");
        const formData = new FormData(form);
        const mode = document.getElementById("confirm-button-modal-edit-add").getAttribute('data-mode');
        formData.append("action", mode);

        if(form.checkValidity()){
            sendAddEditRequest(mode, formData);
        }
        else{
            form.reportValidity();
            return;
        }
    });

    document.querySelectorAll('.button-edit-business').forEach(button => {
        button.addEventListener('click', () => {
        openAddEditModal('edit', button);
    });

    // Detect when row is clicked
    $("#business-directory tbody").off('click', 'tr').on("click", "tr", function(event) {
        if ($(event.target).closest('button').length) {
            return;
        }

        const row = table.row(this).data();
        console.log(row[4]);
        const buttonTemplate = document.createElement('template');
        buttonTemplate.innerHTML = row[4].trim();
        const buttonElement = buttonTemplate.content.firstChild;
        openAddEditModal('view', buttonElement);
    });
  });
});
