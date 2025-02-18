Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [],
    datasets: [{
      label: "Total Crimes",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
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
          maxTicksLimit: 12
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 0, 
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});

function fetchCrimeDataAndUpdateLineChart() {
  fetch('/api/crime-over-months')
    .then(response => response.json())
    .then(data => {
      const labels = data.map(stat => stat.month);
      const crimeCounts = data.map(stat => stat.total);

      myLineChart.data.labels = labels;
      myLineChart.data.datasets[0].data = crimeCounts;
      myLineChart.options.scales.yAxes[0].ticks.max = Math.max(...crimeCounts) + 5; // Adjust max based on data

      myLineChart.update();
    })
    .catch(error => console.error('Error fetching crime data:', error));
}

document.addEventListener('DOMContentLoaded', fetchCrimeDataAndUpdateLineChart);