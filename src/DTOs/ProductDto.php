<?php

namespace Sqmatheus\Ecommerce\DTOs;

final readonly class ProductDto {

    public function __construct(
        public string $name,
        public ?string $description,
        public ?float $price
    )
    {
    }

}