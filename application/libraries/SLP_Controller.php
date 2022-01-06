<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of SLP_Controller class
 *
 * @author  Yogi Kaputra
 * @since   1.0
 *
 *
 */

class SLP_Controller extends MY_Controller {

  var $session_info = array();

  public function __construct() {
    parent::__construct();

    $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0', FALSE);
		$this->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		$this->output->set_header('Pragma: no-cache');

    $this->session_info['app_name']   = "E-Agenda";
    $this->session_info['app_footer'] = "Hak Cipta ©" . ((date('Y') == "2021") ? "2021" : "2021 - ".date('Y')) . " " . "E-Agenda. <i>Powered by</i> Team IT Kominfo Prov. Sumbar";

    //$this->load->library('Menu_loader');

    // Setting up the template
    //$this->template->set_layout('layouts/main');
    $this->template->enable_parser(FALSE); // default true

    $this->template->set_partial('header', 'layouts/partials/header', FALSE);
    $this->template->set_partial('title', 'layouts/partials/title', FALSE);
    $this->template->set_partial('navigation', 'layouts/partials/navigation', FALSE);
    $this->template->set_partial('footer', 'layouts/partials/footer', FALSE);
    $this->template->set_partial('javascript', 'layouts/partials/javascript', FALSE);
  }

}

// This is the end of WRC_AdminCont class
