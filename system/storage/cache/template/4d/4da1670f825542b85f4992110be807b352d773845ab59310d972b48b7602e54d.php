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

/* marketplace/promotion_list.twig */
class __TwigTemplate_04df7f76e4b4ad283e82b7bbe21547fa39b339cf5bace68983be84e34b77827d extends Template
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
        echo ($context["column_left"] ?? null);
        echo "
<div id=\"content\">
  <div class=\"page-header\">
    <div class=\"container-fluid\">
      <div class=\"pull-right\"><a href=\"";
        // line 5
        echo ($context["add"] ?? null);
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo ($context["button_add"] ?? null);
        echo "\" class=\"btn btn-primary\"><i class=\"fa fa-plus\"></i></a>
        <button type=\"button\" data-toggle=\"tooltip\" title=\"";
        // line 6
        echo ($context["button_delete"] ?? null);
        echo "\" class=\"btn btn-danger\" onclick=\"confirm('";
        echo ($context["text_confirm"] ?? null);
        echo "') ? \$('#form-promotion').submit() : false;\"><i class=\"fa fa-trash-o\"></i></button>
      </div>
      <h1>";
        // line 8
        echo ($context["heading_title"] ?? null);
        echo "</h1>
      <ul class=\"breadcrumb\">
        ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 11
            echo "        <li><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 11);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 11);
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "      </ul>
    </div>
  </div>
  <div class=\"container-fluid\">
    ";
        // line 17
        if (($context["error_warning"] ?? null)) {
            // line 18
            echo "    <div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
    ";
        }
        // line 22
        echo "    ";
        if (($context["success"] ?? null)) {
            // line 23
            echo "    <div class=\"alert alert-success alert-dismissible\"><i class=\"fa fa-check-circle\"></i> ";
            echo ($context["success"] ?? null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
    ";
        }
        // line 27
        echo "    <div class=\"panel panel-default\">
      <div class=\"panel-heading\">
        <h3 class=\"panel-title\"><i class=\"fa fa-list\"></i> ";
        // line 29
        echo ($context["text_list"] ?? null);
        echo "</h3>
      </div>
      <div class=\"panel-body\">
        <form action=\"";
        // line 32
        echo ($context["delete"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-promotion\">
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td style=\"width: 1px;\" class=\"text-center\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', this.checked);\" /></td>
                  <td class=\"text-left\">";
        // line 38
        echo ($context["column_extension"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 39
        echo ($context["column_member"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 40
        echo ($context["column_days"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 41
        echo ($context["column_total"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 42
        echo ($context["column_date_start"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 43
        echo ($context["column_date_end"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 44
        echo ($context["column_status"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 45
        echo ($context["column_action"] ?? null);
        echo "</td>
                </tr>
              </thead>
              <tbody>
                ";
        // line 49
        if (($context["promotions"] ?? null)) {
            // line 50
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["promotions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["promotion"]) {
                // line 51
                echo "                <tr>
                  <td class=\"text-center\">";
                // line 52
                if (twig_in_filter(twig_get_attribute($this->env, $this->source, $context["promotion"], "promotion_id", [], "any", false, false, false, 52), ($context["selected"] ?? null))) {
                    // line 53
                    echo "                    <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["promotion"], "promotion_id", [], "any", false, false, false, 53);
                    echo "\" checked=\"checked\" />
                    ";
                } else {
                    // line 55
                    echo "                    <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["promotion"], "promotion_id", [], "any", false, false, false, 55);
                    echo "\" />
                    ";
                }
                // line 56
                echo "</td>
                  <td class=\"text-left\"><strong>";
                // line 57
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "extension", [], "any", false, false, false, 57);
                echo "</strong></td>
                  <td class=\"text-left\">";
                // line 58
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "member", [], "any", false, false, false, 58);
                echo "</td>
                  <td class=\"text-right\">";
                // line 59
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "days", [], "any", false, false, false, 59);
                echo "</td>
                  <td class=\"text-right\">";
                // line 60
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "total", [], "any", false, false, false, 60);
                echo "</td>
                  <td class=\"text-left\">";
                // line 61
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "date_start", [], "any", false, false, false, 61);
                echo "</td>
                  <td class=\"text-left\">";
                // line 62
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "date_end", [], "any", false, false, false, 62);
                echo "</td>
                  <td class=\"text-left\">";
                // line 63
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "status", [], "any", false, false, false, 63);
                echo "</td>
                  <td class=\"text-right\"><a href=\"";
                // line 64
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "edit", [], "any", false, false, false, 64);
                echo "\" data-toggle=\"tooltip\" title=\"";
                echo ($context["button_edit"] ?? null);
                echo "\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\"></i></a></td>
                </tr>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['promotion'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 67
            echo "                ";
        } else {
            // line 68
            echo "                <tr>
                  <td class=\"text-center\" colspan=\"9\">";
            // line 69
            echo ($context["text_no_results"] ?? null);
            echo "</td>
                </tr>
                ";
        }
        // line 72
        echo "              </tbody>
            </table>
          </div>
        </form>
        <div class=\"row\">
          <div class=\"col-sm-6 text-left\">";
        // line 77
        echo ($context["pagination"] ?? null);
        echo "</div>
          <div class=\"col-sm-6 text-right\">";
        // line 78
        echo ($context["results"] ?? null);
        echo "</div>
        </div>
      </div>
    </div>
  </div>
</div>
";
        // line 84
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "marketplace/promotion_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  257 => 84,  248 => 78,  244 => 77,  237 => 72,  231 => 69,  228 => 68,  225 => 67,  214 => 64,  210 => 63,  206 => 62,  202 => 61,  198 => 60,  194 => 59,  190 => 58,  186 => 57,  183 => 56,  177 => 55,  171 => 53,  169 => 52,  166 => 51,  161 => 50,  159 => 49,  152 => 45,  148 => 44,  144 => 43,  140 => 42,  136 => 41,  132 => 40,  128 => 39,  124 => 38,  115 => 32,  109 => 29,  105 => 27,  97 => 23,  94 => 22,  86 => 18,  84 => 17,  78 => 13,  67 => 11,  63 => 10,  58 => 8,  51 => 6,  45 => 5,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "marketplace/promotion_list.twig", "");
    }
}
