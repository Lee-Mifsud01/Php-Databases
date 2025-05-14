<?php
session_start();
include 'includes/dbh.php';

//Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

//Check if user is admin
$userID = $_SESSION['userID'];
$stmt = $conn->prepare("SELECT admin FROM user WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row || $row['admin'] != 1) {
    header("Location: index.php"); //redirect non-admins
    exit();
}

include 'includes/header.php';
include 'includes/topbar.php';
?>

<div class="section" style="padding: 20px;">
    <h2>Admin Panel - Manage Users</h2>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; background: #111; color: white;">
        <thead style="background: #222;">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT userID, email, admin FROM user ORDER BY userID ASC");
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['userID'] . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . ($row['admin'] ? 'Yes' : 'No') . '</td>';
                echo '<td><a href="admin.php?delete=' . $row['userID'] . '" style="color: red;" onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</a></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">No users found.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

</div>
</div>
</body>
</html>
