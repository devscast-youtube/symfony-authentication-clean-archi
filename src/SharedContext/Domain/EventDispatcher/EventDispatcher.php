<?php

declare(strict_types=1);

namespace Classroom\SharedContext\Domain\EventDispatcher;

/**
 * Interface EventDispatcher.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
interface EventDispatcher
{
    /**
     * @param array<int, object> $events
     */
    public function dispatch(array $events): void;
}
