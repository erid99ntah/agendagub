<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Breadcrumb {
	private $breadcrumbs = array();
	//private $separator = '<i class="zmdi zmdi-chevron-right"></i>';
	private $start = '<ol class="breadcrumb">';
	private $end = '</ol>';

	public function __construct($params = array()){
		if (count($params) > 0){
			$this->initialize($params);
		}
	}

	private function initialize($params = array()){
		if (count($params) > 0){
			foreach ($params as $key => $val){
				if (isset($this->{'_' . $key})){
					$this->{'_' . $key} = $val;
				}
			}
		}
	}

	function add($title, $href){
		if (!$title OR !$href) return;
		$this->breadcrumbs[] = array('title' => $title, 'href' => $href);
	}

	function output(){

		if ($this->breadcrumbs) {

			$output = $this->start;

			foreach ($this->breadcrumbs as $key => $crumb) {

				$lastindex = count($this->breadcrumbs)-1;

				$ar_k = array_keys($this->breadcrumbs);
				$lastindex = $ar_k[count($ar_k)-1];

				if ($lastindex == $key) {
					$output .= '<li class="active">'. $crumb['title'] .'</li>';
				} else {
					if($crumb['href'] == '#' || $crumb['href'] == ' ')
						$output .= '<li>'. $crumb['title'] .'</a></li>';
					else
						$output .= '<li><a href="' . $crumb['href'] . '">'. $crumb['title'] .'</a></li>';
				}
			}

			return $output . $this->end . PHP_EOL;
		}

		return '';
	}

}
