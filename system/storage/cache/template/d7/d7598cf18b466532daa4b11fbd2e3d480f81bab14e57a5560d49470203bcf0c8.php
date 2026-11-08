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

/* account/menu.twig */
class __TwigTemplate_f8eb8df04ff6c3bdec1e321421e366f55edd57a735b8a4664126b635dce6ffba extends Template
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
        // line 35
        echo "<div class=\"panel-group\" id=\"collapse-menu\">
  <div class=\"panel panel-default\">
    <div class=\"panel-heading\"><a href=\"";
        // line 37
        echo ($context["account"] ?? null);
        echo "\" class=\"panel-title\"><i class=\"fa fa-home fa-fw\"></i> Dashboard</a></div>
  </div>
  ";
        // line 39
        $context["i"] = 0;
        // line 40
        echo "  ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["menus"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["menu"]) {
            // line 41
            echo "    <div class=\"panel panel-default\">
      <div class=\"panel-heading\">

        <a href=\"#collapse-menu";
            // line 44
            echo ($context["i"] ?? null);
            echo "\" data-toggle=\"collapse\" data-parent=\"#collapse-menu\" class=\"panel-title collapsed\">
                 <i class=\"fa fa-plus-square-o fa-fw\"></i>";
            // line 45
            echo twig_get_attribute($this->env, $this->source, $context["menu"], "text", [], "any", false, false, false, 45);
            echo "
        </a>
      </div>
      ";
            // line 48
            if (twig_get_attribute($this->env, $this->source, $context["menu"], "children", [], "any", false, false, false, 48)) {
                // line 49
                echo "        <div id=\"collapse-menu";
                echo ($context["i"] ?? null);
                echo "\" class=\"panel-collapse collapse\">
          <table class=\"table table-hover\" style=\"margin-bottom: 0;\">
            ";
                // line 51
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["menu"], "children", [], "any", false, false, false, 51));
                foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                    // line 52
                    echo "              ";
                    if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["child"], "value", [], "any", false, false, false, 52), ($context["route"] ?? null)))) {
                        // line 53
                        echo "                <tr class=\"warning\">
                  <td><a href=\"";
                        // line 54
                        echo twig_get_attribute($this->env, $this->source, $context["child"], "href", [], "any", false, false, false, 54);
                        echo "\" data-toggle=\"tooltip\" title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["child"], "tooltip", [], "any", false, false, false, 54);
                        echo "\" class=\"text-warning active\"><i class=\"fa fa-";
                        echo twig_get_attribute($this->env, $this->source, $context["child"], "icon", [], "any", false, false, false, 54);
                        echo " fa-fw\"></i> ";
                        echo twig_get_attribute($this->env, $this->source, $context["child"], "text", [], "any", false, false, false, 54);
                        echo "</a></td>
                </tr>
              ";
                    } else {
                        // line 57
                        echo "                <tr>
                  <td><a href=\"";
                        // line 58
                        echo twig_get_attribute($this->env, $this->source, $context["child"], "href", [], "any", false, false, false, 58);
                        echo "\" data-toggle=\"tooltip\" title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["child"], "tooltip", [], "any", false, false, false, 58);
                        echo "\"><i class=\"fa fa-";
                        echo twig_get_attribute($this->env, $this->source, $context["child"], "icon", [], "any", false, false, false, 58);
                        echo " fa-fw\"></i> ";
                        echo twig_get_attribute($this->env, $this->source, $context["child"], "text", [], "any", false, false, false, 58);
                        echo "</a></td>
                </tr>
              ";
                    }
                    // line 61
                    echo "            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 62
                echo "          </table>
        </div>
      ";
            }
            // line 65
            echo "    </div>
    ";
            // line 66
            $context["i"] = (($context["i"] ?? null) + 1);
            // line 67
            echo "  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['menu'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 68
        echo "</div>
<script type=\"text/javascript\"><!--
\$(document).ready(function() {
\tvar element = \$('#collapse-menu .panel-collapse a.active').parent().parent().parent().parent().parent();

\telement.addClass('in');

\t\$('#collapse-menu a[href=\\'#' + \$(element).attr('id') + '\\']').find('i').replaceWith('<i class=\"fa fa-minus-square-o fa-fw\"></i>');
  \$('#collapse-menu a[href=\\'#' + \$(element).attr('id') + '\\']').removeClass('collapsed');
});

\$('#collapse-menu .panel-heading a[data-toggle=\\'collapse\\']').on('click', function(e) {
    if(\$(this).hasClass('collapsed')) {
      \$(this).find('i').removeClass(\"fa-plus-square-o\");
      \$(this).find('i').addClass(\"fa-minus-square-o\");
    } else {
      \$(this).find('i').removeClass(\"fa-minus-square-o\");
      \$(this).find('i').addClass(\"fa-plus-square-o\");
    }
}); 


//--></script>";
    }

    public function getTemplateName()
    {
        return "account/menu.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  135 => 68,  129 => 67,  127 => 66,  124 => 65,  119 => 62,  113 => 61,  101 => 58,  98 => 57,  86 => 54,  83 => 53,  80 => 52,  76 => 51,  70 => 49,  68 => 48,  62 => 45,  58 => 44,  53 => 41,  48 => 40,  46 => 39,  41 => 37,  37 => 35,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/menu.twig", "");
    }
}
