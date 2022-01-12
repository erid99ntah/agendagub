<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yogi "solop" Kaputra
 */

class Model_hospital extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue()
	{
		$this->form_validation->set_rules('kode_fasyankes', 'Kode Fasyankes', 'required|trim');
		$this->form_validation->set_rules('fullname', 'Nama Fasyankes', 'required|trim');
		$this->form_validation->set_rules('province', 'Provinsi Fasyankes', 'required|trim');
		$this->form_validation->set_rules('regency', 'Kab/Kota Fasyankes', 'required|trim');
		$this->form_validation->set_rules('district', 'Kab/Kota Fasyankes', 'required|trim');
		$this->form_validation->set_rules('village', 'Kab/Kota Fasyankes', 'required|trim');
		$this->form_validation->set_rules('tipe_fasyankes', 'Tipe Fasyankes', 'required|trim');
		$this->form_validation->set_rules('flag', 'Kategori Fasyankes', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required|trim');
  	validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

  var $search = array('kode_fasyankes', 'fullname', 'shortname');
  public function get_datatables($param)
  {
    $this->_get_datatables_query($param);
    if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result_array();
  }

public function count_filtered($param)
  {
    $this->_get_datatables_query($param);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    return $this->db->count_all_results('ms_rs_rujukan');
  }

  private function _get_datatables_query($param)
  {
		$post = array();
		if (is_array($param)) {
      foreach ($param as $v) {
        $post[$v['name']] = $v['value'];
      }
    }
		$this->db->select('id_rs,
											 kode_fasyankes,
											 tipe_fasyankes,
											 fullname,
											 shortname,
											 id_province,
											 id_regency,
											 id_district,
											 id_village,
											 address,
											 phone,
											 flag,
											 status');
    $this->db->from('ms_rs_rujukan');
		//provinsi
		if(isset($post['province']) AND $post['province'] != '')
			$this->db->where('id_province', $post['province']);
		//regency
		if(isset($post['regency']) AND $post['regency'] != '')
			$this->db->where('id_regency', $post['regency']);
		//rsud
		if(isset($post['rujukan']) AND $post['rujukan'] != '')
			$this->db->where('flag', $post['rujukan']);
		//status
		if(isset($post['status']) AND $post['status'] != '')
			$this->db->where('status', $post['status']);

    $i = 0;
    foreach ($this->search as $item) { // loop column
      if($_POST['search']['value']) { // if datatable send POST for search
        if($i===0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->search) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }
		$this->db->order_by('id_rs ASC');
  }

	public function getDataListHospitalReport($province, $regency, $flag, $status)
	{
		if($province != '')
			$this->db->where('id_province', $province);
		if($regency != '')
			$this->db->where('id_regency', $regency);
		if($flag != '')
			$this->db->where('flag', $flag);
		if($status != '')
			$this->db->where('status', $status);
		$this->db->order_by('id_rs ASC');
		$query = $this->db->get('ms_rs_rujukan');
    return $query->result_array();
	}

	public function getDataDetailHospital($id_rs)
	{
		$this->db->where('id_rs', $id_rs);
		$query = $this->db->get('ms_rs_rujukan');
		return $query->row_array();
	}

	public function insertDataHospital()
	{
		$create_by    = $this->app_loader->current_account();
		$create_date 	= gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		$kodefaskes   = escape($this->input->post('kode_fasyankes', TRUE));
		$fullname			= escape($this->input->post('fullname', TRUE));
		//cek data
		$this->db->where('kode_fasyankes', $kodefaskes);
		$qTot = $this->db->count_all_results('ms_rs_rujukan');
		if($qTot > 0)
			return array('message'=>'ERROR', 'kode'=>$kodefaskes, 'nama'=>$fullname);
		else {
			$data = array(
				'kode_fasyankes'	=> $kodefaskes,
				'tipe_fasyankes'	=> escape($this->input->post('tipe_fasyankes', TRUE)),
				'fullname' 				=> $fullname,
				'shortname'				=> escape($this->input->post('shortname', TRUE)),
				'id_province'			=> escape($this->input->post('province', TRUE)),
				'id_regency'			=> escape($this->input->post('regency', TRUE)),
				'id_district'			=> escape($this->input->post('district', TRUE)),
				'id_village'			=> escape($this->input->post('village', TRUE)),
				'address'					=> escape($this->input->post('address', TRUE)),
				'phone'						=> escape($this->input->post('phone', TRUE)),
				'flag'						=> escape($this->input->post('flag', TRUE)),
				'status'					=> escape($this->input->post('status', TRUE)),
				'create_by'				=> $create_by,
				'create_date'			=> $create_date,
				'create_ip'				=> $create_ip,
				'mod_by'					=> $create_by,
				'mod_date'				=> $create_date,
				'mod_ip'					=> $create_ip
			);
			$this->db->insert('ms_rs_rujukan', $data);
			return array('message'=>'SUCCESS', 'kode'=>$kodefaskes, 'nama'=>$fullname);
		}
	}

	public function updateDataHospital()
	{
		$create_by    = $this->app_loader->current_account();
		$create_date 	= gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		$id_rs				= $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
		$kodefaskes   = escape($this->input->post('kode_fasyankes', TRUE));
		$fullname			= escape($this->input->post('fullname', TRUE));
		//cek data rs by id
		$dataRs = $this->getDataDetailHospital($id_rs);
		if(count($dataRs) <= 0)
			return array('message'=>'ERROR', 'kode'=>'', 'nama'=>'');
		else {
			//cek data
			$this->db->where('id_rs !=', $id_rs);
			$this->db->where('kode_fasyankes', $kodefaskes);
			$qTot = $this->db->count_all_results('ms_rs_rujukan');
			if($qTot > 0)
				return array('message'=>'ERROR', 'kode'=>$kodefaskes, 'nama'=>$fullname);
			else {
				$data = array(
					'kode_fasyankes'	=> $kodefaskes,
					'tipe_fasyankes'	=> escape($this->input->post('tipe_fasyankes', TRUE)),
					'fullname' 				=> $fullname,
					'shortname'				=> escape($this->input->post('shortname', TRUE)),
					'id_province'			=> escape($this->input->post('province', TRUE)),
					'id_regency'			=> escape($this->input->post('regency', TRUE)),
					'id_district'			=> escape($this->input->post('district', TRUE)),
					'id_village'			=> escape($this->input->post('village', TRUE)),
					'address'					=> escape($this->input->post('address', TRUE)),
					'phone'						=> escape($this->input->post('phone', TRUE)),
					'flag'						=> escape($this->input->post('flag', TRUE)),
					'status'					=> escape($this->input->post('status', TRUE)),
					'mod_by'					=> $create_by,
					'mod_date'				=> $create_date,
					'mod_ip'					=> $create_ip
				);
				$this->db->where('id_rs', $id_rs);
				$this->db->update('ms_rs_rujukan', $data);
				return array('message'=>'SUCCESS', 'kode'=>$kodefaskes, 'nama'=>$fullname);
			}
		}
	}

	public function deleteDataHospital()
	{
		$id_rs = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
		//cek data rs by id
		$dataRs = $this->getDataDetailHospital($id_rs);
		$kode   = !empty($dataRs) ? $dataRs['kode_fasyankes'] : '';
		$name		= !empty($dataRs) ? $dataRs['fullname'] : '';
		if(count($dataRs) <= 0)
			return array('message'=>'ERROR', 'kode'=>'', 'nama'=>'');
		else {
			$this->db->where('id_rs', $id_rs);
			$this->db->delete('ms_rs_rujukan');
			return array('message'=>'SUCCESS', 'kode'=>$kode, 'nama'=>$name);
		}
	}
}

// This is the end of auth signin model
