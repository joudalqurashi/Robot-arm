-- Robot Arm Control Database Schema
-- Create database
CREATE DATABASE IF NOT EXISTS robot_arm_control;
USE robot_arm_control;

-- Table for storing saved poses
CREATE TABLE IF NOT EXISTS poses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pose_name VARCHAR(100) NOT NULL,
    motor1 INT NOT NULL DEFAULT 90 CHECK (motor1 >= 0 AND motor1 <= 180),
    motor2 INT NOT NULL DEFAULT 90 CHECK (motor2 >= 0 AND motor2 <= 180),
    motor3 INT NOT NULL DEFAULT 90 CHECK (motor3 >= 0 AND motor3 <= 180),
    motor4 INT NOT NULL DEFAULT 90 CHECK (motor4 >= 0 AND motor4 <= 180),
    motor5 INT NOT NULL DEFAULT 90 CHECK (motor5 >= 0 AND motor5 <= 180),
    motor6 INT NOT NULL DEFAULT 90 CHECK (motor6 >= 0 AND motor6 <= 180),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for storing run status and current motor positions
CREATE TABLE IF NOT EXISTS run_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    motor1 INT NOT NULL DEFAULT 90 CHECK (motor1 >= 0 AND motor1 <= 180),
    motor2 INT NOT NULL DEFAULT 90 CHECK (motor2 >= 0 AND motor2 <= 180),
    motor3 INT NOT NULL DEFAULT 90 CHECK (motor3 >= 0 AND motor3 <= 180),
    motor4 INT NOT NULL DEFAULT 90 CHECK (motor4 >= 0 AND motor4 <= 180),
    motor5 INT NOT NULL DEFAULT 90 CHECK (motor5 >= 0 AND motor5 <= 180),
    motor6 INT NOT NULL DEFAULT 90 CHECK (motor6 >= 0 AND motor6 <= 180),
    status INT NOT NULL DEFAULT 0, -- 0 = stopped, 1 = running
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert initial run status record
INSERT INTO run_status (motor1, motor2, motor3, motor4, motor5, motor6, status) 
VALUES (90, 90, 90, 90, 90, 90, 0);

-- Insert some sample poses for demonstration
INSERT INTO poses (pose_name, motor1, motor2, motor3, motor4, motor5, motor6) VALUES
('Default Position', 90, 90, 90, 90, 90, 90),
('Home Position', 90, 90, 90, 59, 115, 34),
('Pickup Position', 137, 55, 90, 26, 90, 90),
('Extended Reach', 90, 115, 90, 69, 90, 33);
