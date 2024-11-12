<?php
// Файл: products.php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Додати відгук
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $mysqli->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);
    $stmt->execute();
    $stmt->close();
}

// Отримати продукти та відгуки
$products = $mysqli->query("SELECT * FROM products");
?>

<h1>Products</h1>

<?php while ($product = $products->fetch_assoc()): ?>
    <h2><?php echo $product['name']; ?></h2>

    <h3>Reviews:</h3>
    <?php
    $reviews = $mysqli->prepare("SELECT rating, comment FROM reviews WHERE product_id = ?");
    $reviews->bind_param("i", $product['id']);
    $reviews->execute();
    $reviews->bind_result($rating, $comment);

    while ($reviews->fetch()) {
        echo "<p>Rating: $rating/5</p>";
        echo "<p>Comment: $comment</p>";
    }
    $reviews->close();
    ?>

    <form method="post" action="products.php">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
        <label for="rating">Rating:</label>
        <select name="rating" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <label for="comment">Comment:</label>
        <textarea name="comment" required></textarea>
        <button type="submit">Submit Review</button>
    </form>
<?php endwhile; ?>
