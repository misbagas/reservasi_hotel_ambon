<?php 
include('db.php');
log_error("Form started loading");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservation_id = (int)$_POST['reservation_id'];  // Assuming reservation_id is passed from a form or URL
    $review = htmlspecialchars($_POST['review']);
    $rating = (int)$_POST['rating'];  // Ensure it's an integer between 1 and 5

    // Check if rating is within valid range
    if ($rating < 1 || $rating > 5) {
        echo "Invalid rating. Please choose a value between 1 and 5.";
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

<form method="POST" action="process_review.php">
    <div class="mb-3">
        <label for="review" class="form-label">Your Review</label>
        <textarea id="review" name="review" class="form-control" rows="4" placeholder="Write your review here..." required></textarea>
    </div>
    <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <select id="rating" name="rating" class="form-select" required>
            <option value="1">1 Star</option>
            <option value="2">2 Stars</option>
            <option value="3">3 Stars</option>
            <option value="4">4 Stars</option>
            <option value="5">5 Stars</option>
        </select>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-custom btn-lg">Submit Review</button>
    </div>
</form>
