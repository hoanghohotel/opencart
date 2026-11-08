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

/* cms/blog_list.twig */
class __TwigTemplate_d1e17b7a85128c918c4ef7b6d89c2fe7a437d335199a49bd4f943329ebc2a079 extends Template
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
        echo "') ? \$('#form-blog').submit() : false;\"><i class=\"fa fa-trash-o\"></i></button>
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
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-blog\">
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td style=\"width: 1px;\" class=\"text-center\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', this.checked);\" /></td>
                  <td class=\"text-left\">";
        // line 38
        echo ($context["column_title"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 39
        echo ($context["column_category"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 40
        echo ($context["column_author"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 41
        echo ($context["column_viewed"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 42
        echo ($context["column_status"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 43
        echo ($context["column_date_added"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 44
        echo ($context["column_action"] ?? null);
        echo "</td>
                </tr>
              </thead>
              <tbody>
                ";
        // line 48
        if (($context["blogs"] ?? null)) {
            // line 49
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["blogs"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["blog"]) {
                // line 50
                echo "                <tr>
                  <td class=\"text-center\">";
                // line 51
                if (twig_in_filter(twig_get_attribute($this->env, $this->source, $context["blog"], "blog_id", [], "any", false, false, false, 51), ($context["selected"] ?? null))) {
                    // line 52
                    echo "                    <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["blog"], "blog_id", [], "any", false, false, false, 52);
                    echo "\" checked=\"checked\" />
                    ";
                } else {
                    // line 54
                    echo "                    <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["blog"], "blog_id", [], "any", false, false, false, 54);
                    echo "\" />
                    ";
                }
                // line 55
                echo "</td>
                  <td class=\"text-left\"><strong>";
                // line 56
                echo twig_get_attribute($this->env, $this->source, $context["blog"], "title", [], "any", false, false, false, 56);
                echo "</strong> ";
                if (twig_get_attribute($this->env, $this->source, $context["blog"], "trending", [], "any", false, false, false, 56)) {
                    echo "<span class=\"label label-warning\">Trending</span>";
                }
                echo "</td>
                  <td class=\"text-left\">";
                // line 57
                echo twig_get_attribute($this->env, $this->source, $context["blog"], "category", [], "any", false, false, false, 57);
                echo "</td>
                  <td class=\"text-left\">";
                // line 58
                echo twig_get_attribute($this->env, $this->source, $context["blog"], "author", [], "any", false, false, false, 58);
                echo "</td>
                  <td class=\"text-right\">";
                // line 59
                echo twig_get_attribute($this->env, $this->source, $context["blog"], "viewed", [], "any", false, false, false, 59);
                echo "</td>
                  <td class=\"text-left\">";
                // line 60
                echo twig_get_attribute($this->env, $this->source, $context["blog"], "status", [], "any", false, false, false, 60);
                echo "</td>
                  <td class=\"text-left\">";
                // line 61
                echo twig_get_attribute($this->env, $this->source, $context["blog"], "date_added", [], "any", false, false, false, 61);
                echo "</td>
                  <td class=\"text-right\"><a href=\"";
                // line 62
                echo twig_get_attribute($this->env, $this->source, $context["blog"], "edit", [], "any", false, false, false, 62);
                echo "\" data-toggle=\"tooltip\" title=\"";
                echo ($context["button_edit"] ?? null);
                echo "\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\"></i></a></td>
                </tr>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['blog'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 65
            echo "                ";
        } else {
            // line 66
            echo "                <tr>
                  <td class=\"text-center\" colspan=\"8\">";
            // line 67
            echo ($context["text_no_results"] ?? null);
            echo "</td>
                </tr>
                ";
        }
        // line 70
        echo "              </tbody>
            </table>
          </div>
        </form>
        <div class=\"row\">
          <div class=\"col-sm-6 text-left\">";
        // line 75
        echo ($context["pagination"] ?? null);
        echo "</div>
          <div class=\"col-sm-6 text-right\">";
        // line 76
        echo ($context["results"] ?? null);
        echo "</div>
        </div>
      </div>
    </div>
  </div>
</div>
";
        // line 82
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/blog_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  253 => 82,  244 => 76,  240 => 75,  233 => 70,  227 => 67,  224 => 66,  221 => 65,  210 => 62,  206 => 61,  202 => 60,  198 => 59,  194 => 58,  190 => 57,  182 => 56,  179 => 55,  173 => 54,  167 => 52,  165 => 51,  162 => 50,  157 => 49,  155 => 48,  148 => 44,  144 => 43,  140 => 42,  136 => 41,  132 => 40,  128 => 39,  124 => 38,  115 => 32,  109 => 29,  105 => 27,  97 => 23,  94 => 22,  86 => 18,  84 => 17,  78 => 13,  67 => 11,  63 => 10,  58 => 8,  51 => 6,  45 => 5,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/blog_list.twig", "");
    }
}
