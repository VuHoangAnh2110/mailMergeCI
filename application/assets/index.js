// Thong báo toastr
    $(document).ready(function(){
        $('#button').on('click', function(){
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
    
            toastr["success"]("Đã có thông báo xịn <3", "Test!")
        });
    });

    
    function ThongBao(type, msg, title){
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr[type](msg, title);
    };

    $(document).ready(function(){
        $('#btnDocx').on('click', function(){
            $.ajax({
                url:'/createDoc',
                method: 'POST',
                data: '',
                success: function(response){
                    const result = JSON.parse(response);
                    ThongBao(result.type, result.msg, result.title);
                }
            })
        });
    });

    $(document).ready(function(){
        $('#btnpreview').on('click', function(){
            $.ajax({
                url: '/previewDoc',
                method: 'GET',
                data: '',
                success: function(response){
                    // const result = JSON.parse(response);
                    // ThongBao(result.type, result.msg, result.title);

                    window.location.href = 'previewDoc';
                }
            })
        })
    });

    $(document).ready(function(){
        $('#btnPrev').on('click', function(){
            $.ajax({
                url: '/previewImg',
                method: 'GET',
                data: '',
                success: function(response){
                    const result = JSON.parse(response);
                    ThongBao(result.type, result.msg, result.title);

                    window.location.href = 'previewImg';

                }
            })
        })
    });


    // $(document).ready(function(){
    //     $('#downExcel').on('click', function(){
    //         $.ajax({
    //             url: '/downloadExcel',
    //             method: 'GET',
    //             data: '',
    //             success: function(response){
    //                 try {
    //                     const result = JSON.parse(response);
    //                     // Kiểm tra xem response có chứa các thuộc tính cần thiết không
    //                     if (result.type && result.msg && result.title) {
    //                         ThongBao(result.type, result.msg, result.title);
    //                     } else {
    //                         console.error("Response không hợp lệ:", result);
    //                         ThongBao('error', 'Dữ liệu không hợp lệ', 'Lỗi');
    //                     }
    //                 } catch (e) {
    //                     console.error("Không thể phân tích JSON:", e);
    //                     ThongBao('error', 'Đã xảy ra lỗi khi tải dữ liệu', 'Lỗi');
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("Có lỗi trong yêu cầu:", error);
    //                 ThongBao('error', 'Đã xảy ra lỗi khi gửi yêu cầu', 'Lỗi');
    //             }
    //         });
    //     });
    // });
    
    
// Khi nhắn template thì preview template
    $(document).ready(function(){
        // Khởi tạo biến để lưu trữ thông tin template được chọn
        var selectedTemplate = null;

        $('.temp').on('click', function(){
            var imgPath = $(this).data('imgpath');
            var nameTemplate = $(this).data('name');

            // Lưu lại template được chọn
            selectedTemplate = {
                imgPath: imgPath,
                nameTemplate: nameTemplate
            };

            if (imgPath) {
                $('#templateImg').attr('src', imgPath).show();
                $('#nameTemp').html(nameTemplate);
            } else {
                $('#templateImg').hide();
            }

            $('li').removeClass('bg-gray-300 font-bold');
            $(this).closest('li').addClass('bg-gray-300 font-bold');
        });
    });