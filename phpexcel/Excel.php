<?php
class Excel{
    
    /*
	 * excel 验证规则
	 * =-=  非空   /\S/
	 * 		数字  /^[0-9]*$/
	 */
	public static $rule = array(
        'user' => array(13=>'/^\d{11}$/'),
	);
    /**
	 * Read And Validate Excel
	 * @param string $filepath  xls文件全路径
	 * @param number $startRow  数据开始行
	 * @param string $rule  excel 验证规则
	 * @return array $data  返回读取的数据
	 */
	public static function readExcel( $filepath, $startRow=2, $rule='default', $verify = array()) {
		require_once ('/PHPExcel/IOFactory.php');
		
		$type = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
		//var_dump($type);
		$objPHPExcel = null;
		if ($type == 'xlsx' || $type == 'xls') {
			//通过PHPExcel_IOFactory::load方法来载入一个文件，load会自动判断文件的后缀名来导入相应的处理类，
            //读取格式保含xlsx/xls/xlsm/ods/slk/csv/xml/gnumeric
            $objPHPExcel = PHPExcel_IOFactory::load($filepath);
		} elseif ($type == 'csv') {
			$objReader = PHPExcel_IOFactory::createReader('CSV')
				->setDelimiter(',')
				->setInputEncoding('GBK') //不设置将导致中文列内容返回boolean(false)或乱码
				->setEnclosure('"')
				->setLineEnding("\r\n")
				->setSheetIndex(0);
			$objPHPExcel = $objReader->load($filepath);
		} else {
			die('Not Supported File Type !');
			return;
		}
		
        //把载入的文件默认表（一般都是第一个）通过toArray方法来返回一个多维数组
        //$dataArray = $objPHPExcel->getActiveSheet()->toArray();
        //var_dump($dataArray);
        
		// sheet
		$sheet = $objPHPExcel->getSheet(0);
		//$sheet = new PHPExcel_Worksheet();
		 
		$allColumn = $sheet->getHighestColumn(); //最大列  字母
		$allColumnNum = PHPExcel_Cell::columnIndexFromString($allColumn); //一共有多少列
		$allRow = $sheet->getHighestRow(); //一共有多少行
		
		// first row
		$feild = array();
		for ($j=0; $j<$allColumnNum; $j++) {
			$cellName = PHPExcel_Cell::stringFromColumnIndex($j).'1';//A1 B1 C1
			$feild[$j] = $sheet->getCell($cellName)->getValue();
		}
        //var_dump($feild);
        
		// rule
		$rule = self::$rule[$rule]; // excel验证规则
		$failCount = 0; // 验证失败条数
		
		$data = array(); // all data;
		for ($i=$startRow; $i<=$allRow; $i++) { // row
			$row = array(); // a row data;
			$isSuccess = true; // row是否验证成功
			for ($k=0; $k<$allColumnNum; $k++) { // cell
				$cellName = PHPExcel_Cell::stringFromColumnIndex($k).$i;
                $cellValue = $sheet->getCell($cellName)->getValue();
                //日期处理
                if(in_array($k, $verify)){
                    $cellValue = gmdate("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($cellValue));//2014-2-8 12:12:32     
                }
				if ($cellValue instanceof PHPExcel_RichText) {
					$cellValue = $cellValue->__toString();
				}
				// validate(格式验证)
				if (!empty($rule[$k])) {
					if (preg_match($rule[$k], $cellValue)) {
						// success
						
					} else {
						// fail
						$isSuccess = false;
						// tag excel  红色 #FF0000  绿色 #00FF00 
						// 红色背景
						$sheet->getStyle($cellName)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
						$sheet->getStyle($cellName)->getFill()->getStartColor()->setARGB('FFFF0000');
						// 添加批注
						//$sheet->getComment($cellName)->setAuthor('tdnt');
						$commentRichText = $sheet->getComment($cellName)->getText()->createTextRun('格式不正确');
						//$commentRichText->getFont()->setBold(true);
						//$sheet->getComment($cellName)->getFillColor()->setRGB('EEEEEE');
						//$sheet->getComment($cellName)->setVisible(true);
						
					}
				}
				$row[$feild[$k]] = $cellValue;
			}
//
			// 给行做标记  (验证成功/验证失败)
			$tagcellName = PHPExcel_Cell::stringFromColumnIndex($allColumnNum+1).$i;
			if (empty($isSuccess)) {
				// 没验证成功
				$failCount++;
				$sheet->getCell($tagcellName)->setValue('验证失败');
				$sheet->getStyle($tagcellName)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
				$sheet->getStyle($tagcellName)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$sheet->getStyle($tagcellName)->getFill()->getStartColor()->setARGB('FFFF0000');
			} else {
				$sheet->getCell($tagcellName)->setValue('验证成功');
				$sheet->getStyle($tagcellName)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
				$sheet->getStyle($tagcellName)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$sheet->getStyle($tagcellName)->getFill()->getStartColor()->setARGB('FF00FF00');
				$data[] = $row;  // 添加成功数据
			}
			
		}
		
		if (!empty($failCount)) {
			
			// output
			//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // xls
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); // xlsx
			$time = date('Ymd-His', time());
			//$_filepath = substr($filepath, 0, strrpos($filepath, '/')+1).$time.'.'.$type;
			//$failpath = substr($filepath, strrpos($filepath, '/asserts'), strrpos($filepath, '/')-strlen($filepath)+1).$time.'.'.$type;
			
			//$_filepath = substr($filepath, 0, strrpos($filepath, '/')+1).$time.'.xls';// xls
			//$failpath = substr($filepath, strrpos($filepath, '/asserts'), strrpos($filepath, '/')-strlen($filepath)+1).$time.'.xls';
			$_filepath = substr($filepath, 0, strrpos($filepath, '/')+1).$time.'.xlsx';// xlsx
			$failpath = substr($filepath, strrpos($filepath, '/asserts'), strrpos($filepath, '/')-strlen($filepath)+1).$time.'.xlsx';
			$objWriter->save($_filepath);
		}
		
		return array('failCount'=>$failCount,'failpath'=>$failpath, 'successCount'=>count($data), 'data'=>$data);
	}
    
    public static function writeExcel( $filepath ) {
        require_once ('PHPExcel.php');
        $objPHPExcel = new PHPExcel();
        //设置excel的属性：
        //创建人
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
        //最后修改人
        $objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
        //标题
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        //题目
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        //描述
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        //关键字
        $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
        //种类
        $objPHPExcel->getProperties()->setCategory("Test result file");
        
        //设置当前的sheet
        $objPHPExcel->setActiveSheetIndex(0);
        //设置sheet的name
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        //设置单元格的值
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'String');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', '发的发');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', true);
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 12);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', true);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 12);
        $objPHPExcel->getActiveSheet()->setCellValue('C3', true);
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 12);
        $objPHPExcel->getActiveSheet()->setCellValue('C1', true);
        $objPHPExcel->getActiveSheet()->setCellValue('D3', true);
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 12);
        $objPHPExcel->getActiveSheet()->setCellValue('D1', true);
        $objPHPExcel->getActiveSheet()->setCellValue('E3', true);
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 12);
        $objPHPExcel->getActiveSheet()->setCellValue('E1', true);
        
        
        //设置填充颜色
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('FF808080');
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setARGB('FF808080');
        
        //设置border的color
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getBorders()->getLeft()->getColor()->setARGB('FF993300');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getBorders()->getTop()->getColor()->setARGB('FF993300');
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getBorders()->getBottom()->getColor()->setARGB('FF993300');
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getBorders()->getTop()->getColor()->setARGB('FF993300');
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getBorders()->getBottom()->getColor()->setARGB('FF993300');
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getBorders()->getRight()->getColor()->setARGB('FF993300');
        
        //设置宽width
        // Set column widths
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        
        
        $objPHPExcel->createSheet();
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($filepath);
        
        //直接下载
//        header('Content-Type: application/vnd.ms-excel'); 
//        header('Content-Disposition: attachment;filename="下载.xls"'); 
//        header('Cache-Control: max-age=0'); 
//        $objWriter->save('php://output');
    }
}