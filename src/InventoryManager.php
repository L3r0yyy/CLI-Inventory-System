<?php

namespace Leroy\CliInventorySystem;

class InventoryManager
{
    private array $items = [];

    public function addItem(string $name, int $quantity): void
    {
        if (isset($this->items[$name])) {
            $this->items[$name] += $quantity;
        } else {
            $this->items[$name] = $quantity;
        }
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
