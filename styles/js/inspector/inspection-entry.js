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
        sendAddRequest(formData);
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

    //Violation fields
    let fieldCount = 0;
    const fieldCountLimit = window.requirements.length;
    document.getElementById('button-add-violation').addEventListener('click', () => {

        if (fieldCount < fieldCountLimit){
            fieldCount++;
    
            const wrapper = document.createElement('div');
            wrapper.classList.add('mb-3', 'p-3', 'border');
            
            const label = document.createElement('h6');
            label.textContent = `Violation #${fieldCount}`;
    
            wrapper.innerHTML += `
            <div class="form-group">
                <label for="violation-${fieldCount}">Type</label>
                <select class="form-select" id="violation-${fieldCount}" name="violation-${fieldCount}" required>
                </select>
            </div>
            <div class="form-group">
                <label for="remarks-${fieldCount}">Remarks</label>
                <input type="text" class="form-control" name="remarks-${fieldCount}" id="remarks-${fieldCount}" required>
            </div>
            `;
            
            wrapper.prepend(label);
            document.getElementById('violation-form-container').appendChild(wrapper);

            const violationSelect = document.getElementById(`violation-${fieldCount}`);
            window.requirements.forEach(req => {
                const option = document.createElement("option");
                option.value = req.reqCode;
                option.textContent = req.reqTitle;
                violationSelect.appendChild(option);
            });

            $(`#violation-${fieldCount}`).select2({
                placeholder: "Select a violation",
                width: '100%',
                theme: "bootstrap-5"
            });
        }
        else{
            alert("You can only have as much violation entries as violation types");
        }
    });
});