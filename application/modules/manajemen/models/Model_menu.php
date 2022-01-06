<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of fungsi model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_menu extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

  public function validasiDataValue($type)
	{
	  $this->form_validation->set_rules('nama_menu', 'Nama Menu', 'required|trim');
    $this->form_validation->set_rules('is_parent', 'Type Menu', 'required|trim');
    $this->form_validation->set_rules('order_menu', 'Order Menu', 'required|trim');

		if($type == "N")
			$this->form_validation->set_rules('id_rules', 'Module', 'required|trim');

    validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

	/*get data list parent menu */
  public function getDataParentMenu()
  {
    $this->db->where('is_parent', 'Y');
		//$this->db->order_by('id_menu', 'ASC');
    $this->db->order_by('order_menu', 'ASC');
    $query = $this->db->get('xi_sa_menu');

		$dd_parent[''] = 'Pilih Data';
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $dd_parent[$row->id_menu] = $row->title_menu;
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

  /*Fungsi generate data list menu*/
	public function getDataListMenu()
  {
		$result = '';
		$mainmenu = $this->getDataListMenuWithParentID(0);
		foreach ($mainmenu as $main) {
			$ceksubmenu = $this->getDataListMenuWithParentID($main['id_menu']);

			$title = str_replace(' ', '-',  strtolower($main['title_menu']));

			$result .= '<tr data-tt-id="'.$main['id_menu'].'">
										<td>'.$main['title_menu'].'</td>
										<td align="center">'.$main['order_menu'].'</td>
										<td>'.convert_status($main['id_status']).'</td>';
			if(($main['is_parent'] == 'Y') && (count($ceksubmenu) > 0))
				$result .= '<td>
											<a href="'.site_url('manajemen/menu/update/'.$main['id_menu'].'/'.$title).'" class="btn btn-orange btn-xs confirm-edit"><i class="fa fa-pencil"></i> </a>
											<a href="'.site_url('manajemen/menu/create/'.$main['id_menu'].'/'.$title).'" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> </a>
										</td>';
			elseif(($main['is_parent'] == 'Y') && (count($ceksubmenu) == 0))
				$result .= '<td>
											<a href="'.site_url('manajemen/menu/update/'.$main['id_menu'].'/'.$title).'" class="btn btn-orange btn-xs confirm-edit"><i class="fa fa-pencil"></i> </a>
											<button class="btn btn-xs btn-danger delete_menu"><i class="fa fa-trash-o"></i> </button>
											<a href="'.site_url('manajemen/menu/create/'.$main['id_menu'].'/'.$title).'" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> </a>
										</td>';
			else
				$result .= '<td>
											<a href="'.site_url('manajemen/menu/update/'.$main['id_menu'].'/'.$title).'" class="btn btn-orange btn-xs confirm-edit"><i class="fa fa-pencil"></i> </a>
											<button class="btn btn-xs btn-danger delete_menu"><i class="fa fa-trash-o"></i> </button>
										</td>
									</tr>';

			if(count($ceksubmenu) > 0) {
				$submenu = $this->getDataSubMenu($main['id_menu']);
				$result .= $submenu;
			}
		}
		return $result;
  }

	private function getDataSubMenu($id_menu)
	{
		$result = '';
		$submenu = $this->getDataListMenuWithParentID($id_menu);
		foreach ($submenu as $sub) {
			$ceksubsubmenu = $this->getDataListMenuWithParentID($sub['id_menu']);

			$title = str_replace(' ', '-',  strtolower($sub['title_menu']));

			$result .= '<tr data-tt-id="'.$sub['id_menu'].'" data-tt-parent-id="'.$id_menu.'">
										<td>'.$sub['title_menu'].'</td>
										<td align="center">'.$sub['order_menu'].'</td>
										<td>'.convert_status($sub['id_status']).'</td>';
			if(($sub['is_parent'] == 'Y') && (count($ceksubsubmenu) > 0))
				$result .= '<td>
											<a href="'.site_url('manajemen/menu/update/'.$sub['id_menu'].'/'.$title).'" class="btn btn-orange btn-xs confirm-edit"><i class="fa fa-pencil"></i> </a>
											<a href="'.site_url('manajemen/menu/create/'.$sub['id_menu'].'/'.$title).'" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> </a>
										</td>';
			elseif(($sub['is_parent'] == 'Y') && (count($ceksubsubmenu) == 0))
				$result .= '<td>
											<a href="'.site_url('manajemen/menu/update/'.$sub['id_menu'].'/'.$title).'" class="btn btn-orange btn-xs confirm-edit"><i class="fa fa-pencil"></i> </a>
											<button class="btn btn-xs btn-danger delete_menu"><i class="fa fa-trash-o"></i> </button>
											<a href="'.site_url('manajemen/menu/create/'.$sub['id_menu'].'/'.$title).'" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle"></i> </a>
										</td>';
			else
				$result .= '<td>
											<a href="'.site_url('manajemen/menu/update/'.$sub['id_menu'].'/'.$title).'" class="btn btn-orange btn-xs confirm-edit"><i class="fa fa-pencil"></i> </a>
											<button class="btn btn-xs btn-danger delete_menu"><i class="fa fa-trash-o"></i> </button>
										</td>
									</tr>';

			if(count($ceksubsubmenu) > 0){
				$subsubmenu = $this->getDataSubMenu($sub['id_menu']);
				$result .= $subsubmenu;
			}
		}

		return $result;
	}

	/*get data menu with parent id*/
  public function getDataListMenuWithParentID($parent_id)
  {
    $this->db->select('*');
    $this->db->from('xi_sa_menu');
		$this->db->where('parent_id', abs($parent_id));
    //$this->db->order_by('id_menu', 'ASC');
    $this->db->order_by('order_menu', 'ASC');
    $query = $this->db->get();

    return $query->result_array();
  }

	/*Fungsi get data edit by id dan url*/
	public function editDataMenu($id, $name)
	{
		$title_menu = str_replace('-', ' ', $name);

		$this->db->select('xi_sa_menu.*,
											xi_sa_module.url_module,
											xi_sa_kontrol.url_kontrol,
											xi_sa_fungsi.url_fungsi');
    $this->db->from('xi_sa_menu');
		$this->db->join('xi_sa_rules', 'xi_sa_menu.id_rules = xi_sa_rules.id_rules', 'left');
		$this->db->join('xi_sa_module', 'xi_sa_rules.id_module = xi_sa_module.id_module', 'left');
		$this->db->join('xi_sa_kontrol', 'xi_sa_rules.id_kontrol = xi_sa_kontrol.id_kontrol', 'left');
		$this->db->join('xi_sa_fungsi', 'xi_sa_rules.id_fungsi = xi_sa_fungsi.id_fungsi', 'left');
		$this->db->where('id_menu', abs($id));
		$this->db->like('title_menu', $this->db->escape_str($title_menu));
    $query = $this->db->get();

    return $query;
	}

  /* Fungsi untuk insert data */
  public function insertDataMenu()
  {
    //get data
    $create_by    = $this->app_loader->current_account();
    $create_date  = date('Y-m-d H:i:s');
    $create_ip    = $this->input->ip_address();

    $nama_menu    = html_escape($this->input->post('nama_menu', TRUE));
    $is_parent    = html_escape($this->input->post('is_parent', TRUE));
    $parent_id    = html_escape($this->input->post('parent_id', TRUE));
    $id_rules 		= html_escape($this->input->post('id_rules', TRUE));
		$url_menu   	= html_escape($this->input->post('url_menu', TRUE));
		$order_menu 	= html_escape($this->input->post('order_menu', TRUE));
    $icon_menu  	= html_escape($this->input->post('icon_menu', TRUE));
    $status     	= html_escape($this->input->post('status', TRUE));

    $data = array(
      'title_menu' => $this->db->escape_str($nama_menu),
      'url_menu' => $this->db->escape_str($url_menu),
      'icon_menu' => $this->db->escape_str($icon_menu),
      'order_menu' => $this->db->escape_str($order_menu),
			'id_rules' => $this->db->escape_str($id_rules),
			'parent_id' => $this->db->escape_str($parent_id),
      'is_parent' => $this->db->escape_str($is_parent),
      'create_by' => $this->db->escape_str($create_by),
      'create_date' => $this->db->escape_str($create_date),
      'create_ip' => $this->db->escape_str($create_ip),
      'mod_by' => $this->db->escape_str($create_by),
      'mod_date' => $this->db->escape_str($create_date),
      'mod_ip' => $this->db->escape_str($create_ip),
      'id_status' => $this->db->escape_str($status),
    );

    /*query insert*/
    $this->db->insert('xi_sa_menu', $data);
    return TRUE;
  }

	/* Fungsi untuk update data */
  public function updateDataMenu()
  {
    //get data
    $create_by    = $this->app_loader->current_account();
    $create_date  = date('Y-m-d H:i:s');
    $create_ip    = $this->input->ip_address();

		$id_menu			= html_escape($this->input->post('menuID', TRUE));
		$nama_menu    = html_escape($this->input->post('nama_menu', TRUE));
    $is_parent    = html_escape($this->input->post('is_parent', TRUE));
    $parent_id    = html_escape($this->input->post('parent_id', TRUE));
    $id_rules 		= html_escape($this->input->post('id_rules', TRUE));
		$url_menu   	= html_escape($this->input->post('url_menu', TRUE));
		$order_menu 	= html_escape($this->input->post('order_menu', TRUE));
    $icon_menu  	= html_escape($this->input->post('icon_menu', TRUE));
    $status     	= html_escape($this->input->post('status', TRUE));

    $data = array(
			'title_menu' => $this->db->escape_str($nama_menu),
			'url_menu' => $this->db->escape_str($url_menu),
			'icon_menu' => $this->db->escape_str($icon_menu),
			'order_menu' => $this->db->escape_str($order_menu),
			'id_rules' => $this->db->escape_str($id_rules),
			'parent_id' => $this->db->escape_str($parent_id),
			'is_parent' => $this->db->escape_str($is_parent),
			'mod_by' => $this->db->escape_str($create_by),
			'mod_date' => $this->db->escape_str($create_date),
			'mod_ip' => $this->db->escape_str($create_ip),
			'id_status' => $this->db->escape_str($status),
    );

		/*query update*/
		$this->db->where('id_menu', abs($id_menu));
		$this->db->update('xi_sa_menu', $data);
    return TRUE;
  }

	public function deleteDataMenu()
	{
		$id_menu = $this->input->post('menuid', TRUE);
		/*query delete*/
		$this->db->where('id_menu', abs($id_menu));
		$this->db->delete('xi_sa_menu');
		return TRUE;
	}
}

// This is the end of auth signin model
