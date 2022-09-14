<?php

namespace App\Command\DTO\Recipe;

use Contributte\JsonRPC\Command\ICommandDTO;

class GetAllCommandDTO implements \Contributte\JsonRPC\Command\ICommandDTO
{
    public static function fromValidParams(\stdClass $parameters): ICommandDTO
    {
        return new GetAllCommandDTO();
    }
}