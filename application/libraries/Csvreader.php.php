<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Csvreader {

    function parse_file($p_Filepath) {
        $file = fopen($p_Filepath, 'r');
        $this->fields = fgetcsv($file);
        $keys_values = explode(',',$this->fields[0]);

        $content = array();
        $keys = $this->escape_string($keys_values);

        $i = 1;
        while(($row = fgetcsv($file)) != false) {
            if ($row != null) { // skip empty lines
                $values = explode(',',$row[0]);
                if(count($keys) == count($values)){
                    $arr = array();
                    $new_values = $this->escape_string($values);
                    for($j = 0; $j < count($keys); $j++) {
                        if($keys[$j] != "") {
                            $arr[$keys[$j]] = $new_values[$j];
                        }
                    }
                    $content[$i] = $arr;
                    $i++;
                }
            }
        }
        fclose($file);
        return $content;
    }

    private function escape_string($data) {
        $result = array();
        foreach($data as $row) {
            $result[] = str_replace('"', '',$row);
        }
        return $result;
    }
}
