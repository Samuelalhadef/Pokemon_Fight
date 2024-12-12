<?php
class Combat {
    private Pokemon $pokemon1;
    private Pokemon $pokemon2;
    private int $tourActuel = 1;
    private int $joueurActif = 1; // 1 pour pokemon1, 2 pour pokemon2

    public function __construct(Pokemon $pokemon1, Pokemon $pokemon2) {
        $this->pokemon1 = $pokemon1;
        $this->pokemon2 = $pokemon2;
    }

    public function getPokemon1(): Pokemon {
        return $this->pokemon1;
    }

    public function getPokemon2(): Pokemon {
        return $this->pokemon2;
    }

    public function getTourActuel(): int {
        return $this->tourActuel;
    }

    public function getJoueurActif(): int {
        return $this->joueurActif;
    }

    public function tourDeCombat(string $action, Pokemon $attacker, Pokemon $defender): string {
        $message = "Tour {$this->tourActuel} - ";
        
        // Vérifier si c'est bien le tour du bon joueur
        $pokemonActif = $this->joueurActif === 1 ? $this->pokemon1 : $this->pokemon2;
        if ($attacker !== $pokemonActif) {
            return "Ce n'est pas votre tour !";
        }

        // Gestion des actions
        switch ($action) {
            case 'Attaquer':
                $attacker->attaquer($defender);
                $message .= "{$attacker->getNom()} attaque {$defender->getNom()} !";
                break;

            case 'Attaque Spéciale':
                $attacker->utiliserAttaqueSpeciale($defender);
                $message .= "{$attacker->getNom()} utilise son attaque spéciale !";
                break;

            case 'Soigner':
                $attacker->soigner();
                $message .= "{$attacker->getNom()} se soigne !";
                break;

            default:
                return "Action inconnue.";
        }

        if ($defender->estKo()) {
            $message .= "\n{$defender->getNom()} est KO !";
        }

        // Changer de joueur actif
        $this->joueurActif = $this->joueurActif === 1 ? 2 : 1;
        
        // Incrémenter le compteur de tours quand les deux joueurs ont joué
        if ($this->joueurActif === 1) {
            $this->tourActuel++;
        }

        return $message;
    }

    public function estTermine(): bool {
        return $this->pokemon1->estKo() || $this->pokemon2->estKo();
    }

    public function getVainqueur(): ?Pokemon {
        if ($this->pokemon1->estKo()) {
            return $this->pokemon2;
        } elseif ($this->pokemon2->estKo()) {
            return $this->pokemon1;
        }
        return null;
    }
}