<?php

namespace App\Card;

class Card
{
    // nedan är spader. lägg till resten
    private $representation = [
        '🂡',
        '🂢',
        '🂣',
        '🂤',
        '🂥',
        '🂦',
        '🂧',
        '🂨',
        '🂩',
        '🂪',
        '🂫',
        '🂬',
        '🂭',
        '🂮',
        '🂱'
    ];
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->representation[$this->value - 1];
    }
}
