<?php

class Error_Model extends Model {
    
    private $mime = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'ogg' => 'application/ogg',
            'mp4' => 'audio/mp4',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
    
            
    
    public function index() {
        $last = $this->_getUrl();
        $roz = explode(".", $last);
        if(count($roz)==1){
            return 0;
        }
        var_dump($roz);
        foreach ($this->mime as $type => $description) {
            if($roz[1] == $type){
                header('Content-type: ' . $description);
                header("HTTP/1.0 404 Not Found");
                exit();
            }
        }
    }
    
     private function _getUrl()    {
        $url1 = isset($_GET['url']) ? $_GET['url'] : null;
        $url2 = rtrim($url1, '/');
        $url3 = filter_var($url2, FILTER_SANITIZE_URL);
        $url4 = explode('/', $url3);
        return $url4[count($url4)-1];
    }
}
