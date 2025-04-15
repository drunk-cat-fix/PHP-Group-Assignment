<?php
session_start();
checkAuth('vendor');

// Mock data
$mostSearchedProducts = [
    ['name' => 'Organic Apples', 'search_count' => 42],
    ['name' => 'Fresh Milk', 'search_count' => 35]
];

$mostVisitedProducts = [
    ['name' => 'Organic Apples', 'view_count' => 150],
    ['name' => 'Free-range Eggs', 'view_count' => 120]
];

$salesReports = [
    'weekly' => ['order_count' => 15, 'total_sales' => 450.50],
    'monthly' => ['order_count' => 65, 'total_sales' => 2100.00]
];
?>
<!-- Keep HTML as is but add disclaimer -->
<div class="container">
    <div class="header">
        <h1>Vendor Reports & Analytics (Demo Data)</h1>
        <p style="color:#666">Real analytics require database integration</p>
    </div>
        <div class="report-section">
            <h2>Most Searched Products</h2>
            <?php if (!empty($mostSearchedProducts)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Search Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mostSearchedProducts as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= $product['search_count'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No search data available for your products.</p>
            <?php endif; ?>
        </div>

        <div class="report-section">
            <h2>Most Visited Product Pages</h2>
            <?php if (!empty($mostVisitedProducts)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>View Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mostVisitedProducts as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= $product['view_count'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No view data available for your products.</p>
            <?php endif; ?>
        </div>

        <div class="report-section">
            <h2>Most Popular Ordered Products</h2>
            <?php if (!empty($mostPopularProducts)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Total Quantity Ordered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mostPopularProducts as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= $product['order_count'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No order data available for your products.</p>
            <?php endif; ?>
        </div>

        <div class="report-section">
            <h2>Sales Reports</h2>
            <div class="sales-cards">
                <?php foreach ($salesReports as $period => $report): ?>
                    <div class="sales-card">
                        <h3><?= ucfirst($period) ?> Sales</h3>
                        <p>Total Orders: <span class="value"><?= $report['order_count'] ?? 0 ?></span></p>
                        <p>Total Sales: <span class="value">RM <?= number_format($report['total_sales'] ?? 0, 2) ?></span></p>
                        <p>Avg Order Value: <span class="value">RM <?= number_format($report['avg_order_value'] ?? 0, 2) ?></span></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>