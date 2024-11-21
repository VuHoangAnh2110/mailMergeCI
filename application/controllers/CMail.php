<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpWord\IOFactory as WordIOFactory; // Aliased to avoid conflict
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory; // Aliased to avoid conflict
use PhpOffice\PhpWord\Shared\ZipArchive;


class CMail extends CI_Controller {
	public function __construct() {
        parent::__construct();  

        $this->load->model("MTemplate");
        // require_once 'vendor/autoload.php'; 
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
        $data = array(
            'title' => 'Mail Merge',
            'body'=> 'allo',
            'base_url'=> base_url(),
        );

        //hiện danh sách template =========
            $list = $this->MTemplate->get_list();
            $data = array(
                'list' => $list,
            );
            $data1['data'] = $data;  
        //=================================

        $this->load->view('layout/VLayout', $data1);
	}

// Tải file mẫu excel về máy người dùng ==========================================================================================
    public function download_excel(): void{
       $filePath = FCPATH . 'application/assets/templates/temp2.xlsx';

       if (file_exists($filePath)) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="TempExcel.xlsx"');
            readfile($filePath);
            exit; // Ngừng thực thi sau khi tải xong

        } else {
            echo json_encode(['type' => 'warning', 'msg' => 'Không tìm thấy file', 'title' => 'Bug!']);
        }
    }
// ==============================================================================================================================

    public function createTemplate() {

        try {
            // Đường dẫn lưu file
            $filePath = FCPATH . 'application\assets\templates\TestW.docx';
    
            // Tạo một template
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($filePath); 
    
            // Thêm các đoạn văn bản
            $templateProcessor->setValue('name1', 'Vũ Hoàng Anh');
            $templateProcessor->setValue('name2', 'Cao Thành Công');
            $templateProcessor->setValue('name3', 'Lại Là Mày');
            $templateProcessor->setValue('name4', 'Vẫn Tao Đây');

            $templateProcessor->setValue('email1','agrgrgb24@gmail.com');
            $templateProcessor->setValue('mota2','Đây là trang fb của bé Hoàng Anh');

            $templateProcessor->setImageValue('image',
            [
                'path'=> FCPATH.'application\assets\images\fb.png',
                'width'=> 100,
                'height'=> 100,
                'ratio'=> false,
            ]);

            // Lưu file
            $fileOutPath = FCPATH .'application\assets\templates\OutFile.docx';
            //$fileOutPath = 'result.docx';
            $templateProcessor->saveAs($fileOutPath);

            // header('Content-Description: File Transfer');
            // header('Content-Disposition: attachment; filename="OutFile.docx"');
            // header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            // unlink($fileOutPath);
            
            echo json_encode(['type' => 'success', 'msg' => 'Tạo file thành công', 'title' => 'OK!']);
            exit;
        } catch (Exception $e) {
            echo json_encode(['type' => 'error', 'msg' => 'Lỗi: ' . $e->getMessage(), 'title' => 'Lỗi!']);
        }
    }
    
    public function previewTemplate() {
        $filePath = FCPATH . 'application\assets\templates\TestW.docx';

        if(!file_exists($filePath)){
            echo json_encode(['type' => 'warning', 'msg' => 'Không thể tìm thấy Template', 'title' => 'Bug!']);
            return;
        }

        // Sử dụng PHPWord để đọc file DOCX
        $phpWord = WordIOFactory::load($filePath);

        // Tạo writer để xuất ra HTML
        $htmlWriter = WordIOFactory::createWriter($phpWord, 'HTML');
  
        // Bắt đầu buffer để lưu nội dung HTML
        ob_start();
        $htmlWriter->save('php://output');
        $htmlContent = ob_get_contents();
        ob_end_clean();
  
        // Truyền nội dung HTML sang view để hiển thị
        $data['htmlContent'] = $htmlContent;
        $data1['data'] = $data;
        $this->load->view('layout/VLayout', $data1);
        // $this->parser->parse('layout/VContent', $data);
    }


    public function previewImg() {
        $filePath = FCPATH . 'application\assets\templates\TestW.docx';
    
        if (!file_exists($filePath)) {
            echo json_encode(['type' => 'warning', 'msg' => 'Không thể tìm thấy Template', 'title' => 'Bug!']);
            return;
        }

        // Sử dụng PHPWord để đọc file DOCX
        $phpWord = WordIOFactory::load($filePath);

        // Tạo writer để xuất ra HTML
        $htmlWriter = WordIOFactory::createWriter($phpWord, 'HTML');
  
        // Bắt đầu buffer để lưu nội dung HTML
        ob_start();
        $htmlWriter->save('php://output');
        $htmlContent = ob_get_contents();
        ob_end_clean();

        echo json_encode(['type' => 'warning', 'msg' => $htmlContent, 'title' => 'Bug!']);

        // Sử dụng mPDF để tạo PDF từ HTML
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($htmlContent);

        // Lưu file PDF
        $pdfPath = FCPATH . 'application/assets/templates/TestW.pdf';
        $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);

        // Hiển thị PDF
        $data['pdfPath'] = base_url('application/assets/templates/TestW.pdf');
        $data1['data'] = $data;
        $this->load->view('layout/VLayout', $data1);
    }
// ==================================================================================================================================

// Tải file và trộn thư ==============================================================================================================
    public function mailMerge() {

        // Kiểm tra xem người dùng có tải file lên không
        if (!empty($_FILES['fileUpload']['name'])) {
            $config['upload_path'] = FCPATH . 'application/assets/';  // Thư mục lưu trữ file tải lên
            $config['allowed_types'] = 'xlsx';      // Chỉ cho phép file Excel
            $config['file_name'] = time() . '_' . $_FILES['fileUpload']['name']; // Đặt tên file để tránh trùng lặp

            // Load thư viện upload của CodeIgniter
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('fileUpload')) {
                // File đã được tải lên thành công
                $uploadedData = $this->upload->data();
                $uploadedFilePath = FCPATH . 'application/assets/' . $uploadedData['file_name'];

                // Tiến hành xử lý file Excel và tạo file Word
                $this->mergeWordAll($uploadedFilePath);
            } else {
                // Thông báo lỗi nếu tải file thất bại
                echo $this->upload->display_errors();
            }
        } else {
            echo "Vui lòng chọn một file Excel.";
        }
    }
// ================================================================================================================================

// Trộn dữ liệu thành nhiều file rồi đóng vào 1 file zip ===========================================================================
    public function mergeWordOne($uploaded_excel_file) {
        // Đọc dữ liệu từ file Excel
        $spreadsheet = SpreadsheetIOFactory::load($uploaded_excel_file);
        $dataRows = $spreadsheet->getActiveSheet()->toArray();

        // Đường dẫn template Word
        $templatePath = FCPATH . 'application/assets/templates/temp2.docx';

        $generatedFiles = [];

        $currentDay = date('d');
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        foreach ($dataRows as $index => $row) {
            if ($index == 0) continue; // Bỏ qua hàng tiêu đề

            $templateProcessor = new TemplateProcessor($templatePath);

            $hoVaTen = isset($row[0]) ? $row[0] : '';  
            $maSinhVien = isset($row[1]) ? $row[1] : '';  
            $templateProcessor->setValue('ten', $hoVaTen);
            $templateProcessor->setValue('msv', $maSinhVien);
         
            // Sử dụng TemplateProcessor để thay thế giá trị placeholder 'ngay' bằng ngày hiện tại
            $templateProcessor->setValue('ngay', $currentDay);
            $templateProcessor->setValue('thang', $currentMonth);
            $templateProcessor->setValue('nam', $currentYear);

            // Tạo file .docx cho mỗi dòng dữ liệu
            $outputFile = FCPATH . 'application/assets/output/document_' . $index . '.docx';
            $templateProcessor->saveAs($outputFile);
            $generatedFiles[] = $outputFile;
        }

        // Tạo file ZIP chứa các file Word đã tạo
        $zip = new ZipArchive();
        $zipName = FCPATH . 'application/assets/temp2.zip';

        if ($zip->open($zipName, ZipArchive::CREATE) === TRUE) {
            foreach ($generatedFiles as $file) {
                $zip->addFile($file, basename($file)); // Thêm từng file vào zip
            }
            $zip->close();
        }

        // Gửi file ZIP cho người dùng
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=mail.zip');
        readfile($zipName);
        exit; // Ngừng thực thi sau khi tải xong
    }
// =================================================================================================================================

// Trộn dữ liệu thành nhiều page trong 1 file =======================================================================================
    public function mergeWordAll($uploaded_excel_file) {
        // Đọc dữ liệu từ file Excel
        $spreadsheet = SpreadsheetIOFactory::load($uploaded_excel_file);
        $dataRows = $spreadsheet->getActiveSheet()->toArray();
        
        // Đường dẫn template Word
        $templatePath = FCPATH . 'application/assets/templates/temp2.docx';
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
    
        // Chỉ định ngày, tháng, năm hiện tại
        $currentDay = date('d');
        $currentMonth = date('m');
        $currentYear = date('Y');
    
        // Đếm số lượng dòng dữ liệu để nhân bản block
        $totalRows = count($dataRows) - 1;  // Bỏ qua tiêu đề
    
        // Nhân bản block cho số dòng dữ liệu từ Excel (bắt đầu từ dòng thứ 2)
        $templateProcessor->cloneBlock('BLOCK', $totalRows, true, true);
    
        // Lặp qua từng dòng dữ liệu
        foreach ($dataRows as $index => $row) {
            if ($index == 0) continue; // Bỏ qua hàng tiêu đề
    
            // Lấy dữ liệu từ các cột
            $hoVaTen = isset($row[0]) ? $row[0] : '';  
            $maSinhVien = isset($row[1]) ? $row[1] : '';  
    
            // Thay thế các placeholders trong block được nhân bản
            $templateProcessor->setValue('ten#' . $index, $hoVaTen);
            $templateProcessor->setValue('msv#' . $index, $maSinhVien);
            $templateProcessor->setValue('ngay#' . $index, $currentDay);
            $templateProcessor->setValue('thang#' . $index, $currentMonth);
            $templateProcessor->setValue('nam#' . $index, $currentYear);
    
            // Thêm ngắt trang sau mỗi block (trừ dòng cuối cùng)
            if ($index < $totalRows) {
                $templateProcessor->setValue('pagebreak#' . $index, '<w:br w:type="page"/>');
            } else {
                $templateProcessor->setValue('pagebreak#' . $index, ''); // Không thêm ngắt trang cho dòng cuối
            }
        }
    
        // Lưu file Word duy nhất
        $outputFile = FCPATH . 'application/assets/output/final_document.docx';
        $templateProcessor->saveAs($outputFile);
    
        // Gửi file cho người dùng
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="final_document.docx"');
        readfile($outputFile);
        exit;
    }
// ======================================================================================================================================
    

}
