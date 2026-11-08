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

/* marketplace/promotion_form.twig */
class __TwigTemplate_c4899f794bbec451bf6dd7de540b838d4b27a2613f874fe75acd48a7387d788e extends Template
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
        <button type=\"submit\" form=\"form-promotion\" data-toggle=\"tooltip\" title=\"";
        // line 6
        echo ($context["button_save"] ?? null);
        echo "\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i></button>
        <a href=\"";
        // line 7
        echo ($context["cancel"] ?? null);
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo ($context["button_cancel"] ?? null);
        echo "\" class=\"btn btn-default\"><i class=\"fa fa-reply\"></i></a></div>
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
        echo "    <div class=\"panel panel-default\">
      <div class=\"panel-heading\">
        <h3 class=\"panel-title\"><i class=\"fa fa-pencil\"></i> ";
        // line 24
        echo ($context["text_form"] ?? null);
        echo "</h3>
      </div>
      <div class=\"panel-body\">
        <form action=\"";
        // line 27
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-promotion\" class=\"form-horizontal\">
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-extension\">";
        // line 29
        echo ($context["entry_extension"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <select name=\"extension_id\" id=\"input-extension\" class=\"form-control\">
                ";
        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["extensions"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["extension"]) {
            // line 33
            echo "                ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["extension"], "extension_id", [], "any", false, false, false, 33), ($context["extension_id"] ?? null)))) {
                // line 34
                echo "                <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "extension_id", [], "any", false, false, false, 34);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 34);
                echo "</option>
                ";
            } else {
                // line 36
                echo "                <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "extension_id", [], "any", false, false, false, 36);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 36);
                echo "</option>
                ";
            }
            // line 38
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['extension'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        echo "              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-member\">";
        // line 43
        echo ($context["entry_member"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <select name=\"member_id\" id=\"input-member\" class=\"form-control\">
                ";
        // line 46
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["members"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["member"]) {
            // line 47
            echo "                ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["member"], "member_id", [], "any", false, false, false, 47), ($context["member_id"] ?? null)))) {
                // line 48
                echo "                <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["member"], "member_id", [], "any", false, false, false, 48);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["member"], "username", [], "any", false, false, false, 48);
                echo " (";
                echo twig_get_attribute($this->env, $this->source, $context["member"], "firstname", [], "any", false, false, false, 48);
                echo " ";
                echo twig_get_attribute($this->env, $this->source, $context["member"], "lastname", [], "any", false, false, false, 48);
                echo ")</option>
                ";
            } else {
                // line 50
                echo "                <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["member"], "member_id", [], "any", false, false, false, 50);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["member"], "username", [], "any", false, false, false, 50);
                echo " (";
                echo twig_get_attribute($this->env, $this->source, $context["member"], "firstname", [], "any", false, false, false, 50);
                echo " ";
                echo twig_get_attribute($this->env, $this->source, $context["member"], "lastname", [], "any", false, false, false, 50);
                echo ")</option>
                ";
            }
            // line 52
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['member'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 53
        echo "              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-days\">";
        // line 57
        echo ($context["entry_days"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"days\" value=\"";
        // line 59
        echo ($context["days"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_days"] ?? null);
        echo "\" id=\"input-days\" class=\"form-control\" />
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-total\">";
        // line 63
        echo ($context["entry_total"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"total\" value=\"";
        // line 65
        echo ($context["total"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_total"] ?? null);
        echo "\" id=\"input-total\" class=\"form-control\" />
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-payment-method\">";
        // line 69
        echo ($context["entry_payment_method"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"payment_method\" value=\"";
        // line 71
        echo ($context["payment_method"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_payment_method"] ?? null);
        echo "\" id=\"input-payment-method\" class=\"form-control\" />
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-transaction-id\">";
        // line 75
        echo ($context["entry_transaction_id"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"transaction_id\" value=\"";
        // line 77
        echo ($context["transaction_id"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_transaction_id"] ?? null);
        echo "\" id=\"input-transaction-id\" class=\"form-control\" />
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-order-status\">";
        // line 81
        echo ($context["entry_order_status"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <select name=\"order_status_id\" id=\"input-order-status\" class=\"form-control\">
                ";
        // line 84
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["order_statuses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["order_status"]) {
            // line 85
            echo "                ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 85), ($context["order_status_id"] ?? null)))) {
                // line 86
                echo "                <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 86);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 86);
                echo "</option>
                ";
            } else {
                // line 88
                echo "                <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 88);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 88);
                echo "</option>
                ";
            }
            // line 90
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order_status'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 91
        echo "              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-date-start\">";
        // line 95
        echo ($context["entry_date_start"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"date_start\" value=\"";
        // line 97
        echo ($context["date_start"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_date_start"] ?? null);
        echo "\" id=\"input-date-start\" class=\"form-control\" />
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-date-end\">";
        // line 101
        echo ($context["entry_date_end"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"date_end\" value=\"";
        // line 103
        echo ($context["date_end"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_date_end"] ?? null);
        echo "\" id=\"input-date-end\" class=\"form-control\" />
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-status\">";
        // line 107
        echo ($context["entry_status"] ?? null);
        echo "</label>
            <div class=\"col-sm-10\">
              <select name=\"status\" id=\"input-status\" class=\"form-control\">
                ";
        // line 110
        if (($context["status"] ?? null)) {
            // line 111
            echo "                <option value=\"1\" selected=\"selected\">";
            echo ($context["text_enabled"] ?? null);
            echo "</option>
                <option value=\"0\">";
            // line 112
            echo ($context["text_disabled"] ?? null);
            echo "</option>
                ";
        } else {
            // line 114
            echo "                <option value=\"1\">";
            echo ($context["text_enabled"] ?? null);
            echo "</option>
                <option value=\"0\" selected=\"selected\">";
            // line 115
            echo ($context["text_disabled"] ?? null);
            echo "</option>
                ";
        }
        // line 117
        echo "              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 125
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "marketplace/promotion_form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  360 => 125,  350 => 117,  345 => 115,  340 => 114,  335 => 112,  330 => 111,  328 => 110,  322 => 107,  313 => 103,  308 => 101,  299 => 97,  294 => 95,  288 => 91,  282 => 90,  274 => 88,  266 => 86,  263 => 85,  259 => 84,  253 => 81,  244 => 77,  239 => 75,  230 => 71,  225 => 69,  216 => 65,  211 => 63,  202 => 59,  197 => 57,  191 => 53,  185 => 52,  173 => 50,  161 => 48,  158 => 47,  154 => 46,  148 => 43,  142 => 39,  136 => 38,  128 => 36,  120 => 34,  117 => 33,  113 => 32,  107 => 29,  102 => 27,  96 => 24,  92 => 22,  84 => 18,  82 => 17,  76 => 13,  65 => 11,  61 => 10,  56 => 8,  50 => 7,  46 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "marketplace/promotion_form.twig", "");
    }
}
