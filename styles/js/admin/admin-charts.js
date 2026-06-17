var linectx = document.getElementById('lineChart').getContext('2d');
var piectx = document.getElementById('pieChart').getContext('2d');

var lineChart = new Chart(linectx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
        label: 'Passed',
        data: [0, 20, 10, 15, 40, 25, 47, 50, 20, 15, 25, 5],
        backgroundColor: 'blue',
        borderColor: 'blue',
        borderWidth: 2,
        fill: false
        }, {
            label: 'Failed',
            data: [2, 1, 17, 50, 25, 25, 31, 60, 13, 0, 56, 1],
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
        labels: ['Poor Handwashing Practice', 'Unclean Restroom', 'Pest Infestation', 'Cross-contamination', 'Bare-Hand Contact with Ready to Eat Food', 'Expired Food Items',
                    'Cluttered or Dirty Floors', 'Unapproved Food Resources', 'Failure to Properly Label Allergens'
                ],
        datasets: [{
            label: 'Violation',
            data: [5, 10, 25, 80, 50, 23, 61, 37, 90],
            backgroundColor: [
                'rgba(0, 138, 139, 0.4)',
                'rgba(0, 111, 179, 0.4)',
                'rgba(194, 152, 28, 0.4)',
                'rgba(97, 37, 193, 0.4)',
                'rgba(193, 37, 37, 0.4)',    
                'rgba(18, 87, 41, 0.4)',    
                'rgba(204, 102, 0, 0.4)',    
                'rgba(193, 37, 145, 0.4)',   
                'rgba(90, 90, 90, 0.4)'      
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
                'rgba(160, 160, 160, 1)'    
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
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