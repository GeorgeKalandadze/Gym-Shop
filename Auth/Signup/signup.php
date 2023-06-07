<?php
require '../../Layouts/GuestLayout.php'
?>
<form class="bg-white block p-4 w-[400px] rounded-md shadow-md">
    <p class="text-xl leading-7 font-semibold text-center text-black">Sign in to your account</p>
    <div class="relative">
        <input placeholder="name" type="text" class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full">
    </div>
    <div class="relative">
        <input placeholder="email" type="email" class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full">
    </div>
    <div class="relative">
        <input placeholder="password" type="password" class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full">
    </div>
    <div class="relative">
        <input placeholder="password confirmation" type="password" class="border-2 border-gray-300 rounded-md px-4 py-2 w-72 mt-[25px] w-full">
    </div>
    <button class="submit bg-indigo-600 text-white font-medium py-2 px-5 rounded-md w-full uppercase mt-[25px]" type="submit">
        Sign in
    </button>
    <p class="signup-link text-gray-700 text-sm text-center mt-[25px]">
        No account?
        <a href="" class="underline">Sign up</a>
    </p>
</form>

