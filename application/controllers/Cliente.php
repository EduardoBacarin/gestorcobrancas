<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Author: Eduardo de Oliveira Bacarin
 * Date: 05/04/2022
 * 
 **/

class Cliente extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // echo json_encode($this->session->userdata());exit;
    if (empty($this->session->userdata('usuario')) || $this->session->userdata('usuario') == false) {
      redirect('login');
    }
  }

  public function index()
  {

    $rodape['js'] = ['assets/js/cliente.js' . V];
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

      $dados = $this->clientes->listar($limit, $page, $q);
      $total = $this->clientes->contar($q);

      if (!empty($dados)) {
        $total_registros = $total;
        $retorno_dados = [];
        $contador = 0;
        foreach ($dados as $dt) {
          $contador++;

          $menu = '<div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">Ações </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item item-editar" data-codigo="' . $dt->codigo_cli . '" data-nome="' . $dt->nome_cli . '"> <i class="fa-solid fa-pen"></i> Editar</a> ' . 
                      ($this->session->userdata('usuario')['nivel_usu'] == 1 ? '<a class="dropdown-item item-excluir" data-codigo="' . $dt->codigo_cli . '" data-nome="' . $dt->nome_cli . '"> <i class="fa-solid fa-trash-can"></i> Excluir</a>' : '') .
                    '</div>
                  </div>';
          $tipodoc = '';
          $array = array(
            $contador,
            limitaTexto($dt->nome_cli, 40),
            mask($dt->documento_cli, 'documento'),
            mask($dt->telefone_cli, 'telefone'),
            !empty($dt->endereco_cli) ? $dt->endereco_cli : '<span class="badge badge-pill badge-danger">Sem Informação</span>',
            !empty($dt->nome_cid) ? $dt->nome_cid . ' / ' . $dt->uf_est  : '<span class="badge badge-pill badge-danger">Sem Informação</span>',
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
    $this->load->model('clientes_model', 'cliente');
    $this->load->model('cidade_model', 'cidade');
    $post = $this->input->post();
    $date = new DateTime();
    if (!empty($post)) {
      if (!empty($post['nome_cli']) && !empty($post['documento_cli']) && !empty($post['telefone_cli'])) {
        $array = [
          'nome_cli' => formata_string($post['nome_cli'], 'string'),
          'documento_cli' => formata_string($post['documento_cli'], 'numeric'),
          'telefone_cli' => formata_string($post['telefone_cli'], 'numeric'),
          'codigo_usu' => $this->session->userdata('usuario')['codigo_usu'],
          'datacadastro_cli' => $date->format('Y-m-d H:i:s')
        ];

        if (!empty($post['cidade_cli'])) {
          $buscaCidade = $this->cidade->busca_cidade_nome($post['cidade_cli'], $post['estado_cli']);
          if ($buscaCidade) {
            $array['cep_cli'] = formata_string($post['cep_cli'], 'numeric');
            $array['endereco_cli'] = formata_string($post['endereco_cli'], 'string');
            $array['bairro_cli'] = formata_string($post['bairro_cli'], 'string');
            $array['numero_cli'] = formata_string($post['numero_cli'], 'numeric');
            $array['complemento_cli'] = $post['complemento_cli'];
            $array['codigo_cid'] = $buscaCidade[0]->codigo_cid;
          } else {
            echo json_encode(array('retorno' => false, 'msg' => 'Não foi possível encontrar a cidade em nosso banco de dados</br>Contate o administrador'));
          }
        }

        if ($post['codigo_cli'] == 0) {
          $inserir = $this->cliente->inserir($array);
          if ($inserir) {
            $this->salvar_log('Inserção do cliente de ID' . $inserir, 'create');
            echo json_encode(array('retorno' => true, 'msg' => 'Cliente cadastrado com sucesso!'));
          } else {
            echo json_encode(array('retorno' => false, 'msg' => 'Falha ao cadastrar'));
          }
        } else {
          $atualizar = $this->cliente->atualizar($post['codigo_cli'], $array);
          if ($atualizar) {
            $this->salvar_log('Atualização do cliente de ID' . $post['codigo_cli'], 'update');
            echo json_encode(array('retorno' => true, 'msg' => 'Cliente atualizado com sucesso!'));
          } else {
            echo json_encode(array('retorno' => false, 'msg' => 'Falha ao atualizar'));
          }
        }
      } else {
        echo json_encode(array('retorno' => false, 'msg' => 'Dados obrigatórios do cliente incompletos'));
      }
    } else {
      echo json_encode(array('retorno' => false, 'msg' => 'Cadastro vazio!'));
    }
  }

  public function inativar()
  {
    $this->load->model('clientes_model', 'cliente');
    $post = $this->input->post();
    if (!empty($post)) {
      $codigo = $post['codigo'];
      $inativar = $this->cliente->inativar($codigo);
      if ($inativar) {
        $this->salvar_log('Inativação do cliente de ID' . $codigo, 'delete');
        echo json_encode(array('retorno' => true, 'msg' => 'Cliente excluído com sucesso!'));
      } else {
        echo json_encode(array('retorno' => false, 'msg' => 'Falha ao excluir o cliente!'));
      }
    }
  }

  public function buscar()
  {
    $this->load->model('clientes_model', 'cliente');
    $post = $this->input->post();
    if (!empty($post)) {
      $codigo = $post['codigo'];
      $cliente = $this->cliente->buscar($codigo);
      if ($cliente) {
        echo json_encode(array('retorno' => true, 'dados' => $cliente[0]));
      } else {
        echo json_encode(array('retorno' => false, 'msg' => 'Falha ao excluir o cliente!'));
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
