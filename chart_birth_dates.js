
  const ctx2 = document.getElementById('myChart2');
  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['0-5', '6-7', '8-9', '10-11', '12-13', '14-15', '16-17', '18-19', '20+'],
      datasets: [{
        label: players_sum + ' játékos korcsoportjának eloszlása',
        data: data_array.reverse(),
         
      }]
    },
    options: {
      plugins: {
        legend: {
            labels: {
                // This more specific font property overrides the global property
                font: {
                  size: 18,
                  family:'Nunito'
              },
            }
        },
    },
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            font: {
                size: 14,
                family:'Nunito',
                
            },
            color: 'white'
        },
        },
        x: {
          ticks: {
            font: {
                size: 14,
                family:'Nunito',
            },
            color: 'white'
        },
        },
      },
    color:'white',
    }
  });