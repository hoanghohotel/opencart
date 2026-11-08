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

/* mail/pin_reset.twig */
class __TwigTemplate_b7d1dd30f2d0ef89de3737387edc4a5fcc7436f1476f940db70b82bb916f3280 extends Template
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
        echo "Hi ";
        echo ($context["username"] ?? null);
        echo ",

A PIN reset was requested for your account. 

Click on the link below to confirm the PIN reset:

";
        // line 7
        echo ($context["reset"] ?? null);
        echo "

IP: ";
        // line 9
        echo ($context["ip"] ?? null);
        echo "

Best Regards
OpenCart Team";
    }

    public function getTemplateName()
    {
        return "mail/pin_reset.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 9,  47 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "mail/pin_reset.twig", "");
    }
}
