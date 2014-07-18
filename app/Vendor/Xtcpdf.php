<?php
App::uses('TCPDF', 'Vendor/tcpdf');

class Xtcpdf extends TCPDF
{

    var $xheadertext  = '';
    var $xheadercolor = array(255,255,255);
    var $xfootertext  = 'Copyright © %d XXXXXXXXXXX. All rights reserved.';
    var $xfooterfont  = PDF_FONT_NAME_MAIN ;
    var $xfooterfontsize = 8 ;


    /**
    * Overwrites the default header
    * set the text in the view using
    *    $fpdf->xheadertext = 'YOUR ORGANIZATION';
    * set the fill color in the view using
    *    $fpdf->xheadercolor = array(0,0,100); (r, g, b)
    * set the font in the view using
    *    $fpdf->setHeaderFont(array('YourFont','',fontsize));
    */
    function Header()
    {

        list($r, $b, $g) = $this->xheadercolor;
		$this->SetFillColor($r, $b, $g);
        $this->SetTextColor(0 , 0, 0);
		$this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);
		
		$this->Cell(0, 22, 'Pág. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 1, 'R', 1);
        //$this->setY(20); // shouldn't be needed due to page margin, but helas, otherwise it's at the page top
		//$this->Cell(0, 5, 'Centro de Procesamiento Digital de Imágenes - (CPDI)', 0,1,'C', 1);
		$orientation = $this->getOrientation();
		switch ($orientation) {
			case 'P':
				$this->Image(K_PATH_IMAGES.'cintilloP.png', 15, 10, 185);
				break;
			case 'L':
				$this->Image(K_PATH_IMAGES.'cintilloL.png', 15, 10, 249);
				break;
			
			default:
				
				break;
		}
		
		//$this->Image(K_PATH_IMAGES.'logo_fonder.png', 170, 8, 30);
		
    }

    /**
    * Overwrites the default footer
    * set the text in the view using
    * $fpdf->xfootertext = 'Copyright © %d YOUR ORGANIZATION. All rights reserved.';
    */
    function Footer()
    {
        $year = date('Y');
        $footertext = sprintf($this->xfootertext, $year);
        $this->SetY(-20);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->xfooterfont,'B',8);
        $this->Cell(0,3, "Fundación Instituto de Ingenieria - Centro de Procesamiento Digital de Imágenes",'T',1,'C');
        $this->SetFont($this->xfooterfont,'',7);
        $this->Cell(0,3, "Carretera Baruta Hoyo de la Puerta, Sartenejas, entrada Tecnopolis.",'',1,'C');
		$this->Cell(0,3, "Teléfonos: (58212) 903 46 10 Fax: (58212) 903 47 83",0,1,'C');
		$this->Cell(0,3, "www.fii.org.ve",0,1,'C');
		//$this->Image(K_PATH_IMAGES.'gobierno_bolivariano.jpg', 10, 280, 30);
		//$this->Image(K_PATH_IMAGES.'logo_gobernacion.png', 170, 278, 25);
    }

	/**
	 * Returns the current page orientation.
	 * @return current page orientation
	 * @public
	 * @since 3.2.000 (2008-06-23)
	 */
	public function getOrientation() {
		return $this->CurOrientation;
	}
}
?>