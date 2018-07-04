<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class CelebriumComponent extends Component {
    
    public function getTemplate($cc) {
        
        $serverNo = rand(0, 24);
        $serverNo = 3;
        
        $queryArr = [
            'nn' => $cc['nn'],
            'sn' => $cc['sn'],
            'toserver' => $serverNo,
            'an' => $cc['an'][$serverNo],
            'pan' => $cc['an'][$serverNo],
            'denomination' => 1
        ];
        
        $url = "https://raida" . $serverNo . ".cloudcoin.global/service/get_ticket?" . http_build_query($queryArr);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $error = false;
        if (!$resultFromAPI = curl_exec($ch)) {
            $resultFromAPI = curl_error($ch);
            $error = true;
        }
        
        curl_close($ch);
        $tmp = json_decode($resultFromAPI, true);
        
        $tmp['error'] = $error;
        
        return ($error) ? $tmp : $this->fetchTemplate($cc['sn'], $tmp['message']);
        
    }
    
    public function fetchTemplate($sn, $message) {
        
        
        $baseUrl = "https://raida.tech/get_template.php?nn=1&sn=" . $sn . "&fromserver1=3&message1=" . $message;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $error = false;
        if (!$resultFromAPI = curl_exec($ch)) {
            $resultFromAPI = curl_error($ch);
            $error = true;
        }
        
        curl_close($ch);
        
        $response = ($error) ? $resultFromAPI : json_decode($resultFromAPI, true);
        
        $response['error'] = $error;
        
        return $response;
        
    }
    
    public function binaryDataToJpeg($binaryData, $fileName) {
        // open the output file for writing
        $ifp = fopen($fileName, 'wb');
        
        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, $binaryData);
        
        // clean up the file resource
        fclose($ifp);
    }
    
    public function base64ToJpeg($base64Str, $fileName) {
        // open the output file for writing
        $ifp = fopen($fileName, 'wb');
        
        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, base64_decode($base64Str));
        
        // clean up the file resource
        fclose($ifp);
    }
    
    
    public function readMemo($file = null) {
        $imgBinary = file_get_contents($file);
        
        $hex = substr(bin2hex($imgBinary), 0, 1300);
        
        $ans = [];
        for ($x = 0; $x < 25; $x++) {
            $an = substr($hex, (40 + ($x * 32)), 32);
            $ans[] = $an;
        }
        
        $aoid = substr($hex, 840, 54);
        $ed = substr($hex, 898, 4);
        
        $nn = hexdec(substr($hex, 902, 2));
        $sn = hexdec(substr($hex, 904, 6));
        
        $coins = [
            'nn' => $nn,
            'an' => $ans,
            'sn' => $sn,
            'ed' => $ed,
            'aoid' => $aoid
        ];
        
        return $coins;
    }
    
    public function readCelebrium($file = null) {
        $cloudCoinJson = file_get_contents($file);
        $cloudCoinArray = json_decode($cloudCoinJson, true);
        return $cloudCoinArray['cloudcoin'][0];
    }
    
    
    public function writeInfo($source, $destination, $meta, $sn) {
        
        $textColor = "#6b6b6b";
        
        // Create objects
        $image = new \Imagick($source);
        $watermark = new \Imagick();
        $mask = new \Imagick();
        $draw = new \ImagickDraw();
        
        // Define dimensions
        $width = $image->getImageWidth();
        $height = $image->getImageHeight();
        
        // Create some palettes
        $watermark->newImage($width, $height, new \ImagickPixel('#ffffff'));
        $mask->newImage($width, $height, new \ImagickPixel('none'));
        
        
        // Set font properties
        $draw->setFont(WWW_ROOT . 'font/RidleyGrotesk-Regular.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor($textColor);
        // Position text at the bottom right of the image
        $draw->setGravity(\Imagick::GRAVITY_SOUTHWEST);
        // Draw text on the watermark palette
        // Draw text on the mask palette
        $mask->annotateImage($draw, 80, 130, 0, strtoupper("Name: " . $meta['title']));
        $mask->annotateImage($draw, 80, 115, 0, strtoupper("Serial: " . number_format($sn) . " of 16,777,216 on Network: 1"));
        $mask->annotateImage($draw, 80, 100, 0, strtoupper("Run: " . (empty($meta['run']) ? "1" : $meta['title'])));
        $mask->annotateImage($draw, 80, 85, 0, strtoupper("Class: " . (empty($meta['rarity']) ? "Launch" : $meta['rarity'])));
        
        
        // This is needed for the mask to work
        $mask->setImageMatte(false);
        
        // Apply mask to watermark
        $watermark->compositeImage($mask, \Imagick::COMPOSITE_COPYOPACITY, 0, 0);
        
        // Overlay watermark on image
        $image->compositeImage($watermark, \Imagick::COMPOSITE_DISSOLVE, 0, 0);
        
        // Set output image format
        $image->setImageFormat('jpg');
        
        // Output the new image
        $ifp = fopen($destination, 'wb');
        
        // we could add validation here with ensuring count( $data ) > 1
        fwrite($ifp, $image);
        
        // clean up the file resource
        fclose($ifp);
        
        
    }
    
    
    public function buildCloudCoinString($cc) {
        
        $cloudCoinStrArray = [
            "01C34A46494600010101006000601D05",
            implode("", $cc['an']),
            "4c6976652046726565204f7220446965",
            "00000000000000000000000000",
            "00",
            dechex($this->calcExpirationDate($cc['ed'])),
            (strlen(dechex($cc['nn'])) < 2) ? "0" . dechex($cc['nn']) : dechex($cc['nn']),
            $this->calcSerialNo($cc['sn'])
        ];
        
        return implode("", $cloudCoinStrArray);
    }
    
    public function calcExpirationDate($ed) {
        $explode = explode("-", $ed);
        return (int)(($explode[1] - date('Y')) * 12) + ($explode[0] - date('m'));
    }
    
    public function calcSerialNo($sn) {
        $hexSn = dechex($sn);
        
        switch (strlen($hexSn)) {
            case 1:
                return "00000" + $hexSn;
            case 2:
                return "0000" + $hexSn;
            case 3:
                return "000" + $hexSn;
            case 4:
                return "00" + $hexSn;
            case 5:
                return "0" + $hexSn;
            case 6:
                return $hexSn;
        }
    }
    
    
    public function verifyMemo($sn, $nn, $serverNo, $an) {
        
        $queryArr = [
            'nn' => $nn,
            'sn' => $sn,
            'an' => $an,
            'pan' => $an,
            'denomination' => 1
        ];
        
        $url = "https://raida" . $serverNo . ".cloudcoin.global/service/detect?" . http_build_query($queryArr);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        if (!$resultFromAPI = curl_exec($ch)) {
            $resultFromAPI = curl_error($ch);
        }
        
        curl_close($ch);
        
        return json_decode($resultFromAPI, true);
        
    }
}

?>
