<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
define('EURO', chr(128) );
define('EURO_VAL', 6.55957 );
define('IVA',22);


// Xavier Nicolay 2004
// Version 1.02

//////////////////////////////////////
// Public functions                 //
//////////////////////////////////////
//  function sizeOfText( $texte, $larg )
//  function addSociete( $nom, $adresse )
//  function fact_dev( $libelle, $num )
//  function addDevis( $numdev )
//  function addFacture( $numfact )
//  function addDate( $date )
//  function addClient( $ref )
//  function addPageNumber( $page )
//  function addClientAdresse( $adresse )
//  function addReglement( $mode )
//  function addEcheance( $date )
//  function addNumTVA($tva)
//  function addReference($ref)
//  function addCols( $tab )
//  function addLineFormat( $tab )
//  function lineVert( $tab )
//  function addLine( $ligne, $tab )
//  function addRemarque($remarque)
//  function addCadreTVAs()
//  function addCadreEurosFrancs()
//  function addTVAs( $params, $tab_tva, $invoice )
//  function temporaire( $texte )

class PDF_Invoice extends TCPDF
{

            function __construct()
           {
               parent::__construct();

           }

           // private variables
           var $colonnes;
           var $format;
           var $angle=0;

           
            // Colored table
        public function tableData($header,$data) {
            // Colors, line width and bold font
            $this->SetFillColor(255, 0, 0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128, 0, 0);
            $this->SetLineWidth(0.3);
            $this->SetFont('Helvetica', 'B');
            // Header
            $w = array(20,45,25,35,35);
            $num_headers = count($header);
            for($i = 0; $i < $num_headers; ++$i) {
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
            }
            $this->Ln();
            // Color and font restoration
            $this->SetFillColor(224, 235, 255);
            $this->SetTextColor(0);
            $this->SetFont('');
            // Data
            $fill = 0;
            foreach($data as $row) {
                $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
                $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
                $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
                $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
                $this->Cell($w[4], 6, number_format($row[4]), 'LR', 0, 'R', $fill);
                $this->Ln();
                $fill=!$fill;
            }
            $this->Cell(array_sum($w), 0, '', 'T');
        }
        
        /**
         * Verifica che la pagina non sia già occupata nel completo
         * se sei va alla pagina successiva
         */
        public function controllaMargine($gap=120,$message=null){
             
                    $pagina=$this->getPage();
                    
                    $altezzapagina  = $this->getPageHeight();
                    $cursorex       =      $this->GetY();

                    if(($altezzapagina-$cursorex)<=$gap){
                        
                        if($message!=null){
                            $this->writeHTMLCell(0,0,'','',$message,0,1, 0, true, 'C', true);
                        }
                        
                        $this->AddPage();
                    }
        }
        
        
        public function tableRow($rows,$colore=null,$misure=null){
            
            $pagina=$this->getPage();
            
            $altezzapagina=$this->getPageHeight();
            $cursorex=$this->GetY();
            
            if(($altezzapagina-$cursorex)<=80){
                
                if(($altezzapagina-$cursorex)>80){
                    $this->Ln(10);
                    //$this->writeHTML("<h3>".t("continua-su-pdf")."</h3>",true,false,false,'','C');
                }
                
                $this->AddPage();
                
            }
            
            if($colore!=null){
                $this->SetFillColor($colore[0],$colore[1],$colore[2]);
            }else{
                $this->SetFillColor(255,255,255);
            }
            
            $this->SetTextColor(0,0,0);
            $this->SetDrawColor(130,120,130);
            $this->SetLineWidth(0.2);
            $this->SetFont('helvetica',null,10);
            
            $num_headers = count($rows);
            if($misure==null){
                $w = array(65,290,90,50,40,100);
            }else{
                $w = $misure;
            }
                
            $html="<style type='text/css'>"
                    . " table{ border: 1px solid #ddd;width: 100%;} "
                    . " table > tr > td{ display: cell-row; border: 1px solid #ddd;padding: 12px;vertical-align: top;}"
                    . " p, span.label{ margin: 0px!important;line-height: 10px;padding: 0px!important;clear: both; }"
                    . " .descrizione{"
                    . " "
                    . " max-width: 200px;"
                    . " "
                    . "} "
                    . "table > tr > td > img{ max-height: 120px!important;width: 90%;}"
                    . "</style><table border=\"0\" cellspacing=\"0\" cellpadding=\"8\" ><tr>";
            for($i = 0; $i < $num_headers; ++$i) {
                $html.="<td width=\"".$w[$i]."\">".$rows[$i]."</td>";
            }
            
            $html.="</tr></table>";
            
            $this->writeHTMLCell(0,0,'','',$html,0,1, 0, true, 'L', true);
            
            
            
        }


}