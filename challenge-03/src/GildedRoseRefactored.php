<?php

namespace App;

class GildedRose
{
    public $name;
    public $quality;
    public $sellIn;

    // Constructor para inicializar propiedades
    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    // Método estático para crear un objeto de manera conveniente
    public static function of($name, $quality, $sellIn)
    {
        return new static($name, $quality, $sellIn);
    }

    // Actualiza el estado del ítem en un "tick" (día que pasa)
    public function tick()
    {
        switch (true) {
            // Ítem legendario que no cambia
            case $this->isSulfuras():
                return;

            // Brie que mejora con el tiempo    
            case $this->isAgedBrie():
                $this->updateAgedBrie();
                break;

            // Entradas que aumentan y luego pierden calidad    
            case $this->isBackstagePass():
                $this->updateBackstagePass();
                break;

            // Ítems conjurados que se deterioran rápido    
            case $this->isConjured():
                $this->updateConjured();
                break;

            // Ítems normales    
            default:
                $this->updateNormal();
                break;
        }
    }

    // Comprueba si es ítem Sulfuras
    private function isSulfuras(): bool
    {
        return $this->name === 'Sulfuras, Hand of Ragnaros';
    }

    // Comprueba si es Aged Brie
    private function isAgedBrie(): bool
    {
        return $this->name === 'Aged Brie';
    }

    // Comprueba si es Backstage pass
    private function isBackstagePass(): bool
    {
        return str_starts_with($this->name, 'Backstage passes');
    }

    // Comprueba si es Conjured
    private function isConjured(): bool
    {
        return str_starts_with($this->name, 'Conjured');
    }

    // Incrementa la calidad respetando el máximo de 50
    private function increaseQuality(int $amount = 1): void
    {
        $this->quality = min(50, $this->quality + $amount);
    }

    // Disminuye la calidad sin que baje de 0
    private function decreaseQuality(int $amount = 1): void
    {
        $this->quality = max(0, $this->quality - $amount);
    }

    // Actualiza ítem normal
    private function updateNormal(): void
    {
        $this->decreaseQuality();
        $this->sellIn--;
        if ($this->sellIn < 0) {
            $this->decreaseQuality();
        }
    }

    // Actualiza Aged Brie
    private function updateAgedBrie(): void
    {
        $this->increaseQuality();
        $this->sellIn--;
        if ($this->sellIn < 0) {
            $this->increaseQuality();
        }
    }

    // Actualiza Backstage Pass
    private function updateBackstagePass(): void
    {
        $this->increaseQuality();
        if ($this->sellIn <= 10) {
            $this->increaseQuality();
        }
        if ($this->sellIn <= 5) {
            $this->increaseQuality();
        }
        $this->sellIn--;
        if ($this->sellIn < 0) {
            $this->quality = 0;
        }
    }

    // Actualiza ítem Conjured
    private function updateConjured(): void
    {
        $this->decreaseQuality(2);
        $this->sellIn--;
        if ($this->sellIn < 0) {
            $this->decreaseQuality(2);
        }
    }
}
