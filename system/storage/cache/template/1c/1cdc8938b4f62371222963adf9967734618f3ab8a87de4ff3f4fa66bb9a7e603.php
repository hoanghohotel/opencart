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

/* cms/blog_comment_list.twig */
class __TwigTemplate_ddb91112522a900e796004b0c086ab253a080d7fa334e78945477b0ff450bd4b extends Template
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
      <div class=\"pull-right\">
        <button type=\"button\" data-toggle=\"tooltip\" title=\"";
        // line 6
        echo ($context["button_delete"] ?? null);
        echo "\" class=\"btn btn-danger\" onclick=\"confirm('";
        echo ($context["text_confirm"] ?? null);
        echo "') ? \$('#form-blog-comment').submit() : false;\"><i class=\"fa fa-trash-o\"></i></button>
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
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-blog-comment\">
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td style=\"width: 1px;\" class=\"text-center\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', this.checked);\" /></td>
                  <td class=\"text-left\">";
        // line 38
        echo ($context["column_blog"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 39
        echo ($context["column_member"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 40
        echo ($context["column_comment"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 41
        echo ($context["column_status"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 42
        echo ($context["column_date_added"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 43
        echo ($context["column_action"] ?? null);
        echo "</td>
                </tr>
              </thead>
              <tbody>
                ";
        // line 47
        if (($context["comments"] ?? null)) {
            // line 48
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["comments"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["comment"]) {
                // line 49
                echo "                <tr>
                  <td class=\"text-center\">";
                // line 50
                if (twig_in_filter(twig_get_attribute($this->env, $this->source, $context["comment"], "blog_comment_id", [], "any", false, false, false, 50), ($context["selected"] ?? null))) {
                    // line 51
                    echo "                    <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["comment"], "blog_comment_id", [], "any", false, false, false, 51);
                    echo "\" checked=\"checked\" />
                    ";
                } else {
                    // line 53
                    echo "                    <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["comment"], "blog_comment_id", [], "any", false, false, false, 53);
                    echo "\" />
                    ";
                }
                // line 54
                echo "</td>
                  <td class=\"text-left\"><strong>";
                // line 55
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "blog", [], "any", false, false, false, 55);
                echo "</strong></td>
                  <td class=\"text-left\">";
                // line 56
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "member", [], "any", false, false, false, 56);
                echo "</td>
                  <td class=\"text-left\">";
                // line 57
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "comment", [], "any", false, false, false, 57);
                echo "</td>
                  <td class=\"text-left\">";
                // line 58
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "status", [], "any", false, false, false, 58);
                echo "</td>
                  <td class=\"text-left\">";
                // line 59
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "date_added", [], "any", false, false, false, 59);
                echo "</td>
                  <td class=\"text-right\">
                    ";
                // line 61
                if ( !twig_get_attribute($this->env, $this->source, $context["comment"], "status_raw", [], "any", false, false, false, 61)) {
                    // line 62
                    echo "                    <a href=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["comment"], "approve", [], "any", false, false, false, 62);
                    echo "\" data-toggle=\"tooltip\" title=\"";
                    echo ($context["button_approve"] ?? null);
                    echo "\" class=\"btn btn-success\"><i class=\"fa fa-check\"></i></a>
                    ";
                }
                // line 64
                echo "                    <a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "edit", [], "any", false, false, false, 64);
                echo "\" data-toggle=\"tooltip\" title=\"";
                echo ($context["button_edit"] ?? null);
                echo "\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\"></i></a>
                  </td>
                </tr>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['comment'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 68
            echo "                ";
        } else {
            // line 69
            echo "                <tr>
                  <td class=\"text-center\" colspan=\"7\">";
            // line 70
            echo ($context["text_no_results"] ?? null);
            echo "</td>
                </tr>
                ";
        }
        // line 73
        echo "              </tbody>
            </table>
          </div>
        </form>
        <div class=\"row\">
          <div class=\"col-sm-6 text-left\">";
        // line 78
        echo ($context["pagination"] ?? null);
        echo "</div>
          <div class=\"col-sm-6 text-right\">";
        // line 79
        echo ($context["results"] ?? null);
        echo "</div>
        </div>
      </div>
    </div>
  </div>
</div>
";
        // line 85
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/blog_comment_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  249 => 85,  240 => 79,  236 => 78,  229 => 73,  223 => 70,  220 => 69,  217 => 68,  204 => 64,  196 => 62,  194 => 61,  189 => 59,  185 => 58,  181 => 57,  177 => 56,  173 => 55,  170 => 54,  164 => 53,  158 => 51,  156 => 50,  153 => 49,  148 => 48,  146 => 47,  139 => 43,  135 => 42,  131 => 41,  127 => 40,  123 => 39,  119 => 38,  110 => 32,  104 => 29,  100 => 27,  92 => 23,  89 => 22,  81 => 18,  79 => 17,  73 => 13,  62 => 11,  58 => 10,  53 => 8,  46 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/blog_comment_list.twig", "");
    }
}
