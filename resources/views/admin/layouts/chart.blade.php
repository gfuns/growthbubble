<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script type="text/javascript">
    // Month labels
    const months = [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];
    const raw      = {!! $dataSets !!};

    // Demo data for 5 items (replace with your own)
    const dataSets = [{
            label: 'Registrations',
            data: raw.registrations
        },
        {
            label: 'Renewals',
            data: raw.renewals
        },
        {
            label: 'Power of Attorneys',
            data: raw.poa
        },
        {
            label: 'Processing Fees',
            data: raw.processing
        },
        {
            label: 'Award Letters',
            data: raw.award_letters
        }
    ];

    // Assign a distinct color to each dataset
    const palette = [
        '#3366cc', '#dc3912', '#ff9900',
        '#109618', '#990099'
    ];

    // Build datasets with styling
    const datasets = dataSets.map((set, i) => ({
        label: set.label,
        data: set.data,
        borderColor: palette[i],
        backgroundColor: palette[i] + '33', // same color with transparency
        tension: 0.25,
        pointRadius: 3,
        fill: false
    }));

    // Current year for tooltip
    const currentYear = new Date().getFullYear();

    // Create the chart
    new Chart(document.getElementById('myLineChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        // ⬇️ Custom tooltip title: e.g., "Mar, 2025"
                        title: (tooltipItems) => {
                            const month = tooltipItems[0].label; // "Mar"
                            return `${month}, ${currentYear}`; // "Mar, 2025"
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e8e8e8'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
