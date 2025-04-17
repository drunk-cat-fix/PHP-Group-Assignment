<?php
require_once __DIR__ . '\..\Utilities\Connection.php';

$conn = getConnection();

// Define sortable columns
$validSortColumns = ['complaint_id', 'complaint_subject', 'complaint_against', 'complaint_time', 'solved'];
$sort = $_GET['sort'] ?? 'complaint_time';
$order = $_GET['order'] ?? 'desc';

// Sanitize input
if (!in_array($sort, $validSortColumns)) {
    $sort = 'complaint_time';
}
$order = strtolower($order) === 'asc' ? 'asc' : 'desc';
$nextOrder = $order === 'asc' ? 'desc' : 'asc';

// Query with dynamic sort
$sql = "SELECT 
            c.complaint_id,
            cu.customer_name,
            c.complaint_subject,
            c.complaint_against,
            c.complaint_time,
            c.solved
        FROM complaint c
        JOIN customer cu ON c.customer_id = cu.customer_id
        ORDER BY $sort $order";

$stmt = $conn->prepare($sql);
$stmt->execute();
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);

function sortLink($label, $column, $currentSort, $currentOrder) {
    $arrow = '';
    if ($column === $currentSort) {
        $arrow = $currentOrder === 'asc' ? ' ▲' : ' ▼';
    }
    $newOrder = $currentOrder === 'asc' && $column === $currentSort ? 'desc' : 'asc';
    return "<a href='?sort=$column&order=$newOrder'>$label$arrow</a>";
}
?>