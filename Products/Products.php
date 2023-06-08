<?php
session_start();
include '../Layouts/AuthenticatedLayout.php';
require '../connection.php';


// Select products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addToCart'])) {
        $productID = $_POST['productID'];
        $quantity = $_POST['quantity'][$productID];
        $userID =  $_SESSION['user_id'];
        echo $userID;
        $checkQuery = "SELECT * FROM cart_items WHERE user_id = $userID AND product_id = $productID";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            $cartItemID = $row['id'];
            $updateQuery = "UPDATE cart_items SET quantity = $quantity WHERE id = $cartItemID";
            mysqli_query($conn, $updateQuery);
        } else {
            $productQuery = "SELECT * FROM products WHERE id = $productID";
            $productResult = mysqli_query($conn, $productQuery);
            $product = mysqli_fetch_assoc($productResult);

            $totalPrice = $product['price'] * $quantity;

            $insertQuery = "INSERT INTO cart_items (user_id, product_id, quantity, total_price)
                            VALUES ($userID, $productID, $quantity, $totalPrice)";
            mysqli_query($conn, $insertQuery);
        }
    }
}
?>

    <section class="flex justify-center flex-wrap">
        <?php for ($i = 0; $i < mysqli_num_rows($result); $i++): ?>
            <?php $row = mysqli_fetch_assoc($result); ?>
            <div class="p-[30px]">
                <div class="p-4 transition duration-300 shadow-lg w-[350px] rounded">
                    <img src="<?="../uploads/". $row['image'] ?>" class="w-full h-[20.63rem] cursor-pointer" />
                    <p class="text-[1.17rem] mt-4 opacity-90 "><?= $row['title'] ?></p>
                    <div class="mt-4 flex justify-between">
                        <h2 class="font-bold text-[1.17rem] ">$<?= $row['price'] ?></h2>
                    </div>
                    <form method="POST" class="flex justify-between items-center  w-full mt-4 ">
                        <input type="hidden" name="productID" value="<?= $row['id'] ?>" >
                        <input type="number" name="quantity[<?= $row['id'] ?>]" value="<?= isset($_POST['quantity'][$row['id']]) ? $_POST['quantity'][$row['id']] : 1 ?>" min="1" class="p-2 px-4 w-[60%]">
                        <button type="submit" name="addToCart" class="text-amber-50 bg-[#008bd2] rounded-none p-2 px-4">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endfor; ?>
    </section>

<?php
mysqli_close($conn);
?>