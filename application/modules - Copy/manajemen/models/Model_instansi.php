<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of fungsi model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_instansi extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($type)
	{
		$this->form_validation->set_rules('nm_opd',  'Nama Instansi', 'required|trim');
		$this->form_validation->set_rules('parent_id', 'Type Instansi', 'required|trim');
		$this->form_validation->set_rules('order_no',  'Order Instansi', 'required|trim');

		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function getNamaInstansi($id){
		$this->db->select('nm_opd');
		$this->db->from('master_opd');
		$this->db->where('id_opd', $id);
		$this->db->limit(1);
		$data = $this->db->get();

		return $data->row_array()['nm_opd'];
	}

	/*get data list parent Instansi */
	public function getDataParentInstansi()
	{
		$this->db->where('parent_id', 0);
		//$this->db->order_by('id_opd', 'ASC');
		//$this->db->order_by('order_no', 'ASC');
		$this->db->order_by('kode_opd', 'ASC');
		$query = $this->db->get('master_opd');

		$dd_parent[''] = 'Pilih Data';
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$dd_parent[$row->id_opd] = $row->nm_opd;
			}
		}
		return $dd_parent;
	}

	/*get data list rules module index aktif */
	public function getDataRulesModule()
	{
		$this->db->select('xi_sa_rules.id_rules,
			xi_sa_module.url_module,
			xi_sa_module.label_module,
			xi_sa_kontrol.url_kontrol,
			xi_sa_kontrol.label_kontrol,
			xi_sa_fungsi.url_fungsi,
			xi_sa_fungsi.label_fungsi');
		$this->db->from('xi_sa_rules');
		$this->db->join('xi_sa_module', 'xi_sa_rules.id_module = xi_sa_module.id_module', 'inner');
		$this->db->join('xi_sa_kontrol', 'xi_sa_rules.id_kontrol = xi_sa_kontrol.id_kontrol', 'inner');
		$this->db->join('xi_sa_fungsi', 'xi_sa_rules.id_fungsi = xi_sa_fungsi.id_fungsi', 'inner');
		$this->db->where('xi_sa_rules.id_status', 1);
		$this->db->where('xi_sa_fungsi.id_jenis_fungsi', 1);
		$this->db->order_by('xi_sa_module.id_module', 'ASC');
		$this->db->order_by('xi_sa_kontrol.id_kontrol', 'ASC');
		$this->db->order_by('xi_sa_fungsi.id_fungsi', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	/*Fungsi generate data list Instansi*/
	public function getDataListInstansi()
	{
		$result = '';
		$mainInstansi = $this->getDataListInstansiWithParentID(0);
		foreach ($mainInstansi as $main) {
			$ceksubInstansi = $this->getDataListInstansiWithParentID($main['id_opd']);

			$title = str_replace(' ', '-',  strtolower($main['nm_opd']));

			$result .= '<tr data-tt-id="'.$main['id_opd'].'">
			<td>'.$main['kode_opd'].'</td>
			<td>'.$main['nm_opd'].'</td>
			<td align="center">'.$main['order_no'].'</td>
			<td>'.convert_status($main['id_status']).'</td>';
			
			$result .= '<td>
			<a href="'.site_url('manajemen/instansi/update/'.$main['id_opd'].'/'.$title).'" class="btn btn-orange btn-xs confirm-edit"><i class="fa fa-pencil"></i> </a>
			<button class="btn btn-xs btn-danger delete_instansi"><i class="fa fa-trash-o"></i> </button>
			<a href="'.site_url('manajemen/instansi/create/'.$main['id_opd'].'/'.$title).'" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> </a>
		</td>';

		if(count($ceksubInstansi) > 0) {
				$subInstansi = $this->getDataSubInstansi($main['id_opd']);
				$result .= $subInstansi;
			}
		}
		return $result;
	}

	private function getDataSubInstansi($id_opd)
	{
		$result = '';
		$subInstansi = $this->getDataListInstansiWithParentID($id_opd);
		foreach ($subInstansi as $sub) {
			$ceksubsubInstansi = $this->getDataListInstansiWithParentID($sub['id_opd']);

			$title = str_replace(' ', '-',  strtolower($sub['nm_opd']));

			$result .= '<tr data-tt-id="'.$sub['id_opd'].'" data-tt-parent-id="'.$id_opd.'">
			<td>'.$sub['kode_opd'].'</td>
			<td>'.$sub['nm_opd'].'</td>
			<td align="center">'.$sub['order_no'].'</td>
			<td>'.convert_status($sub['id_status']).'</td>';

			$result .= '<td>										
			<button class="btn btn-xs btn-danger delete_instansi"><i class="fa fa-trash-o"></i> </button>
			<a href="'.site_url('manajemen/instansi/create/'.$sub['id_opd'].'/'.$title).'" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> </a>
		</td>';

		if(count($ceksubsubInstansi) > 0){
			$subsubInstansi = $this->getDataSubInstansi($sub['id_opd']);
			$result .= $subsubInstansi;
		}
	}

	return $result;
	}

	/*get data Instansi with parent id*/
	public function getDataListInstansiWithParentID($parent_id)
	{
		$this->db->select('*');
		$this->db->from('master_opd');
		$this->db->where('parent_id', abs($parent_id));
		//$this->db->order_by('id_opd', 'ASC');
		$this->db->order_by('kode_opd', 'ASC');
		$query = $this->db->get();

		return $query->result_array();
	}

	/*Fungsi get data edit by id dan url*/
	public function editDataInstansi($id, $name)
	{
		$nm_opd = str_replace('-', ' ', $name);

		$this->db->select('master_opd.*,
			xi_sa_module.url_module,
			xi_sa_kontrol.url_kontrol,
			xi_sa_fungsi.url_fungsi');
		$this->db->from('master_opd');
		$this->db->join('xi_sa_rules', 'master_opd.id_rules = xi_sa_rules.id_rules', 'left');
		$this->db->join('xi_sa_module', 'xi_sa_rules.id_module = xi_sa_module.id_module', 'left');
		$this->db->join('xi_sa_kontrol', 'xi_sa_rules.id_kontrol = xi_sa_kontrol.id_kontrol', 'left');
		$this->db->join('xi_sa_fungsi', 'xi_sa_rules.id_fungsi = xi_sa_fungsi.id_fungsi', 'left');
		$this->db->where('id_opd', abs($id));
		$this->db->like('nm_opd', $this->db->escape_str($nm_opd));
		$query = $this->db->get();

		return $query;
	}

	/* Fungsi untuk insert data */
	public function insertDataInstansi()
	{
		    //get data
		$create_by    = $this->app_loader->current_account();
		$create_date  = date('Y-m-d H:i:s');
		$create_ip    = $this->input->ip_address();

		$nm_opd    = html_escape($this->input->post('nm_opd', TRUE));
		$parent_id    = html_escape($this->input->post('parent_id', TRUE));
		$order_no 	= html_escape($this->input->post('order_no', TRUE));    
		$status     	= html_escape($this->input->post('status', TRUE));

		$data = array(
			'nm_opd' => $this->db->escape_str($nm_opd),      
			'order_no' => $this->db->escape_str($order_no),			
			'parent_id' => $this->db->escape_str($parent_id),
			'create_by' => $this->db->escape_str($create_by),
			'create_date' => $this->db->escape_str($create_date),
			'create_ip' => $this->db->escape_str($create_ip),
			'mod_by' => $this->db->escape_str($create_by),
			'mod_date' => $this->db->escape_str($create_date),
			'mod_ip' => $this->db->escape_str($create_ip),
			'id_status' => $this->db->escape_str($status),
			);

		/*query insert*/
		$this->db->insert('master_opd', $data);
		return TRUE;
	}

	/* Fungsi untuk update data */
	public function updateDataInstansi()
	{
		    //get data
		$create_by    = $this->app_loader->current_account();
		$create_date  = date('Y-m-d H:i:s');
		$create_ip    = $this->input->ip_address();

		$id_opd			= html_escape($this->input->post('instansiid', TRUE));
		$nm_opd    = html_escape($this->input->post('nm_opd', TRUE));
		$parent_id    = html_escape($this->input->post('parent_id', TRUE));
		$parent_id    = html_escape($this->input->post('parent_id', TRUE));
		$id_rules 		= html_escape($this->input->post('id_rules', TRUE));
		$url_Instansi   	= html_escape($this->input->post('url_Instansi', TRUE));
		$order_no 	= html_escape($this->input->post('order_no', TRUE));
		$icon_Instansi  	= html_escape($this->input->post('icon_Instansi', TRUE));
		$status     	= html_escape($this->input->post('status', TRUE));

		$data = array(
			'nm_opd' => $this->db->escape_str($nm_opd),
			'url_Instansi' => $this->db->escape_str($url_Instansi),
			'icon_Instansi' => $this->db->escape_str($icon_Instansi),
			'order_no' => $this->db->escape_str($order_no),
			'id_rules' => $this->db->escape_str($id_rules),
			'parent_id' => $this->db->escape_str($parent_id),
			'parent_id' => $this->db->escape_str($parent_id),
			'mod_by' => $this->db->escape_str($create_by),
			'mod_date' => $this->db->escape_str($create_date),
			'mod_ip' => $this->db->escape_str($create_ip),
			'id_status' => $this->db->escape_str($status),
			);

		/*query update*/
		$this->db->where('id_opd', abs($id_opd));
		$this->db->update('master_opd', $data);
		return TRUE;
	}

	public function deleteDataInstansi()
	{
		$id_opd = $this->input->post('instansiid', TRUE);

		$this->db->select('id_opd');
		$this->db->from('master_opd');
		$this->db->where('master_opd.parent_id', $id_opd);
		$cek = $this->db->get();
		if ($cek->num_rows() > 0) 
		{
			error_message('danger', 'Peringatan!', 'Data Tidak Bisa DIhapus..');
			return FALSE;
		}

		/*query delete*/
		$this->db->where('id_opd', abs($id_opd));
		$this->db->delete('master_opd');
		return TRUE;
	}
}

// This is the end of auth signin model
