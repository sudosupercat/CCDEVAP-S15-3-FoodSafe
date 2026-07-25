var linectx = document.getElementById('lineChart').getContext('2d');
var piectx = document.getElementById('pieChart').getContext('2d');
const year = document.getElementById('yearPicker').value;

var passedData = new Array(12).fill(0);
passedRow.forEach(row => {
    passedData[row.month - 1] = parseInt(row.total);
});

var failedData = new Array(12).fill(0);
failedRow.forEach(row => {
    failedData[row.month - 1] = parseInt(row.total);
});

var violationData = new Array(18).fill(0);
violationRow.forEach(row => {
    violationData[row.num  - 1] = parseInt(row.total);
});

var lineChart = new Chart(linectx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
        label: '# of Passed Inspection',
        data: passedData,
        backgroundColor: 'blue',
        borderColor: 'blue',
        borderWidth: 2,
        fill: false
        }, {
            label: '# of Failed Inspection',
            data: failedData,
            backgroundColor: 'red',
            borderColor: 'red',
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

var pieChart = new Chart(piectx, {
    type: 'pie',
    data: {
        labels: ['Cross-contamination', 'Improper Cooking Temperatures',
                    'Poor Handwashing Practices', 'Improper Food Storage Temperatures', 'Pest Infestation','Expired Food Items','Dirty Kitchen Equipment',
                    'Improper Dishwashing Techniques','Cluttered or Dirty Floors', 'Inadequate Food Protection', 'Improper Employee Hygiene', 'Unapproved Food Resources',
                    'Unclean Restrooms', 'Grease Buildup in Exhaust Systems', 'Failure to Properly Label Allergens','Inadequate Training for Employees', 'Failure to Rapidly Cool or Reheat Foods', 'Bare-Hand Contact with Ready to Eat Food'
                ],
        datasets: [{
            label: 'Violation',
            data: violationData,
            backgroundColor: [
                'rgba(0, 138, 139, 0.4)',
                'rgba(0, 111, 179, 0.4)',
                'rgba(194, 152, 28, 0.4)',
                'rgba(97, 37, 193, 0.4)',
                'rgba(193, 37, 37, 0.4)',
                'rgba(18, 87, 41, 0.4)',
                'rgba(204, 102, 0, 0.4)',
                'rgba(193, 37, 145, 0.4)',
                'rgba(90, 90, 90, 0.4)',
                'rgba(0, 188, 212, 0.4)',
                'rgba(76, 175, 80, 0.4)',
                'rgba(255, 87, 34, 0.4)',
                'rgba(121, 85, 72, 0.4)',
                'rgba(63, 81, 181, 0.4)',
                'rgba(233, 30, 99, 0.4)',
                'rgba(156, 39, 176, 0.4)',
                'rgba(0, 150, 136, 0.4)',
                'rgba(205, 220, 57, 0.4)' 
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgb(146, 99, 255)',
                'rgba(255, 99, 132, 1)',
                'rgb(66, 168, 88)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 200, 1)',
                'rgba(160, 160, 160, 1)',
                'rgba(0, 188, 212, 1)',
                'rgba(76, 175, 80, 1)',
                'rgba(255, 87, 34, 1)',
                'rgba(121, 85, 72, 1)',
                'rgba(63, 81, 181, 1)',
                'rgba(233, 30, 99, 1)',
                'rgba(156, 39, 176, 1)',
                'rgba(0, 150, 136, 1)',
                'rgba(205, 220, 57, 1)'   
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'left',
                align: 'center',
                labels: {
                    boxWidth: 12,
                    font: { 
                        size: 12 
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context){
                        var label = context.label,
                        currentValue = context.raw,
                        total = context.chart._metasets[context.datasetIndex].total;

                        var percentage = parseFloat((currentValue/total*100).toFixed(1));

                        return label + ": " +currentValue + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});