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

    $rodape['js'] = ['assets/js/cliente.js'];
    $this->load->view('estrutura/topo');
    $this->load->view('03_clientes/lista');
    $this->load->view('03_clientes/modal_cadastro');
    $this->load->view('estrutura/rodape', $rodape);

  }

  public function listar()
  {
    $this->load->model('clientes_model', 'clientes');
    $post = $this->input->get();

    if (!empty($post)) {
      $page   = $post['start'];
      $limit  = $post['length'];
      $q      = $post['search']['value'];

      $dados = $this->clientes->listar($this->session->userdata('usuario')['codigo_usu'], $limit, $page);
      $total = $this->clientes->contar($this->session->userdata('usuario')['codigo_usu']);

      if (!empty($dados)) {
        $total_registros = $total;
        $retorno_dados = [];
        $contador = 0;
        foreach ($dados as $dt) {
          $contador++;

          $menu = '<div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">Ações </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item item-excluir" data-codigo="' . $dt->codigo_cli . '"> <i class="fa-solid fa-trash-can"></i> Excluir</a>
                    </div>
                  </div>';
          
          $array = array(
            $contador,
            $dt->nome_cli,
            $dt->documento_cli,
            $dt->telefone_cli,
            $dt->endereco_cli,
            $dt->cidade_cli,
            $menu
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