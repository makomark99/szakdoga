
  const ctx2 = document.getElementById('myChart2');
  let chart=document.getElementById("myChart2");
  if (screen.width <= 400) {
    chart.setAttribute("height", "300");
  }
  else{
    chart.removeAttribute("height");
  }
  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['0-5', '6-7', '8-9', '10-11', '12-13', '14-15', '16-17', '18-19', '20+'],
      datasets: [{
        label: 'Játékosok száma',
        data: data_array.reverse(),
         
      }]
    },
    options: {
      plugins: {
        legend: {
            labels: {
                // This more specific font property overrides the global property
                font: {
                  size: 14,
                  family:'Nunito',
              },
            }
        },
        title: {
          display: true,
          text: players_sum + ' játékos korcsoportjának eloszlása',
          font: {
            size: 18,
            family:'Nunito'
        },
        color:'white',
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