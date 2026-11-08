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

/* common/pagination.twig */
class __TwigTemplate_d7987b7c0061da95dfa286acbc8ca642471f952c421c79b78ab51297201d23ee extends Template
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
        echo "<ul class=\"pagination\">
  ";
        // line 2
        if (($context["first"] ?? null)) {
            // line 3
            echo "    <li class=\"page-item\"><a href=\"";
            echo ($context["first"] ?? null);
            echo "\" class=\"page-link\">|&lt;</a></li>
  ";
        }
        // line 5
        echo "  ";
        if (($context["prev"] ?? null)) {
            // line 6
            echo "    <li class=\"page-item\"><a href=\"";
            echo ($context["prev"] ?? null);
            echo "\" class=\"page-link\">&lt;</a></li>
  ";
        }
        // line 8
        echo "  ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["links"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 9
            echo "    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["link"], "page", [], "any", false, false, false, 9), ($context["page"] ?? null)))) {
                // line 10
                echo "      <li class=\"page-item active\"><span class=\"page-link\">";
                echo twig_get_attribute($this->env, $this->source, $context["link"], "page", [], "any", false, false, false, 10);
                echo "</span></li>
    ";
            } else {
                // line 12
                echo "      <li class=\"page-item\"><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["link"], "href", [], "any", false, false, false, 12);
                echo "\" class=\"page-link\">";
                echo twig_get_attribute($this->env, $this->source, $context["link"], "page", [], "any", false, false, false, 12);
                echo "</a></li>
    ";
            }
            // line 14
            echo "  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        echo "  ";
        if (($context["next"] ?? null)) {
            // line 16
            echo "    <li class=\"page-item\"><a href=\"";
            echo ($context["next"] ?? null);
            echo "\" class=\"page-link\">&gt;</a></li>
  ";
        }
        // line 18
        echo "  ";
        if (($context["last"] ?? null)) {
            // line 19
            echo "    <li class=\"page-item\"><a href=\"";
            echo ($context["last"] ?? null);
            echo "\" class=\"page-link\">&gt;|</a></li>
  ";
        }
        // line 21
        echo "</ul>";
    }

    public function getTemplateName()
    {
        return "common/pagination.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  103 => 21,  97 => 19,  94 => 18,  88 => 16,  85 => 15,  79 => 14,  71 => 12,  65 => 10,  62 => 9,  57 => 8,  51 => 6,  48 => 5,  42 => 3,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/pagination.twig", "");
    }
}
