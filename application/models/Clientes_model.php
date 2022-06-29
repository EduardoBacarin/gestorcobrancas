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

class Clientes_model extends CI_Model
{

	public function inserir($dados)
	{
		$this->db->insert("cliente", $dados);
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

		$this->db->where("codigo_cli", $codigo);

		if ($this->db->update("cliente")) {
			return true;
		} else {
			return false;
		}
	}

	public function inativar($codigo)
	{
		$this->db->set('ativo_cli', false);

		$this->db->where("codigo_cli", $codigo);

		if ($this->db->update("cliente")) {
			return true;
		} else {
			return false;
		}
	}

	public function listar($limit, $offset)
	{
		$this->db->select("*");
		$this->db->from("cliente");
		$this->db->join("cidades", "cidades.codigo_cid = cliente.codigo_cid", 'left');
		$this->db->join("estados", "estados.codigo_est = cidades.codigo_est", 'left');
		$this->db->where("ativo_cli", true);
        $this->db->limit($limit, $offset);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function contar()
	{
		$this->db->select("COUNT(codigo_cli)");
		$this->db->from("cliente");
		$this->db->where("cliente.ativo_cli", true);
		$this->db->order_by("cliente.nome", "ASC");
		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}

	public function listar_todos()
	{
		$this->db->select("*");
		$this->db->from("cliente");
		$this->db->join("cidades", "cidades.codigo_cid = cliente.codigo_cid", 'left');
		$this->db->join("estados", "estados.codigo_est = cidades.codigo_est", 'left');
		$this->db->where("ativo_cli", true);
		$query = $this->db->get();

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function buscar($codigo_cli)
	{
		$this->db->select("*");
		$this->db->from("cliente");
		$this->db->join("cidades", "cidades.codigo_cid = cliente.codigo_cid", 'left');
		$this->db->join("estados", "estados.codigo_est = cidades.codigo_est", 'left');
		$this->db->where("codigo_cli", $codigo_cli);
		$this->db->where("ativo_cli", true);
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
