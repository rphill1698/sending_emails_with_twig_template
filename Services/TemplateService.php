<?php  

use \Twig_Loader_Filesystem as TwigViews;
use \Twig_Environment as Twig;
use \Twig_Extension_Debug as DebugExt;
Class TemplateService
{
    private $Twig;

    public function __construct()
    {
        $loader = new TwigViews(TEMPLATE_PATH);
        $options = array('debug' => true);
        $this->Twig = new Twig($loader, $options);
        $this->Twig->addExtension(new DebugExt());
    }

    public function render_template($path, $fields = array())
    {
        $template = $this->Twig->loadTemplate($path);
        return $template->render($fields);
    }
}