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

/* marketplace/extension_list.twig */
class __TwigTemplate_563148af86aa95a6f3c41d952222143f498b55dca78a0ea6f47fabbdba53b1b8 extends Template
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
        echo "') ? \$('#form-extension').submit() : false;\"><i class=\"fa fa-trash-o\"></i></button>
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
        echo "    <div class=\"row\">
      <div id=\"filter-extension\" class=\"col-md-3 col-md-push-9 col-sm-12\">
        <div class=\"panel panel-default\">
          <div class=\"panel-heading\">
            <h3 class=\"panel-title\"><i class=\"fa fa-filter\"></i> ";
        // line 31
        echo ($context["button_filter"] ?? null);
        echo "</h3>
          </div>
          <div class=\"panel-body\">
            <div class=\"form-group\">
              <label class=\"control-label\" for=\"input-name\">";
        // line 35
        echo ($context["entry_name"] ?? null);
        echo "</label>
              <input type=\"text\" name=\"filter_name\" value=\"";
        // line 36
        echo ($context["filter_name"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_name"] ?? null);
        echo "\" id=\"input-name\" class=\"form-control\" />
            </div>
            <div class=\"form-group\">
              <label class=\"control-label\" for=\"input-category\">";
        // line 39
        echo ($context["entry_category"] ?? null);
        echo "</label>
              <select name=\"filter_extension_category_id\" id=\"input-category\" class=\"form-control\">
                <option value=\"\"></option>
                ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 43
            echo "                ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["category"], "extension_category_id", [], "any", false, false, false, 43), ($context["filter_extension_category_id"] ?? null)))) {
                // line 44
                echo "                <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "extension_category_id", [], "any", false, false, false, 44);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 44);
                echo "</option>
                ";
            } else {
                // line 46
                echo "                <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "extension_category_id", [], "any", false, false, false, 46);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 46);
                echo "</option>
                ";
            }
            // line 48
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 49
        echo "              </select>
            </div>
            <div class=\"form-group\">
              <label class=\"control-label\" for=\"input-license\">";
        // line 52
        echo ($context["entry_license"] ?? null);
        echo "</label>
              <select name=\"filter_license\" id=\"input-license\" class=\"form-control\">
                <option value=\"\"></option>
                ";
        // line 55
        if ((0 === twig_compare(($context["filter_license"] ?? null), "0"))) {
            // line 56
            echo "                <option value=\"0\" selected=\"selected\">";
            echo ($context["text_free"] ?? null);
            echo "</option>
                ";
        } else {
            // line 58
            echo "                <option value=\"0\">";
            echo ($context["text_free"] ?? null);
            echo "</option>
                ";
        }
        // line 60
        echo "                ";
        if ((0 === twig_compare(($context["filter_license"] ?? null), "1"))) {
            // line 61
            echo "                <option value=\"1\" selected=\"selected\">";
            echo ($context["text_commercial"] ?? null);
            echo "</option>
                ";
        } else {
            // line 63
            echo "                <option value=\"1\">";
            echo ($context["text_commercial"] ?? null);
            echo "</option>
                ";
        }
        // line 65
        echo "              </select>
            </div>
            <div class=\"form-group\">
              <label class=\"control-label\" for=\"input-status\">";
        // line 68
        echo ($context["entry_status"] ?? null);
        echo "</label>
              <select name=\"filter_status\" id=\"input-status\" class=\"form-control\">
                <option value=\"\"></option>
                ";
        // line 71
        if ((0 === twig_compare(($context["filter_status"] ?? null), "1"))) {
            // line 72
            echo "                <option value=\"1\" selected=\"selected\">";
            echo ($context["text_enabled"] ?? null);
            echo "</option>
                ";
        } else {
            // line 74
            echo "                <option value=\"1\">";
            echo ($context["text_enabled"] ?? null);
            echo "</option>
                ";
        }
        // line 76
        echo "                ";
        if ((0 === twig_compare(($context["filter_status"] ?? null), "0"))) {
            // line 77
            echo "                <option value=\"0\" selected=\"selected\">";
            echo ($context["text_disabled"] ?? null);
            echo "</option>
                ";
        } else {
            // line 79
            echo "                <option value=\"0\">";
            echo ($context["text_disabled"] ?? null);
            echo "</option>
                ";
        }
        // line 81
        echo "              </select>
            </div>
            <div class=\"form-group text-right\">
              <button type=\"button\" id=\"button-filter\" class=\"btn btn-default\"><i class=\"fa fa-filter\"></i> ";
        // line 84
        echo ($context["button_filter"] ?? null);
        echo "</button>
            </div>
          </div>
        </div>
      </div>
      <div class=\"col-md-9 col-md-pull-3 col-sm-12\">
        <div class=\"panel panel-default\">
          <div class=\"panel-heading\">
            <h3 class=\"panel-title\"><i class=\"fa fa-list\"></i> ";
        // line 92
        echo ($context["text_list"] ?? null);
        echo "</h3>
          </div>
          <div class=\"panel-body\">
            <form action=\"";
        // line 95
        echo ($context["delete"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-extension\">
              <div class=\"table-responsive\">
                <table class=\"table table-bordered table-hover\">
                  <thead>
                    <tr>
                      <td style=\"width: 1px;\" class=\"text-center\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', this.checked);\" /></td>
                      <td class=\"text-center\">";
        // line 101
        echo ($context["column_image"] ?? null);
        echo "</td>
                      <td class=\"text-left\">";
        // line 102
        if ((0 === twig_compare(($context["sort"] ?? null), "e.name"))) {
            echo "<a href=\"";
            echo ($context["sort_name"] ?? null);
            echo "\" class=\"";
            echo twig_lower_filter($this->env, ($context["order"] ?? null));
            echo "\">";
            echo ($context["column_name"] ?? null);
            echo "</a>";
        } else {
            echo "<a href=\"";
            echo ($context["sort_name"] ?? null);
            echo "\">";
            echo ($context["column_name"] ?? null);
            echo "</a>";
        }
        echo "</td>
                      <td class=\"text-left\">";
        // line 103
        if ((0 === twig_compare(($context["sort"] ?? null), "category_name"))) {
            echo "<a href=\"";
            echo ($context["sort_category"] ?? null);
            echo "\" class=\"";
            echo twig_lower_filter($this->env, ($context["order"] ?? null));
            echo "\">";
            echo ($context["column_category"] ?? null);
            echo "</a>";
        } else {
            echo "<a href=\"";
            echo ($context["sort_category"] ?? null);
            echo "\">";
            echo ($context["column_category"] ?? null);
            echo "</a>";
        }
        echo "</td>
                      <td class=\"text-left\">";
        // line 104
        echo ($context["column_member"] ?? null);
        echo "</td>
                      <td class=\"text-right\">";
        // line 105
        if ((0 === twig_compare(($context["sort"] ?? null), "e.price"))) {
            echo "<a href=\"";
            echo ($context["sort_price"] ?? null);
            echo "\" class=\"";
            echo twig_lower_filter($this->env, ($context["order"] ?? null));
            echo "\">";
            echo ($context["column_price"] ?? null);
            echo "</a>";
        } else {
            echo "<a href=\"";
            echo ($context["sort_price"] ?? null);
            echo "\">";
            echo ($context["column_price"] ?? null);
            echo "</a>";
        }
        echo "</td>
                      <td class=\"text-right\">";
        // line 106
        echo ($context["column_stats"] ?? null);
        echo "</td>
                      <td class=\"text-left\">";
        // line 107
        if ((0 === twig_compare(($context["sort"] ?? null), "e.status"))) {
            echo "<a href=\"";
            echo ($context["sort_status"] ?? null);
            echo "\" class=\"";
            echo twig_lower_filter($this->env, ($context["order"] ?? null));
            echo "\">";
            echo ($context["column_status"] ?? null);
            echo "</a>";
        } else {
            echo "<a href=\"";
            echo ($context["sort_status"] ?? null);
            echo "\">";
            echo ($context["column_status"] ?? null);
            echo "</a>";
        }
        echo "</td>
                      <td class=\"text-right\">";
        // line 108
        echo ($context["column_action"] ?? null);
        echo "</td>
                    </tr>
                  </thead>
                  <tbody>
                    ";
        // line 112
        if (($context["extensions"] ?? null)) {
            // line 113
            echo "                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["extensions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["extension"]) {
                // line 114
                echo "                    <tr>
                      <td class=\"text-center\">";
                // line 115
                if (twig_in_filter(twig_get_attribute($this->env, $this->source, $context["extension"], "extension_id", [], "any", false, false, false, 115), ($context["selected"] ?? null))) {
                    // line 116
                    echo "                        <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "extension_id", [], "any", false, false, false, 116);
                    echo "\" checked=\"checked\" />
                        ";
                } else {
                    // line 118
                    echo "                        <input type=\"checkbox\" name=\"selected[]\" value=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "extension_id", [], "any", false, false, false, 118);
                    echo "\" />
                        ";
                }
                // line 119
                echo "</td>
                      <td class=\"text-center\"><img src=\"";
                // line 120
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "image", [], "any", false, false, false, 120);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 120);
                echo "\" class=\"img-thumbnail\" style=\"max-width:40px;max-height:40px;\" /></td>
                      <td class=\"text-left\"><strong>";
                // line 121
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 121);
                echo "</strong>
                        ";
                // line 122
                if (twig_get_attribute($this->env, $this->source, $context["extension"], "recommended", [], "any", false, false, false, 122)) {
                    echo "<span class=\"label label-info\">Recommended</span>";
                }
                // line 123
                echo "                        ";
                if (twig_get_attribute($this->env, $this->source, $context["extension"], "featured", [], "any", false, false, false, 123)) {
                    echo "<span class=\"label label-warning\">Featured</span>";
                }
                // line 124
                echo "                      </td>
                      <td class=\"text-left\">";
                // line 125
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "category", [], "any", false, false, false, 125);
                echo "</td>
                      <td class=\"text-left\">";
                // line 126
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "member", [], "any", false, false, false, 126);
                echo "</td>
                      <td class=\"text-right\">";
                // line 127
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "price", [], "any", false, false, false, 127);
                echo "</td>
                      <td class=\"text-right\">";
                // line 128
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "stats", [], "any", false, false, false, 128);
                echo "</td>
                      <td class=\"text-left\">";
                // line 129
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "status", [], "any", false, false, false, 129);
                echo "</td>
                      <td class=\"text-right\"><a href=\"";
                // line 130
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "edit", [], "any", false, false, false, 130);
                echo "\" data-toggle=\"tooltip\" title=\"";
                echo ($context["button_edit"] ?? null);
                echo "\" class=\"btn btn-primary\"><i class=\"fa fa-pencil\"></i></a></td>
                    </tr>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['extension'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 133
            echo "                    ";
        } else {
            // line 134
            echo "                    <tr>
                      <td class=\"text-center\" colspan=\"9\">";
            // line 135
            echo ($context["text_no_results"] ?? null);
            echo "</td>
                    </tr>
                    ";
        }
        // line 138
        echo "                  </tbody>
                </table>
              </div>
            </form>
            <div class=\"row\">
              <div class=\"col-sm-6 text-left\">";
        // line 143
        echo ($context["pagination"] ?? null);
        echo "</div>
              <div class=\"col-sm-6 text-right\">";
        // line 144
        echo ($context["results"] ?? null);
        echo "</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type=\"text/javascript\"><!--
\$('#button-filter').on('click', function() {
\tvar url = '';

\tvar filter_name = \$('input[name=\\'filter_name\\']').val();
\tif (filter_name) {
\t\turl += '&filter_name=' + encodeURIComponent(filter_name);
\t}

\tvar filter_extension_category_id = \$('select[name=\\'filter_extension_category_id\\']').val();
\tif (filter_extension_category_id !== '') {
\t\turl += '&filter_extension_category_id=' + encodeURIComponent(filter_extension_category_id);
\t}

\tvar filter_license = \$('select[name=\\'filter_license\\']').val();
\tif (filter_license !== '') {
\t\turl += '&filter_license=' + encodeURIComponent(filter_license);
\t}

\tvar filter_status = \$('select[name=\\'filter_status\\']').val();
\tif (filter_status !== '') {
\t\turl += '&filter_status=' + encodeURIComponent(filter_status);
\t}

\tlocation = 'index.php?route=marketplace/extension&user_token=";
        // line 175
        echo ($context["user_token"] ?? null);
        echo "' + url;
});
//--></script>
</div>
";
        // line 179
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "marketplace/extension_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  511 => 179,  504 => 175,  470 => 144,  466 => 143,  459 => 138,  453 => 135,  450 => 134,  447 => 133,  436 => 130,  432 => 129,  428 => 128,  424 => 127,  420 => 126,  416 => 125,  413 => 124,  408 => 123,  404 => 122,  400 => 121,  394 => 120,  391 => 119,  385 => 118,  379 => 116,  377 => 115,  374 => 114,  369 => 113,  367 => 112,  360 => 108,  342 => 107,  338 => 106,  320 => 105,  316 => 104,  298 => 103,  280 => 102,  276 => 101,  267 => 95,  261 => 92,  250 => 84,  245 => 81,  239 => 79,  233 => 77,  230 => 76,  224 => 74,  218 => 72,  216 => 71,  210 => 68,  205 => 65,  199 => 63,  193 => 61,  190 => 60,  184 => 58,  178 => 56,  176 => 55,  170 => 52,  165 => 49,  159 => 48,  151 => 46,  143 => 44,  140 => 43,  136 => 42,  130 => 39,  122 => 36,  118 => 35,  111 => 31,  105 => 27,  97 => 23,  94 => 22,  86 => 18,  84 => 17,  78 => 13,  67 => 11,  63 => 10,  58 => 8,  51 => 6,  45 => 5,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "marketplace/extension_list.twig", "");
    }
}
