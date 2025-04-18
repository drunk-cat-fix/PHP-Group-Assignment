<?php
session_start();
require_once 'service/Admin_Analytics.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        h2 { margin-top: 50px; }
        canvas { margin: 20px 0; max-width: 600px; }
        body { font-family: Arial, sans-serif; padding: 20px; }
    </style>
</head>
<body>
    <h1>Admin Analytics Dashboard</h1>

    <h2>Most Viewed Products</h2>
    <canvas id="viewedChart"></canvas>

    <h2>Most Searched Products</h2>
    <canvas id="searchedChart"></canvas>

    <h2>Most Visited Shops</h2>
    <canvas id="shopViewedChart"></canvas>

    <h2>Most Searched Shops</h2>
    <canvas id="shopSearchedChart"></canvas>

    <h2>Most Ordered Products</h2>
    <canvas id="orderedChart"></canvas>

    <h2>Weekly Sales</h2>
    <canvas id="weeklyChart"></canvas>

    <h2>Monthly Sales</h2>
    <canvas id="monthlyChart"></canvas>

    <h2>Quarterly Sales</h2>
    <canvas id="quarterlyChart"></canvas>

    <h2>Annual Sales</h2>
    <canvas id="annuallyChart"></canvas>

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
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
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
</body>
</html>
