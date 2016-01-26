<?php
namespace Multiple\Frontend\Controllers;
use FileUploader;
use Phalcon\Mvc\View;
use ZipArchive;

class FileController extends ControllerBase {

    public function saveAction () {

        if($this->request->isPost()) {
            $target_dir = PUBLIC_PATH."/files/";
            $uploader =  new FileUploader($_FILES['file']);
            $uploader->file_max_size = 10 * 1024 * 1024 * PHOTO_MAX; // 1024*1024 = 10 * 1MB
            //$uploader->allowed = array('image/*');
            if ($uploader->uploaded) {
                $uploader->file_new_name_body = md5($_FILES["file"]["name"].time());
                $uploader->Process($target_dir);
                if ($uploader->processed) {
                    $newName = $uploader->file_dst_name;
                    return array(
                        'success' => true,
                        'msg' => "Файл $newName успешно загружен!",
                        'filename' => $newName,
                        'fullPath' => "/files/".$newName
                    );
                } else {
                    return array(
                        'success' => false,
                        'msg' => $uploader->error
                    );
                }
            }
        }

        return false;
    }

    /**
     * @param $filePath
     * @param string $fileName
     * @return string
     */
    protected function unzipAction ($filePath, $fileName=null) {
        $fileName = $fileName ? $fileName : session_id() . time();
        $path = '/files/zip/up/'.$fileName.'/';  // absolute path to the directory where zipper.php is in

        $zip = new ZipArchive();
        $x = $zip->open(PUBLIC_PATH. $filePath);  // open the zip file to extract
        if ($x === true) {
            $zip->extractTo(PUBLIC_PATH . $path); // place in the directory with same name
            $zip->close();

            unlink(PUBLIC_PATH. $filePath); // delete zip file
            return $path;
        }

        return false;
    }
}

