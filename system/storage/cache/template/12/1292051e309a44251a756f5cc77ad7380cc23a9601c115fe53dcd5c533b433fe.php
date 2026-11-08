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

/* account/success.twig */
class __TwigTemplate_2b0a76bc619d33150fd4dccf4bc467421454b11f168669391be1e29500c2974f extends Template
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
<div id=\"account-register-success\">
\t<div id=\"register\" class=\"container\">
\t\t<div class=\"row\">
\t\t\t<div class=\"col-md-8\">
\t\t\t\t<h3 style=\"margin-top: 0px;\">Welcome to OpenCart, your account has been created</h3>
\t\t\t\t<p>The mail with verification link has been sent to your email address. Please, verify your account to use opencart.com</p>
\t\t\t\t<div class=\"buttons text-right\">
\t\t\t\t\t<a href=\"";
        // line 9
        echo ($context["continue"] ?? null);
        echo "\" class=\"btn btn-primary pull-right\">Continue</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"col-md-offset-1 col-md-3 hidden-xs\">
\t\t\t\t<div id=\"register-newsletter\">
\t\t\t\t\t<h4>OpenCart Newsletter</h4>
\t\t\t\t\t<div class=\"text-center\">
\t\t\t\t\t\t<p><img src=\"application/view/image/icon/newsletter-subscribe-icon.png\" class=\"img-responsive\"/></p>
\t\t\t\t\t\t<p>Subscribe to our newsletters and stay informed of new releases and other OpenCart events.</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div>
\t\t\t\t\t\t<div class=\"input-group newsletter\">
\t\t\t\t\t\t\t<input type=\"text\" name=\"newsletter\" value=\"\" placeholder=\"Enter your email\" class=\"form-control\"/>
\t\t\t\t\t\t\t<div class=\"input-group-btn\">
\t\t\t\t\t\t\t\t<button type=\"button\" class=\"btn btn-primary subscribe\"><i class=\"fa fa-angle-right\"></i></button>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div id=\"side-banner\">";
        // line 28
        echo ($context["banner"] ?? null);
        echo "</div>
\t\t\t</div>
\t\t</div>
\t</div>
</div>
";
        // line 33
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/success.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 33,  70 => 28,  48 => 9,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/success.twig", "");
    }
}
