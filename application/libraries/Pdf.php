<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Header()
    {
        if ($this->page == 1) {
            
        }
    }

    public function Footer()
    {
        
    }
}

class Pdf_Polos extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Header()
    {
    }

    // Page footer
    public function Footer()
    {
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Halaman '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    
}
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
