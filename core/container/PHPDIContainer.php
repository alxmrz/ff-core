<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 22.08.18
 * Time: 12:40
 */

namespace core\container;


use DI\Container;
use Psr\Container\ContainerInterface;

class PHPDIContainer implements ContainerInterface
{
    /**
     * @var Container
     */
    private $container;

    public function __construct($container = null)
    {
        $this->container = new Container();
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return $this->container->has($id);
    }
}