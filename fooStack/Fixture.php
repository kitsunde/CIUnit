<?php
/*
* fooStack, CIUnit for CodeIgniter
* Copyright (c) 2008-2009 Clemens Gruenberger
* Released under the MIT license, see:
* http://www.opensource.org/licenses/mit-license.php
*/

/**
* Fixture Class
* loads fixtures
* can be used with CIUnit
*/
class Fixture {

    function __construct()
    {
        if (!defined('CIUnit_Version'))
        {
            exit('can\'t load fixture library class when not in test mode!');
        }
    }

    /**
    * loads fixture data $fixt into corresponding table
    */
    function load($table, $fixt)
    {
        $this->CI = &get_instance();
        if (!isset($this->CI->db) || !isset($this->CI->db->database))
        {
         $this->CI->db = $this->CI->config->item('db');   
        }
        //FIXME, this has to be done only once
        $db_name_len = strlen($this->CI->db->database);
        if (substr($this->CI->db->database, $db_name_len-5, $db_name_len) != '_test')
        {
            die("\nSorry, the name of your test database must end on '_test'.\n".
                "This prevents deleting important data by accident.\n");
        }

        # $fixt is supposed to be an associative array outputted by spyc from YAML file
        $this->CI->db->simple_query('truncate table ' . $table . ';');
        foreach ($fixt as $id=>$row)
        {
            foreach ($row as $key=>$val)
            {
                if ($val !== '')
                {
                    $row["`$key`"]=$val;
                }
                //unset the rest
                unset($row[$key]);
            }
            $this->CI->db->insert($table, $row);
            log_message('debug', "fixture: '$id' for $table loaded");
        }
    }

}