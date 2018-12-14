<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf_service{
    
    protected $CI;
    protected $pdf;
    protected $path;
    protected $to_file;
    protected $file_name;

    public function __construct()
    {
        ini_set('memory_limit', '500M');
        $this->CI =& get_instance();
    }

    public function open($path, $file_name, $to_file = FALSE)
    {
        $this->to_file = $to_file;
        $this->path = $path;
        $this->file_name = $file_name;
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        // $options->set('isRemoteEnabled', true);
        $this->pdf = new Dompdf($options);
        // $this->pdf->setPaper('A4', 'portrait');

        return $this;
    }

    public function close($columns, $rows)
    {
        $this->pdf->loadHtml($this->CI->view->render('layouts/pdf', array(
            'columns' => $columns,
            'rows' => $rows
        )));

        $this->pdf->render();
        if($this->to_file){
            file_put_contents($this->path.$this->file_name, $this->pdf->output());
        }
        $this->pdf->stream($this->file_name);
    }

    public function fromTemplate($view, $data)
    {
        $this->pdf->loadHtml($this->CI->view->render($view, array_merge(
            array(
                'base_path' => APPPATH.'..'.DIRECTORY_SEPARATOR.'public/'
            ),
            $data
        )));

        $this->pdf->render();

        if($this->to_file){
            file_put_contents($this->path.$this->file_name, $this->pdf->output());
        }
        
        $this->pdf->stream($this->file_name);
    }
}