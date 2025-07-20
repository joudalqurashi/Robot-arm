<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Get pose ID from query parameter
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception('Invalid pose ID');
    }
    
    $pose_id = intval($_GET['id']);
    
    // Get specific pose from database
    $sql = "SELECT id, pose_name, motor1, motor2, motor3, motor4, motor5, motor6 
            FROM poses 
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $pose_id]);
    $pose = $stmt->fetch();
    
    if (!$pose) {
        throw new Exception('Pose not found');
    }
    
    echo json_encode([
        'success' => true,
        'pose' => $pose
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
