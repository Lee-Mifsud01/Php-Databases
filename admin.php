<?php
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';
include 'includes/functions.php';
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
