<?php
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

// TEMPorary USER ID 
//set this manually while youre not logged in
$userID = 1; // CHANGE THIS to your user id

//Function to delete user
function deleteUser($conn, $deleteID) {
    //Delete from dependent tables first
    $tables = ['albumbadge', 'payment', 'playlist'];
    foreach ($tables as $table) {
        $stmt = $conn->prepare("DELETE FROM $table WHERE userID = ?");
        if (!$stmt) {
            echo "<p style='color:red;'>Error preparing DELETE from $table</p>";
            return false;
        }
        $stmt->bind_param("i", $deleteID);
        $stmt->execute();
        $stmt->close();
    }

    
    $stmt = $conn->prepare("DELETE FROM user WHERE userID = ?");
    if (!$stmt) {
        echo "<p style='color:red;'>Error preparing DELETE from user</p>";
        return false;
    }
    $stmt->bind_param("i", $deleteID);
    $stmt->execute();
    $stmt->close();
    return true;
}



if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteID = (int) $_GET['delete'];

    if ($deleteID == $userID) {
        echo "<p style='color:red;'>You cannot delete yourself.</p>";
    } else {
        if (deleteUser($conn, $deleteID)) {
            // Redirect to avoid resubmission
            header("Location: admin.php");
            exit();
        } else {
            echo "<p style='color:red;'>Failed to delete user.</p>";
        }
    }
}
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
