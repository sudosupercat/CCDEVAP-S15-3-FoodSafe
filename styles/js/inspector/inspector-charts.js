var piectx = document.getElementById('gradeChart').getContext('2d');
var linectx = document.getElementById('inspectionsChart').getContext('2d');

var lineChart = new Chart(linectx, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
          label: 'Inspections',
          data: [30, 45, 60, 35, 50, 40, 40, 10, 5, 23, 12, 30],
          borderColor: 'rgba(54, 162, 235, 1)',
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
        labels: ['A', 'B', 'C', 'F'],
        datasets: [{
            label: 'Grade',
            data: [34, 57, 23, 16],
            backgroundColor: [
                'rgba(15, 218, 28, 0.2)',
                'rgba(220, 170, 35, 0.2)',
                'rgba(219, 169, 29, 0.2)',
                'rgba(205, 32, 47, 0.2)'
            ],
            borderColor: [
                'rgb(15, 188, 26)',
                'rgb(231, 111, 31)',
                'rgba(255, 206, 86, 1)',
                'rgb(205, 31, 60)'
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