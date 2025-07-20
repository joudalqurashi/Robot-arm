// Robot Arm Control Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sliders and event listeners
    initializeSliders();
    initializeButtons();
    loadPoses();
    
    // Update status indicator periodically
    setInterval(updateStatus, 2000);
});

function initializeSliders() {
    // Add event listeners to all motor sliders
    for (let i = 1; i <= 6; i++) {
        const slider = document.getElementById(`motor${i}`);
        const valueDisplay = document.getElementById(`value${i}`);
        
        slider.addEventListener('input', function() {
            valueDisplay.textContent = this.value;
        });
    }
}

function initializeButtons() {
    // Reset button
    document.getElementById('resetBtn').addEventListener('click', resetMotors);
    
    // Save Pose button
    document.getElementById('savePoseBtn').addEventListener('click', showSavePoseModal);
    
    // Run button
    document.getElementById('runBtn').addEventListener('click', runCurrentPose);
    
    // Modal buttons
    document.getElementById('confirmSaveBtn').addEventListener('click', savePose);
    document.getElementById('cancelSaveBtn').addEventListener('click', hideSavePoseModal);
    document.querySelector('.close').addEventListener('click', hideSavePoseModal);
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('savePoseModal');
        if (event.target === modal) {
            hideSavePoseModal();
        }
    });
}

function resetMotors() {
    // Reset all motors to 90 degrees
    for (let i = 1; i <= 6; i++) {
        const slider = document.getElementById(`motor${i}`);
        const valueDisplay = document.getElementById(`value${i}`);
        slider.value = 90;
        valueDisplay.textContent = 90;
    }
}

function getCurrentMotorValues() {
    const values = {};
    for (let i = 1; i <= 6; i++) {
        values[`motor${i}`] = parseInt(document.getElementById(`motor${i}`).value);
    }
    return values;
}

function setMotorValues(values) {
    for (let i = 1; i <= 6; i++) {
        const slider = document.getElementById(`motor${i}`);
        const valueDisplay = document.getElementById(`value${i}`);
        const value = values[`motor${i}`] || 90;
        slider.value = value;
        valueDisplay.textContent = value;
    }
}

function showSavePoseModal() {
    document.getElementById('savePoseModal').style.display = 'block';
    document.getElementById('poseNameInput').focus();
}

function hideSavePoseModal() {
    document.getElementById('savePoseModal').style.display = 'none';
    document.getElementById('poseNameInput').value = '';
}

function savePose() {
    const poseName = document.getElementById('poseNameInput').value.trim();
    if (!poseName) {
        alert('Please enter a pose name');
        return;
    }
    
    const motorValues = getCurrentMotorValues();
    const data = {
        pose_name: poseName,
        ...motorValues
    };
    
    fetch('php/save_pose.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            hideSavePoseModal();
            loadPoses();
            showMessage('Pose saved successfully!', 'success');
        } else {
            alert('Error saving pose: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving pose');
    });
}

function loadPoses() {
    fetch('php/get_poses.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayPoses(data.poses);
        } else {
            console.error('Error loading poses:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displayPoses(poses) {
    const tbody = document.getElementById('posesTableBody');
    tbody.innerHTML = '';
    
    poses.forEach((pose, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${pose.motor1}</td>
            <td>${pose.motor2}</td>
            <td>${pose.motor3}</td>
            <td>${pose.motor4}</td>
            <td>${pose.motor5}</td>
            <td>${pose.motor6}</td>
            <td class="action-buttons">
                <button class="btn btn-primary btn-small" onclick="loadPose(${pose.id})">Load</button>
                <button class="btn btn-danger btn-small" onclick="removePose(${pose.id})">Remove</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function loadPose(poseId) {
    fetch(`php/get_pose.php?id=${poseId}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            setMotorValues(data.pose);
            showMessage('Pose loaded successfully!', 'success');
        } else {
            alert('Error loading pose: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading pose');
    });
}

function removePose(poseId) {
    if (confirm('Are you sure you want to remove this pose?')) {
        fetch('php/delete_pose.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: poseId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadPoses();
                showMessage('Pose removed successfully!', 'success');
            } else {
                alert('Error removing pose: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing pose');
        });
    }
}

function runCurrentPose() {
    const motorValues = getCurrentMotorValues();
    
    fetch('php/run_pose.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(motorValues)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage('Robot arm is running!', 'success');
            updateStatusIndicator(true);
        } else {
            alert('Error running pose: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error running pose');
    });
}

function updateStatus() {
    fetch('php/get_status.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateStatusIndicator(data.status.status === 1);
        }
    })
    .catch(error => {
        console.error('Error updating status:', error);
    });
}

function updateStatusIndicator(isRunning) {
    const indicator = document.getElementById('statusIndicator');
    if (isRunning) {
        indicator.classList.add('running');
    } else {
        indicator.classList.remove('running');
    }
}

function showMessage(message, type) {
    // Create a temporary message element
    const messageDiv = document.createElement('div');
    messageDiv.textContent = message;
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${type === 'success' ? '#28a745' : '#dc3545'};
        color: white;
        border-radius: 5px;
        z-index: 1001;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    `;
    
    document.body.appendChild(messageDiv);
    
    // Remove message after 3 seconds
    setTimeout(() => {
        document.body.removeChild(messageDiv);
    }, 3000);
}
