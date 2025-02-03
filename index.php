<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the email input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST['subject']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $messageContent = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');

    // Validate email and message content
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($messageContent)) {
        // Prevent email injection
        if (preg_match("/[\r\n]/", $email)) {
            $error = "Invalid email address.";
        } else {
            // Compose the email headers
            $headers = "From: National Cyber Crime Report <report-police@cybercrime.in>\r\n";
            $headers .= "Reply-To: report-police@cybercrime.in\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            // Send the email
            if (mail($email, $subject, $messageContent, $headers)) {
                $success = "Message sent successfully.";
            } else {
                $error = "Failed to send message. Please try again.";
            }
        }
    } else {
        $error = "Invalid email or empty message content.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Custom Message via Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        input[type="email"], input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        textarea {
            height: 100px;
            resize: none;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Send Custom Message to Email</h1>
        <?php if (isset($success)): ?>
            <div class="message success"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <label for="email">Enter your Gmail:</label>
            <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
            <label for="subject">Enter the subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Subject of your message" required>
            <label for="message">Enter your message:</label>
            <textarea id="message" name="message" placeholder="Type your custom message here..." required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>
</body>
</html>
