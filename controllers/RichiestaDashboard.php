<?php


class RichiestaDashboard  extends CI_Controller {
    
    
    
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->helper('Persistenza/AmbienteCrud');
        $this->load->helper('Persistenza/RilevazioneCrud');       
        $this->load->helper('Persistenza/EccezioneCrud');    
        
        $this->load->library('session');
    }
    
    public function index() {
        
        $idUtente = $this->session->id;
        
        $ambienti = $this->ListaAmbienti($idUtente);
        
        $impianti = $this->ListaImpianti($ambienti);
        
        $impiantoRandom = $impianti[rand(0,count($impianti)-1)];
        
        // per il test è necessario passare l'impianto    
        $this->testCaseInserisciRilevazioni($impiantoRandom); 
        $this->testCaseInserisciEccezioni($impiantoRandom); 
        
        $dataInizio = date('Y-m-d H:i:s', strtotime('-24 hour'));
        
        $serieDiImpianti = array();
        
        foreach ($impianti as $impianto) {

            $listRil = $this->ListaRilevazioni(array($impianto), $dataInizio, date('Y-m-d H:i:s'));

            

            if (count($listRil)!=0)
                $serieDiImpianti[$impianto->idImpianto.' - '.$impianto->descrizione] = $this->CreaSeriePerGrafico($listRil);
            
        }

        
        $listEcc = $this->ListaEccezioni($impianti, $dataInizio, date('Y-m-d H:i:s'));
        
        // qui mettere la pagina del dashboard
        $this->template->load('admin/dashboard', array('grafici'=>$serieDiImpianti, 'eccezioni'=>$listEcc));
        
    }
    
    private function testCaseInserisciRilevazioni($impianto) {
        $rilevazioneCrud = new RilevazioneCrud();
        
        $rilevazioneRandom = new Rilevazione();
        
        $rilevazioneRandom->dataOra = date('Y-m-d H:i:s', strtotime('-'.rand(0,23).' hour'));
        $rilevazioneRandom->idImpianto = $impianto->idImpianto;
        $rilevazioneRandom->idSensore = rand(1, 9);
        $rilevazioneRandom->valore = rand(0, 7);
        $rilevazioneRandom->note = 'no';
        
        $rilevazioneCrud->ScriviRilevazione($rilevazioneRandom);
    }
    
    private function testCaseInserisciEccezioni($impianto) {
        $eccezioneCrud = new EccezioneCrud();
        
        $eccezioneRandom = new Eccezione();
        
        $eccezioneRandom->dataOra = date('Y-m-d H:i:s', strtotime('-'.rand(0,23).' hour'));
        $eccezioneRandom->idImpianto = $impianto->idImpianto;
        $eccezioneRandom->idSensore = rand(1, 9);
        $eccezioneRandom->note = 'no';
        
        $eccezioneCrud->ScriviEccezione($eccezioneRandom);
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
    
    
    
    
    public function CreaSeriePerGrafico($listaRilevazioni){
        // contiene List<Rilevazione>
        
        $this->load->model('SerieGrafico');
        
        $listaSerie = array();
                
        foreach ($listaRilevazioni as $rilevazione) {
            if (!isset($listaSerie[$rilevazione->idSensore])) 
            {
                $listaSerie[$rilevazione->idSensore] = new SerieGrafico();
                $listaSerie[$rilevazione->idSensore]->tipoGrafico = $rilevazione->sensore;
            }
            
            $sg = $listaSerie[$rilevazione->idSensore];
            
            if (count($sg->ascisse)==0) {
                for($i=date('G');$i<24;$i++) $sg->ascisse[] = $i;
                for($i=0;$i<date('G');$i++) $sg->ascisse[] = $i;
            }
                
            
            if (count($sg->ordinate)==0) {
                for($i=date('G');$i<24;$i++) $sg->ordinate[$i] = 0;
                for($i=0;$i<date('G');$i++) $sg->ordinate[$i] = 0;
            }
                
            
                        
 
            $ora = date('G', strtotime($rilevazione->dataOra));
            $sg->ordinate[$ora] = $rilevazione->valore;

        }

        
        
        return $listaSerie;
    }
    
}