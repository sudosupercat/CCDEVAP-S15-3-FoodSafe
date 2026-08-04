var linectx = document.getElementById('lineChart').getContext('2d');
var piectx = document.getElementById('pieChart').getContext('2d');
var lineViolationctx = document.getElementById('lineChartViolation').getContext('2d');
var lineChartRegionFailedctx = document.getElementById('lineChartRegionFailed').getContext('2d');
const year = document.getElementById('yearPicker').value;

const grades = ['A', 'B', 'C', 'F'];

var gradeData = {};
grades.forEach(grade => gradeData[grade] = new Array(12).fill(0));

gradeRow.forEach(row => {
    if (gradeData[row.grade]) {
        gradeData[row.grade][row.month - 1] = parseInt(row.total);
    }
});

var violationData = new Array(18).fill(0);
violationRow.forEach(row => {
    violationData[row.num  - 1] = parseInt(row.total);
});

var violationDataArrays = [];
for (let i = 0; i < 18; i++) {
    var arr = new Array(17).fill(0);
    distViolationTypeRow.forEach(row => {
        if (row.violationNum == i + 1) {
            arr[row.districtNum - 1] = parseInt(row.total);
        }
    });
    violationDataArrays.push(arr);
}

var distFailedData = new Array(17).fill(0);
distFailedRow.forEach(row => {
    distFailedData[row.district  - 1] = parseInt(row.total);
});


var lineChart = new Chart(linectx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
        label: 'A',
        data: gradeData['A'],
        backgroundColor: 'green',
        borderColor: 'green',
        borderWidth: 2,
        fill: false
        }, {
            label: 'B',
            data: gradeData['B'],
            backgroundColor: 'blue',
            borderColor: 'blue',
            borderWidth: 2,
            fill: false
        }, {
            label: 'C',
            data: gradeData['C'],
            backgroundColor: 'orange',
            borderColor: 'orange',
            borderWidth: 2,
            fill: false
        }, {
            label: 'F',
            data: gradeData['F'],
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

var lineChartRegionFailed = new Chart(lineChartRegionFailedctx, {
    type: 'line',
    data: {
        labels: ['NCR', 'CAR', 'Region I', 'Region II', 'Region III', 'Region IV-A', 'Region IV-B', 'Region V', 'Region VI', 'Region VII', 'Region VIII', 'Region IX', 'Region X', 'Region XI', 'Region XII', 'Region XIII', 'BARMM'],
        datasets: [{
        label: '# of Failed Inspection',
        data: distFailedData,
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


var lineChartViolation = new Chart(lineViolationctx, {
    type: 'line',
    data: {
        labels: ['NCR', 'CAR', 'Region I', 'Region II', 'Region III', 'Region IV-A', 'Region IV-B', 'Region V', 'Region VI', 'Region VII', 'Region VIII', 'Region IX', 'Region X', 'Region XI', 'Region XII', 'Region XIII', 'BARMM'],
        datasets: [
            {
                label: 'Cross-contamination',
                data: violationDataArrays[0],
                backgroundColor: 'rgba(0, 138, 139, 0.4)',
                borderColor:'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Improper Cooking Temperatures',
                data: violationDataArrays[1],
                backgroundColor: 'rgba(0, 111, 179, 0.4)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Poor Handwashing Practices',
                data: violationDataArrays[2],
                backgroundColor: 'rgba(194, 152, 28, 0.4)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Improper Food Storage Temperatures',
                data: violationDataArrays[3],
                backgroundColor: 'rgba(97, 37, 193, 0.4)',
                borderColor:'rgb(146, 99, 255)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Pest Infestation',
                data: violationDataArrays[4],
                backgroundColor: 'rgba(193, 37, 37, 0.4)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Expired Food Items',
                data: violationDataArrays[5],
                backgroundColor: 'rgba(18, 87, 41, 0.4)',
                borderColor: 'rgb(66, 168, 88)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Dirty Kitchen Equipment',
                data: violationDataArrays[6],
                backgroundColor: 'rgba(204, 102, 0, 0.4)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Improper Dishwashing Techniques',
                data: violationDataArrays[7],
                backgroundColor: 'rgba(193, 37, 145, 0.4)',
                borderColor: 'rgba(255, 99, 200, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Cluttered or Dirty Floors',
                data: violationDataArrays[8],
                backgroundColor: 'rgba(90, 90, 90, 0.4)',
                borderColor: 'rgba(160, 160, 160, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Inadequate Food Protection',
                data: violationDataArrays[9],
                backgroundColor: 'rgba(0, 188, 212, 0.4)',
                borderColor: 'rgba(0, 188, 212, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Improper Employee Hygiene',
                data: violationDataArrays[10],
                backgroundColor: 'rgba(76, 175, 80, 0.4)',
                borderColor: 'rgba(76, 175, 80, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Unapproved Food Resources',
                data: violationDataArrays[11],
                backgroundColor: 'rgba(255, 87, 34, 0.4)',
                borderColor: 'rgba(255, 87, 34, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Unclean Restrooms',
                data: violationDataArrays[12],
                backgroundColor: 'rgba(121, 85, 72, 0.4)',
                borderColor: 'rgba(121, 85, 72, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Grease Buildup in Exhaust Systems',
                data: violationDataArrays[13],
                backgroundColor: 'rgba(63, 81, 181, 0.4)',
                borderColor: 'rgba(63, 81, 181, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Failure to Properly Label Allergens',
                data: violationDataArrays[14],
                backgroundColor: 'rgba(233, 30, 99, 0.4)',
                borderColor: 'rgba(233, 30, 99, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Inadequate Training for Employees',
                data: violationDataArrays[15],
                backgroundColor:'rgba(156, 39, 176, 0.4)',
                borderColor: 'rgba(156, 39, 176, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Failure to Rapidly Cool or Reheat Foods',
                data: violationDataArrays[16],
                backgroundColor:'rgba(0, 150, 136, 0.4)',
                borderColor: 'rgba(0, 150, 136, 1)',
                borderWidth: 2,
                fill: false,
            },
            {
                label: 'Bare-Hand Contact with Ready to Eat Food',
                data: violationDataArrays[17],
                backgroundColor: 'rgba(205, 220, 57, 0.4)' ,
                borderColor: 'rgba(205, 220, 57, 1)',
                borderWidth: 2,
                fill: false,
            }
        ]
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