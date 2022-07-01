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
    $rodape['js'] = [
      'assets/js/dashboard.js',
    ];
    $data['cobrancas'] = !empty($this->dashboard->total_cobrancas()) ? $this->dashboard->total_cobrancas() : 0;
    $data['cobrancas_mes'] = !empty($this->dashboard->total_cobrancas_mes()) ? $this->dashboard->total_cobrancas_mes() : 0;
    $data['atrasados'] = !empty($this->dashboard->atrasados()) ? $this->dashboard->atrasados() : 0;
    $data['pagam_hoje'] = !empty($this->dashboard->vencem_hoje()) ? $this->dashboard->vencem_hoje() : 0;
    $data['lucro'] = !empty($this->dashboard->lucro_pagos()) ? number_format($this->dashboard->lucro_pagos()[0]->lucro_par, 2, ',', '.') : '0,00';
    $data['lucro_mes'] = !empty($this->dashboard->lucro_pagos_mes()) ? number_format($this->dashboard->lucro_pagos_mes()[0]->lucro_par, 2, ',', '.') : '0,00';
    
    $this->load->view('estrutura/topo');
    $this->load->view('02_dashboard/dashboard', $data);
    $this->load->view('estrutura/rodape', $rodape);
  }


  public function listar_vencidos()
  {
    $this->load->model('dashboard_model', 'dashboard');
    $post = $this->input->get();

    if (!empty($post)) {

      $page       = $post['start'];
      $limit      = $post['length'];
      $q          = $post['search']['value'];
      $dados = $this->dashboard->listar_vencidos($limit, $page, $q);
      $total = $this->dashboard->contar_vencidos($q);
      if (!empty($dados)) {
        $total_registros = $total;
        $retorno_dados = [];
        $contador = 0;
        foreach ($dados as $dt) {
          $contador++;
          $valor_parcela_semjuros = $dt->total_cob / $dt->qtdparcelas_cob;
          $data_vencimento = new DateTime($dt->datavencimento_par, new DateTimeZone('America/Sao_Paulo'));
          $menu = '<div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">Ações </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item item-pago" data-codigo="' . $dt->codigo_par . '" data-limite="' . $data_vencimento->format('Y-m-d') . '" data-lucro="' . $dt->lucro_par . '" data-valor="' . floatval($dt->valor_par) . '" data-valororiginal="' . number_format(floatval($valor_parcela_semjuros), 2, '.', '') . '" style="display: ' . ($dt->status_par == 3 || $dt->status_par == 4 ? 'none;' : '') . '"> <i class="fa-solid fa-money-bill" style="color: green"></i> Marcar Pago</a>
                      <a class="dropdown-item item-excluir" data-codigo="' . $dt->codigo_par . '"> <i class="fa-solid fa-trash-can"></i> Excluir</a>
                    </div>
                  </div>';

          $restante = $dt->total_cob - $dt->valorpago_par;
          $restante = $restante < 0 ? 0 : $restante;
          $array = array(
            $dt->codigo_par,
            limitaTexto($dt->nome_cli, 40),
            'R$' . number_format($dt->total_cob, 2, ',', '.'),
            'R$' . number_format(floatval($dt->valor_par), 2, ',', '.'),
            $dt->parcela_par . ' de ' . $dt->qtdparcelas_cob,
            date('d/m/Y', strtotime($dt->datavencimento_par)),
            'R$' . number_format($dt->lucro_par, 2, ',', '.'),
            $menu,
          );
          array_push($retorno_dados, $array);
        }

        $retorno = array(
          'recordsTotal' => $total_registros,
          'recordsFiltered' => $total_registros,
          'data' => $retorno_dados,
        );

        echo json_encode($retorno);
      } else {
        $retorno = array(
          'recordsTotal' => 0,
          'recordsFiltered' => 0,
          'data' => [],
        );

        echo json_encode($retorno);
      }
    }
  }

}