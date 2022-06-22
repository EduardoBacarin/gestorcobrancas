<?php
class Cidade_model extends CI_Model
{

	public function busca_cidade_nome($nome, $estado)
	{
		$this->db->select("cidades.*, estados.*");
		$this->db->from("cidades");
		$this->db->join("estados", "estados.codigo_est = cidades.codigo_est", 'inner');
		$this->db->like("cidades.nome_cid", $nome);
		$this->db->like("estados.uf_est", $estado);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
}
