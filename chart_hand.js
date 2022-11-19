
const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'doughnut',
  data :{
    labels: staff_labels,
    datasets: [{
      label: 'összesen',
      data: data_array2,
      backgroundColor: [
        'red',
        'lightblue',
        'yellow',
        'green',
        'gray',
        'darkgreen',
        'brown',
        'white',
        'darkblue',
      ],
      hoverOffset: 2
    }]
  },
  options: {
    
    responsive: true,
    plugins: {
      legend: {
        position: 'bottom',
      },
      title: {
        display: true,
        text: staff_sum+ ' dolgozó beosztásának eloszlása',
        font: {
          size: 18,
          family:'Nunito'
      },
      color:'white',
      },
      customCanvasBackgroundColor: {
          color: 'black'}
    }
  },
});
