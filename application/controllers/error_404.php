<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Author: Eduardo de Oliveira Bacarin
 * Date: 05/04/2022
 * 
 **/

class Error_404 extends CI_controller
{

  public function index()
  {
    $this->output->set_status_header('404');
            // Make sure you actually have some view file named 404.php
            $this->load->view('estrutura/error_404');
  }
}