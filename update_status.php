<?php
header('Content-Type: application/json');
require_once 'config/database.php';

try {
    // Update status to 0 (stopped) in run_status table
    $sql = "UPDATE run_status SET 
            status = 0,
            last_updated = CURRENT_TIMESTAMP
            WHERE id = 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('No status record found to update');
    }
    
    // Get the updated status to confirm
    $sql_check = "SELECT status, last_updated FROM run_status WHERE id = 1";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute();
    $updated_status = $stmt_check->fetch();
    
    echo json_encode([
        'success' => true,
        'message' => 'Status updated to stopped (0) successfully',
        'status' => intval($updated_status['status']),
        'last_updated' => $updated_status['last_updated']
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
