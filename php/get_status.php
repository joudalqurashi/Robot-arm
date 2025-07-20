<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Get current status from run_status table
    $sql = "SELECT motor1, motor2, motor3, motor4, motor5, motor6, status, last_updated 
            FROM run_status 
            WHERE id = 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $status = $stmt->fetch();
    
    if (!$status) {
        throw new Exception('Status not found');
    }
    
    echo json_encode([
        'success' => true,
        'status' => $status
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
