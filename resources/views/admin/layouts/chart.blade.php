<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@if (Auth::user()->role_id == 1)
    <script type="text/javascript">
        var options = {
            series: [{{ $params['queuedTasks'] }}, {{ $params['completedTasks'] }}, {{ $params['activeTasks'] }},
                {{ $params['cancelledTasks'] }}, {{ $params['onHoldTasks'] }}],
            chart: {
                width: 380,
                type: 'donut', //pie
            },
            labels: ['Queued Tasks', 'Completed Tasks', 'Tasks In Progress', 'Cancelled Tasks', 'Tasks On Hold'],
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
@else
    <script type="text/javascript">
        var staffOptions = {
            series: [{{ $params['onHoldTasks'] }}, {{ $params['completedTasks'] }}, {{ $params['activeTasks'] }}, {{ $params['cancelledTasks'] }}],
            chart: {
                width: 380,
                type: 'donut', //pie
            },
            labels: ['Tasks On Hold', 'Completed Tasks', 'Tasks In Progress', 'Cancelled Tasks'],
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

        var staffChart = new ApexCharts(document.querySelector("#staffChart"), staffOptions);
        staffChart.render();
    </script>
@endif
