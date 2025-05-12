<?php
session_start();
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

$userID = $_SESSION['userID'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['languageID'])) {
  $languageID = intval($_POST['languageID']);
  $update = "UPDATE user SET languageID = $languageID WHERE userID = $userID";
  mysqli_query($conn, $update);

  // Redirect to avoid form resubmission and load updated value
  header("Location: settings.php?saved=1");
  exit();
}

// Get current language for the user
$currentLangID = null;
$prefQuery = "SELECT languageID FROM user WHERE userID = $userID";
$prefResult = mysqli_query($conn, $prefQuery);
if ($prefRow = mysqli_fetch_assoc($prefResult)) {
  $currentLangID = $prefRow['languageID'];
}

// Fetch all available languages
$sql = "SELECT languageID, languageName FROM language";
$result = mysqli_query($conn, $sql);
?>

<div class="main-content">
  <h1>Settings</h1>

  <?php if (isset($_GET['saved']) && $_GET['saved'] == 1): ?>
    <p style="color: green;">Language preference saved successfully.</p>
  <?php endif; ?>

  <section class="settings-section">
    <h2>Account</h2>
    <a href="profile.php" class="settings-link">Edit Login</a>
  </section>

  <section class="settings-section">
    <h2>Language</h2>
    <form action="settings.php" method="POST">
      <label for="language-select">Choose Language</label>
      <select name="languageID" id="language-select" class="language-dropdown">
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <option value="<?php echo $row['languageID']; ?>"
              <?php if ($row['languageID'] == $currentLangID) echo 'selected'; ?>>
              <?php echo htmlspecialchars($row['languageName']); ?>
            </option>
          <?php endwhile; ?>
        <?php else: ?>
          <option disabled>No languages available</option>
        <?php endif; ?>
      </select>
      <button type="submit">Save</button>
    </form>
  </section>
</div>
