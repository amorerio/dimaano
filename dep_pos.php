<?php
session_start();
include('db.php');
if (!isset($_SESSION['admin'])) { header("Location: index.php"); }

$d_total_query = mysqli_query($conn, "SELECT COUNT(*) as t FROM departments");
$d_total = mysqli_fetch_assoc($d_total_query)['t'];

$p_total_query = mysqli_query($conn, "SELECT COUNT(*) as t FROM positions");
$p_total = mysqli_fetch_assoc($p_total_query)['t'];

$d_limit = isset($_GET['d_limit']) ? $_GET['d_limit'] : 10;
$p_limit = isset($_GET['p_limit']) ? $_GET['p_limit'] : 10;

$deps = mysqli_query($conn, "SELECT * FROM departments LIMIT $d_limit");
$pos = mysqli_query($conn, "SELECT * FROM positions LIMIT $p_limit");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dept & Pos | LCC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <div class="top-bar">
            <strong>DEPARTMENT & POSITION</strong>
            <div class="nav-icons">
                <a href="#" class="nav-icon-link">👤</a>
                <a href="logout.php" class="nav-icon-link" style="color:red;">🚪</a>
            </div>
        </div>

        <div class="container">
            <div style="display: flex; gap: 20px;">
                <!-- DEPT TABLE -->
                <div class="content-card" style="flex: 1;">
                    <div class="card-header">DEPARTMENT</div>
                    <div class="card-body">
                        <button class="btn-yellow" onclick="openM('addD')">+ Add Department</button>
                        <div class="table-controls" style="margin-top:15px; flex-direction: column; gap: 20px; align-items: flex-start;">
                            <div>Show Entries: 
                                <select onchange="location.href='dep_pos.php?d_limit='+this.value+'&p_limit=<?php echo $p_limit; ?>'" style="width: 70px; padding: 5px;">
                                    <?php for($i=1; $i<=$d_total; $i++) echo "<option ".($i==$d_limit?'selected':'').">$i</option>"; ?>
                                </select>
                            </div>
                            <div>Search: <input type="text" onkeyup="search(this, 'dT')" style="width: 180px; padding: 5px;"></div>
                        </div>
                        <table id="dT">
                            <thead><tr><th>NAME</th><th style="width:80px;">ACTION</th></tr></thead>
                            <tbody>
                                <?php while($r = mysqli_fetch_assoc($deps)) { ?>
                                    <tr>
                                        <td><?php echo $r['name']; ?></td>
                                        <td>
                                            <button onclick="editD(<?php echo $r['id']; ?>,'<?php echo $r['name']; ?>')">✏️</button>
                                            <a href="manage_dep_pos.php?del_dept=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">🗑️</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="table-footer">
                            <div>Showing 1 to <?php echo mysqli_num_rows($deps); ?> of <?php echo $d_total; ?> entries</div>
                            <div class="pagination">
                                <a href="#" class="page-link">Previous</a>
                                <a href="#" class="page-link active">1</a>
                                <a href="#" class="page-link">Next</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- POSITION TABLE -->
                <div class="content-card" style="flex: 1;">
                    <div class="card-header">POSITION</div>
                    <div class="card-body">
                        <button class="btn-yellow" onclick="openM('addP')">+ Add Position</button>
                        <div class="table-controls" style="margin-top:15px; flex-direction: column; gap: 20px; align-items: flex-start;">
                            <div>Show Entries: 
                                <select onchange="location.href='dep_pos.php?p_limit='+this.value+'&d_limit=<?php echo $d_limit; ?>'" style="width: 70px; padding: 5px;">
                                    <?php for($i=1; $i<=$p_total; $i++) echo "<option ".($i==$p_limit?'selected':'').">$i</option>"; ?>
                                </select>
                            </div>
                            <div>Search: <input type="text" onkeyup="search(this, 'pT')" style="width: 180px; padding: 5px;"></div>
                        </div>
                        <table id="pT">
                            <thead><tr><th>NAME</th><th style="width:80px;">ACTION</th></tr></thead>
                            <tbody>
                                <?php while($r = mysqli_fetch_assoc($pos)) { ?>
                                    <tr>
                                        <td><?php echo $r['name']; ?></td>
                                        <td>
                                            <button onclick="editP(<?php echo $r['id']; ?>,'<?php echo $r['name']; ?>')">✏️</button>
                                            <a href="manage_dep_pos.php?del_pos=<?php echo $r['id']; ?>" onclick="return confirm('Delete?')">🗑️</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="table-footer">
                            <div>Showing 1 to <?php echo mysqli_num_rows($pos); ?> of <?php echo $p_total; ?> entries</div>
                            <div class="pagination">
                                <a href="#" class="page-link">Previous</a>
                                <a href="#" class="page-link active">1</a>
                                <a href="#" class="page-link">Next</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS -->
    <div id="addD" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeM('addD')">&times;</span><form action="manage_dep_pos.php" method="POST"><h3>Add Dept</h3><input type="text" name="dept_name" required><br><br><button type="submit" name="add_dept" class="btn-yellow" style="width:100%;">Save</button></form></div></div>
    <div id="addP" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeM('addP')">&times;</span><form action="manage_dep_pos.php" method="POST"><h3>Add Pos</h3><input type="text" name="pos_name" required><br><br><button type="submit" name="add_pos" class="btn-yellow" style="width:100%;">Save</button></form></div></div>
    <div id="editD" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeM('editD')">&times;</span><form action="manage_dep_pos.php" method="POST"><h3>Edit Dept</h3><input type="hidden" name="dept_id" id="did"><input type="text" name="dept_name" id="dn" required><br><br><button type="submit" name="edit_dept" class="btn-yellow" style="width:100%;">Update</button></form></div></div>
    <div id="editP" class="modal"><div class="modal-content"><span class="close-btn" onclick="closeM('editP')">&times;</span><form action="manage_dep_pos.php" method="POST"><h3>Edit Pos</h3><input type="hidden" name="pos_id" id="pid"><input type="text" name="pos_name" id="pn" required><br><br><button type="submit" name="edit_pos" class="btn-yellow" style="width:100%;">Update</button></form></div></div>

    <script>
        function openM(id){document.getElementById(id).style.display='flex';}
        function closeM(id){document.getElementById(id).style.display='none';}
        function editD(id,n){document.getElementById('did').value=id;document.getElementById('dn').value=n;openM('editD');}
        function editP(id,n){document.getElementById('pid').value=id;document.getElementById('pn').value=n;openM('editP');}
        function search(i,t){let f=i.value.toLowerCase();let tr=document.querySelectorAll("#"+t+" tbody tr");tr.forEach(r=>{r.style.display=r.innerText.toLowerCase().includes(f)?"":"none";});}
    </script>
</body>
</html>