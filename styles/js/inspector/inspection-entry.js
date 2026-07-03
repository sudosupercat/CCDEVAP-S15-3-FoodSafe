
document.addEventListener("DOMContentLoaded", () => {
    //Enable/disable grade/switch fields
    const autoRatingSwitch = document.getElementById('autoRatingSwitch');

    autoRatingSwitch.addEventListener('change', function () {
    const disable = this.checked;
    document.querySelectorAll('#score, #grade-pass, #grade-fail').forEach(el => {
        el.disabled = disable;
        });
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