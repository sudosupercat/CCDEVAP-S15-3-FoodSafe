var linectx = document.getElementById('lineChart').getContext('2d');
var piectx = document.getElementById('pieChart').getContext('2d');

var lineChart = new Chart(linectx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
        label: 'Inspections',
        data: [0, 20, 10, 15, 40, 25, 47, 50, 20, 15, 25, 5],
        backgroundColor: 'blue',
        borderColor: 'blue',
        borderWidth: 2,
        fill: false
        }]
    },
    options: {
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
        labels: ['Poor Handwashing Practice', 'Unclean Restroom', 'Pest Infestation', 'Cross-contamination'],
        datasets: [{
            label: 'Violation',
            data: [5, 10, 25, 80],
            backgroundColor: [
                'rgba(0, 138, 139, 0.4)',
                'rgba(0, 111, 179, 0.4)',
                'rgba(194, 152, 28, 0.4)',
                'rgba(97, 37, 193, 0.4)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgb(146, 99, 255)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tootip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2);
                    }

                }
            }
        }
    }
});