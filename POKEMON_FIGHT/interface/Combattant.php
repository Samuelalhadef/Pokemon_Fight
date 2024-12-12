<?php

interface Combattant {
    public function attaquer(Pokemon $adversaire): void;
    public function utiliserAttaqueSpeciale(Pokemon $adversaire): void;
    public function estKo(): bool;
    public function soigner(): void;
}
