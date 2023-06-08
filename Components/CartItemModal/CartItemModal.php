<?php
$servername = "localhost";
$username = "root";
$connectionPassword = "";
$dbname = "gym_shop";

// Create connection
$conn = mysqli_connect($servername, $username, $connectionPassword, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$userID = 1;
$cartItemsQuery = "SELECT * FROM cart_items inner join products
            ON cart_items.product_id = products.id
            WHERE cart_items.user_id = $userID"; // Replace $userID with the actual user ID


$cartItemsResult = mysqli_query($conn, $cartItemsQuery);

?>
<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    }

    .modal-content {
        border-radius: 4px;
        background-color: #fefefe;
        margin-top: 5%;
        margin-left: 60%;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Cart</h2>
        <?php


        if (mysqli_num_rows($cartItemsResult) > 0) {
            // Loop through cart items and display product info
            while ($cartItem = mysqli_fetch_assoc($cartItemsResult)) {
                $productName = $cartItem['title'];
                $productImage = $cartItem['image'];
                $quantity = $cartItem['quantity'];
                ?>

                <div class="cart-item">
                    <img src="<?= $productImage ?>" alt="<?= $productName ?>" class="product-image">
                    <div class="product-info">
                        <p class="product-name"><?= $productName ?></p>
                        <p class="product-quantity">Quantity: <?= $quantity ?></p>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "<p>Your cart is empty.</p>";
        }
        ?>
    </div>
</div>

<script>
    var modal = document.getElementById("myModal");

    function openModal() {
        modal.style.display = "block";
        document.body.style.backgroundColor = "rgba(0, 0, 0, 0.5)"; // Darken background
    }

    function closeModal() {
        modal.style.display = "none";
        document.body.style.backgroundColor = ""; // Reset background
    }
</script>