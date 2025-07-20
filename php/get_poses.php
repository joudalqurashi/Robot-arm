<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Get all poses from database
    $sql = "SELECT id, pose_name, motor1, motor2, motor3, motor4, motor5, motor6, created_at 
            FROM poses 
            ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $poses = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'poses' => $poses
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
