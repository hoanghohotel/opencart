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

/* account/verify.twig */
class __TwigTemplate_c94da96cbdac9df98d27afac9b28cceaca0d54763ce68d3044c2add3178c22db extends Template
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
\t\t\t\t";
        // line 6
        if (($context["verified"] ?? null)) {
            // line 7
            echo "\t\t\t\t<h3 style=\"margin-top: 0px;\">Account has been successfully verified</h3>
\t\t\t\t<p>Please, login to have access to your own account area. You can edit your profile, view past orders, download modules and apply for a seller account. Be sure to checkout the community forums for any help or advice you need.</p>
\t\t\t\t<p>To get started with OpenCart you can <a href=\"";
            // line 9
            echo ($context["download"] ?? null);
            echo "\">download</a> and host yourself or <a href=\"";
            echo ($context["cloud"] ?? null);
            echo "\">create a Cloud Store</a> within a few minutes.</p>
\t\t\t\t<div class=\"buttons text-right\">
\t\t\t\t\t<a href=\"";
            // line 11
            echo ($context["login"] ?? null);
            echo "\" class=\"btn btn-primary pull-right\">Continue</a>
\t\t\t\t</div>
\t\t\t\t";
        } else {
            // line 14
            echo "\t\t\t\t<h3 style=\"margin-top: 0px;\">Something went wrong</h3>
\t\t\t\t<p>Verification link is invalid or account has been already verified.</p>
\t\t\t\t<div class=\"buttons text-right\">
\t\t\t\t\t<a href=\"/\" class=\"btn btn-primary pull-right\">Return to Home</a>
\t\t\t\t</div>
\t\t\t\t";
        }
        // line 20
        echo "\t\t\t</div>
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
        // line 37
        echo ($context["banner"] ?? null);
        echo "</div>
\t\t\t</div>
\t\t</div>
\t</div>
</div>
";
        // line 42
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/verify.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  99 => 42,  91 => 37,  72 => 20,  64 => 14,  58 => 11,  51 => 9,  47 => 7,  45 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/verify.twig", "");
    }
}
