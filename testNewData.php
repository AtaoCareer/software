<?php
/*
 * 测试新建数据表
 */
$dirName = dirname(__FILE__);
require_once $dirName.'/PHPExcel/Classes/PHPExcel/IOFactory.php';
require_once $dirName.'/db.php';

$db = new db($config);
//数据中不能带`.`
$tableName = "new2.new";
$tableName = substr($tableName, 0, -4);

$db->newTable($tableName);