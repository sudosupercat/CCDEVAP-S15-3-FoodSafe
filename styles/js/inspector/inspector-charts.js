var piectx = document.getElementById('gradeChart').getContext('2d');
var linectx = document.getElementById('inspectionsChart').getContext('2d');

var lineChart = new Chart(linectx, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
          label: 'Inspections',
          data: monthlyCounts,
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
        labels: gradeChartData.labels,
        datasets: [{
            label: 'Grade',
            data: gradeChartData.data,
            backgroundColor: [
                'rgba(40, 167, 69, 0.8)',  
                'rgba(255, 193, 7, 0.8)',   
                'rgba(253, 126, 20, 0.8)',  
                'rgba(220, 53, 69, 0.8)'    
            ],
            borderColor: [
                'rgb(15, 188, 26)',
                'rgba(255, 206, 86, 1)',
                'rgb(231, 111, 31)',
                'rgb(205, 31, 60)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            tooltip: {
                callbacks: {
                    label: function(context){
                        var label = context.label,
                        currentValue = context.raw,
                        total = context.chart._metasets[context.datasetIndex].total;
                        var percentage = parseFloat((currentValue/total*100).toFixed(1));
                        return label + ": " + currentValue + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});