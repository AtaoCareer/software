<?php
    /*
     * 将excel文件导入到数据库
     */
    //header("Content-Type:text/html;charset=utf-8");
    $dirName = dirname(__FILE__);
    require_once $dirName.'/PHPExcel/Classes/PHPExcel/IOFactory.php';
    require_once $dirName.'/db.php';
    
    /*
     * 从文件中读取全部的文件名
     */
    
    $readDir = $dirName.'/InAll';
    $fileAllNames = scandir($readDir);//目录中所有文件的
    $fileNames = array_slice($fileAllNames, 2);//去掉 . ..两个目录
    foreach ($fileNames as $eachFile)
    {
        $fileName = $dirName."/InAll/".$eachFile; 
        //将文件名的后缀去掉保留全面部分作为数据表名
        $eachFile = substr($eachFile, 0, -4);
    
        
    
 
    /*
     * 解决中文名称的读取问题，表示EXCEL的中文名是gb2312格式的
     */
     // $fileName = iconv("utf-8", "gb2312", $fileName);
    //TO DO 还没解决中文名的读取问题
    
    $fileType = PHPExcel_IOFactory::identify($fileName);
    
    $objReader = PHPExcel_IOFactory::createReader($fileType);
    
    
    //可以选择 加载哪个sheet
    //$sheetName = array("name1", "name2");
    
    $sheetName = "应用程序统计";
    
    //$sheetName = iconv("gb2312", "utf-8", $sheetName);//开始是因为没有把文件的编码设置成utf8编码
    
    
    $objReader->setLoadSheetsOnly($sheetName);
    
    //load文件
    $objPHPExcel = $objReader->load($fileName);
    /*
     * 尝试看一下得到当前sheet的名称，判断一下EXCEL里SHEET的名称是什么编码
    $objWorkSheet = $objPHPExcel->getActiveSheet();
    $sheetName = $objWorkSheet->getTitle();
    
    echo $sheetName;
    */
   //var_dump($config);
    $db = new db($config);
    //echo $eachFile;
    $db->newTable($eachFile);
    foreach ($objPHPExcel->getWorksheetIterator() as $sheet){ //循环SHEET
        foreach ($sheet->getRowIterator() as $row){           //循环每行
            if ($row->getRowIndex()>3)
            {
                
                $typeInData = array();
                $i = 0;
            foreach ($row->getCellIterator() as $cell){       //循环每个Cell
                $data = $cell->getValue();
                $typeInData[$i] = $data;
                $i++;
            }
            
            
            
            $db->insertData($eachFile, $typeInData[1], $typeInData[2], $typeInData[3]);
            
            
            }
        }
        
    }
    
    }
    