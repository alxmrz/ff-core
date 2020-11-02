<?php


namespace FF;

use FF\db\DatabaseConnection;

class ConsoleApplication
{
    protected $argv = [];
    protected $config = [];
    /** @var DatabaseConnection $db */
    protected $db;
    protected $currentControllerName = '';
    protected $currentControllerAction = 'actionIndex';
    protected $currentControllerActionArgument = '';

    public function __construct(array $argv, array $config)
    {
        $this->argv = $argv;
        $this->config = $config;
    }

    public function run(): int
    {
        if (empty($this->argv[1])) {
            return ExitCode::ERROR;
        }

        $this->createDatabaseConnection();

        $this->registerCurrentController();
        $this->currentControllerAction = 'action' . ucfirst($this->argv[2] ?? 'index');
        $this->currentControllerActionArgument = $this->argv[3] ?? '';

        $controller = $this->createCurrentController();
        $controller->setDb($this->db);

        $controller->{$this->currentControllerAction}($this->currentControllerActionArgument);

        return ExitCode::SUCCESS;
    }

    /**
     * Register current controller depending on the second console argument
     */
    protected function registerCurrentController(): void
    {
        $controllerUniqueName = '';
        $controllerParts = explode('-', $this->argv[1]);
        foreach ($controllerParts as $controllerPart) {
            $controllerUniqueName .= ucfirst($controllerPart);
        }

        $this->currentControllerName = "console\controller\\{$controllerUniqueName}Controller";
    }

    public function getCurrentControllerName(): string
    {
        return $this->currentControllerName;
    }

    /**
     * @return string
     */
    public function getCurrentControllerAction(): string
    {
        return $this->currentControllerAction;
    }

    /**
     * @return string
     */
    public function getCurrentControllerActionArgument(): string
    {
        return $this->currentControllerActionArgument;
    }

    protected function createCurrentController(): ConsoleController
    {
        /** @var ConsoleController $currentController */
        $currentController = new $this->currentControllerName();

        return $currentController;
    }

    protected function createDatabaseConnection()
    {
        $this->db = new DatabaseConnection($this->config);
    }
}