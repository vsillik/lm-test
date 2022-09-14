<?php

namespace App\Command\Type\Recipe;

use App\Command\DTO\Recipe\CreateCommandDTO;
use App\Model\RecipeDTO;
use App\Model\RecipeFacade;
use Contributte\JsonRPC\Command\ICommandDTO;
use Contributte\JsonRPC\Response\IResponse;
use Contributte\JsonRPC\Response\Type\SuccessResponse;

class CreateCommand implements \Contributte\JsonRPC\Command\ICommand
{
    public function __construct(private readonly RecipeFacade $facade)
    {
    }

    public function getCommandDTOClass(): string
    {
        return CreateCommandDTO::class;
    }

    public function execute(ICommandDTO $commandDTO): IResponse
    {
        if (!$commandDTO instanceof CreateCommandDTO) {
            throw new \InvalidArgumentException("Invalid instance of DTO given");
        }

        $row = $this->facade->create($commandDTO->name, $commandDTO->ingredients, $commandDTO->preparation_process);
        return new SuccessResponse((object) new RecipeDTO($row->id, $row->name, $row->ingredients, $row->preparation_process));
    }
}