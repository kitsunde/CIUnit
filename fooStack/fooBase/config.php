<?php

define('FSPATH', APPPATH.'libraries/fooStack/');

function foo_config()
{
    $config['foostack']['prefix'] = 'foo';
    $config['foostack']['active_plugins']= array('fooStack','ME');
    return $config['foostack'];
}