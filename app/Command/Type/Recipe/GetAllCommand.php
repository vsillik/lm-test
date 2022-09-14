<?php

namespace App\Command\Type\Recipe;

use App\Command\DTO\Recipe\GetAllCommandDTO;
use App\Model\RecipeDTO;
use App\Model\RecipeFacade;
use Contributte\JsonRPC\Command\ICommandDTO;
use Contributte\JsonRPC\Response\IResponse;
use Contributte\JsonRPC\Response\Type\SuccessResponse;

class GetAllCommand implements \Contributte\JsonRPC\Command\ICommand
{
    public function __construct(private readonly RecipeFacade $facade)
    {
    }

    public function getCommandDTOClass(): string
    {
        return GetAllCommandDTO::class;
    }

    public function execute(ICommandDTO $commandDTO): IResponse
    {
        if (!$commandDTO instanceof GetAllCommandDTO) {
            throw new \InvalidArgumentException("Invalid instance of DTO given");
        }

        $rows = $this->facade->getAll();

        $response = new \stdClass();
        $response->recipes = [];

        foreach ($rows as $row) {
            $response->recipes[] = (object) new RecipeDTO($row->id, $row->name, $row->ingredients, $row->preparation_process);
        }

        return new SuccessResponse($response);
    }
}