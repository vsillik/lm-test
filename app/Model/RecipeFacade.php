<?php

namespace App\Model;

use App\Utils\UUIDValidator;
use Nette;
use Tracy\Debugger;

final class RecipeFacade
{
    use Nette\SmartObject;

    public function __construct(private readonly Nette\Database\Connection $database,
                                private readonly \Nette\Database\Explorer $explorer)
    {
    }

    public function get(string $id): Nette\Database\Table\ActiveRow|null
    {
        if (!UUIDValidator::validate($id)) {
            throw new \InvalidArgumentException("Given ID is not uuid");
        }

        return $this->explorer->table('recipes')->get($id);
    }

    public function getAll(): Nette\Database\Table\Selection
    {
        return $this->explorer->table('recipes');
    }

    public function delete(string $id): int
    {
        if (!UUIDValidator::validate($id)) {
            throw new \InvalidArgumentException("Given ID is not uuid");
        }

        return $this->explorer->table('recipes')->where('id', $id)->delete();
    }

    public function create(string $name, string $ingredients, string $preparation_process): string
    {
        $result = $this->database->query('INSERT INTO recipes ? RETURNING id', [
            'name' => $name,
            'ingredients' => $ingredients,
            'preparation_process' => $preparation_process
        ]);

        return $result->fetchField();
    }

    public static function rowToArray(Nette\Database\Table\ActiveRow $row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
            'ingredients' => $row->ingredients,
            'preparation_process' => $row->preparation_process
        ];
    }
}