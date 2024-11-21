<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    $this->parser->parse('layout/VHeader', $data);
    $this->parser->parse('layout/VContent', $data);
    $this->parser->parse('layout/VMail', $data);
    // $this->load->view('layout/VMail', $data);
    $this->parser->parse('layout/VFooter', $data);   
