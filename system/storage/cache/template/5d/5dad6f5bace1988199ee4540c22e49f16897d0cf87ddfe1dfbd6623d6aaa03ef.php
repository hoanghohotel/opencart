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

/* member/member_list.twig */
class __TwigTemplate_24c9a16a1d1c91b27c76692f2b491cafd19e76598edb6db13af452dc815faf00 extends Template
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
        echo "') ? \$('#form-member').submit() : false;\"><i class=\"fa fa-trash-o\"></i></button>
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
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-member\">
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td style=\"width: 1px;\" class=\"text-center\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', this.checked);\" /></td>
                  <td class=\"text-left\">";
        // line 38
        echo ($context["column_username"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 39
        echo ($context["column_name"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 40
        echo ($context["column_email"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 41
        echo ($context["column_roles"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 42
        echo ($context["column_balance"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 43
        echo ($context["column_status"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 44
        echo ($context["column_date_added"] ?? null);
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
        if (($context["members"] ?? null)) {
            // line 50
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["members"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["member"]) {
                // line 51
                echo "                <tr>
                  <td class=\"text-center\">";
                // line 52
                if (twig_in_filter(twig_get_attribute($this->env, $this->source, $context["member"], "member_id", [], "any", false, false, false, 52), ($context["selected"] ?? null))) {
                    // line 53
                    echo "                    <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["member"], "member_id", [], "any", false, false, false, 53);
                    echo "\" checked=\"checked\" />
                    ";
                } else {
                    // line 55
                    echo "                    <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["member"], "member_id", [], "any", false, false, false, 55);
                    echo "\" />
                    ";
                }
                // line 56
                echo "</td>
                  <td class=\"text-left\"><strong>";
                // line 57
                echo twig_get_attribute($this->env, $this->source, $context["member"], "username", [], "any", false, false, false, 57);
                echo "</strong></td>
                  <td class=\"text-left\">";
                // line 58
                echo twig_get_attribute($this->env, $this->source, $context["member"], "name", [], "any", false, false, false, 58);
                if (twig_get_attribute($this->env, $this->source, $context["member"], "company", [], "any", false, false, false, 58)) {
                    echo " <small class=\"text-muted\">(";
                    echo twig_get_attribute($this->env, $this->source, $context["member"], "company", [], "any", false, false, false, 58);
                    echo ")</small>";
                }
                echo "</td>
                  <td class=\"text-left\">";
                // line 59
                echo twig_get_attribute($this->env, $this->source, $context["member"], "email", [], "any", false, false, false, 59);
                echo "</td>
                  <td class=\"text-left\">
                    ";
                // line 61
                if (twig_get_attribute($this->env, $this->source, $context["member"], "seller_status", [], "any", false, false, false, 61)) {
                    echo "<span class=\"label label-primary\">Seller</span> ";
                }
                // line 62
                echo "                    ";
                if (twig_get_attribute($this->env, $this->source, $context["member"], "partner_status", [], "any", false, false, false, 62)) {
                    echo "<span class=\"label label-success\">Partner</span> ";
                }
                // line 63
                echo "                    ";
                if (twig_get_attribute($this->env, $this->source, $context["member"], "moderator", [], "any", false, false, false, 63)) {
                    echo "<span class=\"label label-warning\">Moderator</span>";
                }
                // line 64
                echo "                  </td>
                  <td class=\"text-right\">";
                // line 65
                echo twig_get_attribute($this->env, $this->source, $context["member"], "balance", [], "any", false, false, false, 65);
                echo "</td>
                  <td class=\"text-left\">";
                // line 66
                echo twig_get_attribute($this->env, $this->source, $context["member"], "status", [], "any", false, false, false, 66);
                echo "</td>
                  <td class=\"text-left\">";
                // line 67
                echo twig_get_attribute($this->env, $this->source, $context["member"], "date_added", [], "any", false, false, false, 67);
                echo "</td>
                  <td class=\"text-right\"><a href=\"";
                // line 68
                echo twig_get_attribute($this->env, $this->source, $context["member"], "edit", [], "any", false, false, false, 68);
                echo "\" data-toggle=\"tooltip\" title=\"";
                echo ($context["button_edit"] ?? null);
                echo "\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\"></i></a></td>
                </tr>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['member'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 71
            echo "                ";
        } else {
            // line 72
            echo "                <tr>
                  <td class=\"text-center\" colspan=\"9\">";
            // line 73
            echo ($context["text_no_results"] ?? null);
            echo "</td>
                </tr>
                ";
        }
        // line 76
        echo "              </tbody>
            </table>
          </div>
        </form>
        <div class=\"row\">
          <div class=\"col-sm-6 text-left\">";
        // line 81
        echo ($context["pagination"] ?? null);
        echo "</div>
          <div class=\"col-sm-6 text-right\">";
        // line 82
        echo ($context["results"] ?? null);
        echo "</div>
        </div>
      </div>
    </div>
  </div>
</div>
";
        // line 88
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "member/member_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  276 => 88,  267 => 82,  263 => 81,  256 => 76,  250 => 73,  247 => 72,  244 => 71,  233 => 68,  229 => 67,  225 => 66,  221 => 65,  218 => 64,  213 => 63,  208 => 62,  204 => 61,  199 => 59,  190 => 58,  186 => 57,  183 => 56,  177 => 55,  171 => 53,  169 => 52,  166 => 51,  161 => 50,  159 => 49,  152 => 45,  148 => 44,  144 => 43,  140 => 42,  136 => 41,  132 => 40,  128 => 39,  124 => 38,  115 => 32,  109 => 29,  105 => 27,  97 => 23,  94 => 22,  86 => 18,  84 => 17,  78 => 13,  67 => 11,  63 => 10,  58 => 8,  51 => 6,  45 => 5,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "member/member_list.twig", "");
    }
}
