<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csvreader {

    function parse_file($p_Filepath) {
        $file = fopen($p_Filepath, 'r');
        
        // Get the headers/field names from the first row
        $headers = fgetcsv($file);
        $keys_values = $headers;
        //print_r($headers);
        $content = array();
        while (($row = fgetcsv($file)) !== false) {
            if ($row != null) {
                $values =  $row;
    
                if (count($keys_values) == count($values)) {
                    $arr = array();
                    $new_values = $this->escape_string($values);
    
                    for ($i = 0; $i < count($keys_values); $i++) {
                        if ($keys_values[$i] != "" && isset($new_values[$i])) {
                            $arr[$keys_values[$i]] = $new_values[$i];
                        }
                    }
    
                    $content[] = $arr;
                }
            }
        }

        fclose($file);
        return $content;
    }

    private function escape_string($data) {
        $result = array();
        foreach ($data as $row) {
            $result[] = str_replace('"', '', $row);
        }
        return $result;
    }
}
