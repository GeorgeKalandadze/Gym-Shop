<?php
include '../Layouts/AdminPanelLayout.php';
require '../connection.php';

// Create a new product
$productID = $_GET['id'];

// Fetch the product data from the database
$sql = "SELECT * FROM products WHERE id = '$productID'";
$result = mysqli_query($conn, $sql);
$productData = mysqli_fetch_assoc($result);
$errors = array();
$title = $image = $price = $category_id = '';
if (isset($_POST['update'])) {

$title = $_POST['title'];
$price = $_POST['price'];
$category_id = $_POST['category_id'];


// File upload handling
$image = $_FILES['image']['name'];
$tempName = $_FILES['image']['tmp_name'];
$imagePath = "../uploads/" . $image;

if (empty($title)) {
    $errors['title'] = 'Title is required';
}

if (empty($image)) {
$errors['image'] = 'Image is required';
} elseif (!file_exists($tempName)) {
$errors['image'] = 'Invalid image file';
}

if (empty($price)) {
$errors['price'] = 'Price is required';
}

if (empty($category_id)) {
$errors['category_id'] = 'Category is required';
}

if (empty($errors)) {
 
$existingProductQuery = "SELECT * FROM products WHERE title = '$title'";
$existingProductResult = mysqli_query($conn, $existingProductQuery);
move_uploaded_file($tempName, $imagePath);
$sql = "UPDATE products SET title='$title', image='$image', price='$price', category_id='$category_id' WHERE id='$productID'";
mysqli_query($conn, $sql);
        }
}



// Fetch categories
$sql = "SELECT * FROM categories";
$categories = mysqli_query($conn, $sql);
?>

<h1 class="text-3xl font-bold mb-6">Products</h1>

<!-- Update Product Form -->
<div class="flex justify-center items-center">
    <form class="w-[500px] bg-white rounded-lg shadow-md border p-[50px]" method="POST" enctype="multipart/form-data">
        <h2 class="text-xl leading-7 font-semibold text-center text-black mb-4">Update Product</h2>

        <div class="relative">
            <input
                    placeholder="Title"
                    name="title"
                    type="text"
                    class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                    value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($productData['title']); ?>"
            >
            <?php if (isset($errors['title'])): ?>
                <p class="text-red-700 mt-3.5"><?= $errors['title'] ?></p>
            <?php endif; ?>
        </div>

        <div class="relative">
            <input
                    placeholder="Image"
                    name="image"
                    type="file"
                    class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                    value="<?php echo isset($price) ? $image  : htmlspecialchars($productData['image']); ?>"
            >
            <?php if (isset($errors['image'])): ?>
                <p class="text-red-700 mt-3.5"><?= $errors['image'] ?></p>
            <?php endif; ?>
        </div>

        <div class="relative">
            <input
                    placeholder="Price"
                    name="price"
                    type="number"
                    class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                    value="<?php echo isset($price) ? $price  : htmlspecialchars($productData['price']); ?>"
            >
            <?php if (isset($errors['price'])): ?>
                <p class="text-red-700 mt-3.5"><?= $errors['price'] ?></p>
            <?php endif; ?>
        </div>

        <div class="relative">
            <select name="category_id" class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full">
                <?php
                while ($row = mysqli_fetch_assoc($categories)) {
                    $selected = ($row['id'] == $category_id) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                }
                ?>
            </select>
            <?php if (isset($errors['category_id'])): ?>
                <p class="text-red-700 mt-3.5"><?= $errors['category_id'] ?></p>
            <?php endif; ?>
        </div>

        <button class="submit bg-indigo-600 text-white font-medium py-2 px-5 rounded-md w-full uppercase mt-[25px]" type="submit" name="update">
            Update
        </button>
    </form>
</div>

