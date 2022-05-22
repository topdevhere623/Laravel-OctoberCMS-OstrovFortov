<?php


class HtmlHelper
{

    private static $instance;
    private $dir;

    private function __construct()
    {
        $this->dir = __DIR__.'/blocks/';
    }

    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getBlock($blockName)
    {
        $fileName = $this->getFileName($blockName);
        if(file_exists($fileName)){
            return file_get_contents($fileName);
        }
    }

    private function getFileName($blockName)
    {
        return $this->dir.$blockName.'.php';;
    }

    public function includeBlock($blockName, $data = [])
    {
        $fileName = $this->getFileName($blockName);
        if(file_exists($fileName)){
            foreach ($data as $k => $item) {
                ${$k} = $item;
            }
            include $fileName;
        }
    }

    public function printBlock($blockName)
    {
        $content = $this->getBlock($blockName);
        if($content && gettype($content) == 'string'){
            print $content;
        }
    }

}