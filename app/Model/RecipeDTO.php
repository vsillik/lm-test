<?php

namespace App\Model;

class RecipeDTO
{
    public function __construct(public readonly string $id,
                                public readonly string $name,
                                public readonly string $ingredients,
                                public readonly string $preparation_process)
    {
    }
}