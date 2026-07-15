
$(document).ready( function () {
    // Initializes the DataTable
    $('#business-directory').DataTable();
    
    const modalAddEdit = new bootstrap.Modal(document.getElementById('add-edit-modal'));
    const modalDelete = new bootstrap.Modal(document.getElementById('delete-modal'));
    
    // Customizes the buttons in the shared add and delete modal
    function openAddEditModal(mode, button){       
        const title = document.getElementById('title-modal-edit-add');
        const confirmBtn = document.getElementById('confirm-button-modal-edit-add');

        if(mode === 'add'){
            title.textContent = "Add";
            confirmBtn.classList.remove('btn-info');
            confirmBtn.classList.add('btn-success');
            confirmBtn.textContent = "Add";
            confirmBtn.setAttribute('data-mode', 'add');
            document.getElementById('business-establishment-image').setAttribute("required", "");
            document.getElementById('business-name').value = "";
            document.getElementById('business-license-no').value = "";
            document.getElementById('business-address').value = "";
            document.getElementById('contact-number').value = "";
            document.getElementById('image-preview').src = "";
            document.getElementById('business-maps-url').value = "";
            document.getElementById('business-license-no').value = "";
            document.getElementById('district').value = "";
        }
        else if(mode === 'edit'){
            title.textContent = "Edit";
            confirmBtn.classList.remove('btn-success');
            confirmBtn.classList.add('btn-info');
            confirmBtn.textContent = "Edit";
            confirmBtn.setAttribute('data-mode', 'edit');
            document.getElementById('business-id').value = button.getAttribute('data-foodBusinessId');
            document.getElementById('business-establishment-image').removeAttribute("required");
            document.getElementById('business-name').value = button.getAttribute('data-name');
            document.getElementById('business-license-no').value = button.getAttribute('data-licNo');
            document.getElementById('business-address').value = button.getAttribute('data-address');
            document.getElementById('contact-number').value = button.getAttribute('data-contact');
            document.getElementById('image-preview').src = "img/" + button.getAttribute('data-image');
            document.getElementById('business-maps-url').value = button.getAttribute('data-maps');
            document.getElementById('business-license-no').value = button.getAttribute('data-licNo');
            document.getElementById('district').value = button.getAttribute('data-district');
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
    
    document.querySelectorAll('.button-delete-business').forEach(button => {
        button.addEventListener('click', function() {
            customizeDeleteMessage(this);
        });
    });

    // Event listeners for buttons
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

        sendAddEditRequest(mode, formData);
    });

    document.querySelectorAll('.button-edit-business').forEach(button => {
        button.addEventListener('click', () => {
        openAddEditModal('edit', button);
    });
  });
} );
