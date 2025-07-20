# Robot Arm Control Panel

A comprehensive web-based control system for a 6-motor robot arm with real-time monitoring and pose management capabilities.

## Features

- **Interactive Control Panel**: Control 6 servo motors with sliders (0-180°)
- **Pose Management**: Save, load, and delete custom poses
- **Real-time Status Monitoring**: Live status display with auto-refresh
- **Database Integration**: MySQL database for persistent storage
- **Responsive Design**: Works on desktop and mobile devices

## File Structure

```
robot arm/
├── index.html              # Main control panel
├── status.html             # Status monitoring page
├── get_run_pose.php        # API to get current running pose
├── update_status.php       # API to set status = 0 (stop robot)
├── Database/
│   └── database_setup.sql        # Database schema
├── config/
│   └── database.php        # Database configuration
├── css/
│   └── style.css          # Stylesheet
├── js/
│   └── script.js          # JavaScript functionality
├── php/
│   ├── save_pose.php      # Save new poses
│   ├── get_poses.php      # Get all saved poses
│   ├── get_pose.php       # Get specific pose
│   ├── delete_pose.php    # Delete poses
│   ├── run_pose.php       # Execute poses
│   └── get_status.php     # Get current status
└── images/
    └── robot-arm.svg      # Robot arm illustration
    └── amr.jpj            # Robot arm image

```

## Setup Instructions

### 1. Database Setup

1. Start XAMPP and ensure MySQL is running
2. Open phpMyAdmin (http://localhost/phpmyadmin)
3. Import the `database_setup.sql` file to create the database and tables
4. The database will be created with sample poses

### 2. File Placement

1. Copy all files to your XAMPP htdocs directory: `c:\xampp\htdocs\New\joud\robot arm\`
2. Ensure proper folder structure is maintained

### 3. Database Configuration

The default configuration in `config/database.php` is set for XAMPP:
- Host: localhost
- Database: robot_arm_control
- Username: root
- Password: (empty)

Modify these settings if your setup is different.

## Usage

### Main Control Panel (index.html)

1. **Motor Control**: Use sliders to adjust motor angles (0-180°)
2. **Reset**: Click "Reset" to set all motors to 90° (default position)
3. **Save Pose**: Click "Save Pose" to save current motor positions
4. **Run**: Click "Run" to execute current motor positions
5. **Load Poses**: Use "Load" buttons in the table to load saved poses
6. **Remove Poses**: Use "Remove" buttons to delete saved poses

### Status Monitor (status.html)

1. **Real-time Monitoring**: Displays current motor angles and status
2. **Auto-refresh**: Updates every 2 seconds automatically
3. **Manual Refresh**: Click "Refresh Status" for immediate update
4. **Stop Robot**: Click "Stop Robot" to set status to 0
5. **Navigation**: Click "Control Panel" to return to main interface

## API Endpoints

### get_run_pose.php
- **Method**: GET
- **Purpose**: Retrieve current running pose and status
- **Response**: JSON with motor angles, status, and timestamp

### update_status.php
- **Method**: POST
- **Purpose**: Set robot status to 0 (stopped)
- **Response**: JSON confirmation with updated status

### Other PHP Scripts
- `save_pose.php`: Save new poses (POST)
- `get_poses.php`: Get all saved poses (GET)
- `get_pose.php`: Get specific pose by ID (GET)
- `delete_pose.php`: Delete pose by ID (POST)
- `run_pose.php`: Execute pose and set status to running (POST)
- `get_status.php`: Get current robot status (GET)

## Database Schema

### poses Table
- `id`: Primary key
- `pose_name`: Name of the pose
- `motor1-motor6`: Motor angles (0-180)
- `created_at`, `updated_at`: Timestamps

### run_status Table
- `id`: Primary key (always 1)
- `motor1-motor6`: Current motor positions
- `status`: 0 = stopped, 1 = running
- `last_updated`: Timestamp

## Browser Compatibility

- Chrome (recommended)
- Firefox
- Safari
- Edge

## Troubleshooting

1. **Database Connection Issues**: Check XAMPP MySQL service and database credentials
2. **File Not Found**: Ensure all files are in the correct directory structure
3. **JavaScript Errors**: Check browser console for detailed error messages
4. **AJAX Failures**: Verify PHP files are accessible and database is running



image for the Web site 

<img width="1919" height="907" alt="image" src="https://github.com/user-attachments/assets/5421be20-1f1d-42a2-9d50-f72308047d28" />


<img width="1919" height="554" alt="image" src="https://github.com/user-attachments/assets/d7431de7-49c2-4384-ac94-a6da7d68e428" />

<img width="1919" height="908" alt="image" src="https://github.com/user-attachments/assets/716f5163-cdd7-4acd-a3e5-58b050a497c8" />

<img width="1919" height="895" alt="image" src="https://github.com/user-attachments/assets/2c9b7853-d8dd-4cdd-8470-a33b415d5a69" />

<img width="1586" height="742" alt="image" src="https://github.com/user-attachments/assets/6eb0b016-3767-4da2-ac58-32267a30259e" />

<img width="1588" height="824" alt="image" src="https://github.com/user-attachments/assets/bdb85e11-caaa-4c2d-a447-008e56c4c2e7" />








