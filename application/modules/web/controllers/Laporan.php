<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of laporan
 *
 * @author kominfo
 */

class Laporan extends MY_Controller {

   public function __construct()
   {
    parent::__construct();
        $this->load->model(array('model_laporan' => 'mlap'));
   }

    public function export()
    {   
        
        $tanggal       = escape($this->input->get('tanggal', TRUE));
        $jenis_agenda  = escape($this->input->get('jenis_agenda', TRUE));
        $penerima      = escape($this->input->get('penerima', TRUE));
      
        $this->export_to_pdf($tanggal, $jenis_agenda, $penerima);            
    }

    private function export_to_pdf($tanggal, $jenis_agenda, $penerima)
    {
        $tahun = substr($tanggal,0,4);
        $bulan = substr($tanggal,5,2); 
        $nama = $this->mlap->getNamaUserByToken($penerima);

        $title = 'Daftar Agenda '.$nama.' '.bulan($bulan).' '.$tahun.' ';

        //set pdf
        $pdf = new pdf();
        //set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Diskominfo Pemprov Sumatera Barat');
        $pdf->SetTitle('Daftar Agenda');
        $pdf->SetSubject('Daftar Agenda Pimpinan');
        $pdf->SetKeywords('Agenda, Diskominfo, Sumbar');
        //remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        //set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //set margins
        $pdf->SetMargins(5, 10, 5);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        //set default font subsetting mode
        $pdf->setFontSubsetting(true);
        //Set font
        $pdf->SetAutoPageBreak(TRUE, 3);
        //Add a page
        $pdf->AddPage('L', 'F4');
        $pdf->SetFont('times', '', 11);
        $pdf->writeHTMLCell(0, 0, 10, '', '<p style="text-indent: 0.3in;text-align: center;">'.$title.'</p>', 0, 0, 0, true, 'L', true);
        $pdf->ln(12);
                
        $html = '<table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                                <td style="width:5%;" align="center"><b>No.</b></td>
                                <td style="width:10%;" align="center"><b>NAMA AGENDA</b></td>
                                <td style="width:10%;" align="center"><b>JAM MULAI</b></td>
                                <td style="width:10%;" align="center"><b>JAM SELESAI</b></td>
                                <td style="width:10%;" align="center"><b>KEGIATAN</b></td>
                                <td style="width:10%;" align="center"><b>LOKASI KEGIATAN</b></td>
                                <td style="width:10%;" align="center"><b>PENYELENGGARA</b></td>
                                <td style="width:10%;" align="center"><b>CP</b></td>
                                <td style="width:10%;" align="center"><b>DIHADIRI</b></td>
                                <td style="width:10%;" align="center"><b>KETERANGAN</b></td>
                            </tr>';
        $n = 1;
        
            $total = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

            for ($i=1; $i <= $total; $i++) 
            {   
                   $tglAgenda = $tanggal.'-'.$i;
                   $dataAgenda = $this->mlap->getDataAgenda($tglAgenda, $jenis_agenda, $penerima);
                   
                   $html .= '<tr><td colspan="10" style="background:#ccc;"> <strong> Tanggal : '.$tglAgenda.'</strong> </td></tr>';

                   if(count($dataAgenda) > 0) 
                   {    
                        foreach ($dataAgenda as $key => $dh) {
                            $html .= '<tr>';
                                $html .= '<td style="width:5%;text-align:center;">'.$n.'.</td>';
                                $html .= '<td style="width:10%;text-align:center;">'.$dh['nama_agenda'].'</td>';
                                $html .= '<td style="width:10%;">'.$dh['jam_mulai'].'</td>';
                                $html .= '<td style="width:10%;">'.$dh['jam_selesai'].'</td>';
                                $html .= '<td style="width:10%;">'.$dh['kegiatan'].'</td>';
                                $html .= '<td style="width:10%;">'.$dh['lokasi_kegiatan'].'</td>';
                                $html .= '<td style="width:10%;">'.$dh['penyelenggara'].'</td>';
                                $html .= '<td style="width:10%;">'.$dh['cp'].'</td>';
                                $html .= '<td style="width:10%;">'.$this->mlap->getStatusAgenda($dh['id_status']).'</td>';
                                $html .= '<td style="width:10%;">'.$dh['keterangan'].'</td>';
                                
                            $html .= '</tr>';
                            $n++;
                        }
                   }
                   else
                   {
                        $html .= '<tr><td colspan="10">Data Belum Ada </td></tr>';
                   }                    
            }
            
        
        $html .= '</table>';
        $pdf->writeHTMLCell(0, 0, 10, '', $html, 0, 0, 0, true, 'L', true);
        $pdf->lastPage();
        //---------------------------------------------------------
        //Close and output PDF document
        $pdf->Output('daftar_agenda_'.$tanggal.'.pdf','D');
        //---------------------------------------------------------
    }

    

}

// This is the end of home clas
