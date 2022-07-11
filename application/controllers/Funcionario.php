<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Author: Eduardo de Oliveira Bacarin
 * Date: 05/04/2022
 * 
 **/

class Funcionario extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // echo json_encode($this->session->userdata());exit;
    if (empty($this->session->userdata('usuario')) || $this->session->userdata('usuario') == false) {
      redirect('login');
    } else if ($this->session->userdata('usuario')['nivel_usu'] == 2) {
      redirect('dashboard');
    }
  }

  public function index()
  {

    $rodape['js'] = ['assets/js/funcionario.js' . V];
    $this->load->view('estrutura/topo');
    $this->load->view('05_funcionarios/lista');
    $this->load->view('05_funcionarios/modal_cadastro');
    $this->load->view('estrutura/rodape', $rodape);
  }

  public function listar()
  {
    $this->load->model('funcionarios_model', 'funcionarios');
    $post = $this->input->get();

    if (!empty($post)) {
      $page   = $post['start'];
      $limit  = $post['length'];
      $q      = $post['search']['value'];

      $dados = $this->funcionarios->listar($limit, $page, $q);
      $total = $this->funcionarios->contar($q);
      if (!empty($dados)) {
        $total_registros = $total;
        $retorno_dados = [];
        $contador = 0;
        foreach ($dados as $dt) {
          $contador++;

          $menu = '<div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">Ações </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item item-editar" data-codigo="' . $dt->codigo_usu . '" data-nome="' . $dt->nome_usu . '"> <i class="fa-solid fa-pen"></i> Editar</a>
                      <a class="dropdown-item item-excluir" data-codigo="' . $dt->codigo_usu . '" data-nome="' . $dt->nome_usu . '"> <i class="fa-solid fa-trash-can"></i> Excluir</a>
                    </div>
                  </div>';
          $tipodoc = '';
          $array = array(
            $contador,
            $dt->nome_usu,
            $dt->documento_usu,
            $dt->email_usu,
            !empty($dt->telefone_usu) ? mask($dt->telefone_usu, 'telefone') : '<span class="badge badge-pill badge-danger">Sem Informação</span>',
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

  public function salvar()
  {
    $this->load->model('funcionarios_model', 'funcionarios');
    $post = $this->input->post();
    $date = new DateTime();
    if (!empty($post)) {
      if (!empty($post['nome_func']) && !empty($post['documento_func']) && !empty($post['senha_func'])) {
        $senha = hash_hmac('sha256', $post['senha_func'], KEY);
        $array = [
          'nome_usu'                => formata_string($post['nome_func'], 'string'),
          'email_usu'               => formata_string($post['email_func'], 'email'),
          'documento_usu'           => $post['documento_func'],
          'telefone_usu'            => formata_string($post['telefone_func'], 'numeric'),
          'nivel_usu'               => 2,
          'ativo_usu'               => 1,
          'senha_usu'               => $senha,
          'senhadescriptograda_usu' => $post['senha_func']
        ];
        if ($post['codigo_usu'] == 0) {
          $inserir = $this->funcionarios->inserir($array);
          if ($inserir) {
            $this->salvar_log('Inserindo o funcionário de ID ' . $inserir, 'create');
            echo json_encode(array('retorno' => true, 'msg' => 'Funcionário cadastrado com sucesso!'));
          } else {
            echo json_encode(array('retorno' => false, 'msg' => 'Falha ao cadastrar'));
          }
        } else {
          $atualizar = $this->funcionarios->atualizar($post['codigo_usu'], $array);
          if ($atualizar) {
            $this->salvar_log('Atualizando o funcionário de ID ' . $post['codigo_usu'], 'update');
            echo json_encode(array('retorno' => true, 'msg' => 'Funcionário atualizado com sucesso!'));
          } else {
            echo json_encode(array('retorno' => false, 'msg' => 'Falha ao atualizar'));
          }
        }
      } else {
        echo json_encode(array('retorno' => false, 'msg' => 'Dados obrigatórios do funcionário incompletos'));
      }
    } else {
      echo json_encode(array('retorno' => false, 'msg' => 'Cadastro vazio!'));
    }
  }

  public function inativar()
  {
    $this->load->model('funcionarios_model', 'funcionarios');
    $post = $this->input->post();
    if (!empty($post)) {
      $codigo = $post['codigo'];
      $inativar = $this->funcionarios->inativar($codigo);
      if ($inativar) {
        $this->salvar_log('Inativando o funcionário de ID ' . $post['codigo'], 'delete');
        echo json_encode(array('retorno' => true, 'msg' => 'Funcionário excluído com sucesso!'));
      } else {
        echo json_encode(array('retorno' => false, 'msg' => 'Falha ao excluir o funcionário!'));
      }
    }
  }

  public function buscar()
  {
    $this->load->model('funcionarios_model', 'funcionarios');
    $post = $this->input->post();
    if (!empty($post)) {
      if (!empty($post['codigo'])) {
        $codigo = $post['codigo'];
        $funcionario = $this->funcionarios->buscar($codigo);
        if ($funcionario) {
          echo json_encode(array('retorno' => true, 'dados' => $funcionario[0]));
        } else {
          echo json_encode(array('retorno' => false, 'msg' => 'Falha ao buscar o funcionário!'));
        }
      } else {
        echo json_encode(array('retorno' => false, 'msg' => 'Falha ao buscar o funcionário!'));
      }
    }
  }

  private function salvar_log($acao, $crud, $cobranca = '', $parcela = '')
  {
    $this->load->model('log_model', 'logfunc');
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone('America/Sao_Paulo'));
    $array = [
      'codigo_usu'       => $this->session->userdata('usuario')['codigo_usu'],
      'codigo_cob'       => $cobranca,
      'codigo_par'       => $parcela,
      'acao_log'         => $acao,
      'crud_log'         => $crud,
      'datacadastro_log' => $date->format('Y-m-d H:i:s'),
    ];
    $log = $this->logfunc->inserir($array);
  }
}
