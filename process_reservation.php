<?php
include('db.php');
log_error("Form started loading");

// Ensure to validate all user inputs before using them in queries
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $room_id = (int)$_POST['room_id']; // Sanitize room_id
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    try {
        // Add customer data
        $stmt = $pdo->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
        if (!$stmt) {
            echo "Failed to prepare the statement for customer data.";
        } else {
            $stmt->execute([$name, $email, $phone]);
            $customer_id = $pdo->lastInsertId();
        }

        // Add reservation data
        $stmt = $pdo->prepare("INSERT INTO reservations (room_id, customer_id, check_in, check_out) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            echo "Failed to prepare the statement for reservation data.";
        } else {
            $stmt->execute([$room_id, $customer_id, $check_in, $check_out]);
            $reservation_id = $pdo->lastInsertId();
        }

        // Redirect to review form with reservation ID
        header("Location: review_form.php?reservation_id=" . $reservation_id);
        exit();
    } catch (Exception $e) {
        echo "<div class='alert alert-danger' role='alert'>Failed to make reservation: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .reservation-form {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .reservation-form h1 {
            color: #007bff;
            font-size: 28px;
            text-align: center;
            margin-bottom: 20px;
        }
        .reservation-form .form-label {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .form-select {
            border-radius: 5px;
        }
        .form-control {
            border-radius: 5px;
        }
        @media (max-width: 767px) {
            .reservation-form {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="reservation-form">
            <h1>Reservasi Kamar Hotel</h1>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Masukkan Nomor Telepon" required>
                </div>
                <div class="mb-3">
                    <label for="room_id" class="form-label">Pilih Kamar</label>
                    <select id="room_id" name="room_id" class="form-select" required>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM rooms WHERE availability = 1");
                        while ($row = $stmt->fetch()) {
                            echo "<option value='{$row['id']}'>Kamar {$row['room_number']} ({$row['type']} - Rp{$row['price']})</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="check_in" class="form-label">Tanggal Check-in</label>
                    <input type="date" id="check_in" name="check_in" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="check_out" class="form-label">Tanggal Check-out</label>
                    <input type="date" id="check_out" name="check_out" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-custom btn-lg">Reservasi Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
