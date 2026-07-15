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
    }

    document.getElementById('add-inspection-final').addEventListener('click', () => {
        const form = document.getElementById("form-add-inspection");
        const formData = new FormData(form);
        sendAddRequest(formData);
    });
    
    //Hide/show grade/switch fields
    const autoRatingSwitch = document.getElementById('autoRatingSwitch');

    autoRatingSwitch.addEventListener('change', function () {
        const hidden = this.checked;

        if(this.checked){
            $("#container-score-grade").hide();
        }
        else{
            $("#container-score-grade").show();
        }
    });

    //Set date max attribute to current day
    const maxDate = document.getElementById('inspection-date');
    const day = new Date().toISOString().split('T')[0]; 
    maxDate.max = day;

    //Violation fields
    let fieldCount = 0;
    const fieldCountLimit = 3;
    document.getElementById('button-add-violation').addEventListener('click', () => {
        if (fieldCount < 3){
            fieldCount++;
    
            const wrapper = document.createElement('div');
            wrapper.classList.add('mb-3', 'p-3', 'border');
    
            const label = document.createElement('h6');
            label.textContent = `Violation #${fieldCount}`;
    
            wrapper.innerHTML += `
            <div class="form-group">
                <label for="violation-${fieldCount}">Type</label>
                <select class="form-control" id="violation-${fieldCount}" name="violation-${fieldCount}" required>
                <option>Improper Handling</option>
                <option>No Sanitation</option>
                <option>Pest Infestation</option>
                </select>
            </div>
            <div class="form-group">
                <label for="remarks-${fieldCount}">Remarks</label>
                <input type="text" class="form-control" name="remarks-${fieldCount}" id="remarks-${fieldCount}" required>
            </div>
            `;

            wrapper.prepend(label);
            document.getElementById('violation-form-container').appendChild(wrapper);
        }
        else{
            alert("Violation fields are already enough.");
        }
    });
});