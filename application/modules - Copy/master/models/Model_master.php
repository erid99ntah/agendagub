<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model odp
 *
 * @author Yogi "solop" Kaputra
 */

class Model_master extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getDataStudy()
  {
		$this->db->order_by('id ASC');
		$query = $this->db->get('ref_pendidikan');
    $dd_study[''] = 'Pilih Pendidikan';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_study[$row['id']] = $row['study'];
      }
    }
    return $dd_study;
  }

	public function getDataNegara()
  {
		$this->db->order_by('id ASC');
		$query = $this->db->get('wa_negara');
    $dd_negara[''] = 'Pilih Negara';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_negara[$row['name']] = $row['name'];
      }
    }
    return $dd_negara;
  }

	public function getDataProvince()
  {
		$this->db->order_by('id ASC');
		$query = $this->db->get('wa_province');
    $dd_prov[''] = 'Pilih Provinsi';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_prov[$row['id']] = $row['name'];
      }
    }
    return $dd_prov;
  }

	public function getDataRegency()
  {
		$this->db->where('province_id', '13');
		$this->db->order_by('status ASC');
		$this->db->order_by('name ASC');
		$query = $this->db->get('wa_regency');
    $dd_reg[''] = 'Pilih Kab/Kota';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_reg[$row['id']] = ($row['status'] == 1) ? "KAB ".$row['name'] : $row['name'];
      }
    }
    return $dd_reg;
  }

  public function getDataRegencyByProvince($id)
  {
		$this->db->where('province_id', $id);
		$this->db->order_by('name ASC');
		$this->db->order_by('status ASC');
		$query = $this->db->get('wa_regency');
    return $query->result_array();
  }

  public function getDataDistrictByRegency($id)
  {
		$this->db->where('regency_id', $id);
		$this->db->order_by('id ASC');
		$query = $this->db->get('wa_district');
    return $query->result_array();
  }

  public function getDataVillageByDistrict($id)
  {
		$this->db->where('district_id', $id);
		$this->db->order_by('id ASC');
		$query = $this->db->get('wa_village');
    return $query->result_array();
  }

	public function getDataMasterRsRujukan($id=0)
  {
		$this->db->where('status', '1');
		$this->db->where('flag', '1');
		if($id!=0)
			$this->db->where('id_rs !=', $id);
		$this->db->order_by('id_rs ASC');
		$query = $this->db->get('ms_rs_rujukan');
    $dd_rs[''] = 'Pilih Rumah Sakit';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_rs[$row['id_rs']] = $row['shortname'].' ['.$row['kode_fasyankes'].']';
      }
    }
    return $dd_rs;
  }

	public function getDataMasterHospital()
  {
		$this->db->where('status', '1');
		$this->db->order_by('id_rs ASC');
		$query = $this->db->get('ms_rs_rujukan');
    $dd_rs[''] = 'Pilih Rumah Sakit';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_rs[$row['id_rs']] = $row['shortname'].' ['.$row['kode_fasyankes'].']';
      }
    }
    return $dd_rs;
  }

	public function getDataMasterHospitalById($id)
  {
		$this->db->where('id_rs', $id);
		$this->db->where('status', '1');
		$this->db->order_by('id_rs ASC');
		$query = $this->db->get('ms_rs_rujukan');
    $dd_rs[''] = 'Pilih Rumah Sakit';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_rs[$row['id_rs']] = $row['shortname'].' ['.$row['kode_fasyankes'].']';
      }
    }
    return $dd_rs;
  }

  /*-----------------------------------Instansi-----------------------------------------------------*/
  public function getDataListInstansi()
  {
    $this->db->where('id_status', 1);
    if(!$this->app_loader->is_admin()) 
    {
      $id_opd = $this->app_loader->current_opd();
      $this->db->where('id_opd', $id_opd);
    }    
    $this->db->order_by('id_opd ASC');
    $query = $this->db->get('master_opd');

      $dd_instansi['']='Pilih OPD';
      if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
          $dd_instansi[$row->id_opd] = $row->nm_opd;
        }
      }
      return $dd_instansi;
  }

  public function getNamaOpd($id_opd)
  {
    $this->db->select('nm_opd');
    $this->db->from('master_opd');
    $this->db->where('id_opd', $id_opd);
    $this->db->limit(1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) 
      return $query->row()->nm_opd;
    else
      return 0;
  }

  public function getInstansiAll()
  {     
        if(!$this->app_loader->is_admin()) 
        {
          $id_opd = $this->app_loader->current_opd();
          $child_ins   = $id_opd;
        } 
        else
        {
          $id_opd      = 0;
          $child_ins   = 1;  
        }
        
        return $this->getInstansiParent($id_opd, $child_ins);
  }

  public function getInstansiParent($id_opd, $child_ins)
  {
        $tampil = "";

        $this->db->where('id_status', 1);
        if(!$this->app_loader->is_admin()) 
        {
          $id_opd = $this->app_loader->current_opd();
          $this->db->where('id_opd', $id_opd);
        } 
        else
        {
          $this->db->where('parent_id', 0);
        }   
        
        $this->db->order_by('id_opd ASC');
        $data_parent = $this->db->get('master_opd');


        if($data_parent->num_rows() > 0)
        { 
            foreach ($data_parent->result() as $data_parent) 
            {
              if($data_parent->id_opd == $child_ins)
                  $pilih = "selected";
              else
                  $pilih = "";
              
              $tampil .= '<option value="'.$data_parent->id_opd.'" '.$pilih.'>&#8866; '.$data_parent->nm_opd.'</option>';

              $this->db->select('id_opd');
              $this->db->where('parent_id', $id_opd);
              $this->db->order_by('id_opd ASC');
              $cekChild = $this->db->get('master_opd');

              if($cekChild->num_rows() > 0)
                $tampil .= $this->getInstansiChild($data_parent->id_opd, $child_ins, 1);

            }
        }

        return $tampil;
    }

    public function getInstansiChild($parent_id, $child_id, $number)
    {
        $child = "";

        $this->db->where('id_status', 1);
        if(!$this->app_loader->is_admin()) 
        {
          $id_opd = $this->app_loader->current_opd();
          $this->db->where('id_opd', $id_opd);
        }    
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('id_opd ASC');
        $data_child = $this->db->get('master_opd');


        $spasi = "";
        $nomor = $number + 1;

        for ($i = 1; $i < $nomor; $i++) {
            $spasi .= "&mdash;";
        }

        foreach ($data_child->result() as $key) {
            if($key->id_opd == $child_id)
                $pilih = "selected";
            else
                $pilih = "";

            $child .= '<option value="'.$key->id_opd.'" '.$pilih.'>&#8866;'.$spasi.' '.$key->nm_opd.'</option>';

            $this->db->select('id_opd');
            $this->db->order_by('id_opd ASC');
            $cekChild = $this->db->get('master_opd');

            if($cekChild->num_rows() > 0)               
                $child .= $this->getInstansiChild($key->id_opd, $child_id, $nomor);
        }

        return $child;
    }

  /*-----------------------------------Instansi-----------------------------------------------------*/

  
}

// This is the end of auth signin model
