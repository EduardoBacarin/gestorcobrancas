<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Veterinarios_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Usuarios_model extends CI_Model
{

	public function inserir($dados)
	{
		$this->db->insert("usuario", $dados);
		//print_r($this->db->last_query());exit;
		if ($this->db->insert_id() >= 1) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function atualizar($codigo, $dados)
	{
		$this->db->set($dados);

		$this->db->where("codigo_usu", $codigo);

		if ($this->db->update("usuario")) {
			return true;
		} else {
			return false;
		}
	}

	public function listar($codigo_usu)
	{
		$this->db->select("*");
		$this->db->from("usuario");
		$this->db->where("ativo_usu", true);
		$this->db->where("codigo_usu", $codigo_usu);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function buscar($codigo_usu)
	{
		$this->db->select("*");
		$this->db->from("usuario");
		$this->db->where("codigo_usu", $codigo_usu);
		$this->db->where("ativo_usu", true);
		$this->db->limit(1);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function busca_login($email, $senha)
	{
		$this->db->select("*");
		$this->db->from("usuario");
		$this->db->where("email_usu", $email);
		$this->db->where("senha_usu", $senha);
		$this->db->where("ativo_usu", true);
		$this->db->limit(1);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
}
