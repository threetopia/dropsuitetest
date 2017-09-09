<?php

/**
 * Author : Tri Hartanto (dev@trihartanto.com)
 *
 * This class using to demonstrated File Handling
 */
class FileUtil
{
    private $filesData = [];
    
    public function __construct($directory)
    {
        $this->scanDirectory($directory);
    }
    
    /**
     * This will scan directory
     *
     * @param string $directory
     */
    public function scanDirectory($directory)
    {
        if (empty($directory)) {
            return false;
        }
        
        $directoryList = scandir($directory);
        if ( ! empty($directoryList)) {
            foreach ($directoryList as $val) {
                if ($val == '.' || $val == '..') {
                    continue;
                }
                
                $key = $directory . DIRECTORY_SEPARATOR . $val;
                if (is_file($key)) {
                    $type = mime_content_type($key);
                    if ($type != 'text/plain') {
                        continue;
                    }
                    
                    $content                    = file_get_contents($key);
                    $this->filesData[$content]  = (isset($this->filesData[$content])) ? $this->filesData[$content] + 1 : 1;
                } else {
                    $this->scanDirectory($key);
                }
            }
        }
    }
    
    /**
     * Get most same content of the files
     *
     * @return string
     */
    public function getFileWithMostSameContent()
    {
        arsort($this->filesData);
        $content = key($this->filesData);
        
        return $content . ' ' . $this->filesData[$content];
    }
    
    /**
     * Get all list of the same content file
     *
     * @return string
     */
    public function getFileWithSameContent()
    {
        $html = '';
        foreach ($this->filesData as $content => $count) {
            $html .= $content . ' ' . $count . '<br>';
        }
        
        return $html;
    }
}

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
