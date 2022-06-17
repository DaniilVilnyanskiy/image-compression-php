<?php
echo "<link rel='stylesheet' href='style.css'>";

myFunc('folder');

function myFunc ($dir) {
    if ((stripos($dir,'zip') > -1) || (stripos($dir,'pdf') > -1)) { return false;}
    $files = array_diff(scandir($dir), ['..','.']); /* Массив файлов */

    foreach ($files as $file) {

        $path = $dir.'/'.$file;  /* Полный путь до файла */
        $explode = explode(".", $file);
        $result = end($explode);

        if ((is_dir($path)) || ($result == 'zip') || ($result == 'pdf') || ($result == '')) {
            myFunc($path);
        } else if ((filesize($path) > 100000) && (filesize($path) < 200000)) {
            echo '<div><span>'.$file.'</span><span>> 100 && < 200 </span></div>';
            echoSizeFile($path);
//            getExtension($file, $path);
//            tinyImg($path);
//            echoSizeFile($path);
        } else if ((filesize($path) > 200000) && (filesize($path) < 350000)) {
            echo '<div><span>'.$file.'</span><span>> 200 && < 350 </span></div>';
            echoSizeFile($path);
//            getExtension($file, $path);
//            tinyImg($path);
        } else if (filesize($path) > 350000) {
            echo '<div><span>'.$file.'</span><span>больше 350</span></div>';
            echoSizeFile($path);
//            getExtension($file, $path);
//            tinyImg($path);
        }
    }
}

function getExtension($file, $path) {

    $explode = explode(".", $file);
    $result = end($explode);

    if (($result === 'jpg') || ($result === 'jpeg')) {
        $sourceJpg = imagecreatefromjpeg($path);
        list($width, $height,$type) = getimagesize($path);
        resizeJpg($width, $height, $sourceJpg, $path);

    } else if ($result === 'png') {
        $sourcePng = imagecreatefrompng($path);
        list($width, $height, $type) = getimagesize($path);
        resizePng($width, $height, $sourcePng, $path);
    };
}

function echoSizeFile ($path) {
    echo '<div> Размер файла: ' . filesize($path).'</div>';
}
function saveJpg ($width, $height, $newWidth, $newHeight, $sourceJpg, $path) {
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresized($thumb, $sourceJpg, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagejpeg($thumb,''.$path.'');

}
function savePng ($width, $height, $newWidth, $newHeight, $sourcePng, $path) {
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresized($thumb, $sourcePng, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagejpeg($thumb,''.$path.'');

}
function saveScaleJpg ($width, $height, $newWidth, $newHeight, $sourceJpg, $path) {
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($thumb, $sourceJpg, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagejpeg($thumb,''.$path.'');
}
function saveScalePng ($width, $height, $newWidth, $newHeight, $sourcePng, $path) {
    $thumb = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($thumb, $sourcePng, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imagejpeg($thumb,''.$path.'');

}

function tinyImg ($path) {
    if (filesize($path) > 100000) {
        require_once("vendor/autoload.php");
        \Tinify\setKey("pYtqw1gJCd8spWvTSgXxRgCS6hsJQFHk");
        $source = \Tinify\fromFile("".$path."");
        $source->toFile("".$path."");

    }
}



/*////////////     УСЛОВИЯ        //////////*/


function resizeJpg ($width, $height, $sourceJpg, $path) {

    if (($width === 500 || $height === 500)) {

        echo "ширина и высота $width, $height";

    } else if (($width < 501 || $height < 501)) {

    } else if (($width === 600 || $height === 600)) {
        echo "начальная ширина и высота $width, $height";
        $newWidth = $width - 100;
        $newHeight = $height - 100;

        saveJpg($width, $height, $newWidth, $newHeight, $sourceJpg, $path);

    } else if (($width === 700 || $height === 700)) {
        echo "начальная ширина и высота была $width х $height";
        $newWidth = $width - 200;
        $newHeight = $height - 200;

        saveJpg($width, $height, $newWidth, $newHeight, $sourceJpg, $path);

    } else if (($width === 800 || $height === 800)) {
        echo "начальная ширина и высота была $width х $height";
        $newWidth = $width - 300;
        $newHeight = $height - 300;

        saveJpg($width, $height, $newWidth, $newHeight, $sourceJpg, $path);

    } else if (($width === 900 || $height === 900)) {
        echo "начальная ширина и высота была $width х $height";
        $newWidth = $width - 400;
        $newHeight = $height - 400;

        saveJpg($width, $height, $newWidth, $newHeight, $sourceJpg, $path);

    } else if (($width < 1500 && $width > 500) && ($height < 1500 && $height > 500)) {
        $newWidth = $width * 0.8;
        $newHeight = ($width * 0.8) / ($width/$height);

        saveScaleJpg($width, $height, $newWidth, $newHeight, $sourceJpg, $path);
    } else {
        $newWidth = $width * 0.7;
        $newHeight = ($width * 0.7) / ($width/$height);

        saveScaleJpg($width, $height, $newWidth, $newHeight, $sourceJpg, $path);
    }
}



function resizePng ($width, $height, $sourcePng, $path) {

    if (($width === 500 || $height === 500)) {

        echo "начальная ширина и высота $width, $height";

    } else if (($width < 501 || $height < 501)) {

    } else if (($width === 600 || $height === 600)) {
        echo "начальная ширина и высота $width, $height";
        $newWidth = $width - 100;
        $newHeight = $height - 100;

        savePng($width, $height, $newWidth, $newHeight, $sourcePng, $path);

    } else if (($width === 700 || $height === 700)) {
        echo "начальная ширина и высота была $width х $height";
        $newWidth = $width - 200;
        $newHeight = $height - 200;

        savePng($width, $height, $newWidth, $newHeight, $sourcePng, $path);

    } else if (($width === 800 || $height === 800)) {
        echo "начальная ширина и высота была $width х $height";
        $newWidth = $width - 300;
        $newHeight = $height - 300;

        savePng($width, $height, $newWidth, $newHeight, $sourcePng, $path);

    } else if (($width === 900 || $height === 900)) {
        echo "начальная ширина и высота была $width х $height";
        $newWidth = $width - 400;
        $newHeight = $height - 400;

        savePng($width, $height, $newWidth, $newHeight, $sourcePng, $path);

    } else if (($width < 1500 && $width > 500) && ($height < 1500 && $height > 500)) {
        $newWidth = $width * 0.8;
        $newHeight = ($width * 0.8) / ($width/$height);

        saveScalePng($width, $height, $newWidth, $newHeight, $sourcePng, $path);
    } else {
        $newWidth = $width * 0.7;
        $newHeight = ($width * 0.7) / ($width/$height);

        saveScalePng($width, $height, $newWidth, $newHeight, $sourcePng, $path);
    }
}





?>