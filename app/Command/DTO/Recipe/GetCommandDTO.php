<?php

namespace App\Command\DTO\Recipe;

use Contributte\JsonRPC\Command\ICommandDTO;

class GetCommandDTO implements \Contributte\JsonRPC\Command\ICommandDTO
{
    public function __construct(public readonly string $id)
    {
    }

    public static function fromValidParams(\stdClass $parameters): ICommandDTO
    {
        if (!property_exists($parameters, 'id') || !is_string($parameters->id)) {
            throw new \InvalidArgumentException("id not specified");
        }

        return new GetCommandDTO($parameters->id);
    }
}