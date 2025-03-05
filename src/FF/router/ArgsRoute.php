<?php

declare(strict_types=1);

namespace FF\router;

class ArgsRoute
{
    /**
     * @var string[]
     */
    private array $routeParts;

    public function __construct(string $uri)
    {
        $this->routeParts = explode('/', $uri);
    }

    public function getPartsCount(): int
    {
        return count($this->routeParts);
    }

    public function hasPartsCountEqualedTo(ArgsRoute $route): bool
    {
        return $this->getPartsCount() === $route->getPartsCount();
    }

    public function getParts(): array
    {
        return $this->routeParts;
    }

    public function extractArgsByTemplateRoute(ArgsRoute $route): array
    {
        $routeArgs = [];

        foreach ($route->getParts() as $key => $part) {
            preg_match("/{(\w+)}/", (string)$part, $matches);

            if ($this->hasAtPositionTheSamePart($key, $part)) {
                continue;
            } elseif (count($matches) === 0) {
                return [];
            }

            if (count($matches) > 0) {
                $routeArgs[$matches[1]] = $this->routeParts[$key];
            } else {
                $routeArgs = [];
            }
        }

        return $routeArgs;
    }

    public function hasAtPositionTheSamePart(int|string $key, mixed $part): bool
    {
        return $this->routeParts[$key] === $part;
    }
}