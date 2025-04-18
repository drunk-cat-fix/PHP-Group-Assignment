<?php
session_start();
require_once 'service/Admin_Analytics.php';
require_once 'admin_nav.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Analytics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #2c3e50;
        }

        section {
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 22px;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 20px;
            border-left: 6px solid #3498db;
            padding-left: 12px;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .chart-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .chart-card h2 {
            font-size: 16px;
            margin-bottom: 12px;
            color: #2c3e50;
        }

        canvas {
            width: 100% !important;
            height: 300px !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Analytics Dashboard</h1>

        <!-- Product Analytics -->
        <section>
            <div class="section-title">📦 Product Analytics</div>
            <div class="chart-grid">
                <div class="chart-card">
                    <h2>Most Viewed Products</h2>
                    <canvas id="viewedChart"></canvas>
                </div>
                <div class="chart-card">
                    <h2>Most Searched Products</h2>
                    <canvas id="searchedChart"></canvas>
                </div>
            </div>
        </section>

        <!-- Shop Analytics -->
        <section>
            <div class="section-title">🏪 Shop Analytics</div>
            <div class="chart-grid">
                <div class="chart-card">
                    <h2>Most Visited Shops</h2>
                    <canvas id="shopViewedChart"></canvas>
                </div>
                <div class="chart-card">
                    <h2>Most Searched Shops</h2>
                    <canvas id="shopSearchedChart"></canvas>
                </div>
            </div>
        </section>

        <!-- Product Sales -->
        <section>
            <div class="section-title">📈 Product Sales</div>
            <div class="chart-grid">
                <div class="chart-card">
                    <h2>Most Ordered Products</h2>
                    <canvas id="orderedChart"></canvas>
                </div>
            </div>
        </section>

        <!-- Sales Report -->
        <section>
            <div class="section-title">💰 Sales Report</div>
            <div class="chart-grid">
                <div class="chart-card">
                    <h2>Weekly Sales</h2>
                    <canvas id="weeklyChart"></canvas>
                </div>
                <div class="chart-card">
                    <h2>Monthly Sales</h2>
                    <canvas id="monthlyChart"></canvas>
                </div>
                <div class="chart-card">
                    <h2>Quarterly Sales</h2>
                    <canvas id="quarterlyChart"></canvas>
                </div>
                <div class="chart-card">
                    <h2>Annual Sales</h2>
                    <canvas id="annuallyChart"></canvas>
                </div>
            </div>
        </section>
    </div>
</body>

    <script>
        function createBarChart(id, labels, data, label, bg = 'rgba(54, 162, 235, 0.6)') {
            new Chart(document.getElementById(id), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: bg
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        function createLineChart(id, labels, data, label, bg = 'rgba(75, 192, 192, 0.6)') {
            new Chart(document.getElementById(id), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        fill: false,
                        borderColor: bg,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        createBarChart("viewedChart", <?= jsonData($viewed, 'product_name') ?>, <?= jsonData($viewed, 'product_visit_count') ?>, "Views");
        createBarChart("searchedChart", <?= jsonData($searched, 'product_name') ?>, <?= jsonData($searched, 'product_search_count') ?>, "Searches");
        createBarChart("shopViewedChart", <?= jsonData($shopViewed, 'shop_name') ?>, <?= jsonData($shopViewed, 'vendor_visit_count') ?>, "Visits");
        createBarChart("shopSearchedChart", <?= jsonData($shopSearched, 'shop_name') ?>, <?= jsonData($shopSearched, 'shop_search_count') ?>, "Searches");
        createBarChart("orderedChart", <?= jsonData($ordered, 'product_name') ?>, <?= jsonData($ordered, 'total_qty') ?>, "Quantity Ordered");

        createLineChart("weeklyChart", <?= jsonData($weekly, 'date') ?>, <?= jsonData($weekly, 'total') ?>, "Weekly Sales");
        createBarChart("monthlyChart", <?= jsonData($monthly, 'month') ?>, <?= jsonData($monthly, 'total') ?>, "Monthly Sales");
        createBarChart("quarterlyChart", <?= jsonData($quarterly, 'quarter') ?>, <?= jsonData($quarterly, 'total') ?>, "Quarterly Sales");
        createBarChart("annuallyChart", <?= jsonData($annually, 'year') ?>, <?= jsonData($annually, 'total') ?>, "Annual Sales");
    </script>
</html>
