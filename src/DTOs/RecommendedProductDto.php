<?php

namespace Sqmatheus\Ecommerce\DTOs;

use Override;

final readonly class RecommendedProductDto implements \JsonSerializable {

    public function __construct(
        public string $id,
        public string $name
    )
    {
    }

    #[Override]
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}