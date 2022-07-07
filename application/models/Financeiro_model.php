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

class Financeiro_model extends CI_Model
{

	public function inserir($dados)
	{
		$this->db->insert("financeiro", $dados);
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

		$this->db->where("codigo_fin", $codigo);

		if ($this->db->update("financeiro")) {
			return true;
		} else {
			return false;
		}
	}

	public function inativar($codigo)
	{
		$this->db->set('ativo_fin', false);

		$this->db->where("codigo_fin", $codigo);

		if ($this->db->update("financeiro")) {
			return true;
		} else {
			return false;
		}
	}

	public function listar_despesas($limit, $offset, $mes, $ano)
	{
		$this->db->select("*");
		$this->db->from("financeiro");
		$this->db->join("usuario", "usuario.codigo_usu = financeiro.codigo_usu", 'left');
		$this->db->where("ativo_fin", true);
		$this->db->where("tipo_fin", 1);
		$this->db->where("MONTH(financeiro.data_fin)", $mes);
		$this->db->where("YEAR(financeiro.data_fin)", $ano);
		$this->db->order_by('financeiro.data_fin', 'ASC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}


	public function listar_categorias()
	{
		$this->db->select("*");
		$this->db->from("financeiro_categoria");
		$this->db->where("ativo_catfin", true);
		$this->db->order_by('nome_catfin', 'ASC');
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function despesas_categoria()
	{
		$this->db->select_sum('financeiro.valor_fin');
		$this->db->select("financeiro_categoria.nome_catfin");
		$this->db->from("financeiro");
		$this->db->join("financeiro_categoria", "financeiro_categoria.codigo_catfin = financeiro.codigo_catfin");
		$this->db->where("financeiro.ativo_fin", true);
		$this->db->where("MONTH(financeiro.data_fin)", date('m'));
		$this->db->where("financeiro.tipo_fin", 1);
		$this->db->group_by('financeiro.codigo_catfin');
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function resumo_financeiro($mes, $ano)
	{
		$this->db->select_sum('financeiro.valor_fin');
		$this->db->select('financeiro.tipo_fin');
		$this->db->from("financeiro");
		$this->db->where("financeiro.ativo_fin", true);
		$this->db->where("MONTH(financeiro.data_fin)", $mes);
		$this->db->where("YEAR(financeiro.data_fin)", $ano);
		$this->db->group_by('financeiro.tipo_fin');
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}


	public function despesas_funcionario()
	{
		$this->db->select_sum('financeiro.valor_fin');
		$this->db->select("usuario.nome_usu");
		$this->db->from("financeiro");
		$this->db->join("usuario", "usuario.codigo_usu = financeiro.codigo_usu");
		$this->db->where("financeiro.ativo_fin", true);
		$this->db->where("MONTH(financeiro.data_fin)", date('m'));
		$this->db->where("financeiro.tipo_fin", 1);
		$this->db->where("financeiro.codigo_usu !=", 0);
		$this->db->group_by('financeiro.codigo_usu');
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}


	public function listar_receitas($limit, $offset, $mes, $ano)
	{
		$this->db->select("*");
		$this->db->from("financeiro");
		$this->db->join("usuario", "usuario.codigo_usu = financeiro.codigo_usu", 'left');
		$this->db->where("ativo_fin", true);
		$this->db->where("tipo_fin", 2);
		$this->db->where("MONTH(financeiro.data_fin)", $mes);
		$this->db->where("YEAR(financeiro.data_fin)", $ano);
		$this->db->order_by('financeiro.data_fin', 'ASC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function contar_despesas()
	{
		$this->db->select("COUNT(codigo_cli)");
		$this->db->from("financeiro");
		$this->db->join("usuario", "usuario.codigo_usu = financeiro.codigo_usu", 'left');
		$this->db->where("tipo_fin", 1);
		$this->db->where("ativo_fin", true);
		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}

	public function contar_receitas()
	{
		$this->db->select("COUNT(codigo_cli)");
		$this->db->from("financeiro");
		$this->db->join("usuario", "usuario.codigo_usu = financeiro.codigo_usu", 'left');
		$this->db->where("tipo_fin", 2);
		$this->db->where("ativo_fin", true);
		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}


	public function buscar($codigo_fin)
	{
		$this->db->select("*");
		$this->db->from("financeiro");
		$this->db->where("codigo_fin", $codigo_fin);
		$this->db->where("ativo_fin", true);
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
