<?php
class PokemonAPI {
    private const API_BASE_URL = 'https://pokeapi.co/api/v2/';
    private const CACHE_DURATION = 86400; 
    
 
    public function getPokemonData($nameOrId) {
        
        $nameOrId = strtolower($nameOrId);
        
        
        $cacheFile = __DIR__ . "/cache/pokemon_{$nameOrId}.json";
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < self::CACHE_DURATION)) {
            return json_decode(file_get_contents($cacheFile), true);
        }
        
        
        $url = self::API_BASE_URL . 'pokemon/' . $nameOrId;
        $response = @file_get_contents($url);
        
        if ($response === false) {
            error_log("Erreur lors de la récupération des données pour le Pokémon: $nameOrId");
            return null;
        }
        
       
        if (!is_dir(__DIR__ . '/cache')) {
            mkdir(__DIR__ . '/cache', 0777, true);
        }
        file_put_contents($cacheFile, $response);
        
        return json_decode($response, true);
    }
    

    public function getPokemonImageUrl($pokemonData) {
        return $pokemonData['sprites']['front_default'] ?? '';
    }
    

    public function getPokemonStats($pokemonData) {
        $stats = [];
        foreach ($pokemonData['stats'] as $stat) {
            $stats[$stat['stat']['name']] = $stat['base_stat'];
        }
        return $stats;
    }
}