<?php defined('BASEPATH') OR exit('No direct script access allowed');

// For processing Imports
use \Box\Spout\Reader\ReaderFactory;
use \Box\Spout\Writer\WriterFactory;
use \Box\Spout\Common\Type;

// For processing exports
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Spreadsheet_service{

    protected $CI;

    protected $spreadsheet, $sheets, $sheet, $rows, $row, $cells, $cell;

    public function __construct()
    {
        ini_set('memory_limit', '500M');
        $this->CI =& get_instance();
    }

    public function open($filePath, $file_name = NULL, $write = FALSE, $to_file = FALSE, $type = NULL)
    {

        if($write){
            $this->spreadsheet = WriterFactory::create(Type::XLSX);
            $this->spreadsheet->openToBrowser($file_name);
            if($to_file){
                $this->spreadsheet->openToFile($filePath.$file_name);
            }
        }
        else{
            $this->spreadsheet = ReaderFactory::create(Type::XLSX);
            $this->spreadsheet->open($filePath.$file_name);
        }

        return $this;
    }

    public function columns()
    {
        $output = array();
        
        foreach ($this->spreadsheet->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $index => $row) {
                if($index == 1){
                    foreach ($row as $key => $value) {
                        $output[] = trim($value);
                    }
                }
            }
        }

        return $output;
    }

    public function rows($callback = NULL, $from_cell_index = 0, $to_cell_index = 1000)
    {
        $output = array();
        foreach ($this->spreadsheet->getSheetIterator() as $sheet) {
            $output_sheet = array();
            foreach ($sheet->getRowIterator() as $index => $row) {
                if($index > 1){
                    $output_rows = array();
                    foreach ($row as $cell_index => $cell) {
                        if($cell_index >= $from_cell_index && $cell_index <= $to_cell_index){
                            $output_rows[] = $cell;
                        }
                    }
                    if(!empty($output_rows)){
                        if(isset($callback) && is_callable($callback)){
                            $callback($output_rows);
                        }
                        $output_sheet[] = $output_rows;
                    }
                }
            }
            $output[] = $output_sheet;
        }

        return $output;
    }

    public function close($columns, $rows)
    {
        $this->spreadsheet->addRow($columns);
        $this->spreadsheet->addRows($rows);
        
        $this->spreadsheet->close();
    }

}