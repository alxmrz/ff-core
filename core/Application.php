<?php
/**
 * @author Alexandr Moroz <alexandr.moroz97@mail.com>
 */
namespace core;

use core\exceptions\UnavailableRequestException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

/**
 * Класс Application - основной класс приложения. 
 */
class Application implements BaseApplication
{
  /**
   * Контроллер приложения на основе запроса
   * @var \core\Controller 
   */
  private $controller;
  /**
   * Класс, возвращающий данные http запроса (GET, POST, SERVER)
   * @var \core\HttpDemultiplexer
   */
  private $httpDemultiplexer;
  /**
   * Наименование страницы (шаблона), который нужно отобразить
   * @var string 
   */
  private $pageToRender;
  /**
   * Флаг, показывающий, успешно ли запущено приложение
   * @var int 
   */
  private $runResult = 1;
  
  /**
   * Массив доступных запросов, которые можно отобразить, иначе 404 ошибка
   * @var array 
   */
  private $requestsExpected = array(
      'mainpage',
      'skills',
      'feedback'
  );
  /**
   * Основной публичный метод приложения. Точка входа.
   * @return int флаг успешности запуска приложения
   */
  public function run()
  {
    return $this->runResult === 1 ? $this->controller->generatePage() : $this->runResult;
  }

  /**
   * @param array $config Конфигурация приложения
   */
  public function __construct(array $config = [])
  {
      $this->init($config);
  }
  /**
   * Метод отображает шаблон об ошибке, в случае необработанного исключения
   * @param \Exception $ex исключение, выбрашенное приложением.
   * @param string $additionInfo Информация для посетителя об ошибке
   */
  private function showErrorPage(\Exception $ex, string $additionInfo = '')
  {
    $this->runResult = 0;
    $additionInfo = $additionInfo;
    $errorMessage = $ex->getMessage();
    require '../view/error.php';
  }

  /**
   * Ищет по URI запрашиваемый запрос
   * @return void
   */
  private function setUrlParams()
  {
    $server = $this->httpDemultiplexer->getServer();
    $explodedArray = explode('/', ($server['REQUEST_URI']));
    $this->pageToRender = $explodedArray[1];
    if (empty($this->pageToRender)) {
      $this->pageToRender = 'mainpage';
    }

    $this->isRequestExpected();
  }

  /**
   * Проверяет валидность запроса страницы
   * @return boolen 
   * @throws UnavailableRequestException если вызванный запрос не существует 
   */
  private function isRequestExpected(): bool
  {
    if (in_array($this->pageToRender, $this->requestsExpected)) {
      return true;
    }
    throw new UnavailableRequestException("REQUEST {$this->pageToRender} IS NOT AVAILIBLE");
  }
  /**
   * Регистрирует контроллер приложения на основе запроса.
   * @param array $config конфиг приложения
   * @return void
   */
  private function registerController(array $config = [])
  {

    $pageController = 'controller\\' . $this->pageToRender . 'Controller';

    $this->controller = new $pageController($config);
  }
  /**
   * Регистрирует логгер (сейчас monolog)
   * @return void
   */
  private function registerLogger()
  {
    $logger = new Logger('Request_logger');

    $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/my_app.log', Logger::DEBUG));
    $logger->pushHandler(new FirePHPHandler());
    
    $this->logger = $logger;
  }
  /**
   * 
   * @return HttpDemultiplexer
   */
  public function getHttpDemultiplexer(): HttpDemultiplexer
  {
    return $this->httpDemultiplexer;
  }
  /**
   * 
   * @return \core\Controller
   */
  public function getController(): \core\Controller
  {
    return $this->controller;
  }
  /**
   * 
   * @return string
   */
  public function getPageToRender(): string
  {
    return $this->pageToRender;
  }

    /**
     * @param array $config
     */
    private function init(array $config)
    {
        try {
            $this->registerLogger();

            $this->httpDemultiplexer = new HttpDemultiplexer;
            $this->setUrlParams();
            $this->logger->info('Registered request', array('request' => $this->httpDemultiplexer->getServer()['REQUEST_URI'], 'ip' => isset($_SERVER['REMOTE_ADDR'])?? ''));
            $this->registerController($config);

        } catch (UnavailableRequestException $unex) {
            $this->logger->info('Not available request', array('request' => $this->httpDemultiplexer->getServer()['REQUEST_URI'], 'ip' => isset($_SERVER['REMOTE_ADDR'])?? ''));
            $this->showErrorPage($unex, '404 Страница не найдена');
        } catch (\Exception $ex) {
            $this->logger->info('Unexpected exception', array('message' => $ex->getMessage(), 'ip' => isset($_SERVER['REMOTE_ADDR'])?? ''));
            $this->showErrorPage(ex);
        }
    }

}
