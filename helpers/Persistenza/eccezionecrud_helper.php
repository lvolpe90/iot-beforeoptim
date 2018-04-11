<?php



class EccezioneCrud {
    
    
    protected $ci;
    
        
    public function __construct() {
        $this->ci =& get_instance();

        $this->ci->load->database();
        
        $this->ci->db->query('CREATE TABLE IF NOT EXISTS eccezione (idSensore INTEGER, idImpianto INTEGER, dataora DATETIME, note TEXT, idEccezione INTEGER PRIMARY KEY)');
        
        $this->ci->db->query('CREATE TABLE IF NOT EXISTS impianto (idAmbiente INTEGER, descrizione TEXT, idImpianto INTEGER PRIMARY KEY)');
        
        $this->ci->db->query('CREATE TABLE IF NOT EXISTS sensore (tipo TEXT, marca TEXT, idSensore INTEGER PRIMARY KEY)');
        
        $this->ci->db->query('CREATE TABLE IF NOT EXISTS sensore_impianto (idSensore INTEGER, idImpianto INTEGER, idSensoreImpianto PRIMARY KEY)');

        
        
        $this->ci->load->model('Impianto');
        $this->ci->load->model('Sensore');
        $this->ci->load->model('Eccezione');
        

    }
    
    
    public function ScriviEccezione($e) {
        $this->ci->db->insert('eccezione', $e);
    }
    
    
    public function LeggiEccezione($idEccezione) {
        
        // ritorna Eccezione
        
        return $this->ci->db->get_where('eccezione', array('idEccezione'=>$idEccezione))->result('Eccezione');
        
    }
    
    
    public function LeggiEccezioni($idImpianto) {
        
    }
    
    
    public function LeggiEccezioniTempo($idImpianto, $dataDa, $dataA) {
        
        
        
    }
    
    
}