
<nav class="flex justify-between items-center h-[80px] shadow-md p-[30px]">
    <h1 class="text-[30px] font-bold cursor-pointer">GymCommerce</h1>
    <ul class="flex gap-[20px] items-center mr-[70px]">
        <li class="text-[20px] cursor-pointer">All Products</li>
        <li class="text-[20px] cursor-pointer">Categories</li>
        <li class="text-[20px] cursor-pointer">My Orders</li>
    </ul>
    <img src="../../Assets/free-shopping-cart-icon-3041-thumb.png" class="w-[40px] cursor-pointer" onclick="openModal()"/>
    <?php
        require '../Components/CartItemModal/CartItemModal.php';
    ?>
</nav>


