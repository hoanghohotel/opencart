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

/* common/header.twig */
class __TwigTemplate_0f9a8e3c2c0204ab01445ef3ed50032822098465f540364e432b8fe7593a08a3 extends Template
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
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
<meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<title>";
        // line 6
        echo ($context["title"] ?? null);
        echo "</title>
<base href=\"";
        // line 7
        echo ($context["base"] ?? null);
        echo "\" />
";
        // line 8
        if (($context["description"] ?? null)) {
            // line 9
            echo "<meta name=\"description\" content=\"";
            echo ($context["description"] ?? null);
            echo "\" />
";
        }
        // line 11
        if (($context["keywords"] ?? null)) {
            // line 12
            echo "<meta name=\"keywords\" content=\"";
            echo ($context["keywords"] ?? null);
            echo "\" />
";
        }
        // line 14
        if (($context["robots"] ?? null)) {
            // line 15
            echo "<meta name=\"robots\" content=\"";
            echo ($context["robots"] ?? null);
            echo "\" />
";
        }
        // line 17
        echo "
<meta name=\"agentfy_data\" content=\"";
        // line 18
        echo twig_escape_filter($this->env, ($context["agentfy_data"] ?? null), "html_attr");
        echo "\" />
<link href=\"application/view/stylesheet/bootstrap.css\" rel=\"stylesheet\" />
<link href=\"application/view/stylesheet/stylesheet.css\" rel=\"stylesheet\" />
<link href=\"application/view/javascript/fontawesome/css/font-awesome.min.css\" rel=\"stylesheet\" />
<link href=\"application/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" />
<script src=\"application/view/javascript/jquery/jquery-1.12.2.min.js\"></script>
<script src=\"application/view/javascript/bootstrap/js/bootstrap.min.js\"></script>
<script src=\"application/view/javascript/jquery/datetimepicker/moment.js\" type=\"text/javascript\"></script>
<script src=\"application/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js\" type=\"text/javascript\"></script>
<script src=\"application/view/javascript/common.js\"></script>

";
        // line 29
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["styles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["style"]) {
            // line 30
            echo "<link href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["style"], "href", [], "any", false, false, false, 30);
            echo "\" type=\"text/css\" rel=\"";
            echo twig_get_attribute($this->env, $this->source, $context["style"], "rel", [], "any", false, false, false, 30);
            echo "\" media=\"";
            echo twig_get_attribute($this->env, $this->source, $context["style"], "media", [], "any", false, false, false, 30);
            echo "\" />
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['style'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["links"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 33
            echo "<link href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["link"], "href", [], "any", false, false, false, 33);
            echo "\" rel=\"";
            echo twig_get_attribute($this->env, $this->source, $context["link"], "rel", [], "any", false, false, false, 33);
            echo "\" />
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "
</head>
<body>
<div id=\"fb-root\"></div>
<script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v15.0\" nonce=\"jXyV7bXV\"></script>
<header>
  <nav class=\"navbar navbar-default navbar-fixed-top\">
    <div class=\"container\">
      <div class=\"navbar-header\">
        <button type=\"button\" data-toggle=\"collapse\" data-target=\"#navbar-collapse-header\" class=\"navbar-toggle collapsed\"><span class=\"icon-bar\"></span> <span class=\"icon-bar\"></span> <span class=\"icon-bar\"></span></button>
        <a href=\"";
        // line 45
        echo ($context["home"] ?? null);
        echo "\" class=\"navbar-brand\"><img src=\"application/view/image/icon/opencart-logo.png\" title=\"";
        echo ($context["title"] ?? null);
        echo "\" alt=\"";
        echo ($context["logo"] ?? null);
        echo "\" /></a></div>
      <div class=\"collapse navbar-collapse\" id=\"navbar-collapse-header\">
        <ul class=\"nav navbar-nav\">
          <li><a href=\"";
        // line 48
        echo ($context["feature"] ?? null);
        echo "\">Features</a></li>
          <li><a href=\"";
        // line 49
        echo ($context["demo"] ?? null);
        echo "\">Demo</a></li>
          <li><a href=\"";
        // line 50
        echo ($context["marketplace"] ?? null);
        echo "\">Marketplace</a></li>
          <li><a href=\"";
        // line 51
        echo ($context["blog"] ?? null);
        echo "\">Blog</a></li>
          <li><a href=\"";
        // line 52
        echo ($context["download"] ?? null);
        echo "\">Download</a></li>
          <li class=\"dropdown\"><a href=\"#\" data-toggle=\"dropdown\">Resources <span class=\"caret\"></span></a>
            <ul class=\"dropdown-menu\">
              <li><a href=\"";
        // line 55
        echo ($context["showcase"] ?? null);
        echo "\">Showcase</a></li>
              <li><a href=\"";
        // line 56
        echo ($context["contact"] ?? null);
        echo "\">Contact Us</a></li>
              ";
        // line 58
        echo "              <li><a href=\"";
        echo ($context["partner"] ?? null);
        echo "\">OpenCart Partners</a></li>
              <li><a href=\"https://forum.opencart.com\">Community Forums</a></li>
              <li><a href=\"https://www.facebook.com/groups/www.opencart\" target=\"_blank\">Facebook Community</a></li>
              <li><a href=\"https://docs.opencart.com\">OpenCart Documentation</a></li>
              <li><a target=\"_blank\" href=\"https://github.com/opencart/opencart\">GitHub</a></li>
              <li><a href=\"https://docs.opencart.com/#additional-reading\">OpenCart Books</a></li>
              <li><a href=\"https://github.com/opencart/opencart/issues\">Github Bug Tracker</a></li>
              <li><a href=\"https://docs.opencart.com/developer/module/\">Developer</a></li>
            </ul>
          </li>
          ";
        // line 68
        if ( !($context["logged"] ?? null)) {
            // line 69
            echo "          <li class=\"visible-xs\"><a href=\"";
            echo ($context["login"] ?? null);
            echo "\">Login</a></li>
          <li class=\"visible-xs\"><a href=\"";
            // line 70
            echo ($context["register"] ?? null);
            echo "\">Register</a></li>
          ";
        } else {
            // line 72
            echo "          <li class=\"visible-xs\"><a href=\"";
            echo ($context["account"] ?? null);
            echo "\">Account</a></li>
          <li class=\"visible-xs\"><a href=\"";
            // line 73
            echo ($context["logout"] ?? null);
            echo "\">Logout</a></li>
          ";
        }
        // line 75
        echo "        </ul>
        <div class=\"navbar-right hidden-xs\">";
        // line 76
        if ( !($context["logged"] ?? null)) {
            echo "<a href=\"";
            echo ($context["login"] ?? null);
            echo "\" class=\"btn btn-link navbar-btn\">Login</a> <a href=\"";
            echo ($context["register"] ?? null);
            echo "\" class=\"btn btn-black navbar-btn\">Register</a>";
        } else {
            echo "<a href=\"";
            echo ($context["account"] ?? null);
            echo "\" class=\"btn btn-link navbar-btn\">Account</a> <a href=\"";
            echo ($context["logout"] ?? null);
            echo "\" class=\"btn btn-black navbar-btn\">Logout</a>";
        }
        echo "</div>
      </div>
    </div>
  </nav>
</header>
";
    }

    public function getTemplateName()
    {
        return "common/header.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  216 => 76,  213 => 75,  208 => 73,  203 => 72,  198 => 70,  193 => 69,  191 => 68,  177 => 58,  173 => 56,  169 => 55,  163 => 52,  159 => 51,  155 => 50,  151 => 49,  147 => 48,  137 => 45,  125 => 35,  114 => 33,  110 => 32,  97 => 30,  93 => 29,  79 => 18,  76 => 17,  70 => 15,  68 => 14,  62 => 12,  60 => 11,  54 => 9,  52 => 8,  48 => 7,  44 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/header.twig", "");
    }
}
