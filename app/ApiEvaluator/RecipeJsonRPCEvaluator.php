<?php

namespace App\ApiEvaluator;

use App\Model\RecipeFacade;
use App\Utils\UUIDValidator;
use Datto\JsonRpc\Evaluator;
use Datto\JsonRpc\Exceptions\MethodException;
use Datto\JsonRpc\Exceptions\ArgumentException;

class RecipeJsonRPCEvaluator implements Evaluator
{
    public function __construct(private readonly RecipeFacade $facade)
    {
    }

    public function evaluate($method, $arguments)
    {
        return match ($method) {
            'recipe.create' => $this->create($arguments),
            'recipe.get' => $this->get($arguments),
            'recipe.getAll' => $this->getAll($arguments),
            'recipe.delete' => $this->delete($arguments),
            default => throw new MethodException()
        };
    }

    private function create(array $arguments): array
    {
        if (!array_key_exists('name', $arguments) ||
            !array_key_exists('ingredients', $arguments) ||
            !array_key_exists('preparation_process', $arguments)) {
            throw new ArgumentException();
        }

        $id = $this->facade->create($arguments['name'], $arguments['ingredients'], $arguments['preparation_process']);

        return [
            "id" => $id
        ];
    }

    private function get(array $arguments): array
    {
        if (!array_key_exists('id', $arguments) ||
            !UUIDValidator::validate($arguments['id'])) {
            throw new ArgumentException();
        }

        $row = $this->facade->get($arguments['id']);

        if ($row === null) {
            return [];
        }

        return RecipeFacade::rowToArray($row);
    }

    private function getAll(array $arguments): array
    {
        $rows = $this->facade->getAll();

        $result = [];

        foreach ($rows as $row) {
            $result[] = RecipeFacade::rowToArray($row);
        }

        return $result;
    }

    private function delete(array $arguments): array
    {
        if (!array_key_exists('id', $arguments) ||
            !UUIDValidator::validate($arguments['id'])) {
            throw new ArgumentException();
        }

        $affected = $this->facade->delete($arguments['id']);

        return [
            'deleted' => $affected > 0
        ];
    }
}