<?php

namespace App\Command\DTO\Recipe;

use Contributte\JsonRPC\Command\ICommandDTO;

class CreateCommandDTO implements \Contributte\JsonRPC\Command\ICommandDTO
{
    public function __construct(public readonly string $name,
                                public readonly string $ingredients,
                                public readonly string $preparation_process)
    {
    }

    public static function fromValidParams(\stdClass $parameters): ICommandDTO
    {
        if (!property_exists($parameters, 'name') || !is_string($parameters->name)) {
            throw new \InvalidArgumentException("name not specified");
        }

        if (!property_exists($parameters, 'ingredients') || !is_string($parameters->ingredients)) {
            throw new \InvalidArgumentException("ingredients not specified");
        }

        if (!property_exists($parameters, 'preparation_process') || !is_string($parameters->preparation_process)) {
            throw new \InvalidArgumentException("preparation_process not specified");
        }

        return new CreateCommandDTO($parameters->name, $parameters->ingredients, $parameters->preparation_process);
    }
}