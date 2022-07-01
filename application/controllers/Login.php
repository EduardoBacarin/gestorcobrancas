<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Author: Eduardo de Oliveira Bacarin
 * Date: 05/04/2022
 * 
 **/

class Login extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // echo json_encode(hash_hmac('sha256', '102030', KEY));exit;
  }

  public function index()
  {
    if (!empty($this->session->userdata('usuario'))) {
      redirect('dashboard');
    } else {
      $this->load->view('01_login/login');
    }
  }

  public function entrar()
  {
    $this->load->model('usuarios_model');
    if (!isset($_SESSION)) {
      session_start();
    }
    $post = $this->input->post();
    $senha = hash_hmac('sha256', $post['senha_user'], KEY);
    $email = $post['email_user'];

    $busca = $this->usuarios_model->busca_login($email, $senha);
    if (!empty($busca)) {
      $sessao = [
        'codigo_usu'      => $busca[0]->codigo_usu,
        'nome_usu'        => $busca[0]->nome_usu,
        'documento_usu'   => $busca[0]->documento_usu,
        'nivel_usu'       => $busca[0]->nivel_usu,
      ];

      $this->session->set_userdata('usuario', $sessao);
      $this->salvar_log($busca[0]->codigo_usu, 'Login do funcionário de ID' . $busca[0]->codigo_usu, 'login');
      echo json_encode(array('retorno' => true, 'redirect' => '/dashboard'));
    } else {
      echo json_encode(array('retorno' => false, 'msg' => 'Usuário ou senha inválidos!'));
    }
  }

  public function registro()
  {
    $this->load->view('01_login/register');
  }

  public function sair()
  {
    $this->session->sess_destroy();
    $this->session->set_userdata('usuario', '');
    redirect('login');
  }



  private function salvar_log($usuario, $acao, $crud, $cobranca = '', $parcela = '')
  {
    $this->load->model('log_model', 'logfunc');
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone('America/Sao_Paulo'));
    $array = [
      'codigo_usu'       => $usuario,
      'codigo_cob'       => $cobranca,
      'codigo_par'       => $parcela,
      'acao_log'         => $acao,
      'crud_log'         => $crud,
      'datacadastro_log' => $date->format('Y-m-d H:i:s'),
    ];
    $log = $this->logfunc->inserir($array);
  }
}
