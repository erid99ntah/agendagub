<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of group model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_group extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

  public function validasiDataValue()
	{
	  $this->form_validation->set_rules('nama_group', 'Nama Grup', 'required|trim');
    $this->form_validation->set_rules('level_akses', 'Level Akses', 'required');
    validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

  public function getDataLevelAkses()
  {
    $this->db->where('id_status', 1);
    $this->db->order_by('id_level_akses', 'ASC');
    $query = $this->db->get('xi_sa_level_akses');

		$dd_level[''] = 'Pilih Data';
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $dd_level[$row->id_level_akses] = $row->level_akses;
      }
    }
    return $dd_level;
  }

  /*Fungsi Geta Data List*/
  public function getDataListGroup()
  {
    $this->db->select('a.*,
											CONCAT("Module: ",GROUP_CONCAT(DISTINCT(d.label_module) ORDER BY d.id_module ASC SEPARATOR ", ")) AS hak_akses');
    $this->db->from('xi_sa_group a');
		$this->db->join('xi_sa_group_privileges b', 'a.id_group = b.id_group', 'left');
		$this->db->join('xi_sa_rules c', 'b.id_rules = c.id_rules', 'left');
		$this->db->join('xi_sa_module d', 'c.id_module = d.id_module', 'left');
		$this->db->group_by('a.id_group');
		$this->db->order_by('a.id_group', 'ASC');
    $query = $this->db->get();

    return $query->result();
  }

	/*get data group by id*/
	public function getDataGroupById($id_group)
	{
		$this->db->select('*');
    $this->db->from('xi_sa_group');
    $this->db->where('id_group', abs($id_group));
		$this->db->where('id_status', 1);
    $query = $this->db->get();

    return $query;
	}

	/*Fungsi get data edit by id dan url*/
	public function editDataGroup($id, $name)
	{
    $title = str_replace('-', ' ', $name);

		$this->db->select('*');
    $this->db->from('xi_sa_group');
		$this->db->where('id_group', abs($id));
		$this->db->like('nama_group', $this->db->escape_str($title));
    $query = $this->db->get();

    return $query;
	}

  /* Fungsi untuk insert data */
  public function insertDataGroup()
  {
    //get data
    $create_by     = $this->app_loader->current_account();
    $create_date   = date('Y-m-d H:i:s');
    $create_ip     = $this->input->ip_address();

    $nama_group    = html_escape($this->input->post('nama_group', TRUE));
    $level_akses   = html_escape($this->input->post('level_akses', TRUE));
    $status        = html_escape($this->input->post('status', TRUE));

    $data = array(
      'nama_group' => $this->db->escape_str($nama_group),
      'id_level_akses	' => $this->db->escape_str($level_akses),
      'create_by' => $this->db->escape_str($create_by),
      'create_date' => $this->db->escape_str($create_date),
      'create_ip' => $this->db->escape_str($create_ip),
      'mod_by' => $this->db->escape_str($create_by),
      'mod_date' => $this->db->escape_str($create_date),
      'mod_ip' => $this->db->escape_str($create_ip),
      'id_status' => $this->db->escape_str($status),
    );

    /*query insert*/
    $this->db->insert('xi_sa_group', $data);
    return TRUE;
  }

	/* Fungsi untuk update data */
  public function updateDataGroup()
  {
    //get data
    $create_by     = $this->app_loader->current_account();
    $create_date   = date('Y-m-d H:i:s');
    $create_ip     = $this->input->ip_address();

		$id_group		   = html_escape($this->input->post('groupid', TRUE));
    $nama_group    = html_escape($this->input->post('nama_group', TRUE));
    $level_akses   = html_escape($this->input->post('level_akses', TRUE));
    $status        = html_escape($this->input->post('status', TRUE));

    $data = array(
      'nama_group' => $this->db->escape_str($nama_group),
      'id_level_akses	' => $this->db->escape_str($level_akses),
      'mod_by' => $this->db->escape_str($create_by),
      'mod_date' => $this->db->escape_str($create_date),
      'mod_ip' => $this->db->escape_str($create_ip),
      'id_status' => $this->db->escape_str($status),
    );

		/*query update*/
		$this->db->where('id_group', abs($id_group));
		$this->db->update('xi_sa_group', $data);
    return TRUE;
  }

	public function deleteDataGroup()
	{
		$group = $this->input->post('checkid', TRUE);
		//jika ingin menghapus data lakukan looping
		foreach ($group as $key => $id) {
			/*query delete*/
			$this->db->delete('xi_sa_group', array('id_group' => abs($id)));
			/*delete group privileges*/
			$this->db->delete('xi_sa_group_privileges', array('id_group' => abs($id)));
			/*delete user group privileges*/
			$this->db->delete('xi_sa_users_privileges', array('id_group' => abs($id)));
		}
		return TRUE;
	}

	/* get data all rules module*/
	public function getDataAllRulesModule()
  {
    $this->db->select('xi_sa_rules.id_rules,
                      xi_sa_module.label_module,
											xi_sa_kontrol.label_kontrol,
											xi_sa_fungsi.label_fungsi');
		$this->db->from('xi_sa_rules');
    $this->db->join('xi_sa_module', 'xi_sa_rules.id_module = xi_sa_module.id_module', 'inner');
		$this->db->join('xi_sa_kontrol', 'xi_sa_rules.id_kontrol = xi_sa_kontrol.id_kontrol', 'inner');
		$this->db->join('xi_sa_fungsi', 'xi_sa_rules.id_fungsi = xi_sa_fungsi.id_fungsi', 'inner');
		$this->db->where('xi_sa_rules.id_status', 1);
    $this->db->order_by('xi_sa_module.id_module', 'ASC');
    $this->db->order_by('xi_sa_kontrol.id_kontrol', 'ASC');
    $this->db->order_by('xi_sa_fungsi.id_fungsi', 'ASC');
		$query = $this->db->get();

		return $query->result_array();
  }

	/* get data rules by group from group privileges */
	public function getDataRulesGroupPrivileges($id_group)
	{
		$this->db->select('*');
		$this->db->from('xi_sa_group_privileges');
		$this->db->join('xi_sa_group', 'xi_sa_group.id_group = xi_sa_group_privileges.id_group', 'inner');
		$this->db->where('xi_sa_group_privileges.id_group', abs($id_group));
		$this->db->where('xi_sa_group_privileges.id_status', 1);
		$this->db->where('xi_sa_group.id_status', 1);
		$query = $this->db->get();

		return $query->result();
	}

	/*insert data group privileges*/
	public function insertDataGroupPrivilege()
	{
		$group = $this->input->post('group', TRUE);
		$rules = $this->input->post('prvlg', TRUE);
		//update status group privileges berdasarkan id group
		$this->db->set('id_status', 0);
		$this->db->where('id_group', abs($group));
		$this->db->update('xi_sa_group_privileges');

		foreach ($rules as $key => $id) {
			$this->db->where('id_group', abs($group));
			$this->db->where('id_rules', abs($id));
			$cekData = $this->db->count_all_results('xi_sa_group_privileges');
			if($cekData > 0) {
				//update status group privileges jadi 1
				$this->db->set('id_status', 1);
				$this->db->where('id_group', abs($group));
				$this->db->where('id_rules', abs($id));
				$this->db->update('xi_sa_group_privileges');
			} else {
				//insert data group privileges
				$data = array('id_group' => $group, 'id_rules' => $id, 'id_status' => 1);
				$this->db->insert('xi_sa_group_privileges', $data);
			}
		}
		return TRUE;
	}
}

// This is the end of auth signin model
