# MyTunes 

MyTunes is a music library management and discovery platform built with PHP and MySQL. Users can browse albums, tracks, artists, playlists, and manage profiles. Admins can delete users from the admin panel button.

---

## Features

-  Browse, search, and stream tracks & albums
-  User authentication and profile management
-  Upload profile pictures and update personal settings
-  Artist merchandise integration (wearables, vinyls, CDs, etc.)
-  Subscriptions and payment flow (including fake receipt & confirmation)
-  Earn and view music-related badges
-  Spotify API integration for real artist data
-  Clean Neumorphic UI with responsive layout

---

## Project Structure

PHP-DATABASES/
├── API/ # External API scripts
├── images/ # Icons and assets (like play, next, queue)
├── includes/ # Reusable components (header, db, sidebar, topbar)
│ ├── dbh.php # Database connection
│ ├── header.php # HTML head content
│ ├── topbar.php # Top navigation bar
│ └── login-inc.php # Login logic
├── uploads/ # User-uploaded profile
├── vendor/ # Composer dependencies
├── .env # Environment variables (credentials, API keys for google)
├── .gitignore # Git exclusions
├── style.css # Project styling
├── README.md 
├── index.php # Homepage
├── login.php # User login
├── register.php # User registration
├── profile.php # Profile & settings
├── artist.php # Artist details
├── album.php # Album and track view
├── tracks.php # Track details
├── library.php # User's saved playlists
├── admin.php # Admin panel
├── search.php # Track/album/artist search
├── product.php # Merchandise product page
├── all-merch.php # Browse all merch
├── subscriptions.php # View plans
├── purchase_subscription.php
├── cancel_subscription.php
├── payment.php / payment_receipt.php / confirm_payment.php


---

## Technologies

- PHP (procedural + prepared statements)
- MySQL (phpMyAdmin, foreign keys, joins)
- HTML/CSS with custom styling
- Spotify Web API (cURL with OAuth token)

---

## Setup Instructions

Setup Instructions

1. Clone the Repository

git clone https://github.com/Lee-Mifsud01/Php-Databases.git
cd Php-Databases

2. Start MAMP / XAMPP

Make sure Apache and MySQL are running.

3. Create and Import the Database

Open phpMyAdmin.

Create a new database: mytunesdb.

Import the provided .sql 

4. Set Up the Project

Place the project folder in your htdocs directory (for MAMP).

Update any database connection variables in includes/dbh.php:

$servername = "localhost";
$username = "root";
$password = "root"; // or blank for XAMPP
$dbname = "mytunesdb";


Admin Access Setup

Admins can access special tools at /admin.php.

To make a user an admin, run the following SQL in phpMyAdmin:

UPDATE user
SET admin = 1
WHERE userID = YOUR_USER_ID;

Replace YOUR_USER_ID with the ID of the user you want to make an admin.

Once done, the user will see an "Admin Panel" link in the sidebar after login.


#Updating the Spotify API Access Token

Spotify requires a valid access token for artist lookups and image rendering.

Steps:
Go to your Spotify refresh token request (Postman in refresh token request).
Press Send to generate a new access token.
Copy the access_token value from the response.
Where to Paste the New Token:
Update the $accessToken variable in these files:

artist.php
index.php
includes/topbar.php
Example:

$accessToken = "NEWLY_GENERATED_ACCESS_TOKEN";
Update this string whenever the token expires (roughly every hour).

Authors

Created by:

Lee Mifsud
Daniel Mallia
Matthew Scerri Simiana
Lyona Manche
