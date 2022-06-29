<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Author: Eduardo de Oliveira Bacarin
 * Date: 05/04/2022
 * 
 **/

class Cobranca extends CI_Controller
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
    $this->load->model('clientes_model', 'clientes');
    $rodape['js'] = [
      'assets/js/cobranca.js',
      'assets/plugins/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js',
    ];
    $topo['css'] = [
      'assets/plugins/bootstrap-select-1.13.14/dist/css/bootstrap-select.min.css',
    ];
    $data['clientes'] = $this->clientes->listar_todos();
    $this->load->view('estrutura/topo', $topo);
    $this->load->view('04_cobrancas/lista');
    $this->load->view('04_cobrancas/modal_cadastro', $data);
    $this->load->view('04_cobrancas/modal_parcelas');
    $this->load->view('estrutura/rodape', $rodape);
  }

  public function listar()
  {
    $this->load->model('cobrancas_model', 'cobrancas');
    $post = $this->input->get();

    if (!empty($post)) {
      $page   = $post['start'];
      $limit  = $post['length'];
      $q      = $post['search']['value'];
      $mes    = $post['mes_selecionado'];
      $ano    = $post['ano_selecionado'];
      $dados = $this->cobrancas->listar($limit, $page, $mes, $ano);
      $total = $this->cobrancas->contar($mes);

      if (!empty($dados)) {
        $total_registros = $total;
        $retorno_dados = [];
        $contador = 0;
        foreach ($dados as $dt) {

          $contador++;


          $menu = '<div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">Ações </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item item-verparcelas" data-codigo="' . $dt->codigo_cob . '"> <i class="fa-solid fa-magnifying-glass-dollar" style="color: green"></i> Ver Parcelas</a>
                      <a class="dropdown-item item-excluir" data-codigo="' . $dt->codigo_cob . '"> <i class="fa-solid fa-trash-can"></i> Excluir</a>
                    </div>
                  </div>';

          switch ($dt->tipocobranca_cob) {
            case 1:
              $tipo = 'Mensal';
              break;
            case 2:
              $tipo = 'Diário';
              break;
            default:
              $tipo = 'Diário';
              break;
          }

          $array = array(
            $dt->codigo_cob,
            limitaTexto($dt->nome_cli, 40),
            $dt->nome_cid . '/' . $dt->uf_est,
            $dt->qtdparcelas_cob,
            $dt->taxa_cob . '%',
            $tipo,
            'R$' . number_format($dt->totalcomjuros_cob, 2, ',', '.'),
            'R$' . number_format($dt->total_cob, 2, ',', '.'),
            'R$' . number_format($dt->lucro_cob, 2, ',', '.'),
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

  public function listar_parcelas()
  {
    $this->load->model('cobrancas_model', 'cobrancas');
    $post = $this->input->get();

    if (!empty($post)) {

      $page       = $post['start'];
      $limit      = $post['length'];
      $q          = $post['search']['value'];
      $cobranca    = $post['cobranca'];
      $dados = $this->cobrancas->listar_parcelas($limit, $page, $cobranca);
      $total = $this->cobrancas->contar_parcelas($cobranca);

      if (!empty($dados)) {
        $total_registros = $total;
        $retorno_dados = [];
        $contador = 0;
        foreach ($dados as $dt) {
          $contador++;
          $data_vencimento = new DateTime($dt->datavencimento_par, new DateTimeZone('America/Sao_Paulo'));
          $hoje = new DateTime();
          $hoje->setTimezone(new DateTimeZone('America/Sao_Paulo'));

          $status = '';
          $valor_original = 0;

          $valor_parcela_semjuros = $dt->total_cob / $dt->qtdparcelas_cob;
          $status_cod = 0;
          switch ($dt->status_par) {
            case 1:
              if ($data_vencimento->format('Y-m-d') > $hoje->format('Y-m-d')) {
                $status = '<i class="fa-regular fa-clock" style="color: orange"></i> <strong>Aguardando</strong>';
              } else if ($data_vencimento->format('Y-m-d') == $hoje->format('Y-m-d')) {
                $status = '<i class="fa-regular fa-clock" style="color: orange"></i> <strong>Vence Hoje</strong>';
              }else {
                $status = '<i class="fa-solid fa-circle-exclamation" style="color: red"></i> <strong>Atrasado</strong>';
                $status_cod = 1;
                $diffdias = $hoje->diff($data_vencimento)->days;
                if ($diffdias > 0) {
                  if ($dt->tipojuros_cob == 1) {
                    $valorcomjuros = $this->jurosSimples($data_vencimento->format('Y-m-d'), $dt->valor_par, $dt->taxavencimento_cob);
                    $valor_original = $dt->valor_par;
                    $dt->valor_par = $valorcomjuros['valor_final'];
                    $dt->lucro_par = number_format($dt->lucro_par, 2, '.', '') + number_format($valorcomjuros['valor_taxa'], 2, '.', '');
                  } else if ($dt->tipojuros_cob == 2) {
                    $valorcomjuros = $this->jurosComposto($data_vencimento->format('Y-m-d'), $dt->valor_par, $dt->taxavencimento_cob);
                    $valor_original = $dt->valor_par;
                    $dt->valor_par = $valorcomjuros;
                    $dt->lucro_par = number_format($dt->lucro_par, 2, '.', '') + number_format($valorcomjuros['valor_taxa'], 2, '.', '');
                  }
                }
              }
              break;
            case 3:
              $status = '<i class="fa-regular fa-circle-check" style="color: green"></i> <strong>Pago</strong>';
              break;
            case 4:
              $status = '<i class="fa-solid fa-circle-check" style="color: #E6D100"></i> <strong>Pago com Atraso</strong>';
              break;
          }

          $menu = '<div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">Ações </button>
                    <div class="dropdown-menu">';
          if ($status_cod == 1) {
            $menu .= '<a class="dropdown-item item-jurosatraso" data-codigo="' . $dt->codigo_par . '"> <i class="fa-solid fa-trash-can"></i> Calcular Juros de Atraso</a>';
          }

          $menu .= '<a class="dropdown-item item-pago" data-codigo="' . $dt->codigo_par . '" data-limite="' . $data_vencimento->format('Y-m-d') . '" data-lucro="' . $dt->lucro_par . '" data-valor="' . floatval($dt->valor_par) . '" data-valororiginal="' . number_format(floatval($valor_parcela_semjuros), 2, '.', '') . '" style="display: ' . ($dt->status_par == 3 || $dt->status_par == 4 ? 'none;' : '') . '"> <i class="fa-solid fa-money-bill" style="color: green"></i> Marcar Pago</a>
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
            $status,
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

  public function salvar()
  {
    $this->load->model('cobrancas_model', 'cobrancas');
    $post = $this->input->post();
    $date = new DateTime();

    /* PAREI AQUI ------ O VALOR DA PARCELA VEM VAZIO QUANDO SELECIONADO OPÇAO MENSAL E COBRANÇA POR VALOR DE PARCELA */
    if (!empty($post)) {
      if (!empty($post['codigo_cli'])) {
        $valoremprestado = number_format(formata_string($post['total_cob'], 'money'), 2, '.', '');

        if ($post['tipocobranca_cob'] == 2) {
          //DIARIO
          if ($post['tipocalculo_cob'] == 1) {
            //PARCELA INFORMADA
            $valor_parcela = number_format(formata_string($post['valorparcela_cob'], 'money'), 2, '.', '');
            $valorfinal = number_format($valor_parcela * $post['qtdparcelas_cob'], 2, '.', '');
            $taxadejuros = ($valorfinal - $valoremprestado) / ($valoremprestado * 1) * 100;
            $taxadejuros = number_format($taxadejuros, 2, '.', '');
            $tipocalculo = 1;
          } else {
            //JUROS INFORMADO
            $taxadejuros = formata_string($post['taxa_cob'], 'float');
            $valorjuros = number_format($valoremprestado * ($taxadejuros / 100), 2, '.', '');
            $valorfinal = number_format($valoremprestado + $valorjuros, 2, '.', '');
            $valor_parcela = number_format($valorfinal / $post['qtdparcelas_cob'], 2, '.', '');
            $tipocalculo = 2;
          }
        } else {
          //MENSAL
          if ($post['tipocalculo_cob'] == 1) {
            //PARCELA INFORMADA
            $valor_parcela = number_format(formata_string($post['valorparcela_cob'], 'money'), 2, '.', '');
            $valorfinal = number_format($valor_parcela * $post['qtdparcelas_cob'], 2, '.', '');
            $taxadejuros = ($valorfinal - $valoremprestado) / ($valoremprestado * 1) * 100;
            $taxadejuros = number_format($taxadejuros, 2, '.', '');
            $tipocalculo = 1;
            $tipocalculo = 1;
          } else {
            //JUROS INFORMADO
            $taxadejuros = formata_string($post['taxa_cob'], 'float');
            $valorjuros = number_format($valoremprestado * ($taxadejuros / 100), 2, '.', '');
            $valorfinal = number_format($valoremprestado + $valorjuros, 2, '.', '');
            $valor_parcela = number_format($valorfinal / $post['qtdparcelas_cob'], 2, '.', '');
            $tipocalculo = 2;
          }
        }

        $lucro = $valorfinal - $valoremprestado;
        $lucro_parcela = $lucro / $post['qtdparcelas_cob'];
        $array = [
          'codigo_usu'          => $this->session->userdata('usuario')['codigo_usu'],
          'codigo_cli'          => formata_string($post['codigo_cli'], 'numeric'),
          'total_cob'           => number_format(formata_string($post['total_cob'], 'money'), 2, '.', ''),
          'totalcomjuros_cob'   => number_format(formata_string($valorfinal, 'money'), 2, '.', ''),
          'valorparcela_cob'    => $valor_parcela,
          'taxa_cob'            => $taxadejuros,
          'diacobranca_cob'     => formata_string($post['diacobranca_cob'], 'numeric'),
          'dialimite_cob'       => formata_string($post['dialimite_cob'], 'numeric'),
          'tipojuros_cob'       => formata_string($post['tipojuros_cob'], 'numeric'),
          'tipocalculo_cob'     => $tipocalculo,
          'tipocobranca_cob'    => $post['tipocobranca_cob'],
          'taxavencimento_cob'  => formata_string($post['taxavencimento_cob'], 'float'),
          'lucro_cob'           => number_format($lucro, 2, '.', ''),
          'qtdparcelas_cob'     => formata_string($post['qtdparcelas_cob'], 'numeric'),
          'datacadastro_cob'    => $date->format('Y-m-d H:i:s'),
        ];

        if ($lucro > 0 && $lucro_parcela > 0) {
          if ($post['codigo_cob'] == 0) {
            $inserir = $this->cobrancas->inserir($array);
            for ($i = 0; $i < $post['qtdparcelas_cob']; $i++) {
              if ($post['tipocobranca_cob'] == 1) {
                $datapagamento = new DateTime(date("Y-m-" . $post['diacobranca_cob']));
                $datapagamento->modify('+' . $i . ' months');

                $datavencimento = new DateTime(date("Y-m-" . $post['dialimite_cob']));
                $datavencimento->modify('+' . $i . ' months');
              } else {
                $datapagamento = new DateTime(date("Y-m-d"));
                $datapagamento->modify('+' . $i . ' days');

                $datavencimento = new DateTime(date("Y-m-d"));
                $datavencimento->modify('+' . $i . ' days');
              }

              $array_parcela = [
                'codigo_cob'          => $inserir,
                'codigo_cli'          => formata_string($post['codigo_cli'], 'numeric'),
                'valor_par'           => $valor_parcela,
                'datapagamento_par'   => $datapagamento->format('Y-m-d H:i:s'),
                'datavencimento_par'  => $datavencimento->format('Y-m-d H:i:s'),
                'lucro_par'           => number_format($lucro_parcela, 2, '.', ''),
                'parcela_par'         => $i + 1,
                'status_par'          => 1,
                'ativo_par'           => 1,
              ];

              $insereParcela = $this->cobrancas->insere_parcela($array_parcela);
            }

            if ($inserir) {
              echo json_encode(array('return' => true, 'msg' => 'Cobrança cadastrada com sucesso!'));
            } else {
              echo json_encode(array('return' => false, 'msg' => 'Falha ao cadastrar'));
            }
          } else {
            $atualizar = $this->cobrancas->atualizar($post['codigo_cli'], $array);
            if ($atualizar) {
              echo json_encode(array('return' => true, 'msg' => 'Cobrança atualizada com sucesso!'));
            } else {
              echo json_encode(array('return' => false, 'msg' => 'Falha ao atualizar'));
            }
          }
        } else {
          echo json_encode(array('return' => false, 'msg' => 'Lucro negativo!!'));
        }
      } else {
        echo json_encode(array('return' => false, 'msg' => 'Dados obrigatórios do cliente incompletos'));
      }
    } else {
      echo json_encode(array('return' => false, 'msg' => 'Cadastro vazio!'));
    }
  }

  public function inativar()
  {
    $this->load->model('cobrancas_model', 'cobrancas');
    $post = $this->input->post();
    if (!empty($post)) {
      $codigo = $post['codigo'];
      $inativar = $this->cobrancas->inativar($codigo);
      if ($inativar) {
        echo json_encode(array('return' => true, 'msg' => 'Cobrança excluída com sucesso!'));
      } else {
        echo json_encode(array('return' => false, 'msg' => 'Falha ao excluir o cliente!'));
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
        echo json_encode(array('return' => true, 'dados' => $cliente[0]));
      } else {
        echo json_encode(array('return' => false, 'msg' => 'Falha ao excluir o cliente!'));
      }
    }
  }

  public function marcar_pago()
  {
    $this->load->model('cobrancas_model', 'cobrancas');
    $post = $this->input->post();
    $codigo = $post['codigo_par'];
    $valorpago = number_format(formata_string($post['valorpago_par'], 'money'), 2, '.', '');
    $lucro = $valorpago - number_format($post['valororiginal'], 2, '.', '');

    $datalimite = new DateTime($post['datalimite_par'], new DateTimeZone('America/Sao_Paulo'));
    $datapago = new DateTime($post['datapago_par'], new DateTimeZone('America/Sao_Paulo'));
    $hoje = new DateTime();
    $hoje->setTimezone(new DateTimeZone('America/Sao_Paulo'));

    if ($datalimite < $hoje) {
      $pagamento = [
        'status_par' => 4,
        'datapago_par' => $datapago->format('Y-m-d H:i:s'),
        'valorpago_par' => $valorpago,
        'lucrofinal_par' => number_format($lucro, 2, '.', ''),
      ];
      $pago = $this->cobrancas->atualizar_parcela($codigo, $pagamento);
      if ($pago) {
        echo json_encode(array('return' => true, 'msg' => 'Cobrança paga com sucesso'));
      } else {
        echo json_encode(array('return' => false, 'msg' => 'Falha ao marcar pago!'));
      }
    } else {
      $pagamento = [
        'status_par' => 3,
        'datapago_par' => $datapago->format('Y-m-d H:i:s'),
        'valorpago_par' => $valorpago,
        'lucrofinal_par' => number_format($lucro, 2, '.', ''),
      ];
      $pago = $this->cobrancas->atualizar_parcela($codigo, $pagamento);
      if ($pago) {
        echo json_encode(array('return' => true, 'msg' => 'Cobrança paga com sucesso'));
      } else {
        echo json_encode(array('return' => false, 'msg' => 'Falha ao marcar pago!'));
      }
    }
  }

  public function calcula_juros(){
    $post = $this->input->post();
    $this->load->model('cobrancas_model', 'cobrancas');

    if (!empty($post)){
      $busca_parcela = $this->cobrancas->buscar_parcela($post['codigo']);

      if (!empty($busca_parcela)){
        if ($busca_parcela[0]->tipojuros_cob == 1){
          // JUROS SIMPLES
          $calculo_juros = $this->jurosSimples($busca_parcela[0]->datavencimento_par, $busca_parcela[0]->valor_par, $busca_parcela[0]->taxavencimento_cob);
          if (!empty($calculo_juros)){
            $calculo_juros['valor_parcela'] = floatval($busca_parcela[0]->valor_par);
            $calculo_juros['tipo_juros'] = 'Juros Simples';
            echo json_encode(array('return' => true, 'juros' => $calculo_juros));
          }else{
            echo json_encode(array('return' => false, 'msg' => 'Falha nos cálculos dos juros!'));
          }
        }else if($busca_parcela[0]->tipojuros_cob == 2){
          // JUROS COMPOSTO
          $calculo_juros = $this->jurosComposto($busca_parcela[0]->datavencimento_par, $busca_parcela[0]->valor_par, $busca_parcela[0]->taxavencimento_cob);
          if (!empty($calculo_juros)){
            $calculo_juros['valor_parcela'] = floatval($busca_parcela[0]->valor_par);
            $calculo_juros['tipo_juros'] = 'Juros Composto';
            echo json_encode(array('return' => true, 'juros' => $calculo_juros));
          }else{
            echo json_encode(array('return' => false, 'msg' => 'Falha nos cálculos dos juros!'));
          }
        }else{
          echo json_encode(array('return' => false, 'msg' => 'Tipo de juros inválido!'));
        }
      }else{
        echo json_encode(array('return' => false, 'msg' => 'Falha ao buscar dados da parcela!'));
      }
    }else{
      echo json_encode(array('return' => false, 'msg' => 'Falha ao calcular os juros!'));
    }
  }


  private function jurosSimples($data_vencimento, $valorparcela, $taxajuros)
  {
    $hoje          = new DateTime();
    $vencimento    = new DateTime($data_vencimento);
    $qtd_dias      = $hoje->diff($vencimento);
    $qtd_dias      = $qtd_dias->days;
    $taxajuros     = $taxajuros / 100;
    $valorparcela  = number_format($valorparcela, 2, '.', '');

    $valor_taxa = ($valorparcela * $taxajuros) / 30;
    $valor_taxa = $valor_taxa * $qtd_dias;
    $valor_final = $valorparcela + $valor_taxa;

    return array(
      "valor_final"       => $valor_final,
      "valor_taxa"        => $valor_taxa,
      "taxa_cobrada"      => $taxajuros,
      "dias_atrasados"    => $qtd_dias,
    );
  }

  private function jurosComposto($data_vencimento, $investment, $rate)
  {
    $hoje          = new DateTime();
    $vencimento    = new DateTime($data_vencimento);
    $qtd_dias      = $hoje->diff($vencimento);
    $diffdias      = $qtd_dias->days;
    // echo json_encode($diffdias);exit;

    $valor_corrido = $investment;
    for ($i = 0; $i < $diffdias; $i++) {
      $juros_dia = $valor_corrido * ($rate / 100);
      $valor_corrido = $valor_corrido + $juros_dia;
    }
    $diferenca = $valor_corrido - $investment;

    return array(
      "valor_final"       => $valor_corrido,
      "taxa_cobrada"      => floatval($rate)/100,
      "valor_taxa"        => $diferenca,
      "dias_atrasados"    => $diffdias,
    );
  }
}
