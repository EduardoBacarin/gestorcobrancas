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

class Dashboard_model extends CI_Model
{

	public function total_cobrancas()
	{
		$this->db->select("COUNT(codigo_cob)");
		$this->db->from("cobrancas");
		$this->db->where("cobrancas.ativo_cob", true);
		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}

	public function total_cobrancas_mes()
	{
		$this->db->select("COUNT(codigo_cob)");
		$this->db->from("cobrancas");
		$this->db->where("cobrancas.ativo_cob", true);
		$this->db->where("MONTH(cobrancas.datacadastro_cob)", date('m'));
		$this->db->where("YEAR(cobrancas.datacadastro_cob)", date('Y'));
		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}

	public function lucro_pagos()
	{
		$this->db->select_sum('lucro_par');
		$this->db->from("parcelas_cobranca");
		$this->db->where("parcelas_cobranca.ativo_par", true);
		$this->db->where("parcelas_cobranca.status_par", 3);
		$this->db->or_where("parcelas_cobranca.status_par", 4);
		$query = $this->db->get();

		if ($this->db->count_all_results() >= 1) {
			return $query->result();
		} else {
			return 0;
		}
	}

	public function lucro_pagos_mes()
	{
		$this->db->select_sum('lucro_par');
		$this->db->from("parcelas_cobranca");
		$this->db->where("parcelas_cobranca.ativo_par", true);
		$this->db->where("MONTH(parcelas_cobranca.datapago_par)", date('m'));
		$this->db->where("YEAR(parcelas_cobranca.datapago_par)", date('Y'));
		$this->db->where("parcelas_cobranca.status_par", 3);
		$this->db->or_where("parcelas_cobranca.status_par", 4);
		$query = $this->db->get();

		if ($this->db->count_all_results() >= 1) {
			return $query->result();
		} else {
			return 0;
		}
	}

	public function lucro_total()
	{
		$this->db->select_sum('lucro_cob');
		$this->db->from("cobrancas");
		$this->db->where("cobrancas.ativo_cob", true);
		$query = $this->db->get();

		if ($this->db->count_all_results() >= 1) {
			return $query->result();
		} else {
			return 0;
		}
	}

	public function vencem_hoje()
	{
		$this->db->select("COUNT(codigo_par)");
		$this->db->from("parcelas_cobranca");
		$this->db->where("parcelas_cobranca.ativo_par", true);
		$this->db->where("parcelas_cobranca.datavencimento_par", date('Y-m-d'));
		$this->db->where("parcelas_cobranca.status_par", 1);

		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}

	public function atrasados()
	{
		$this->db->select("COUNT(codigo_par)");
		$this->db->from("parcelas_cobranca");
		$this->db->join("cobrancas", "cobrancas.codigo_cob = parcelas_cobranca.codigo_cob", 'inner');
		$this->db->where("cobrancas.ativo_cob", true);
		$this->db->where("parcelas_cobranca.ativo_par", true);
		$this->db->where("parcelas_cobranca.datavencimento_par <", date('Y-m-d'));
		$this->db->where("parcelas_cobranca.status_par", 1);
		$total = $this->db->count_all_results();

		if ($this->db->count_all_results() >= 1) {
			return $total;
		} else {
			return 0;
		}
	}
}
