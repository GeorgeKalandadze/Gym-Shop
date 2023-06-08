<?php
include '../Layouts/AuthenticatedLayout.php';
require '../connection.php';

// Select products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addToCart'])) {
        // Retrieve the product ID and quantity from the form
        $productID = $_POST['productID'];
        $quantity = $_POST['quantity'];

        // Get the user ID from the session (replace this with your own logic)
        $userID = 1; // Change this line with your own logic to get the user ID

        // Check if the item already exists in the cart_items table for the user
        $checkQuery = "SELECT * FROM cart_items WHERE user_id = $userID AND product_id = $productID";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Item already exists, update the quantity
            $row = mysqli_fetch_assoc($checkResult);
            $cartItemID = $row['id'];
            $newQuantity = $row['quantity'] + $quantity;

            // Update the quantity in the cart_items table
            $updateQuery = "UPDATE cart_items SET quantity = $newQuantity WHERE id = $cartItemID";
            mysqli_query($conn, $updateQuery);
        } else {
            // Item doesn't exist, insert it into the cart_items table
            // Retrieve product details from the database
            $productQuery = "SELECT * FROM products WHERE id = $productID";
            $productResult = mysqli_query($conn, $productQuery);
            $product = mysqli_fetch_assoc($productResult);

            // Calculate the total price
            $totalPrice = $product['price'] * $quantity;

            // Insert the product into the cart_items table
            $insertQuery = "INSERT INTO cart_items (user_id, product_id, quantity, total_price)
                            VALUES ($userID, $productID, $quantity, $totalPrice)";
            mysqli_query($conn, $insertQuery);
        }

        // Redirect to the cart page or display a success message
        // Replace this line with your own logic for redirecting or displaying a success message
        echo "Product added to cart successfully!";
    }
}

?>

<section class="flex justify-between flex-wrap">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="p-[30px]">
            <div class="p-4 transition duration-300 shadow-lg w-[350px] rounded">
                <img src="<?= $row['image'] ?>" class="w-full h-[20.63rem] cursor-pointer" />
                <p class="text-[1.17rem] mt-4 opacity-90 "><?= $row['title'] ?></p>
                <div class="mt-4 flex justify-between">
                    <h2 class="font-bold text-[1.17rem] ">$<?= $row['price'] ?></h2>
                </div>
                <form method="POST" class="flex justify-between items-center  w-full mt-4 ">
                    <input type="hidden" name="productID" value="<?= $row['id'] ?>" >
                    <input type="number" name="quantity" value="1" min="1" class="p-2 px-4 w-[60%]">
                    <button type="submit" name="addToCart" class="text-amber-50 bg-[#008bd2] rounded-none p-2 px-4">Add to Cart</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</section>

<?php
mysqli_close($conn);
?>
