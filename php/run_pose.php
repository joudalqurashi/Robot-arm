<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }
    
    // Validate motor values (0-180)
    for ($i = 1; $i <= 6; $i++) {
        if (!isset($input["motor$i"])) {
            throw new Exception("Missing motor$i value");
        }
        $value = intval($input["motor$i"]);
        if ($value < 0 || $value > 180) {
            throw new Exception("Motor $i value must be between 0 and 180");
        }
    }
    
    // Update run_status table with new motor positions and set status to running (1)
    $sql = "UPDATE run_status SET 
            motor1 = :motor1, 
            motor2 = :motor2, 
            motor3 = :motor3, 
            motor4 = :motor4, 
            motor5 = :motor5, 
            motor6 = :motor6, 
            status = 1,
            last_updated = CURRENT_TIMESTAMP
            WHERE id = 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':motor1' => intval($input['motor1']),
        ':motor2' => intval($input['motor2']),
        ':motor3' => intval($input['motor3']),
        ':motor4' => intval($input['motor4']),
        ':motor5' => intval($input['motor5']),
        ':motor6' => intval($input['motor6'])
    ]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Robot arm is now running with the specified pose'
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
