# Frozen Framework 
An MVC php framework.  

Run the commands below for starting dev containers, docker required:
- *make build* - build php image
- *make run*   - run container with php
- *make deps*  - install composer deps

Use *make test* for running all tests in project

How to use:
1) Make Controller with name of your requestUri. Example:
    http://example.com/request/page
    In this case **Controller** class will be `RequestController` 
    with action `actionPage`
2) If you need you can make a template in `view` directory and render it with:
`$this->render('path/to/template', $data)`. Look at MainpageController for example.      
The default template system is `TWIG`.
3) Also use can use framework in micro mode. Define param ['mode' => 'micro'] in application config. See example/index.php for details. 
4) Start your request page to see result.
