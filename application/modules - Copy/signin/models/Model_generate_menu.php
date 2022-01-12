<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of generate menu model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_generate_menu extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getDataMenu()
	{
		$this->db->select('xi_sa_menu.id_menu,
											xi_sa_menu.title_menu,
											CASE xi_sa_menu.is_parent
												WHEN "Y" THEN xi_sa_menu.url_menu
												ELSE IF(LCASE(xi_sa_module.url_module) = LCASE(xi_sa_kontrol.url_kontrol), IF(LCASE(xi_sa_fungsi.url_fungsi) = "index", LCASE(xi_sa_module.url_module), CONCAT(LCASE(xi_sa_module.url_module),"/",LCASE(xi_sa_fungsi.url_fungsi))), IF(LCASE(xi_sa_fungsi.url_fungsi) = "index", CONCAT(LCASE(xi_sa_module.url_module),"/",LCASE(xi_sa_kontrol.url_kontrol)), CONCAT(LCASE(xi_sa_module.url_module),"/",LCASE(xi_sa_kontrol.url_kontrol),"/",LCASE(xi_sa_fungsi.url_fungsi))))
											END AS url_menu,
											xi_sa_menu.icon_menu,
											xi_sa_menu.order_menu,
											xi_sa_menu.id_rules,
											xi_sa_menu.parent_id,
											xi_sa_menu.is_parent');
		$this->db->from('xi_sa_menu');
		$this->db->join('xi_sa_rules', 'xi_sa_rules.id_rules = xi_sa_menu.id_rules', 'left');
		$this->db->join('xi_sa_module', 'xi_sa_module.id_module = xi_sa_rules.id_module', 'left');
		$this->db->join('xi_sa_kontrol', 'xi_sa_kontrol.id_kontrol = xi_sa_rules.id_kontrol', 'left');
		$this->db->join('xi_sa_fungsi', 'xi_sa_fungsi.id_fungsi = xi_sa_rules.id_fungsi', 'left');
		$this->db->join('xi_sa_group_privileges', 'xi_sa_group_privileges.id_rules = xi_sa_rules.id_rules', 'left');
		$this->db->join('xi_sa_group', 'xi_sa_group.id_group = xi_sa_group_privileges.id_group', 'left');
		$this->db->where('xi_sa_menu.id_status', 1);
		$this->db->where('xi_sa_rules.id_status', 1);
		$this->db->where('xi_sa_module.id_status', 1);
		$this->db->where('xi_sa_kontrol.id_status', 1);
		$this->db->where('xi_sa_fungsi.id_status', 1);
		$this->db->where('xi_sa_group_privileges.id_status', 1);
		$this->db->where('xi_sa_group.id_status', 1);
		$this->db->where('xi_sa_group.id_group', $this->app_loader->current_group());
		$this->db->order_by('xi_sa_menu.id_menu ASC', 'xi_sa_menu.order_menu ASC');
		$this->db->get();
		$query1 = $this->db->last_query();

		/*-------------------------------ambil parent-----------------------------*/
		$menus = "";
		$getParent = $this->db->query($query1);
		foreach ($getParent->result() as $id) {
			if($id->parent_id != 0)
				$menus .= $this->getMenuParent($id->parent_id);
		}
		$parentID = explode(',', substr(trim($menus), 0, -1));
		/*------------------------------------------------------------------------*/

		$this->db->select('id_menu,
											 title_menu,
											 url_menu,
											 icon_menu,
											 order_menu,
											 id_rules,
											 parent_id,
											 is_parent');
		$this->db->from('xi_sa_menu');
		$this->db->where('is_parent', 'Y');
		$this->db->where('id_status', 1);
		$this->db->where_in('id_menu', $parentID);
		$this->db->order_by('id_menu ASC', 'order_menu ASC');
		$this->db->get();
		$query2 = $this->db->last_query();

		$query = $this->db->query("(".$query1.") UNION (".$query2.")");

		return $query->result_array();
	}

  private function getMenuParent($parent)
  {
		$menus = "";

		$this->db->select('id_menu, parent_id');
		$this->db->from('xi_sa_menu');
		$this->db->where('id_menu', $parent);
		$this->db->where('is_parent', 'Y');
		$this->db->where('id_status', 1);
		$this->db->order_by('id_menu ASC', 'order_menu ASC');
		$query = $this->db->get();

		$menus .= $query->row()->id_menu.',';
		if($query->row()->parent_id != 0)
			$menus .= $this->getMenuParent($query->row()->parent_id);

		return $menus;
  }

}

// This is the end of auth signin model
