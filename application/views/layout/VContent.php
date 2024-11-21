

<div class="mx-20 mt-5 bg-white">
    <div class="p-4 text-lg">
        <!-- Input để tải lên file Excel -->
        <div class="">
            <form action="{$base_url}mailMerge" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="mr-3" for="fileUpload"> Tải dữ liệu (excel): </label>
                    <input type="file" name="fileUpload" id="excelFile" class="form-control" required>  
                </div>
    
                <button type="submit" class="mt-2 bg-green-500 text-white text-sm px-3 py-2 rounded hover:bg-green-600 ml-2"> 
                    Mail Merge 
                </button>
            </form>
        </div>

        <!-- {$htmlContent}

        <iframe src="{$pdfPath}" frameborder="0"></iframe>
         -->
        <!-- <img src="{$imagePath}" alt="Preview" /> -->
    </div>
</div>