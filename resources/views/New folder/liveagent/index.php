<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Agent</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <!-- Left Sidebar -->
    <div class="left-sidebar">
        <div class="left-sidebar-header">
            <div class="header-controls">
        <button onclick="logout()">Logout</button>
        <button>Ready</button>
        <div class="search-bar">
            <input type="text" placeholder="Search or select account">
        </div>
    </div>
        </div>
   
    <!-- Tab Container -->
    <div class="tab-container">
        <div class="tab active" data-tab="incoming">Incoming</div>
        <div class="tab" data-tab="history" id="history-tab">History
            <div class="days-dropdown">
                <div class="day-option">Today</div>
                <div class="day-option my-day">Yesterday</div>
                <div class="day-option my-day">7 Days</div>
                <div class="day-option my-day">30 Days</div>
            </div>
        </div>
    </div>
    
    <!-- Incoming Tab Content -->
    <div id="incoming" class="tab-content active">
        <div>Incoming calls content goes here</div>
    </div>
    
    <!-- History Tab Content -->
    <div id="history" class="tab-content">
        <div class="history-item active">
            <div>V.1 Advance Funeral Home</div>
            <div class="history-time">(901) 356-2366 - Feb 18 1:20 PM</div>
        </div>
        <div class="history-item">
            <div>Williams and Scottish</div>
            <div class="history-time">(883) 705-0977 - Feb 18 11:12 PM</div>
        </div>
        <div class="history-item">
            <div>Mrs. Finally Service Funeral Home</div>
            <div class="history-time">(985) 544-5390 - Feb 18 15:55 PM</div>
        </div>
    </div>
    <div class="make">
    <button class="make-outbound">Make Outbound Call</button>
    </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="content-header">Williams and Scottish</h1>
        
<div class="content-card">
    <h3>Black And Clark Funeral Home</h3>
    
    <div class="detail-row">
        <span class="detail-label">Name:</span>
        <span class="detail-value" id="name-value">Black And Clark Funeral Home</span>
        <input type="text" class="edit-field" id="name-edit" value="Black And Clark Funeral Home" style="display:none;">
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Email:</span>
        <span class="detail-value" id="email-value">bcfh@blackandclark.com</span>
        <input type="email" class="edit-field" id="email-edit" value="bcfh@blackandclark.com" style="display:none;">
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Phone:</span>
        <span class="detail-value" id="phone-value">2143768297</span>
        <input type="tel" class="edit-field" id="phone-edit" value="2143768297" style="display:none;">
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Address:</span>
        <span class="detail-value" id="address-value">2517 East Illinois Street, Dallas, TX. Fax 2143761288</span>
        <input type="text" class="edit-field" id="address-edit" value="2517 East Illinois Street, Dallas, TX. Fax 2143761288" style="display:none;">
    </div>
    
    <div class="detail-row">
        <span class="detail-label">Greeting:</span>
        <span class="detail-value" id="greeting-value">Thank You For Calling Black and Clark Funeral Home</span>
        <input type="text" class="edit-field" id="greeting-edit" value="Thank You For Calling Black and Clark Funeral Home" style="display:none;">
    </div>
    
    <div class="notes-box">
        <strong>Notes:</strong> 
        <span id="notes-value">Fax: 2143761288, JOHN LEWIS IS THE FD ON CALL FOR DEATH CALLS AND PRICING AND JOJO SUNDAY IS ON FOR BACKUP and Then Mr. Pruitt, for DEATH CALL FOR DISPATCHING: CLICK (SEND BULK SMS) DEATH FORM FOR JOHN LEWIS, JOJO SUNDAY AND TO MR PRUITT, AND CLICK (SEND EMAIL AND FAX) FORM TO OFFICE EMAIL AND FAX</span>
        <textarea class="edit-field" id="notes-edit" style="display:none;">Fax: 2143761288, JOHN LEWIS IS THE FD ON CALL FOR DEATH CALLS AND PRICING AND JOJO SUNDAY IS ON FOR BACKUP and Then Mr. Pruitt, for DEATH CALL FOR DISPATCHING: CLICK (SEND BULK SMS) DEATH FORM FOR JOHN LEWIS, JOJO SUNDAY AND TO MR PRUITT, AND CLICK (SEND EMAIL AND FAX) FORM TO OFFICE EMAIL AND FAX</textarea>
    </div>
    
    <div class="action-buttons">
        <button id="edit-btn" class="edit-btn">Edit</button>
        <button id="cancel-btn" class="cancel-btn" style="display:none;">Cancel</button>
        <button id="save-btn" class="save-btn" style="display:none;">Save</button>
    </div>
    <p>Website: https://blackandclark.com</p>
</div>
        
        <div class="content-card my-box">
    <h3>Call Details</h3>
    
    <div class="call-info">
        <div class="info-row">
            <span class="info-label">From:</span>
            <span class="info-value">outbound:rlpinkney</span>
        </div>
        <div class="info-row">
            <span class="info-label">Department:</span>
            <span class="info-value"></span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value status-acknowledged">Acknowledged</span>
        </div>
        <div class="info-row">
            <span class="info-label">Acknowledged Time:</span>
            <span class="info-value">02-18-2024 11:22 pm</span>
        </div>
    </div>
    <audio controls autoplay muted>
  <source src="horse.ogg" type="audio/ogg">
  <source src="horse.mp3" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
</div>
<!--all-btn--->
<div class="button-container">
        <div class="button-row">
            <button class="action-btn primary-btn" id="startCallBtn">Start the Call</button>
            <button class="action-btn primary-btn" id="callbackBtn">Callback</button>
            <button class="action-btn primary-btn" id="holdBtn">Place on hold</button>
            <button class="action-btn primary-btn" id="transferBtn">Transfer</button>
            <button class="action-btn primary-btn" id="voicemailBtn">Send to voicemail</button>
        </div>
        <div class="button-row">
            <button class="action-btn danger-btn" id="deathCallBtn">Death Call</button>
            <button class="action-btn secondary-btn" id="emailBtn">Send Email</button>
            <button class="action-btn secondary-btn" id="smsBtn">Send SMS</button>
            <button class="action-btn secondary-btn" id="directionsBtn">Send Directions</button>
            <button class="action-btn secondary-btn" id="obituariesBtn">Send Obituaries</button>
        </div>
    </div>

    <!-- Transfer Popup -->
    <div class="popup-overlay" id="transferPopup">
        <div class="popup-content">
            <div class="popup-header">
                <div class="popup-title">Transfer Call</div>
                <button class="close-btn" id="closeTransferBtn">&times;</button>
            </div>
            <div class="popup-body">
                <div class="form-group">
                    <label for="transferTo">Transfer to:</label>
                    <select id="transferTo">
                        <option value="john">John Lewis (FD)</option>
                        <option value="jojo">JoJo Sunday (Backup)</option>
                        <option value="pruitt">Mr. Pruitt</option>
                        <option value="office">Office</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="transferNotes">Notes:</label>
                    <textarea id="transferNotes" rows="3"></textarea>
                </div>
            </div>
            <div class="popup-footer">
                <button class="action-btn primary-btn" id="confirmTransferBtn">Transfer</button>
                <button class="action-btn" id="cancelTransferBtn">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Death Call Popup -->
    <div class="popup-overlay" id="deathCallPopup">
        <div class="popup-content">
            <div class="popup-header">
                <div class="popup-title">Death Call Form</div>
                <button class="close-btn" id="closeDeathCallBtn">&times;</button>
            </div>
            <div class="popup-body">
                <div class="funeral-home">M J Edwards Funeral Home</div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Caller's Name</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Gender</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>Name of Decedent</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Location of Decedent</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>What Floor</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Room</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Zip</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>Approx Weight</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>DOB</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>Age</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>TOD</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>Doctor</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel">
                    </div>
                    <div class="form-group">
                        <label>Next of Kin</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Relationship</label>
                        <input type="text">
                    </div>
                    <div class="form-group">
                        <label>Cell</label>
                        <input type="tel">
                    </div>
                </div>
                
                <div class="action-buttons">
                    <button class="action-btn secondary-btn">Send Email</button>
                    <button class="action-btn secondary-btn">Send SMS</button>
                    <button class="action-btn secondary-btn">Send FAX</button>
                    <button class="action-btn secondary-btn">Send Bulk Emails</button>
                    <button class="action-btn secondary-btn">Send Bulk SMS</button>
                    <button class="action-btn primary-btn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Popup -->
    <div class="popup-overlay" id="emailPopup">
        <div class="popup-content">
            <div class="popup-header">
                <div class="popup-title">Send Email</div>
                <button class="close-btn" id="closeEmailBtn">&times;</button>
            </div>
            <div class="popup-body">
                <div class="form-group">
                    <label for="emailRecipient">To:</label>
                    <input type="email" id="emailRecipient">
                </div>
                <div class="form-group">
                    <label for="emailSubject">Subject:</label>
                    <input type="text" id="emailSubject">
                </div>
                <div class="form-group">
                    <label for="emailBody">Message:</label>
                    <textarea id="emailBody" rows="5"></textarea>
                </div>
            </div>
            <div class="popup-footer">
                <button class="action-btn secondary-btn" id="sendEmailBtn">Send Email</button>
                <button class="action-btn" id="cancelEmailBtn">Cancel</button>
            </div>
        </div>
    </div>
<!--all-btn--->
    </div>
    
    <!-- Right Sidebar -->
    <div class="right-sidebar">
        <div class="my-agents">
        <h3 class="right-sidebar-header">Agents</h3>
        <div class="notification">
            New call from V.1 Advance Funeral Home
        </div>
        
        <div class="notification">
            Appointment reminder for tomorrow
        </div>
        
        <div class="notification">
            System maintenance scheduled
        </div>
        
        <div class="notification">
            3 new contacts added
        </div>
        </div>
        <div class="my-agents-2">
        <div class="notification my-note">
            White Heaven Location
        </div>
        
        <div class="notification my-note">
            Appointment reminder for tomorrow
        </div>
        
        <div class="notification my-note">
            Zelma Eaton/Office Manager
        </div>
        
        <div class="notification my-note">
            Lucille Wallace
        </div>
        <div class="notification my-note">
            Wendell Naylor/FD GM
        </div>
        </div>
        

    </div>

        <script>
            // Transfer Call
        document.getElementById('transferBtn').addEventListener('click', function() {
            document.getElementById('transferPopup').style.display = 'flex';
        });
        
        document.getElementById('closeTransferBtn').addEventListener('click', function() {
            document.getElementById('transferPopup').style.display = 'none';
        });
        
        document.getElementById('cancelTransferBtn').addEventListener('click', function() {
            document.getElementById('transferPopup').style.display = 'none';
        });
        
        document.getElementById('confirmTransferBtn').addEventListener('click', function() {
            const to = document.getElementById('transferTo').value;
            const notes = document.getElementById('transferNotes').value;
            alert(`Call transferred to: ${to}\nNotes: ${notes}`);
            document.getElementById('transferPopup').style.display = 'none';
        });
        
        // Death Call
        document.getElementById('deathCallBtn').addEventListener('click', function() {
            document.getElementById('deathCallPopup').style.display = 'flex';
        });
        
        document.getElementById('closeDeathCallBtn').addEventListener('click', function() {
            document.getElementById('deathCallPopup').style.display = 'none';
        });
        
        // Email
        document.getElementById('emailBtn').addEventListener('click', function() {
            document.getElementById('emailPopup').style.display = 'flex';
        });
        
        document.getElementById('closeEmailBtn').addEventListener('click', function() {
            document.getElementById('emailPopup').style.display = 'none';
        });
        
        document.getElementById('cancelEmailBtn').addEventListener('click', function() {
            document.getElementById('emailPopup').style.display = 'none';
        });
        
        document.getElementById('sendEmailBtn').addEventListener('click', function() {
            const to = document.getElementById('emailRecipient').value;
            const subject = document.getElementById('emailSubject').value;
            const body = document.getElementById('emailBody').value;
            alert(`Email sent to: ${to}\nSubject: ${subject}\nMessage: ${body}`);
            document.getElementById('emailPopup').style.display = 'none';
        });
        
        // Other buttons with simple alerts
        document.getElementById('startCallBtn').addEventListener('click', function() {
            alert('Call started');
        });
        
        document.getElementById('callbackBtn').addEventListener('click', function() {
            alert('Callback scheduled');
        });
        
        document.getElementById('holdBtn').addEventListener('click', function() {
            alert('Call placed on hold');
        });
        
        document.getElementById('voicemailBtn').addEventListener('click', function() {
            alert('Call sent to voicemail');
        });
        
        document.getElementById('smsBtn').addEventListener('click', function() {
            alert('SMS sent');
        });
        
        document.getElementById('directionsBtn').addEventListener('click', function() {
            alert('Directions sent');
        });
        
        document.getElementById('obituariesBtn').addEventListener('click', function() {
            alert('Obituaries sent');
        });
        function logout() {
            if(confirm("Are you sure you want to logout?")) {
                // Perform logout action
                alert("Logged out successfully");
                // window.location.href = "logout.php"; // Uncomment for actual logout
            }
        }
        const historyTab = document.getElementById('history-tab');
        const dropdown = document.querySelector('.days-dropdown');
        const tabs = document.querySelectorAll('.tab');
        
        // Show/hide days dropdown when History tab is clicked
        historyTab.addEventListener('click', function(e) {
            // Only toggle if clicking the tab itself, not dropdown
            if (e.target === this) {
                dropdown.classList.toggle('show');
                
                // Close dropdown when clicking History tab again
                if (dropdown.classList.contains('show')) {
                    // Switch to History tab
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                    document.getElementById('history').classList.add('active');
                }
            }
        });
        
        // Close dropdown when clicking elsewhere
        document.addEventListener('click', function(e) {
            if (!historyTab.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
        
        // Day selection functionality
        document.querySelectorAll('.day-option').forEach(option => {
            option.addEventListener('click', function() {
                alert(`Showing history for: ${this.textContent}`);
                dropdown.classList.remove('show');
            });
        });
        
        // Make outbound call button
        document.querySelector('.make-outbound').addEventListener('click', function() {
            alert('Initiating outbound call...');
            dropdown.classList.remove('show');
        });
        
        // Tab switching (for Incoming tab)
        document.querySelector('[data-tab="incoming"]').addEventListener('click', function() {
            dropdown.classList.remove('show');
        });
        document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('edit-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const saveBtn = document.getElementById('save-btn');
        
        // Store original values
        let originalValues = {};
        
        editBtn.addEventListener('click', function() {
            // Save original values
            originalValues = {
                name: document.getElementById('name-value').textContent,
                email: document.getElementById('email-value').textContent,
                phone: document.getElementById('phone-value').textContent,
                address: document.getElementById('address-value').textContent,
                greeting: document.getElementById('greeting-value').textContent,
                notes: document.getElementById('notes-value').textContent
            };
            
            // Hide all value spans
            document.querySelectorAll('.detail-value').forEach(el => el.style.display = 'none');
            document.getElementById('notes-value').style.display = 'none';
            
            // Show all edit fields
            document.querySelectorAll('.edit-field').forEach(el => el.style.display = 'block');
            
            // Switch buttons
            editBtn.style.display = 'none';
            cancelBtn.style.display = 'inline-block';
            saveBtn.style.display = 'inline-block';
        });
        
        cancelBtn.addEventListener('click', function() {
            // Restore original values
            document.getElementById('name-value').textContent = originalValues.name;
            document.getElementById('email-value').textContent = originalValues.email;
            document.getElementById('phone-value').textContent = originalValues.phone;
            document.getElementById('address-value').textContent = originalValues.address;
            document.getElementById('greeting-value').textContent = originalValues.greeting;
            document.getElementById('notes-value').textContent = originalValues.notes;
            
            // Hide all edit fields
            document.querySelectorAll('.edit-field').forEach(el => el.style.display = 'none');
            
            // Show all value spans
            document.querySelectorAll('.detail-value').forEach(el => el.style.display = 'inline');
            document.getElementById('notes-value').style.display = 'inline';
            
            // Switch buttons
            editBtn.style.display = 'inline-block';
            cancelBtn.style.display = 'none';
            saveBtn.style.display = 'none';
        });
        
        saveBtn.addEventListener('click', function() {
            // Update values from edit fields
            document.getElementById('name-value').textContent = document.getElementById('name-edit').value;
            document.getElementById('email-value').textContent = document.getElementById('email-edit').value;
            document.getElementById('phone-value').textContent = document.getElementById('phone-edit').value;
            document.getElementById('address-value').textContent = document.getElementById('address-edit').value;
            document.getElementById('greeting-value').textContent = document.getElementById('greeting-edit').value;
            document.getElementById('notes-value').textContent = document.getElementById('notes-edit').value;
            
            // Hide all edit fields
            document.querySelectorAll('.edit-field').forEach(el => el.style.display = 'none');
            
            // Show all value spans
            document.querySelectorAll('.detail-value').forEach(el => el.style.display = 'inline');
            document.getElementById('notes-value').style.display = 'inline';
            
            // Switch buttons
            editBtn.style.display = 'inline-block';
            cancelBtn.style.display = 'none';
            saveBtn.style.display = 'none';
            
            // Here you would typically send the updated data to your server
            alert('Changes saved successfully!');
        });
    });
// Basic player functionality
    const playBtn = document.querySelector('.play-btn');
    let isPlaying = false;
    
    playBtn.addEventListener('click', function() {
        isPlaying = !isPlaying;
        playBtn.textContent = isPlaying ? '❚❚' : '▶';
        
        // Here you would integrate with your audio player API
        if (isPlaying) {
            // Start playing
        } else {
            // Pause playback
        }
    });

     
     
    </script>
</body>
</html>