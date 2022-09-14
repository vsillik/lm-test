<?php

namespace App\Model;

use Nette;

final class RecipeFacade
{
    use Nette\SmartObject;

    public function __construct(private readonly \Nette\Database\Explorer $explorer)
    {
    }

    public function get(string $id): Nette\Database\Table\ActiveRow|null
    {
        return $this->explorer->table('recipes')->get($id);
    }

    public function getAll(): Nette\Database\Table\Selection
    {
        return $this->explorer->table('recipes');
    }

    public function delete(string $id): int
    {
        return $this->explorer->table('recipes')->where('id', $id)->delete();
    }

    public function create(string $name, string $ingredients, string $preparation_process): Nette\Database\Table\ActiveRow
    {
        return $this->explorer->table('recipes')->insert([
           'name' => $name,
           'ingredients' => $ingredients,
           'preparation_process' => $preparation_process
        ]);
    }
}