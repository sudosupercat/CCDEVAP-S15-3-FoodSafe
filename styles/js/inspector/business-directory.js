
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
            document.getElementById('business-name').value = "";
            document.getElementById('business-license-no').value = "";
            document.getElementById('business-address').value = "";
            document.getElementById('contact-number').value = "";
            document.getElementById('image-preview').src = "";
            document.getElementById('business-maps-url').value = "";
            document.getElementById('business-license-no').value = "";
        }
        
        if(mode === 'edit'){
            title.textContent = "Edit";
            confirmBtn.classList.remove('btn-success');
            confirmBtn.classList.add('btn-info');
            confirmBtn.textContent = "Edit";
            document.getElementById('business-name').value = button.getAttribute('data-name');
            document.getElementById('business-license-no').value = button.getAttribute('data-licNo');
            document.getElementById('business-address').value = button.getAttribute('data-address');
            document.getElementById('contact-number').value = button.getAttribute('data-contact');
            document.getElementById('image-preview').src = "img/" + button.getAttribute('data-image');
            document.getElementById('business-maps-url').value = button.getAttribute('data-maps');
            document.getElementById('business-license-no').value = button.getAttribute('data-licNo');
            }
            // } else {
            //         document.getElementById('entryForm').reset();
            //     }
                
                confirmBtn.onclick = () => handleSubmit(mode, existingObjData?.id);
                modalAddEdit.show();
    }
    
    //
    function handleSubmit(mode, id = null){
        const name = document.getElementById('entryName').value;
        const desc = document.getElementById('entryDesc').value;
        
        if (mode === 'add') {
            console.log('Adding entry:', { name, desc });
            // Add entry logic here
        } else {
            console.log('Updating entry:', { id, name, desc });
            // Update entry logic here
        }
        
        modalAddEdit.hide();
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

    document.querySelectorAll('.button-edit-business').forEach(button => {
        button.addEventListener('click', () => {
        openAddEditModal('edit', button);
    });
  });
} );
