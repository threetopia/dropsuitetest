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
