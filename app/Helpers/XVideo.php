<?php

namespace App\Helpers;

use App\Videos;

class XVideo
{
    private static $instances = [];

    public static function getInstance()
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function parse()
    {
        $result = [];
        $categories = [];
        $row = 1;
        $fileName = storage_path()."/files/xvideo_dump.csv";
        
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $parse = explode(";", preg_replace('/;{2,}/i', ";", $data[0]));
                unset($data[0]);
            
                $item = [
                    "title" => (isset($parse[1])) ? $parse[1] : NULL,
                    "time" => (isset($parse[2])) ? $parse[2] : NULL,
                    "preview_image" => (isset($parse[4])) ? $parse[3] : NULL,
                    "video_path" => (isset($parse[4])) ? $parse[4] : NULL,
                ];

                if( isset($parse[5]) ) {
                    $categories[] = $parse[5];
                }

                foreach($data as $key => $value) {
                    $category = explode(";", preg_replace('/;{2,}/i', ";", $value));
                    
                    if( count($category) > 0) {
                        if( count($category) > 1 ) {
                            foreach($category as $category_name) {
                                $categories[] = $category_name;
                            }
                        } else {
                            $categories[] = $category[0];
                        }
                    }
                }

                $item['categories'] = json_encode(array_unique($categories));
                
                Videos::create($item);
            }
            fclose($handle);
       }
    }
}