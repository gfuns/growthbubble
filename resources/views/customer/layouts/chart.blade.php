<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">
    var options = {
        series: [{{ $params["queuedTasks"] }}, {{ $params["completedTasks"] }}, {{ $params["activeTasks"] }}, {{ $params["cancelledTasks"] }}, {{ $params["onHoldTasks"] }}],
        chart: {
            width: 380,
            type: 'donut', //pie
        },
        labels: ['Queued', 'Completed', 'In Progress', 'Cancelled', 'On Hold'],
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            floating: false, // ensures it sits below chart
            itemMargin: {
                horizontal: 10,
                vertical: 5
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },

            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
