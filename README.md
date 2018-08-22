# Frozen Framework 
This is my super good framework realization.  
In general it is a MVC project.  
How to use:
1) Make Controller with name of your requestUri. Example:
    http://example.com/request/page
    In this case **Controller** class will be `RequestController` 
    with action `actionPage`
2) If you need you can make a template in `view` directory and render it with:
`$this->render('path/to/template', $data)`. Look at MainpageController for example.      
The default template system is `TWIG`.
3) Start your request page to see result.
