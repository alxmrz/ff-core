<?php

namespace FF\router;

class ArgsRoute
{
    /**
     * @var string[]
     */
    private array $routeParts;
    private string $uri;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
        $this->routeParts = explode('/', $uri);
    }

    public function getPartsCount(): string
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
            preg_match("/{(\w+)}/", $part, $matches);

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

    /**
     * @param int|string $key
     * @param mixed $part
     * @return bool
     */
    public function hasAtPositionTheSamePart(int|string $key, mixed $part): bool
    {
        return $this->routeParts[$key] === $part;
    }
}