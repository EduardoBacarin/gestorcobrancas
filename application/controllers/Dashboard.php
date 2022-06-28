<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Author: Eduardo de Oliveira Bacarin
 * Date: 05/04/2022
 * 
 **/

class Dashboard extends CI_Controller{
    
  public function __construct(){
    parent::__construct();
    // echo json_encode($this->session->userdata());exit;
    if(empty($this->session->userdata('usuario')) || $this->session->userdata('usuario') == false){
      redirect('login');
    }
  }

  public function index(){
    $this->load->model('dashboard_model', 'dashboard');
    $data['cobrancas'] = !empty($this->dashboard->total_cobrancas()) ? $this->dashboard->total_cobrancas() : 0;
    $data['cobrancas_mes'] = !empty($this->dashboard->total_cobrancas_mes()) ? $this->dashboard->total_cobrancas_mes() : 0;
    $data['atrasados'] = !empty($this->dashboard->atrasados()) ? $this->dashboard->atrasados() : 0;
    $data['pagam_hoje'] = !empty($this->dashboard->vencem_hoje()) ? $this->dashboard->vencem_hoje() : 0;
    $data['lucro'] = !empty($this->dashboard->lucro_pagos()) ? number_format($this->dashboard->lucro_pagos()[0]->lucro_par, 2, ',', '.') : '0,00';
    $data['lucro_mes'] = !empty($this->dashboard->lucro_pagos_mes()) ? number_format($this->dashboard->lucro_pagos_mes()[0]->lucro_par, 2, ',', '.') : '0,00';
    
    $this->load->view('estrutura/topo');
    $this->load->view('02_dashboard/dashboard', $data);
    $this->load->view('estrutura/rodape');
  }

}