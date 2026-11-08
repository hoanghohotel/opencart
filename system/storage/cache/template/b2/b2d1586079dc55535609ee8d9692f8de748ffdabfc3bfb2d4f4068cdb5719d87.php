<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* error/not_found.twig */
class __TwigTemplate_5f27573a680f25a2afee9dba9d6c1582633d4f3bcea67caaee9555f1d43a23cb extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo ($context["header"] ?? null);
        echo "
<div id=\"not-found\">
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-sm-4 hidden-xs\">
        <div class=\"icon\"><img src=\"application/view/image/icon/icon-error-404-page-not-found.png\" alt=\"OpenCart.com\" title=\"OpenCart.com\" class=\"img-responsive\"/></div>
      </div>
      <div class=\"col-sm-8\">
        <div class=\"message\">
          <h1>404</h1>
          <h2>Page Not Found</h2>
          <div class=\"icon visible-xs\"><img src=\"application/view/image/icon/icon-error-404-page-not-found.png\" alt=\"OpenCart.com\" title=\"OpenCart.com\" class=\"img-responsive\"/></div>
          <p>We can't seem to find the page you are looking for.</p>
          <p>Go to our <a href=\"";
        // line 14
        echo ($context["home"] ?? null);
        echo "\">home page</a> or go back to <a href=\"javascript:history.go(-1);\">previous page</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
";
        // line 20
        echo ($context["footer"] ?? null);
        echo " ";
    }

    public function getTemplateName()
    {
        return "error/not_found.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 20,  53 => 14,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "error/not_found.twig", "");
    }
}
