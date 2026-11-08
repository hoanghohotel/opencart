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

/* cms/demo.twig */
class __TwigTemplate_52c77119df70352a2ad6358a711304455ae9f8f3ae740701fc5e56c48a241159 extends Template
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
<div id=\"cms-demo\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>OpenCart Demonstration</h1>
      <p>You can try OpenCart without having to install by clicking on one of the demo links below for the frontend and adminstration demo.</p>
    </div>
  </div>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-sm-6 border-right\">
        <div class=\"demonstration-box\">
          <a href=\"https://demo.opencart.com/\" target=\"_blank\" class=\"box-overlay\">
            <span>View Store Front</span>
          </a>
          <h2>Store Front</h2>
          <img src=\"application/view/image/demonstration/store-front.png\" class=\"img-responsive\" />
        </div>
      </div>
      <div class=\"col-sm-6\">
        <div class=\"demonstration-box\">
          <a href=\"https://demo.opencart.com/TlbeVW/\" target=\"_blank\" class=\"box-overlay\">
            <span class=\"hidden-xs\">View Administration
              <br/>Login &amp; Password: <i>demo</i>
            </span>
            <span class=\"visible-xs-block\">View Administration</span>
          </a>
          <h2>Administration</h2>
          <img src=\"application/view/image/demonstration/store-admin.png\" class=\"img-responsive\" />
          <p class=\"visible-xs-block\">Login &amp; Password: demo</p>
        </div>
      </div>
      <div class=\"col-sm-12\">
        <div class=\"text-center demonstration-box\"><a href=\"https://docs.opencart.com/\" target=\"_blank\" class=\"btn btn-lg btn-primary\">Official Documentation</a></div>
      </div>
    </div>
  </div>
</div>
";
        // line 39
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/demo.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 39,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/demo.twig", "");
    }
}
