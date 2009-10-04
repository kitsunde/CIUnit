<?php

include_once dirname(__FILE__) . '/CIUnit.php';
include_once dirname(__FILE__) . '/getops.php';

class Generate
{
    function __construct()
    {
        $this->CI = &set_controller('MY_Controller');
        $this->CI->load->library('Spyc');        
    }
    
    function get_table_data($table, $limit = 0)
    {
        $query = "SELECT * FROM `$table`";
        if ($limit > 0)
        {
            $query .= " LIMIT " . (int) $limit; 
        }
        $res = mysql_query($query);
        $data = Array();
        while (($row = mysql_fetch_assoc($res)) !== false)
        {
            $data['row' . (count($data) + 1)] = $row;
        }
        mysql_free_result($res);
        return $data;
    }    
    
    function fixtures($args = Array())
    {
        if (substr($this->CI->db->database, -5, 5) != '_test')
        {
           die("\nSorry, the name of your test database must end on '_test'.\nThis prevents deleting important data by accident.\n");
        }
        
        $this->CI->db->database = preg_replace("#_test$#", "_development", $this->CI->db->database);
        if (!$this->CI->db->db_select())
        {
            die("\nCould not select development database.\n");   
        }        
       
        $opts = getopts(array(
        	'rows'     => array('switch' => 'n','type' => GETOPT_VAL, 'default' => 5),
            'fixtures' => array('switch' => 'f','type' => GETOPT_MULTIVAL),
            'output'   => array('switch' => 'o','type' => GETOPT_VAL, 'default' => dirname(__FILE__) . '/fixtures')
        ),$args);
        
        
        $rows     = $opts['rows'];
        $fixtures = $opts['fixtures'];
        $output   = rtrim(str_replace('\\','/',$opts['output']), '/') . '/';
        
        if (!@chdir($output))
        {
            die("\nOutput directory '$output' does not exist.\n");   
        }
                               
        
        $tables = $this->CI->db->list_tables();
        if (count($fixtures) == 0)
        {
            $fixtures = $tables;    
        }
        else
        {
            /* check tables */
            foreach ($fixtures as $fixture)
            {
                if (!in_array($fixture, $tables))
                {
                    die("\nTable `$fixture` does not exist.\n");
                }   
            }       
        }
        
        
        foreach ($fixtures as $fixture)
        {
            $filename = $fixture . '_fixt.yml';
            $data = $this->get_table_data($fixture, $rows);
            $yaml_data = $this->CI->spyc->dump($data);
            
            $yaml_data = preg_replace('#^\-\-\-#', '', $yaml_data);
            
            /* don't check if the file already exists */
            file_put_contents($filename, $yaml_data);    
        }
    }
}

$args = $_SERVER['argv'];
$self = array_shift($args);

$generate = new Generate;
$generate_what = array_shift($args);

if (!method_exists($generate, $generate_what))
{
    die("\nMethod '$generate_what' is invalid.
Usage:
    php generate.php fixtures <options>
Options:
    -f  tables of which fixtures should be created (-f table1 -f table2 etc)
    -n  number of rows in fixtures
    -o  output directory\n");
}
else
{
    $generate->$generate_what($_SERVER['argv']);   
}
