<?php

namespace Sqmatheus\Ecommerce\DTOs;

final readonly class BuyProductDto {

    public function __construct(
        public string $idProduct,
        public string $userName
    )
    {
    }

}