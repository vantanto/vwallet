@props(['dataCategories'])

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center mb-2">
            Expenses by Category
        </div>
        <div id="chart-demo-pie"></div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<?php echo "<script> const dataCategories = ". $dataCategories .";</script>\n"?>
<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-demo-pie'), {
            chart: {
                type: "donut",
                fontFamily: 'inherit',
                height: 200,
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: false
                },
            },
            fill: {
                opacity: 1,
            },
            series: dataCategories['sum'].length > 0 ? dataCategories['sum'] : [1],
            labels: dataCategories['name'].lengt > 0 ? dataCategories['name'] : ["No Expenses"],
            tooltip: {
                theme: 'dark'
            },
            grid: {
                strokeDashArray: 4,
            },
            legend: {
                show: true,
                position: 'right',
                offsetY: 12,
                markers: {
                    width: 10,
                    height: 10,
                    radius: 100,
                },
                itemMargin: {
                    horizontal: 8,
                    vertical: 8
                },
            },
            tooltip: {
                fillSeriesColor: false
            },
        })).render();
    });
    // @formatter:on
  </script>
@endpush