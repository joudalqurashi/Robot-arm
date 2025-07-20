<?php
header('Content-Type: application/json');
require_once 'config/database.php';

try {
    // Get current running pose from run_status table
    $sql = "SELECT motor1, motor2, motor3, motor4, motor5, motor6, status, last_updated 
            FROM run_status 
            WHERE id = 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $run_pose = $stmt->fetch();
    
    if (!$run_pose) {
        throw new Exception('Run pose not found');
    }
    
    // Format the response
    $response = [
        'success' => true,
        'run_pose' => [
            'motor1' => intval($run_pose['motor1']),
            'motor2' => intval($run_pose['motor2']),
            'motor3' => intval($run_pose['motor3']),
            'motor4' => intval($run_pose['motor4']),
            'motor5' => intval($run_pose['motor5']),
            'motor6' => intval($run_pose['motor6']),
            'status' => intval($run_pose['status']),
            'status_text' => $run_pose['status'] == 1 ? 'Running' : 'Stopped',
            'last_updated' => $run_pose['last_updated']
        ]
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
