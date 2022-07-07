<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 * Author: Eduardo de Oliveira Bacarin
 * Date: 05/04/2022
 * 
 **/

class Usuario extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // echo json_encode($this->session->userdata());exit;
    if (empty($this->session->userdata('usuario')) || $this->session->userdata('usuario') == false) {
      redirect('login');
    }
    $this->load->helper('funcoes_helper');
    $this->codigo_usu = $this->session->userdata('usuario')['codigo_usu'];
  }

  public function index()
  {
    $this->load->model('usuarios_model');

    $topo['css_link'] = array(
      '//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css'
    );

    $rodape['js'] = array(
      'assets/js/usuario.js' . V,
    );

    $usuario = $this->usuarios_model->buscar($this->session->userdata('usuario')['codigo_usu'])[0];
    $data['nome'] = $usuario->nome_usu;
    $data['documento'] = $usuario->documento_usu;
    $data['email'] = $usuario->email_usu;

    $this->load->view('estrutura/topo', $topo);
    $this->load->view('02_dashboard/alterar_usuario', $data);
    $this->load->view('estrutura/rodape', $rodape);
  }

  public function salvar_usuario()
  {
    $this->load->model('usuarios_model');
    $post = $this->input->post();
    if (!empty($post)) {
      $dados_usu = [
        'nome_usu' => formata_string($post['nome'], 'string'),
        'email_usu' => formata_string($post['email'], 'email'),
        'documento_usu' => formata_string($post['documento'], 'numeric'),
      ];

      if (!empty($post['senha'])){
        $dados_usu['senha_usu'] = hash_hmac('sha256', $post['senha'], KEY);
      }

      $atualizaUsuario = $this->usuarios_model->atualizar($this->session->userdata('usuario')['codigo_usu'], $dados_usu);
      if ($atualizaUsuario){
        echo json_encode(array('retorno' => true, 'msg' => 'Usuário atualizado com sucesso!'));
      }else{
        echo json_encode(array('retorno' => false, 'msg' => 'Erro ao atualizar o usuário, atualize e tente novamente.'));
      }
    } else {
      echo json_encode(array('retorno' => false, 'msg' => 'Erro no envio dos dados, atualize e tente novamente'));
    }
  }
}
