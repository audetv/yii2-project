<?php

declare(strict_types=1);

namespace core\entities;

interface AggregateRoot
{
    /**
     * @return array
     */
    public function releaseEvents(): array;
}
