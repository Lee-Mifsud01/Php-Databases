<?php
// Start the session to access user session data
session_start();
include 'includes/dbh.php'; // Database connection

//Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect if not logged in
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

// If the user is not an admin, redirect them to the homepage
if (!$row || $row['admin'] != 1) {
    header("Location: index.php"); 
    exit();
}

include 'includes/header.php';
include 'includes/topbar.php';
?>

<!-- admin ui -->
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
                // Delete link with confirmation prompt
                echo '<td><a href="admin.php?delete=' . $row['userID'] . '" style="color: red;" onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</a></td>';
                echo '</tr>';
            }
        } else {
            // Display message if no users are found
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
