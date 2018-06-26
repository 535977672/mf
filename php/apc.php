<?php
if(!extension_loaded('apc')){
    echo '没有安装apc';
    return false;
}
$bar = 'BAR';
apc_add('foo', $bar);
var_dump(apc_fetch('foo'));
