fetch("../api/student_stats.php")
  .then(response => response.json())
  .then(data => {
    const labels = data.map(item => item.year_level);
    const totals = data.map(item => item.total);

    const ctx = document.getElementById("studentChart").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [{
          label: "Number of Students",
          data: totals,
          backgroundColor: "rgba(54, 162, 235, 0.6)"
        }]
      }
    });
  });
