// public/assets/js/stats.js
document.addEventListener('DOMContentLoaded', () => {
  fetch('stats_data.php')
    .then(res => {
      if (!res.ok) throw new Error('Error cargando estadísticas');
      return res.json();
    })
    .then(data => {
      const { labels, tasks, notes, pomodoros } = data;

      // Función helper para instanciar un gráfico
      function makeChart(ctx, label, dataset) {
        return new Chart(ctx, {
          type: 'line',
          data: {
            labels,
            datasets: [{
              label,
              data: dataset,
              tension: 0.3,
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { position: 'top' }
            }
          }
        });
      }

      // Crear cada gráfico
      makeChart(
        document.getElementById('tasksChart').getContext('2d'),
        'Tareas completadas',
        tasks
      );
      makeChart(
        document.getElementById('notesChart').getContext('2d'),
        'Apuntes creados',
        notes
      );
      makeChart(
        document.getElementById('pomosChart').getContext('2d'),
        'Pomodoros completados',
        pomodoros
      );
    })
    .catch(err => console.error(err));
});
