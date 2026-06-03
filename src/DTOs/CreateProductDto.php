<?php

namespace Sqmatheus\Ecommerce\DTOs;

final readonly class CreateProductDto {

    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?float $price = null,
    )
    {
    }

}