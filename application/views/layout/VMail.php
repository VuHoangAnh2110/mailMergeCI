
<body class="bg-gray-100">
    <div class="mx-10 p-5">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-5">
            <!-- Phần Form -->
            <div class="md:col-span-2 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Chọn Template</h2>
                <div class="flex items-center mb-4">
                    <button class="bg-blue-500 text-white text-sm px-3 py-2 rounded hover:bg-blue-600" id="downExcel">
                        <a href="{$base_url}downloadExcel">
                            Down Excel 
                        </a>
                    </button>
                    <!-- <button class="bg-green-500 text-white text-sm px-3 py-2 rounded hover:bg-green-600 ml-2"> 
                        <a href="{$base_url}mailMerge">
                            Mail Merge 
                        </a>    
                    </button>
                    <button class="bg-red-500 text-white text-sm px-3 py-2 rounded hover:bg-red-600 ml-2"> 
                        Load Data 
                    </button> -->
                </div>
                <div class="border border-gray-300 rounded p-2 h-60 overflow-y-auto">
                    <h3 class="font-semibold mb-2">Danh sách:</h3>
                    <ul id="fileList" class="text-center">
                    {assign var="count" value=0}
                        {foreach from=$list item=value}
                            {if $count == 0}
                                <!-- vì $list ở đây là object không phải array nên sử dụng $value->nametemp, không $value.nametemp -->
                                <li class="p-2 rounded-lg hover:bg-gray-200">
                                    <button class="temp w-full" data-imgpath="{$value->imgpath}" data-name="{$value->nametemp}">
                                        {$value->nametemp} 
                                    </button>
                                </li> 
                            {else}
                                <li class="border-t mt-1 p-2 rounded-lg hover:bg-gray-200"> 
                                    <button class="temp w-full" data-imgpath="{$value->imgpath}" data-name="{$value->nametemp}">
                                        {$value->nametemp} 
                                    </button>
                                </li>
                            {/if}
                            {assign var="count" value=$count+1}
                        {/foreach}

                        <!-- Danh sách sẽ được thêm vào ở đây -->
                    </ul>
                </div>
            </div>

            <!-- Phần Hiển Thị Các Phần Tải Lên -->
            <div class="md:col-span-4 bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Preview Tempate</h2>
                <div class="border border-gray-300 rounded p-2 h-auto overflow-y-auto">
                    <h3 id="nameTemp" class="font-semibold mb-2"> name template </h3>
                    <div id="imgPreview" class="m-4">
                        <!-- Thên hình ảnh -->
                         <img id="templateImg" src="" alt="Image preview" style="max-width: 100%; display: none;">
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>
    </div>

