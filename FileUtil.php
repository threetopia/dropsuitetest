<?php

/**
 * Author : Tri Hartanto (dev@trihartanto.com)
 *
 * This class using to demonstrated File Handling
 */
class FileUtil
{
    private $filesData      = [];
    private $filesCountData = [];
    
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
                    
                    $content                        = file_get_contents($key);
                    $hash                           = sha1_file($key);
                    $this->filesData[$hash]         = $content;
                    $this->filesCountData[$hash]    = (isset($this->filesCountData[$hash])) ? $this->filesCountData[$hash] + 1 : 1;
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
        arsort($this->filesCountData);
        $hash = key($this->filesCountData);
        
        return $this->filesData[$hash] . ' ' . $this->filesCountData[$hash];
    }
    
    /**
     * Get all list of the same content file
     *
     * @return string
     */
    public function getFileWithSameContent()
    {
        $html = '';
        foreach ($this->filesData as $hash => $content) {
            $html .= $content . ' ' . $this->filesCountData[$hash] . '<br>';
        }
        
        return $html;
    }
}
