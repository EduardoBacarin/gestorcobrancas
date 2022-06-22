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

class Cobrancas_model extends CI_Model
{

	public function inserir($dados)
	{
		$this->db->insert("cobrancas", $dados);
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

		$this->db->where("codigo_cob", $codigo);

		if ($this->db->update("cobrancas")) {
			return true;
		} else {
			return false;
		}
	}

	public function inativar($codigo)
	{
		$this->db->set('ativo_cob', false);

		$this->db->where("codigo_cob", $codigo);

		if ($this->db->update("cobrancas")) {
			return true;
		} else {
			return false;
		}
	}

	public function listar($codigo_usu)
	{
		$this->db->select("*");
		$this->db->from("cobranca");
		$this->db->join("cliente", "cliente.codigo_cli = cobranca.codigo_cli", 'inner');
		$this->db->join("parcelas_cobranca", "parcelas_cobranca.codigo_cob = cobranca.codigo_cob", 'inner');
		$this->db->where("cobranca.ativo_cob", true);
		$this->db->where("cobranca.codigo_usu", $codigo_usu);
		$query = $this->db->get();

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function contar($codigo_usu)
	{
		$this->db->select("COUNT(codigo_cob)");
		$this->db->from("cobranca");
		$this->db->where("cobranca.codigo_usu", $codigo_usu);
		$this->db->where("cobranca.ativo_cob", true);
		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}

	public function buscar($codigo_cob)
	{
		$this->db->select("*");
		$this->db->from("cobranca");
		$this->db->join("parcelas_cobranca", "parcelas_cobranca.codigo_cob = cobranca.codigo_cob", 'inner');
		$this->db->where("codigo_cob", $codigo_cob);
		$this->db->where("ativo_cob", true);
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
