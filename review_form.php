<?php 
include('db.php');
log_error("Form started loading");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservation_id = (int)$_POST['reservation_id'];  // Assuming reservation_id is passed from a form or URL
    $review = htmlspecialchars($_POST['review']);
    $rating = (int)$_POST['rating'];  // Ensure it's an integer between 1 and 5

    // Check if rating is within valid range
    if ($rating < 1 || $rating > 5) {
        echo "<div class='alert alert-warning' role='alert'>Invalid rating. Please choose a value between 1 and 5.</div>";
        exit();
    }

    try {
        // Insert review and rating
        $stmt = $pdo->prepare("INSERT INTO reviews (reservation_id, review, rating) VALUES (?, ?, ?)");
        $stmt->execute([$reservation_id, $review, $rating]);

        // Optionally, redirect to a confirmation page or show a success message
        echo "<div class='alert alert-success' role='alert'>Review submitted successfully!</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger' role='alert'>Failed to submit review: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave a Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .reservation-form {
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="reservation-form">
            <h1 class="text-center mb-4">Leave a Review</h1>
            <form method="POST" action="">
                <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($_GET['reservation_id']); ?>">
                
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <select id="rating" name="rating" class="form-select" required>
                        <option value="">Select Rating</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="review" class="form-label">Review</label>
                    <textarea id="review" name="review" class="form-control" rows="4" required placeholder="Write your review here..."></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-custom btn-lg">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
