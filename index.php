<?php
include 'FileUtil.php';

$fileUtil = new FileUtil('DropsuiteTest');

$html = '<i>Attached is the example folder.';
$html .= 'In this case if I pass the folder\'s path, the script will return me the number of files that have same content.';
$html .= 'On those folders content1 = content2 = content3, So the application will return content + number</i><br>';
$html .= '<b>Answer :</b><br>';
$html .= $fileUtil->getFileWithSameContent();
$html .= '<br>';
$html .= '<i>Also you need to return the bigger number of files if there are multiple files with the same content</i><br>';
$html .= '<b>Answer :</b><br>';
$html .= $fileUtil->getFileWithMostSameContent();

echo $html;