<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
	protected $_code  = '';
	protected $_jenis = '';
	public function __construct()
	{
		parent::__construct();
	}

	public function setCode($code)
	{
		$this->_code = $code;
	}

	public function setJenis($type)
	{
		$this->_jenis = $type;
	}

	public function footer()
	{
		// Position at 15 mm from bottom
    $this->SetY(-25);
		$this->SetFont('helvetica', '', 8);
		// Set font
		if($this->_jenis == '1') {
			$this->writeHTMLCell('', '', 15, '', '<p style="border-bottom:1px solid #000;"><b><i>Catatan:</i></b></p>', 0, 0, 0, true, 'J', true);
			$this->ln(4);
			$html = '<p>
									UU ITE No 11 Tahun 2008 Pasal 5 ayat 1 :<br>
									<i>"Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah."</i><br>
									Dokumen ini telah ditandatangani secara elektronik menggunakan <b>sertifikat elektronik</b> yang diterbitkan <b>BSrE</b>.<br>
									Dokumen ini dicetak melalui aplikasi <b>SPJ Online</b> dan dapat dipergunakan sebagai bukti yang sah.<br>
									Cetakan ini merupakan salinan dan <b>dapat dibuktikan keasliannya melalui scan QRCode</b> yang terdapat pada dokumen ini.
							 </p>';
			$this->writeHTMLCell(168, '', 15, '', $html, 0, 0, 0, true, 'J', true);
 			$style = array(
 				'border' => false,
 		    'hpadding' => 1,
 		    'fgcolor' => array(0,0,0),
 		    'bgcolor' => false
 			);
 			$this->write2DBarcode($this->_code, 'QRCODE,L', '', '', 50, 50, $style, 'N');
		} else if($this->_jenis == '2') {
			$this->writeHTMLCell('', '', 15, '', '<p style="border-bottom:1px solid #000;"><b><i>Catatan:</i></b></p>', 0, 0, 0, true, 'J', true);
			$this->ln(4);
			$html = '<p>
								Dokumen ini dicetak melalui aplikasi <b>SPJ Online</b> dan dapat dipergunakan sebagai bukti yang sah.<br>
								Cetakan ini merupakan salinan dan <b>dapat dibuktikan keasliannya melalui scan QRCode</b> yang terdapat pada dokumen ini.
						  </p>';
			$this->writeHTMLCell(168, '', 15, '', $html, 0, 0, 0, true, 'J', true);
 			$style = array(
 				'border' => false,
 		    'hpadding' => 1,
 		    'fgcolor' => array(0,0,0),
 		    'bgcolor' => false
 			);
 			$this->write2DBarcode($this->_code, 'QRCODE,L', '', '', 50, 50, $style, 'N');
		} else {
			$this->writeHTMLCell('', '', 15, '', '<p></p>', 0, 0, 0, true, 'J', true);
		}
	}
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
