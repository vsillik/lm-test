<?php

namespace App\Command\Type\Recipe;

use App\Command\DTO\Recipe\DeleteCommandDTO;
use App\Model\RecipeFacade;
use Contributte\JsonRPC\Command\ICommandDTO;
use Contributte\JsonRPC\Response\IResponse;
use Contributte\JsonRPC\Response\Type\SuccessResponse;

class DeleteCommand implements \Contributte\JsonRPC\Command\ICommand
{
    public function __construct(private readonly RecipeFacade $facade)
    {
    }

    public function getCommandDTOClass(): string
    {
        return DeleteCommandDTO::class;
    }

    public function execute(ICommandDTO $commandDTO): IResponse
    {
        if (!$commandDTO instanceof DeleteCommandDTO) {
            throw new \InvalidArgumentException("Invalid instance of DTO given");
        }

        $affected = $this->facade->delete($commandDTO->id);

        $response_obj = new \stdClass();
        $response_obj->success = $affected > 0;

        return new SuccessResponse($response_obj);
    }
}