<?php



class RichiestaReport extends CI_Controller {
    
    
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->helper('Persistenza/AmbienteCrud');
        $this->load->helper('Persistenza/RilevazioneCrud');       
        $this->load->helper('Persistenza/EccezioneCrud');    
        
        $this->load->library('session');
        
    }
    
    public function index() {
        
        if (isset($this->input->post()["dataDa"]) && isset($this->input->post()["dataA"])) 
            $this->RichiestaReport($this->input->post()["dataDa"], $this->input->post()["dataA"]);
        else
            $this->RichiestaReport(date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
        
        
    }
    
    
    
    public function RichiestaReport($dataDa, $dataA) {
        
                
        // ritorna Lista<Report>
        
        $idUtente = $this->session->id;
        
        $ambienti = $this->ListaAmbienti($idUtente);
        
        $impianti = $this->ListaImpianti($ambienti);
        
        $listRil = $this->ListaRilevazioni($impianti, $dataDa, $dataA);
        
        $listEcc = $this->ListaEccezioni($impianti, $dataDa, $dataA);
        
        // qui mettere la pagina del dashboard
        $this->template->load('admin/report', array('rilevazioni'=>$listRil, 'eccezioni'=>$listEcc));
        
    }
    
    public function ListaAmbienti($idUtente) {
        
        
        // ritorna Lista<Ambiente>
        $ambienteCrud = new AmbienteCrud();
        
        return $ambienteCrud->ListaAmbienti($idUtente);
        
        
        
    }
    
    
    public function ListaImpianti($ambienti) {
        
        // $ambienti = array() of Ambiente
        
        // ritorna Lista<Impianto>
        
                // ritorna Lista<Ambiente>
        $ambienteCrud = new AmbienteCrud();
        
        $listaImpianti = array();
        
        foreach ($ambienti as $amb) {
            $listaImpianti = array_merge($listaImpianti, $ambienteCrud->ListaImpianti($amb->idAmbiente));
        }
        
        return $listaImpianti;
        
    }
    
    
    
    public function ListaRilevazioni ( $impianti, $dataDa, $dataA ) {
        
        //$impianti = array() of Impianto
        
        // ritorna Lista<Rilevazione>
        
        $listaRilevazioni = array();
        
        $rilevazioniCrud = new RilevazioneCrud();
        
        
        foreach ($impianti as $impianto) {
            $listaRilevazioni = array_merge($listaRilevazioni, $rilevazioniCrud->LeggiRilevazioniTempo($impianto->idImpianto, $dataDa, $dataA));
            
        }

        return $listaRilevazioni;

    }
    
    
   public function ListaEccezioni ( $impianti, $dataDa, $dataA ) {
        
        //$impianti = array() of Impianto
        
        // ritorna Lista<Eccezione>
        
        $listaEccezioni = array();
        
        $eccezioniCrud = new EccezioneCrud();
        
        
        foreach ($impianti as $impianto) {
            $listaEccezioni = array_merge($listaEccezioni, $eccezioniCrud->LeggiEccezioniTempo($impianto->idImpianto, $dataDa, $dataA));
        }
        
        return $listaEccezioni;        
    }
    
    
}