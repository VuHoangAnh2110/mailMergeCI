<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Sử dụng cdn để nhúng jquery -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!--  -->
    <link rel="stylesheet" href="{$base_url}application/assets/toastr/toastr.min.css">
    <title> {$title} </title>
    
</head>

<body class="bg-blue-100 pb-16">
    <div class="">
        <div id="header" class="border-2 bg-opacity-30 bg-green-500 p-5">
            <h1 class="flex justify-center text-xl"> Xin chào đến với Hoàng Anh Channel! </h1>
        </div>

        <div id="content" class="grid grid-col-1 sm:grid-cols-1 border-gray-900/10">
              
            <!-- Bộ office -->
                <div id="office" class="mt-5 mx-10 flex justify-start">
                    <button id="btnPrev" class="relative inline-flex items-center justify-start 
                    px-6 py-3 overflow-hidden font-medium transition-all bg-white rounded hover:bg-white group" onclick="">
                    <span class="w-48 h-48 rounded rotate-[-40deg] bg-purple-600 absolute bottom-0 left-0 
                    -translate-x-full ease-out duration-500 transition-all translate-y-full mb-9 ml-9 
                    group-hover:ml-0 group-hover:mb-32 group-hover:translate-x-0">
                    </span> 
                    <span class="relative w-full text-left text-black transition-colors duration-300 ease-in-out group-hover:text-white">
                        Preview
                    </span> 
                    </button>

                    <button id="btnDocx" onclick=""
                    class="border-2 border-black rounded-lg hover:text-white 
                        hover:bg-gradient-to-r from-sky-500 to-indigo-500 bg-green-100 p-3 ml-4"> 
                        Tải FILE Word
                    </button>

                    <button id="btnpreview" class="relative inline-block text-lg group ml-4" onclick=""> 
                    <span class="relative z-10 block px-5 py-3 overflow-hidden font-medium leading-tight text-gray-800 
                    transition-colors duration-300 ease-out border-2 border-gray-900 rounded-lg group-hover:text-white"> 
                    <span class="absolute inset-0 w-full h-full px-5 py-3 
                    rounded-lg bg-gray-50">
                    </span> 
                    <span class="absolute left-0 w-48 h-48 -ml-2 transition-all duration-300 origin-top-right -rotate-90
                    -translate-x-full translate-y-12 bg-gray-900 group-hover:-rotate-180 ease">
                    </span> 
                   
                        <span class="relative"> Preview Template </span> 
                    
                    </span> 
                    <span class="absolute bottom-0 right-0 w-full h-12 -mb-1 -mr-1 transition-all duration-200 ease-linear
                    bg-gray-900 rounded-lg group-hover:mb-0 group-hover:mr-0" data-rounded="rounded-lg">
                    </span> 
                    </button>
                </div>

    