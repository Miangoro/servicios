// Espera a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {

  const graficasData = window.graficasData;

  const backgroundColors = [
    'rgba(255, 99, 132, 0.5)',
    'rgba(54, 162, 235, 0.5)',
    'rgba(255, 206, 86, 0.5)',
    'rgba(75, 192, 192, 0.5)',
    'rgba(153, 102, 255, 0.5)',
    'rgba(255, 159, 64, 0.5)',
    'rgba(199, 199, 199, 0.5)'
  ];

  const borderColors = [
    'rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)',
    'rgba(199, 199, 199, 1)'
  ];

  // Itera sobre cada encuesta en los datos
  for (const idEncuesta in graficasData) {
    if (Object.prototype.hasOwnProperty.call(graficasData, idEncuesta)) {
      const encuesta = graficasData[idEncuesta];

      // Itera sobre cada pregunta dentro de la encuesta
      encuesta.preguntas.forEach(pregunta => {
        const labels = pregunta.opciones.map(opcion => opcion.nombre_opcion);
        const data = pregunta.opciones.map(opcion => opcion.conteo);

        // Define el ID del canvas donde se dibujará la gráfica
        const canvasId = `chart-${idEncuesta}-${pregunta.id_pregunta}`;
        const ctx = document.getElementById(canvasId);

        if (ctx) {
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [{
                label: pregunta.nombre_pregunta,
                data: data,
                backgroundColor: backgroundColors.slice(0, labels.length),
                borderColor: borderColors.slice(0, labels.length),
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    // Muestra los números enteros en el eje Y
                    precision: 0
                  }
                }
              }
            }
          });
        } else {
          console.error(`Error: No se encontró el elemento canvas con ID: ${canvasId}`);
        }
      });
    }
  }
});
