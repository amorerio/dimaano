<?php
session_start();
include('db.php');
if (!isset($_SESSION['admin'])) { header("Location: index.php"); }
$deps = mysqli_query($conn, "SELECT * FROM departments");
$pos_list = mysqli_query($conn, "SELECT * FROM positions");
$all_emps = mysqli_query($conn, "SELECT e.*, d.name as dept, p.name as pos FROM employees e LEFT JOIN departments d ON e.dept_id = d.id LEFT JOIN positions p ON e.pos_id = p.id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <div class="top-bar">
            <strong>EMPLOYEE MANAGEMENT</strong>
            <div class="nav-icons">
                <a href="#" class="nav-icon-link">👤</a>
                <a href="logout.php" class="nav-icon-link" style="color:red;">🚪</a>
            </div>
        </div>
        <div class="container">
            <h2 style="text-align:center; color:#003366;">EMPLOYEE INFORMATION</h2>
            <div class="toolbar no-print">
                <button class="tool-btn" onclick="resetForm()">➕ New</button>
                <button class="tool-btn" onclick="openM('pM')">🖨️ Print</button>
                <button class="tool-btn" onclick="openM('vM')">👁️ View</button>
            </div>
            <div class="content-card" id="printArea">
                <div class="tabs no-print">
                    <button class="tab-btn active" onclick="openT(event, 'p')">PERSONAL INFO</button>
                    <button class="tab-btn" onclick="openT(event, 'em')">EMERGENCY</button>
                    <button class="tab-btn" onclick="openT(event, 'd')">DEPENDENT</button>
                    <button class="tab-btn" onclick="openT(event, 'ed')">EDUCATION</button>
                    <button class="tab-btn" onclick="openT(event, 'r')">REFERENCE</button>
                    <button class="tab-btn" onclick="openT(event, 'pos')">POSITION</button>
                </div>
                <form id="empForm" action="manage_employees.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="empId" name="emp_id" value="">
                    <div id="p" class="tab-content active">
                        <div class="personal-container">
                            <div class="profile-pic-area">
                                <img src="images/default.png" id="imgP" class="profile-circle">
                                <input type="file" name="photo" id="phi" onchange="prev(this)" style="display:none;">
                                <button type="button" class="btn-yellow" onclick="document.getElementById('phi').click()">UPLOAD</button>
                            </div>
                            <div class="form-grid" style="flex:1;">
                                <div><label>Emp No.</label><input type="text" name="emp_no" required></div>
                                <div><label>Password</label><input type="password" name="pass" required></div>
                                <div><label>Last Name</label><input type="text" name="lname" required></div>
                                <div><label>First Name</label><input type="text" name="fname" required></div>
                                <div><label>Middle Name</label><input type="text" name="mname"></div>
                                <div><label>Gender</label><select name="gender" required><option value="">-- Select --</option><option>Male</option><option>Female</option></select></div>
                                <div><label>Email</label><input type="email" name="email" required></div>
                                <div><label>Civil Status</label><input type="text" name="status" required></div>
                            </div>
                        </div>
                        <div class="form-grid" style="margin-top:20px;">
                            <div><label>Nationality</label><input type="text" name="nat"></div>
                            <div><label>Religion</label><input type="text" name="rel"></div>
                            <div><label>Birth Date</label><input type="date" name="bdate"></div>
                            <div><label>Perm. Address</label><input type="text" name="p_addr"></div>
                            <div><label>Pres. Address</label><input type="text" name="curr_addr"></div>
                            <div><label>Contact</label><input type="text" name="cont"></div>
                            <div><label>SSS</label><input type="text" name="sss"></div>
                            <div><label>Philhealth</label><input type="text" name="phil"></div>
                            <div><label>Pag-ibig</label><input type="text" name="pag"></div>
                            <div><label>ATM</label><input type="text" name="atm"></div>
                            <div><label>TIN</label><input type="text" name="tin"></div>
                        </div>
                    </div>
                    <div id="em" class="tab-content">
                        <div class="form-grid">
                            <div><label>Name</label><input type="text" id="en"></div>
                            <div><label>Rel.</label><input type="text" id="er"></div>
                            <div><label>Addr.</label><input type="text" id="ea"></div>
                            <div><label>Cont.</label><input type="text" id="ec"></div>
                            <button type="button" class="btn-yellow" onclick="addB('eB','emergency',['en','er','ea','ec'])">Add</button>
                        </div>
                        <div class="data-box" id="eB"></div>
                    </div>
                    <div id="d" class="tab-content">
                        <div class="form-grid">
                            <div><label>Name</label><input type="text" id="dn"></div>
                            <div><label>B-Date</label><input type="date" id="db"></div>
                            <div><label>Rel.</label><input type="text" id="dr"></div>
                            <button type="button" class="btn-yellow" onclick="addB('dB','dependent',['dn','db','dr'])">Add</button>
                        </div>
                        <div class="data-box" id="dB"></div>
                    </div>
                    <div id="ed" class="tab-content">
                        <div class="form-grid">
                            <div><label>School</label><input type="text" id="sn"></div>
                            <div><label>Addr.</label><input type="text" id="sa"></div>
                            <div><label>S.Y.</label><input type="text" id="sy"></div>
                            <div><label>Level</label><select id="sl"><option>Primary</option><option>Secondary</option></select></div>
                            <button type="button" class="btn-yellow" onclick="addB('eduB','education',['sn','sa','sy','sl'])">Add</button>
                        </div>
                        <div class="data-box" id="eduB"></div>
                    </div>
                    <div id="r" class="tab-content">
                        <div class="form-grid">
                            <div><label>Name</label><input type="text" id="rn"></div>
                            <div><label>Occ.</label><input type="text" id="ro"></div>
                            <div><label>Addr.</label><input type="text" id="ra"></div>
                            <div><label>Cont.</label><input type="text" id="rc"></div>
                            <button type="button" class="btn-yellow" onclick="addB('rB','reference',['rn','ro','ra','rc'])">Add</button>
                        </div>
                        <div class="data-box" id="rB"></div>
                    </div>
                    <div id="pos" class="tab-content">
                        <div class="form-grid">
                            <div><label>Dept</label><select name="dept" id="pd" required><?php mysqli_data_seek($deps, 0); while($d=mysqli_fetch_assoc($deps)) echo "<option value='".$d['id']."'>".$d['name']."</option>"; ?></select></div>
                            <div><label>Pos</label><select name="pos" id="pp" required><?php mysqli_data_seek($pos_list, 0); while($p=mysqli_fetch_assoc($pos_list)) echo "<option value='".$p['id']."'>".$p['name']."</option>"; ?></select></div>
                            <div><label>Start</label><input type="date" name="s_date" id="ps" required></div>
                            <div><label>End</label><input type="date" name="e_date" id="pe" required></div>
                            <div><label>Monthly</label><input type="text" name="m_pay" id="mp" required oninput="calculatePay()"></div>
                            <div><label>Daily</label><input type="text" name="d_pay" id="dp" readonly></div>
                            <div><label>Hourly</label><input type="text" name="h_pay" id="hp" readonly></div>
                            <button type="button" class="btn-yellow" onclick="addB('pB','position',['pd','pp','ps','pe','mp','dp','hp'])">Add</button>
                        </div>
                        <div class="data-box" id="pB"></div>
                    </div>
                    <div style="padding:20px; text-align:right; gap:10px; display:flex; justify-content:flex-end;" class="no-print">
                        <button type="button" id="editBtn" class="tool-btn" style="display:none; background-color:#FFA500; color:white;" onclick="enableEditMode()">✏️ EDIT</button>
                        <button type="submit" name="save_employee" id="saveBtn" class="tool-btn" style="background-color:#28a745; color:white; opacity:0.5; cursor:not-allowed;" disabled>💾 SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="pM" class="modal"><div class="modal-content" style="width:400px; text-align:center;"><h3>Print Preview</h3><button class="btn-yellow" onclick="window.print()">PROCEED</button> <button type="button" onclick="closeM('pM')">CLOSE</button></div></div>
    <div id="vM" class="modal"><div class="modal-content"><h3>Employee Records</h3><input type="text" placeholder="Search..." onkeyup="sE(this.value)"><table id="eT"><thead><tr><th>Photo</th><th>ID</th><th>Name</th><th>Dept</th><th>Pos</th></tr></thead><tbody><?php mysqli_data_seek($all_emps,0); while($r=mysqli_fetch_assoc($all_emps)){ ?><tr style="cursor:pointer;" onclick="loadEmployeeData(<?php echo $r['id']; ?>)"><td><img src="images/<?php echo $r['photo']; ?>" width="40" height="40" style="border-radius:50%"></td><td><?php echo $r['emp_no']; ?></td><td><?php echo $r['fname']." ".$r['lname']; ?></td><td><?php echo $r['dept']; ?></td><td><?php echo $r['pos']; ?></td></tr><?php } ?></tbody></table><br><button type="button" onclick="closeM('vM')">Close</button></div></div>
    <script>
        // Get form and buttons
        const form = document.getElementById('empForm');
        const saveBtn = document.getElementById('saveBtn');
        const editBtn = document.getElementById('editBtn');
        const empIdInput = document.getElementById('empId');
        let itemCounter = 0;
        
        // Function to reset form and hide edit button
        function resetForm() {
            form.reset();
            empIdInput.value = '';
            editBtn.style.display = 'none';
            document.getElementById('imgP').src = 'images/default.png';
            ['eB', 'dB', 'eduB', 'rB'].forEach(id => document.getElementById(id).innerHTML = '');
            validateForm();
        }
        
        // Function to validate all required fields
        function validateForm() {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value || field.value.trim() === '') {
                    isValid = false;
                }
            });
            saveBtn.disabled = !isValid;
            saveBtn.style.opacity = isValid ? '1' : '0.5';
            saveBtn.style.cursor = isValid ? 'pointer' : 'not-allowed';
        }
        
        // Add event listeners to all input and select fields
        const allInputs = form.querySelectorAll('input, select');
        allInputs.forEach(input => {
            input.addEventListener('change', validateForm);
            input.addEventListener('input', validateForm);
        });
        
        // Initial validation on page load
        window.addEventListener('load', validateForm);
        
        // Function to create data item with edit/delete buttons
        function createDataItem(boxId, type, values) {
            let box = document.getElementById(boxId);
            let itemId = 'item_' + itemCounter++;
            let div = document.createElement('div');
            div.id = itemId;
            div.style.padding = '8px';
            div.style.borderBottom = '1px solid #eee';
            div.style.display = 'flex';
            div.style.justifyContent = 'space-between';
            div.style.alignItems = 'center';
            
            let content = document.createElement('span');
            content.innerHTML = "• " + values.filter(x => x).join(" | ");
            
            let actions = document.createElement('div');
            actions.style.display = 'flex';
            actions.style.gap = '5px';
            
            let editBtn = document.createElement('button');
            editBtn.type = 'button';
            editBtn.innerHTML = '✏️';
            editBtn.style.padding = '2px 6px';
            editBtn.style.cursor = 'pointer';
            editBtn.style.border = 'none';
            editBtn.style.background = '#FFA500';
            editBtn.style.color = 'white';
            editBtn.style.borderRadius = '3px';
            editBtn.onclick = () => editItem(itemId, type, boxId);
            
            let deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.innerHTML = '🗑️';
            deleteBtn.style.padding = '2px 6px';
            deleteBtn.style.cursor = 'pointer';
            deleteBtn.style.border = 'none';
            deleteBtn.style.background = '#dc3545';
            deleteBtn.style.color = 'white';
            deleteBtn.style.borderRadius = '3px';
            deleteBtn.onclick = () => deleteItem(itemId);
            
            actions.appendChild(editBtn);
            actions.appendChild(deleteBtn);
            
            div.appendChild(content);
            div.appendChild(actions);
            div.dataset.type = type;
            div.dataset.values = JSON.stringify(values);
            box.appendChild(div);
        }
        
        // Function to edit an item
        function editItem(itemId, type, boxId) {
            let item = document.getElementById(itemId);
            let values = JSON.parse(item.dataset.values);
            
            let fieldIds = [];
            if (type === 'emergency') fieldIds = ['en', 'er', 'ea', 'ec'];
            else if (type === 'dependent') fieldIds = ['dn', 'db', 'dr'];
            else if (type === 'education') fieldIds = ['sn', 'sa', 'sy', 'sl'];
            else if (type === 'reference') fieldIds = ['rn', 'ro', 'ra', 'rc'];
            
            fieldIds.forEach((id, idx) => {
                document.getElementById(id).value = values[idx] || '';
            });
            
            deleteItem(itemId);
        }
        
        // Function to delete an item
        function deleteItem(itemId) {
            document.getElementById(itemId).remove();
        }
        
        // Function to enable edit mode
        function enableEditMode() {
            alert('Edit mode enabled. You can modify any field and save changes.');
        }
        
        // Function to load complete employee data from server
        function loadEmployeeData(empId) {
            fetch('fetch_employee.php?id=' + empId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const emp = data.employee;
                        empIdInput.value = empId;
                        
                        // Fill personal info
                        document.querySelector('input[name="emp_no"]').value = emp.emp_no || '';
                        document.querySelector('input[name="pass"]').value = emp.portal_password || '';
                        document.querySelector('input[name="lname"]').value = emp.lname || '';
                        document.querySelector('input[name="fname"]').value = emp.fname || '';
                        document.querySelector('input[name="mname"]').value = emp.mname || '';
                        document.querySelector('select[name="gender"]').value = emp.gender || '';
                        document.querySelector('input[name="email"]').value = emp.email || '';
                        document.querySelector('input[name="status"]').value = emp.civil_status || '';
                        document.querySelector('input[name="nat"]').value = emp.nationality || '';
                        document.querySelector('input[name="rel"]').value = emp.religion || '';
                        document.querySelector('input[name="bdate"]').value = emp.bdate || '';
                        document.querySelector('input[name="p_addr"]').value = emp.perm_address || '';
                        document.querySelector('input[name="curr_addr"]').value = emp.pres_address || '';
                        document.querySelector('input[name="cont"]').value = emp.contact || '';
                        document.querySelector('input[name="sss"]').value = emp.sss || '';
                        document.querySelector('input[name="phil"]').value = emp.philhealth || '';
                        document.querySelector('input[name="pag"]').value = emp.pagibig || '';
                        document.querySelector('input[name="atm"]').value = emp.atm || '';
                        document.querySelector('input[name="tin"]').value = emp.tin || '';
                        
                        // Fill position info
                        document.querySelector('select[name="dept"]').value = emp.dept_id || '';
                        document.querySelector('select[name="pos"]').value = emp.pos_id || '';
                        document.querySelector('input[name="s_date"]').value = emp.start_date || '';
                        document.querySelector('input[name="e_date"]').value = emp.end_date || '';
                        document.querySelector('input[name="m_pay"]').value = emp.monthly_pay || '';
                        document.querySelector('input[name="d_pay"]').value = emp.daily_pay || '';
                        document.querySelector('input[name="h_pay"]').value = emp.hourly_pay || '';
                        
                        // Set profile picture
                        if (emp.photo && emp.photo !== 'default.png') {
                            document.getElementById('imgP').src = 'images/' + emp.photo;
                        } else {
                            document.getElementById('imgP').src = 'images/default.png';
                        }
                        
                        // Load emergency contacts with edit/delete buttons
                        const eB = document.getElementById('eB');
                        eB.innerHTML = '';
                        if (data.emergency && data.emergency.length > 0) {
                            data.emergency.forEach(e => {
                                createDataItem('eB', 'emergency', [e.name, e.relation, e.address, e.contact]);
                            });
                        }
                        
                        // Load dependents with edit/delete buttons
                        const dB = document.getElementById('dB');
                        dB.innerHTML = '';
                        if (data.dependents && data.dependents.length > 0) {
                            data.dependents.forEach(d => {
                                createDataItem('dB', 'dependent', [d.name, d.birthdate, d.relation]);
                            });
                        }
                        
                        // Load education with edit/delete buttons
                        const eduB = document.getElementById('eduB');
                        eduB.innerHTML = '';
                        if (data.education && data.education.length > 0) {
                            data.education.forEach(e => {
                                createDataItem('eduB', 'education', [e.school_name, e.address, e.school_year, e.level]);
                            });
                        }
                        
                        // Load references with edit/delete buttons
                        const rB = document.getElementById('rB');
                        rB.innerHTML = '';
                        if (data.references && data.references.length > 0) {
                            data.references.forEach(r => {
                                createDataItem('rB', 'reference', [r.name, r.occupation, r.address, r.contact]);
                            });
                        }
                        
                        // Show edit button when loading existing employee
                        editBtn.style.display = 'inline-block';
                        closeM('vM');
                        validateForm();
                    } else {
                        alert('Error loading employee data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading employee data');
                });
        }
        
        function calculatePay() {
            let monthly = parseFloat(document.getElementById('mp').value) || 0;
            let daily = monthly / 22;
            let hourly = daily / 8;
            document.getElementById('dp').value = daily.toFixed(2);
            document.getElementById('hp').value = hourly.toFixed(2);
            validateForm();
        }
        
        function openM(id){document.getElementById(id).style.display='flex';}
        function closeM(id){document.getElementById(id).style.display='none';}
        function openT(e,t){let tc=document.querySelectorAll(".tab-content");tc.forEach(c=>c.style.display="none");let tb=document.querySelectorAll(".tab-btn");tb.forEach(b=>b.classList.remove("active"));document.getElementById(t).style.display="block";e.currentTarget.classList.add("active");}
        function prev(i){if(i.files && i.files[0]){let r=new FileReader();r.onload=e=>document.getElementById('imgP').src=e.target.result;r.readAsDataURL(i.files[0]);}}
        
        function addB(boxId, type, fieldIds) {
            let values = [];
            fieldIds.forEach(id => {
                let el = document.getElementById(id);
                let val = el.tagName === "SELECT" ? el.options[el.selectedIndex].text : el.value;
                if (val) values.push(val);
                el.value = '';
            });
            if (values.length > 0) {
                createDataItem(boxId, type, values);
            }
        }
        
        function sE(v){let f=v.toLowerCase();let tr=document.querySelectorAll("#eT tbody tr");tr.forEach(r=>r.style.display=r.innerText.toLowerCase().includes(f)?"":"none");}
    </script>
</body>
</html>