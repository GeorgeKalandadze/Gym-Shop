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

$checkQuery = "SELECT * FROM categories";
$categories = mysqli_query($conn, $checkQuery);

$category_id = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
}
?>

<nav class="flex justify-between items-center h-[80px] shadow-md p-[30px]">
    <h1 class="text-[30px] font-bold cursor-pointer">GymCommerce</h1>
    <ul class="flex gap-[20px] items-center mr-[70px]">
        <li class="text-[20px] cursor-pointer"><a href="Products.php">All Products</a></li>
        <li class="text-[20px] cursor-pointer" onmouseover="showCategories()">Categories</li>
        <li class="text-[20px] cursor-pointer">My Orders</li>
    </ul>
    <img src="../../Assets/free-shopping-cart-icon-3041-thumb.png" class="w-[40px] cursor-pointer" onclick="openModal()"/>

    <?php
    require '../Components/CartItemModal/CartItemModal.php';
    ?>

    <div id="categoriesDropdown" class="hidden w-[300px] absolute top-[80px] right-[50%] transform translate-x-1/2  bg-black bg-opacity-50 p-[10px] shadow-md">
        <form class="relative" method="post" action="Products.php?category_id=<?=$category_id?>">
            <label for="categorySelect" class="font-bold text-white">Select a Category:</label>
            <select id="categorySelect" name="category_id" class="block w-full p-2 mt-2 border border-gray-300 rounded-md bg-white text-black" onchange="this.form.submit()">
                <?php
                while ($row = mysqli_fetch_assoc($categories)) {
                    $selected = ($row['id'] == $category_id) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                }
                ?>
            </select>
            <button type="submit" style="display: none;"></button>
        </form>
    </div>

    <script>
        function showCategories() {
            var dropdown = document.getElementById("categoriesDropdown");
            dropdown.classList.toggle("hidden");
        }
    </script>
</nav>