<?php

$Message = new Module();
$Message->addModule(new Message(), array("html" => "{_'settings_node_rights_legend'}", "class" => "alert-info"));
$Message->output();			

$Module = new Module();
$Module->addModule(new Settings('getNodeRights'), $return);
$Module->output();

?>