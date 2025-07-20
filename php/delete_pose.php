<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['id']) || !is_numeric($input['id'])) {
        throw new Exception('Invalid pose ID');
    }
    
    $pose_id = intval($input['id']);
    
    // Delete pose from database
    $sql = "DELETE FROM poses WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $pose_id]);
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('Pose not found');
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Pose deleted successfully'
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
