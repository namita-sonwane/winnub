<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generatore extends CI_Controller {
    
        
        

        public function scarica($tipo,$codice){



                 $this->load->library("PDF_Invoice");

                 $preventivo=$this->user->getPreventivo($codice);
                 $preventivo=$preventivo[key($preventivo)];   

                 $modello=$preventivo->getCarrello();

                 //print_r($modello);

                 //il modello del carrello è l'insieme degli oggetti caricati dentro
                 //si trattà di un'array di elementi

                  $nomeazienda="Nome azienda..";

                  $code=($codice);
                 // create a PDF object
                  $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                 // set document (meta) information
                  $pdf->SetCreator(PDF_CREATOR);
                  $pdf->SetAuthor('Winnub creator B2B');
                  $pdf->SetTitle($nomeazienda.'  Invoice ');
                  $pdf->SetSubject('Invoice - '.$code);


                 // add a page
                  $pdf->AddPage();


                 // test Cell stretching
                  $pdf->Cell(0,25, 'NOME AZIENDA ',0,1,'L',0,'');

                  $pdf->Cell(0,20, 'Intestazione',1,1,'C',0,'');

                  $pdf->Ln(5);

                  $start_row=5;

                  foreach($modello as $items){

                      $itemprod=$this->modello_prodotti->getArticoloCarrello($items["modello"]);
                      $testo=$itemprod->nome;

                      $misure=" ".$items["larghezza"]." X ".$items["altezza"];

                      $img=($itemprod->foto);
                      $pdf->Image($img,null,null,0,40);


                      $pdf->Text(0,60,$itemprod->nome,1,'C');


                      $pdf->Cell(0,60,$testo,1,2);



                      $pdf->Ln(45);
                  }

                  // some payment instructions or information

                  $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
                  $pdf->MultiCell(175, 10, '<em>Lorem ipsum dolor sit amet, consectetur adipiscing elit</em>. Vestibulum sagittis venenatis urna, in pellentesque ipsum pulvinar eu. In nec <a href="http://www.google.com/">nulla libero</a>, eu sagittis diam. Aenean egestas pharetra urna, et tristique metus egestas nec. Aliquam erat volutpat. Fusce pretium dapibus tellus.', 0, 'L', 0, 1, '', '', true, null, true);

                    //Close and output PDF document

                  $pdf->Output(time()."_".$codice.'_invoice.pdf','D');



                    $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );

                    $pdf->AddPage();

                    $pdf->Output();


                    _report_log(array("message"=>"Richiedo download documento : ".$codice." "));


                    exit();
        }

      
      
}