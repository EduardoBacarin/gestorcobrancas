<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Author: Eduardo de Oliveira Bacarin
 * Date: 05/04/2022
 * 
 **/

class Financeiro extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (empty($this->session->userdata('usuario')) || $this->session->userdata('usuario') == false) {
      redirect('login');
    }else if($this->session->userdata('usuario')['nivel_usu'] != 1){
      redirect('login');
    }
  }

  public function index()
  {
    $this->load->model('funcionarios_model', 'funcionarios');
    $this->load->model('financeiro_model', 'financeiro');

    $rodape['js'] = [
      'assets/plugins/apexcharts-bundle/dist/apexcharts.min.js',
      'assets/js/financeiro.js' . V,
    ];

    $rodape['css'] = [
      'assets/plugins/apexcharts-bundle/dist/apexcharts.css'
    ];

    $data['funcionarios'] = $this->funcionarios->listar_todos();
    $data['categoria_financeiro'] = $this->financeiro->listar_categorias();

    $this->load->view('estrutura/topo');
    $this->load->view('06_financeiro/lista');
    $this->load->view('06_financeiro/modal_cadastro', $data);
    $this->load->view('estrutura/rodape', $rodape);
  }

  public function listar_despesas()
  {
    $this->load->model('financeiro_model', 'financeiro');
    $post = $this->input->get();

    if (!empty($post)) {
      $page   = $post['start'];
      $limit  = $post['length'];
      $q      = $post['search']['value'];
      $mes    = $post['mes_selecionado'];
      $ano    = $post['ano_selecionado'];

      $dados = $this->financeiro->listar_despesas($limit, $page, $mes, $ano);
      $total = $this->financeiro->contar_despesas($mes, $ano);

      if (!empty($dados)) {
        $total_registros = $total;
        $retorno_dados = [];
        $contador = 0;
        foreach ($dados as $dt) {
          $contador++;

          $menu = '<div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">Ações </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item item-editar" data-codigo="' . $dt->codigo_fin . '" data-nome="' . $dt->nome_fin . '"> <i class="fa-solid fa-pen"></i> Editar</a>
                      <a class="dropdown-item item-excluir" data-codigo="' . $dt->codigo_fin . '" data-nome="' . $dt->nome_fin . '"> <i class="fa-solid fa-trash-can"></i> Excluir</a>
                    </div>
                  </div>';
          $tipodoc = '';
          $array = array(
            $contador,
            date('d/m/Y', strtotime($dt->data_fin)),
            !empty($dt->nome_usu) ? $dt->nome_usu : '-',
            $dt->nome_fin,
            !empty($dt->descricao_fin) ? $dt->descricao_fin : '-',
            'R$ ' . number_format($dt->valor_fin, 2, ',', '.'),
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

  public function listar_receitas()
  {
    $this->load->model('financeiro_model', 'financeiro');
    $post = $this->input->get();

    if (!empty($post)) {
      $page   = $post['start'];
      $limit  = $post['length'];
      $q      = $post['search']['value'];
      $mes    = $post['mes_selecionado'];
      $ano    = $post['ano_selecionado'];

      $dados = $this->financeiro->listar_receitas($limit, $page, $mes, $ano);
      $total = $this->financeiro->contar_receitas($mes, $ano);

      if (!empty($dados)) {
        $total_registros = $total;
        $retorno_dados = [];
        $contador = 0;
        foreach ($dados as $dt) {
          $contador++;

          $menu = '<div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">Ações </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item item-editar" data-codigo="' . $dt->codigo_fin . '" data-nome="' . $dt->nome_fin . '"> <i class="fa-solid fa-pen"></i> Editar</a>
                      <a class="dropdown-item item-excluir" data-codigo="' . $dt->codigo_fin . '" data-nome="' . $dt->nome_fin . '"> <i class="fa-solid fa-trash-can"></i> Excluir</a>
                    </div>
                  </div>';
          $tipodoc = '';
          $array = array(
            $contador,
            date('d/m/Y', strtotime($dt->data_fin)),
            !empty($dt->nome_usu) ? $dt->nome_usu : '-',
            $dt->nome_fin,
            !empty($dt->descricao_fin) ? $dt->descricao_fin : '-',
            'R$ ' . number_format($dt->valor_fin, 2, ',', '.'),
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
    $this->load->model('financeiro_model', 'financeiro');
    $post = $this->input->post();
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone('America/Sao_Paulo'));

    if (!empty($post)) {
      if (!empty($post['data_fin']) && !empty($post['nome_fin']) && !empty($post['valor_fin'])) {

        $array = [
          'tipo_fin' => $post['tipo_fin'],
          'codigo_usu' => $post['codigo_usu'],
          'codigo_catfin' => $post['codigo_catfin'],
          'data_fin' => $post['data_fin'],
          'nome_fin' => formata_string($post['nome_fin'], 'string'),
          'valor_fin' => floatval(formata_string($post['valor_fin'], 'money')),
          'descricao_fin' => $post['descricao_fin'],
          'datacadastro_cli' => $date->format('Y-m-d H:i:s')
        ];

        if ($post['codigo_fin'] == 0) {
          $inserir = $this->financeiro->inserir($array);
          if ($inserir) {
            $this->salvar_log('Inserção de transacão de ID' . $inserir, 'create');
            echo json_encode(array('retorno' => true, 'msg' => 'Cliente cadastrado com sucesso!'));
          } else {
            echo json_encode(array('retorno' => false, 'msg' => 'Falha ao cadastrar'));
          }
        } else {
          $atualizar = $this->financeiro->atualizar($post['codigo_fin'], $array);
          if ($atualizar) {
            $this->salvar_log('Atualização de transação de ID' . $post['codigo_fin'], 'update');
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
    $this->load->model('financeiro_model', 'financeiro');
    $post = $this->input->post();
    if (!empty($post)) {
      $codigo = $post['codigo'];
      $financeiro = $this->financeiro->buscar($codigo);
      if ($financeiro) {
        echo json_encode(array('retorno' => true, 'dados' => $financeiro[0]));
      } else {
        echo json_encode(array('retorno' => false, 'msg' => 'Falha ao excluir o cliente!'));
      }
    }
  }

  public function grafico_despesas_categoria(){
    $this->load->model('financeiro_model', 'financeiro');
    $dados = $this->financeiro->despesas_categoria();
    if (!empty($dados)){
      $categoria = [];
      $soma = [];
      foreach ($dados as $item){
        array_push($categoria, $item->nome_catfin);
        array_push($soma, floatval($item->valor_fin));
      }

      echo json_encode(array('retorno' => true, 'soma' => $soma, 'categoria' => $categoria));
    }
  }

  public function grafico_despesas_funcionario(){
    $this->load->model('financeiro_model', 'financeiro');
    $dados = $this->financeiro->despesas_funcionario();
    if (!empty($dados)){
      $funcionario = [];
      $soma = [];
      foreach ($dados as $item){
        array_push($funcionario, $item->nome_usu);
        array_push($soma, floatval($item->valor_fin));
      }

      echo json_encode(array('retorno' => true, 'soma' => $soma, 'funcionario' => $funcionario));
    }
  }

  public function calcula_resumo(){
    $this->load->model('financeiro_model', 'financeiro');
    $post = $this->input->post();
    $dados = $this->financeiro->resumo_financeiro($post['mes'], $post['ano']);
    if (!empty($dados)){
      $calculo['despesa'] = 0;
      $calculo['receita'] = 0;
      foreach ($dados as $item){
        if ($item->tipo_fin == 1){
          $calculo['despesa'] = $item->valor_fin;
        }else{
          $calculo['receita'] = $item->valor_fin;
        }
      }
      echo json_encode(array('retorno' => true, 'despesa' => $calculo['despesa'], 'receita' => $calculo['receita']));
    }else{
      echo json_encode(array('retorno' => false));
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
