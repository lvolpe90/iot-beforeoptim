<?php


public class RichiestaDashboard {
    
    
    
    public function index() {
        
        
    }
    
    
    public function ListaAmbienti($utente) {
        
        
        // ritorna Lista<Ambiente>
        
        
    }
    
    
    public function ListaImpianti($ambienti) {
        
        // $ambienti = array() of Ambiente
        
        // ritorna Lista<Impianto>
        
    }
    
    
    
    public function ListaRilevazioni ( $impianti, $dataDa, $dataA ) {
        
        //$impianti = array() of Impianto
        
        // ritorna Lista<Rilevazione>
    }
    
    
    
    public function ListaEccezioni ( $impianti, $dataDa, $dataA ) {
        
        //$impianti = array() of Impianto
        
        // ritorna Lista<Eccezione>
    }
    
    
    
    
    public function CreaSeriePerGrafico ( $listaRilevazioni, $listaEccezioni  )  {
        
        
        // ritorna Lista<SerieGrafico>
    }
    
}