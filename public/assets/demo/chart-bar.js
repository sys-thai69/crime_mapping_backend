Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var ctx = document.getElementById("myBarChart");
var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
      label: "Crime Count",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 0, 
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});

function fetchCrimeDataAndUpdateBarChart() {
  fetch('/api/crime-counts')
    .then(response => response.json())
    .then(data => {
      const labels = data.map(stat => stat.crime_type);
      const crimeCounts = data.map(stat => stat.total);

      myBarChart.data.labels = labels;
      myBarChart.data.datasets[0].data = crimeCounts;
      myBarChart.options.scales.yAxes[0].ticks.max = Math.max(...crimeCounts) + 5; // Adjust max based on data

      myBarChart.update();
    })
    .catch(error => console.error('Error fetching crime counts:', error));
}

document.addEventListener('DOMContentLoaded', fetchCrimeDataAndUpdateBarChart);
