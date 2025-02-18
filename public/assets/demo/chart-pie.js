Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';


function fetchCrimeDataAndCreateChart() {
  fetch('/api/crime-stats')
    .then(response => response.json())
    .then(data => {
      const labels = data.map(stat => stat.crime_type);
      const percentages = data.map(stat => stat.percentage);
      const backgroundColors = ['#007bff', '#dc3545', '#ffc107', '#28a745', '#17a2b8', '#6c757d',
        '#e83e8c', '#fd7e14', '#20c997', '#6610f2', '#343a40', '#f8f9fa'];

      var ctx = document.getElementById("myPieChart");
      var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            data: percentages,
            backgroundColor: backgroundColors.slice(0, labels.length), 
          }],
        },
      });
    })
    .catch(error => console.error('Error fetching crime stats:', error));
}

document.addEventListener('DOMContentLoaded', fetchCrimeDataAndCreateChart);
