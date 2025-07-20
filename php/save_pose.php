<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }
    
    // Validate required fields
    $required_fields = ['pose_name', 'motor1', 'motor2', 'motor3', 'motor4', 'motor5', 'motor6'];
    foreach ($required_fields as $field) {
        if (!isset($input[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }
    
    // Validate motor values (0-180)
    for ($i = 1; $i <= 6; $i++) {
        $value = intval($input["motor$i"]);
        if ($value < 0 || $value > 180) {
            throw new Exception("Motor $i value must be between 0 and 180");
        }
    }
    
    // Validate pose name
    $pose_name = trim($input['pose_name']);
    if (empty($pose_name) || strlen($pose_name) > 100) {
        throw new Exception('Pose name must be between 1 and 100 characters');
    }
    
    // Insert pose into database
    $sql = "INSERT INTO poses (pose_name, motor1, motor2, motor3, motor4, motor5, motor6) 
            VALUES (:pose_name, :motor1, :motor2, :motor3, :motor4, :motor5, :motor6)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':pose_name' => $pose_name,
        ':motor1' => intval($input['motor1']),
        ':motor2' => intval($input['motor2']),
        ':motor3' => intval($input['motor3']),
        ':motor4' => intval($input['motor4']),
        ':motor5' => intval($input['motor5']),
        ':motor6' => intval($input['motor6'])
    ]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Pose saved successfully',
        'pose_id' => $pdo->lastInsertId()
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
