<?php

namespace App\Command\Type\Recipe;

use App\Command\DTO\Recipe\GetCommandDTO;
use App\Model\RecipeDTO;
use App\Model\RecipeFacade;
use Contributte\JsonRPC\Command\ICommandDTO;
use Contributte\JsonRPC\Response\Enum\GenericCodes;
use Contributte\JsonRPC\Response\IResponse;
use Contributte\JsonRPC\Response\Type\ErrorResponse;
use Contributte\JsonRPC\Response\Type\SuccessResponse;

class GetCommand implements \Contributte\JsonRPC\Command\ICommand
{
    public function __construct(private readonly RecipeFacade $facade)
    {
    }

    public function getCommandDTOClass(): string
    {
        return GetCommandDTO::class;
    }

    public function execute(ICommandDTO $commandDTO): IResponse
    {
        if (!$commandDTO instanceof GetCommandDTO) {
            throw new \InvalidArgumentException("Invalid instance of DTO given");
        }

        $row = $this->facade->get($commandDTO->id);

        if ($row === null) {
            return new ErrorResponse(GenericCodes::CODE_INVALID_PARAMS, "Not found");
        }

        return new SuccessResponse((object) new RecipeDTO($row->id, $row->name, $row->ingredients, $row->preparation_process));
    }
}