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

class Funcionarios_model extends CI_Model
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

	public function inativar($codigo)
	{
		$this->db->set('ativo_usu', false);

		$this->db->where("codigo_usu", $codigo);

		if ($this->db->update("usuario")) {
			return true;
		} else {
			return false;
		}
	}

	public function listar($limit, $offset, $busca)
	{
		$this->db->select("*");
		$this->db->from("usuario");
		$this->db->where("ativo_usu", true);
		$this->db->where("nivel_usu", 2);
		if (!empty($busca)) {
			$this->db->group_start();
				$this->db->like("usuario.nome_usu", $busca);
				$this->db->or_like("usuario.telefone_usu", $busca);
				$this->db->or_like("usuario.documento_usu", $busca);
				$this->db->or_like("usuario.email_usu", $busca);
			$this->db->group_end();
		}
		$this->db->order_by('usuario.codigo_usu', 'ASC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function contar($busca)
	{
		$this->db->select("*");
		$this->db->from("usuario");
		$this->db->where("ativo_usu", true);
		$this->db->where("nivel_usu", 2);
		if (!empty($busca)) {
			$this->db->group_start();
				$this->db->like("usuario.nome_usu", $busca);
				$this->db->or_like("usuario.telefone_usu", $busca);
				$this->db->or_like("usuario.documento_usu", $busca);
				$this->db->or_like("usuario.email_usu", $busca);
			$this->db->group_end();
		}
		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}

	public function buscar($codigo_usu)
	{
		$this->db->select("*");
		$this->db->from("usuario");
		$this->db->where("codigo_usu", $codigo_usu);
		$this->db->where("ativo_usu", true);
		$this->db->where("nivel_usu", 2);
		$this->db->limit(1);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function listar_todos()
	{
		$this->db->select("*");
		$this->db->from("usuario");
		$this->db->where("ativo_usu", true);
		$this->db->where("nivel_usu", 2);
		$this->db->order_by('usuario.codigo_usu', 'ASC');
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}
}
