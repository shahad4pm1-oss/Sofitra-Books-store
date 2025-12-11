<?php
session_start();
require_once 'db.php';

$message = "";

if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
    $message = "Registration successful! Please login.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, fullname, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            header("Location: Categories.html"); // Redirect to a protected page or home
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "No account found with that email.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Sofitra Books</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // Optional: Keep the welcome alert if desired, or remove it.
    </script>
</head>

<body>

    <header>
        <h1>Sofitra Books store</h1>
        <!-- Ensure path to image is correct. If login.php is in same dir as index.html, it should work -->
        <img src="photo/so.png" alt="Sofitra Books Logo" width="500" height="200">
        <p>Welcome to our online bookstore!</p>
    </header>

    <section class="page1">
        <h2>Login to Your Account</h2>

        <?php if (!empty($message))
            echo "<p style='color:red; text-align:center;'>$message</p>"; ?>

        <form action="login.php" method="POST">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Create one</a></p>
    </section>

    <nav>
        <a href="index.html" class="button">Home</a>
        <a href="Categories.html" class="button">Buy Books</a>
        <a href="contact.html" class="button">Contact Us</a>
    </nav>

    <main>
        <h2>Our Services</h2>
        <ul>
            <li>A wide selection of books across various categories</li>
            <li>Easy returns within 7 days of purchase</li>
            <li> online payment (e.g., Apple Pay)</li>
            <li>Organized categories to help you find the perfect book</li>
        </ul>
    </main>

    <footer>
        <p>&copy; 2025 Sofitra Books. All rights reserved.</p>
    </footer>

</body>

</html>