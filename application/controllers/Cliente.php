<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Author: Eduardo de Oliveira Bacarin
 * Date: 05/04/2022
 * 
 **/

class Cliente extends CI_Controller{
    
  public function __construct(){
    parent::__construct();
    // echo json_encode($this->session->userdata());exit;
    if(empty($this->session->userdata('usuario')) || $this->session->userdata('usuario') == false){
      redirect('login');
    }
  }

  public function index(){
    $this->load->view('estrutura/topo');
    $this->load->view('03_clientes/lista');
    $this->load->view('estrutura/rodape');
  }

}