<?php

class Compressor
{
    protected $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    public function compress()
    {
        if ($this->CI->input->is_cli_request()) {
            $this->CI->output->_display();
            return;
        }

        if ($this->CI->input->is_ajax_request()) {
            $this->CI->output->_display();
            return;
        }

        $output = $this->CI->output->get_output();

        $output = $this->CI->compressor->compress($output);

        $this->CI->output->set_header("X-MMS-Compressor-Minify: ".json_encode($this->CI->compressor->minify));
        $this->CI->output->set_header("X-MMS-Compressor-Uglify: ".json_encode($this->CI->compressor->uglify));

        $this->CI->output->_display($output);
        
        return;
    }
}
