<?php
declare(strict_types=1);

use core\ExitCode;
use core\ConsoleApplication;
use core\ConsoleController;

final class ConsoleApplicationTest extends CustomTestCase
{
    public function testRun_WhenArgsNotPassedThenZeroCodeReturned()
    {
        $consoleApplication = $this->createConsoleApplication();

        $this->assertTrue($consoleApplication->run() === ExitCode::ERROR);
    }

    public function testRun_WhenControllerNameIsPassedThenSuccessCodeReturned()
    {
        $consoleApplication = $this->createConsoleApplication(['test']);

        $this->assertTrue($consoleApplication->run() === ExitCode::SUCCESS);
    }

    public function testRun_WhenArgsContainControllerNameThenGenerateExpectedControllerName()
    {
        $consoleApplication = $this->createConsoleApplication(['test']);

        $consoleApplication->run();

        $this->assertEquals('console\controller\TestController', $consoleApplication->getCurrentControllerName());


        $consoleApplication = $this->createConsoleApplication(['newtest']);

        $consoleApplication->run();

        $this->assertEquals('console\controller\NewtestController', $consoleApplication->getCurrentControllerName());
    }

    public function testRun_WhenControllerArgumentContainsHyphenThenEveryWordsfirstLetterIsInUpperCase()
    {
        $consoleApplication = $this->createConsoleApplication(['new-test']);

        $consoleApplication->run();

        $this->assertEquals('console\controller\NewTestController', $consoleApplication->getCurrentControllerName());
    }

    public function testRun_WhenPassedMoreThanTwoArgumentsToScriptThenSecondArgumentIsControllerActionThirdIsItsArgument()
    {
        $consoleApplication = $this->createConsoleApplication(['test', 'testaction', 'testargument']);
        $consoleApplication->controllerMock = $this->getMockBuilder(ConsoleController::class)
            ->setMethods(['actionTestaction'])
            ->getMock();

        $consoleApplication->run();

        $this->assertEquals('actionTestaction', $consoleApplication->getCurrentControllerAction());
        $this->assertEquals('testargument', $consoleApplication->getCurrentControllerActionArgument());
    }

    public function testRun_WhenControllerCreatedThenItsActionIsCalled()
    {
        $consoleApplication = $this->createConsoleApplication(['test', 'testaction', 'testargument']);
        $consoleApplication->controllerMock = $this->getMockBuilder(ConsoleController::class)
            ->setMethods(['actionTestaction'])
            ->getMock();

        $consoleApplication->controllerMock->expects($this->once())
            ->method('actionTestaction')
            ->with('testargument');

        $consoleApplication->run();
    }

    /**
     * @param array $args
     * @return ConsoleApplication|__anonymous@2504
     */
    protected function createConsoleApplication(array $args = [])
    {
        $args = array_merge(['scriptname'], $args);

        $consoleApplication = new class($args) extends ConsoleApplication {
            public $controllerMock;

            public function createCurrentController(): ConsoleController
            {
                return $this->controllerMock;
            }
        };

        $consoleApplication->controllerMock = $this->getMockBuilder(ConsoleController::class)
            ->setMethods([$consoleApplication->getCurrentControllerAction()])
            ->getMock();

        return $consoleApplication;
    }

}