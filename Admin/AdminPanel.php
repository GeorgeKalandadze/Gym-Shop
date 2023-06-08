<?php
include '../Layouts/AdminPanelLayout.php';
require '../connection.php';

// Create a new product
$errors = array();
$title = $image = $price = $category_id = '';
if (isset($_POST['create'])) {
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
        // Check if product already exists
        $existingProductQuery = "SELECT * FROM products WHERE title = '$title'";
        $existingProductResult = mysqli_query($conn, $existingProductQuery);
        if (mysqli_num_rows($existingProductResult) > 0) {
            $errors['title'] = 'Product already exists';
        } else {
            move_uploaded_file($tempName, $imagePath);

            $sql = "INSERT INTO products (title, image, price, category_id) VALUES ('$title', '$image', '$price', '$category_id')";
            mysqli_query($conn, $sql);
        }
    }
}

// Read all products
$sql = "SELECT  *  FROM products INNER JOIN categories ON products.category_id = categories.id";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch categories
$sql = "SELECT * FROM categories";
$categories = mysqli_query($conn, $sql);
?>

<h1 class="text-3xl font-bold mb-6">Products</h1>

<!-- Create Product Form -->
<div class=" flex justify-center items-center">
    <form class="w-[500px] bg-white rounded-lg shadow-md border p-[50px]" method="POST"  enctype="multipart/form-data">
        <h2 class="text-xl leading-7 font-semibold text-center text-black mb-4">Create Product</h2>

        <div class="relative">
            <input
                    placeholder="Title"
                    name="title"
                    type="text"
                    class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full"
                    value="<?php echo htmlspecialchars($title); ?>"
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
                    value="<?php echo htmlspecialchars($image); ?>"
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
                    value="<?php echo htmlspecialchars($price); ?>"
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
        <button class="submit bg-indigo-600 text-white font-medium py-2 px-5 rounded-md w-full uppercase mt-[25px]" type="submit" name="create">
            Create
        </button>
    </form>
</div>

