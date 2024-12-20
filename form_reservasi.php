<?php
session_start();
include('db.php');
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
            display: flex;
        }
        .side-navbar {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40;
            color: #ffffff;
            height: 100vh;
            padding: 20px;
        }
        .side-navbar a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .side-navbar a:hover {
            background-color: #007bff;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .reservation-form {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .reservation-form h1 {
            color: #343a40;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: #ffffff;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="side-navbar">
    <h2>Hotel System</h2>
    <a href="form_reservasi.php">Reservasi</a>
    <a href="#" onclick="showReservations()">Cek Reservasi</a>
    <?php if (isset($_SESSION['user_id'])): ?>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
<?php endif; ?>

    <div id="reservations" style="display: none; margin-top: 20px;">
        <h5>Rooms Booked</h5>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) AS booked_rooms FROM reservations");
        $result = $stmt->fetch();
        echo "<p>Booked Rooms: " . $result['booked_rooms'] . "</p>";
        ?>
    </div>
</div>


    <div class="content">
        <div class="reservation-form">
            <h1>Reservasi Kamar</h1>
            <form method="POST" action="process_reservation.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Telepon</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Masukkan Nomor Telepon" required>
                </div>
                <div class="mb-3">
                    <label for="room_id" class="form-label">Kamar</label>
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
                    <label for="check_in" class="form-label">Check-in</label>
                    <input type="date" id="check_in" name="check_in" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="check_out" class="form-label">Check-out</label>
                    <input type="date" id="check_out" name="check_out" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-custom btn-lg">Reservasi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showReservations() {
            const reservationSection = document.getElementById('reservations');
            reservationSection.style.display = reservationSection.style.display === 'none' ? 'block' : 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
