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

	public function insere_parcela($dados)
	{
		$this->db->insert("parcelas_cobranca", $dados);
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

	public function atualizar_parcela($codigo, $dados)
	{
		$this->db->set($dados);

		$this->db->where("codigo_par", $codigo);

		if ($this->db->update("parcelas_cobranca")) {
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

	public function listar($limit, $offset, $mes, $ano, $busca = '')
	{
		$this->db->select("*");
		$this->db->from("cobrancas");
		$this->db->join("cliente", "cliente.codigo_cli = cobrancas.codigo_cli", 'left');
		$this->db->where("cobrancas.ativo_cob", true);
		$this->db->where("MONTH(cobrancas.datacadastro_cob)", $mes);
		$this->db->where("YEAR(cobrancas.datacadastro_cob)", $ano);
		if (!empty($busca)) {
			$this->db->like("cliente.nome_cli", $busca);
			$this->db->or_like("cliente.telefone_cli", $busca);
			$this->db->or_like("cliente.documento_cli", $busca);
			$this->db->or_like("cobrancas.total_cob", $busca);
		}
		$this->db->order_by('cobrancas.datacadastro_cob', 'ASC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function listar_parcelas($limit, $offset, $cobranca)
	{
		$this->db->select("*");
		$this->db->from("parcelas_cobranca");
		$this->db->join("cobrancas", "cobrancas.codigo_cob = parcelas_cobranca.codigo_cob", 'inner');
		$this->db->join("cliente", "cliente.codigo_cli = cobrancas.codigo_cli", 'inner');
		$this->db->join("cidades", "cidades.codigo_cid = cliente.codigo_cid", 'inner');
		$this->db->join("estados", "estados.codigo_est = cidades.codigo_est", 'inner');
		$this->db->where("cobrancas.ativo_cob", true);
		$this->db->where("parcelas_cobranca.codigo_cob", $cobranca);
		$this->db->limit($limit, $offset);
		$query = $this->db->get();

		if ($query->num_rows() >= 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function contar_parcelas($cobranca)
	{
		$this->db->select("COUNT(codigo_cob)");
		$this->db->from("parcelas_cobranca");
		$this->db->where("parcelas_cobranca.ativo_par", true);
		$this->db->where("parcelas_cobranca.codigo_cob", $cobranca);
		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}

	public function contar($busca = '', $mes, $ano)
	{
		$this->db->select("COUNT(codigo_cob)");
		$this->db->from("cobrancas");
		$this->db->join("cliente", "cliente.codigo_cli = cobrancas.codigo_cli", 'left');
		$this->db->where("cobrancas.ativo_cob", true);
		$this->db->where("MONTH(cobrancas.datacadastro_cob)", $mes);
		$this->db->where("YEAR(cobrancas.datacadastro_cob)", $ano);
		if (!empty($busca)) {
			$this->db->like("cliente.nome_cli", $busca);
			$this->db->or_like("cliente.telefone_cli", $busca);
			$this->db->or_like("cliente.documento_cli", $busca);
			$this->db->or_like("cobrancas.total_cob", $busca);
		}
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
		$this->db->from("cobrancas");
		$this->db->join("parcelas_cobranca", "parcelas_cobranca.codigo_cob = cobrancas.codigo_cob", 'inner');
		$this->db->where("cobrancas.codigo_cob", $codigo_cob);
		$this->db->where("cobrancas.ativo_cob", true);
		$this->db->limit(1);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function buscar_parcela($codigo_par)
	{
		$this->db->select("*");
		$this->db->from("parcelas_cobranca");
		$this->db->join("cobrancas", "parcelas_cobranca.codigo_cob = cobrancas.codigo_cob", 'inner');
		$this->db->where("parcelas_cobranca.codigo_par", $codigo_par);
		$this->db->where("parcelas_cobranca.ativo_par", true);
		$this->db->limit(1);
		$query = $this->db->get();

		// print_r($this->db->last_query());exit;

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function calcula_restante($codigo_cob)
	{
		$this->db->select("COUNT(*) as parcelas_restante, SUM(valor_par) as total_restante");
		$this->db->from("parcelas_cobranca");
		$this->db->where("parcelas_cobranca.codigo_cob", $codigo_cob);
		$this->db->where("parcelas_cobranca.status_par <=", 2);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	public function calcula_pago($codigo_cob)
	{
		$this->db->select("COUNT(*) as parcelas_paga, SUM(valorpago_par) as total_pago");
		$this->db->from("parcelas_cobranca");
		$this->db->where("parcelas_cobranca.status_par >=", 3);
		$this->db->where("parcelas_cobranca.codigo_cob", $codigo_cob);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
