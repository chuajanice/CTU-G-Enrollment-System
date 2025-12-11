let ctx = document.getElementById("studentChart").getContext("2d");
let studentChart;

function loadChart() {
  fetch("get_chart_counts.php")
    .then(res => res.json())
    .then(data => {
      if (studentChart) studentChart.destroy();

      studentChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["BSIT", "BIT-CT", "BSIE", "BTLED-ICT", "DMT"],
          datasets: [{
            label: "Number of Students",
            data: [
              data.BSIT || 0, 
              data["BIT-CT"] || 0, 
              data.BSIE || 0, 
              data["BTLED-ICT"] || 0,
			  data.DMT || 0
            ],
            backgroundColor: ["#ff6600", "#0056b3", "#a65656", "#ab7800", "#228B22"]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              title: { display: true, text: 'Number of Students' }
            }
          },
          plugins: {
            legend: { display: false },
            title: { display: true, text: 'CTU - Ginatilan Enrollment Overview' }
          }
        }
      });
    });
}

// Refresh chart every 2 seconds
setInterval(loadChart, 30000);
loadChart();
