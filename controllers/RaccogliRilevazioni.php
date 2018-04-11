<?php 


class RaccogliRilevazioni  extends CI_Controller {
    
    public function index() {
        
        
       
    }
    
    
    public function RaccogliRilevazione($id_sensore, $dataora, $valore, $note = FALSE) {
        
        
        // ritorna
        
        $this->load->helper('Persistenza/AmbienteCrud');
        $this->load->helper('Persistenza/RilevazioneCrud');
        
        $ambienteCrud = new AmbienteCrud();
        
        $crud = new RilevazioneCrud();
        
        $nuova_ril = new Rilevazione();
        
        $nuova_ril->dataOra = $dataora;
        $nuova_ril->valore = $valore;
        $nuova_ril->note = $note;
        $nuova_ril->sensore  = new Sensore();
        $nuova_ril->sensore->idSensore = $id_sensore;
        $nuova_ril->idSensore = $id_sensore;
        
        
        $idImpianto = $ambienteCrud->GetImpiantoBySensore($id_sensore);
        
        $nuova_ril->idImpianto = $idImpianto;
        
        $crud->ScriviRilevazione($nuova_ril);
        
//        echo json_encode($crud->LeggiRilevazione(1));
//        exit();
        
        return $nuova_ril;
        
    }
    
    public function RaccogliEccezione($id_sensore, $dataora, $note = FALSE) {
        
        // ritorna Eccezione
        
        $this->load->helper('Persistenza/AmbienteCrud');
        $this->load->helper('Persistenza/EccezioneCrud');
        
        $ambienteCrud = new AmbienteCrud();
        
        $crud = new EccezioneCrud();
        
        $nuova_ecc = new Eccezione();
        
        $nuova_ecc->dataOra = $dataora;
        $nuova_ecc->note = $note;
        $nuova_ecc->sensore  = new Sensore();
        $nuova_ecc->sensore->idSensore = $id_sensore;
        $nuova_ecc->idSensore = $id_sensore;
        
        $idImpianto = $ambienteCrud->GetImpiantoBySensore($id_sensore);
        
        $nuova_ecc->idImpianto = $idImpianto;
        
        $crud->ScriviEccezione($nuova_ecc);

        return $nuova_ecc;
        
    }
    
    
}