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

/* account/edit.twig */
class __TwigTemplate_e76b2d458fb649237a22c63a19dda8d30478956fd34a6df4463286699b5302a1 extends Template
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
<div id=\"account-edit\">
\t<div class=\"container\">
\t\t<div class=\"row\">
\t\t\t<div class=\"col-sm-9\">
\t\t\t\t<h1>Edit My Information</h1>
\t\t\t\t";
        // line 7
        if (($context["error_warning"] ?? null)) {
            // line 8
            echo "\t\t\t\t\t<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "
\t\t\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t\t\t\t</div>
\t\t\t\t";
        }
        // line 12
        echo "\t\t\t\t<form action=\"";
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\">
\t\t\t\t\t<fieldset>
\t\t\t\t\t\t<legend>Edit your account details</legend>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<label for=\"input-username\">Username</label> <input type=\"text\" name=\"username\" value=\"";
        // line 16
        echo ($context["username"] ?? null);
        echo "\" placeholder=\"Username\" id=\"input-username\" class=\"form-control\"/>
\t\t\t\t\t\t\t";
        // line 17
        if (($context["error_username"] ?? null)) {
            // line 18
            echo "\t\t\t\t\t\t\t\t<div class=\"text-danger\">";
            echo ($context["error_username"] ?? null);
            echo "</div>
\t\t\t\t\t\t\t";
        }
        // line 20
        echo "\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t\t<div class=\"col-sm-6\">
\t\t\t\t\t\t\t\t<div class=\"form-group required\">
\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"input-firstname\">First Name</label> <input type=\"text\" name=\"firstname\" value=\"";
        // line 24
        echo ($context["firstname"] ?? null);
        echo "\" placeholder=\"First Name\" id=\"input-firstname\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t";
        // line 25
        if (($context["error_firstname"] ?? null)) {
            // line 26
            echo "\t\t\t\t\t\t\t\t\t\t<div class=\"text-danger\">";
            echo ($context["error_firstname"] ?? null);
            echo "</div>
\t\t\t\t\t\t\t\t\t";
        }
        // line 28
        echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"col-sm-6\">
\t\t\t\t\t\t\t\t<div class=\"form-group required\">
\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"input-lastname\">Last Name</label> <input type=\"text\" name=\"lastname\" value=\"";
        // line 32
        echo ($context["lastname"] ?? null);
        echo "\" placeholder=\"Last Name\" id=\"input-lastname\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t";
        // line 33
        if (($context["error_lastname"] ?? null)) {
            // line 34
            echo "\t\t\t\t\t\t\t\t\t\t<div class=\"text-danger\">";
            echo ($context["error_lastname"] ?? null);
            echo "</div>
\t\t\t\t\t\t\t\t\t";
        }
        // line 36
        echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"col-sm-6\">
\t\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"input-company\">Company</label> <input type=\"text\" name=\"company\" value=\"";
        // line 40
        echo ($context["company"] ?? null);
        echo "\" placeholder=\"Company Name\" id=\"input-company\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"col-sm-6\">
\t\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t\t\t<label class=\"control-label\" for=\"input-tax-id\">Tax ID</label> <input type=\"text\" name=\"tax_id\" value=\"";
        // line 45
        echo ($context["tax_id"] ?? null);
        echo "\" placeholder=\"Tax ID\" id=\"input-tax-id\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group required\">
\t\t\t\t\t\t\t<label for=\"input-email\">E-Mail</label> <input type=\"text\" name=\"email\" value=\"";
        // line 50
        echo ($context["email"] ?? null);
        echo "\" placeholder=\"E-Mail\" id=\"input-email\" class=\"form-control\"/>
\t\t\t\t\t\t\t";
        // line 51
        if (($context["error_email"] ?? null)) {
            // line 52
            echo "\t\t\t\t\t\t\t\t<div class=\"text-danger\">";
            echo ($context["error_email"] ?? null);
            echo "</div>
\t\t\t\t\t\t\t";
        }
        // line 54
        echo "\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class=\"form-group required\">
\t\t\t\t\t\t\t<label class=\"control-label\" for=\"input-country\">Country</label> <select name=\"country_id\" id=\"input-country\" class=\"form-control\">
\t\t\t\t\t\t\t\t<option value=\"\"></option>
\t\t\t\t\t\t\t\t";
        // line 59
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["countries"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 60
            echo "\t\t\t\t\t\t\t\t\t";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 60), ($context["country_id"] ?? null)))) {
                // line 61
                echo "\t\t\t\t\t\t\t\t\t\t<option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 61);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 61);
                echo "</option>
\t\t\t\t\t\t\t\t\t";
            } else {
                // line 63
                echo "\t\t\t\t\t\t\t\t\t\t<option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 63);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 63);
                echo "</option>
\t\t\t\t\t\t\t\t\t";
            }
            // line 65
            echo "\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 66
        echo "\t\t\t\t\t\t\t</select>
\t\t\t\t\t\t\t";
        // line 67
        if (($context["error_country"] ?? null)) {
            // line 68
            echo "\t\t\t\t\t\t\t\t<div class=\"text-danger\">";
            echo ($context["error_country"] ?? null);
            echo "</div>
\t\t\t\t\t\t\t";
        }
        // line 70
        echo "\t\t\t\t\t\t</div>
\t\t\t\t\t</fieldset>
\t\t\t\t\t<fieldset>
\t\t\t\t\t\t<legend>Profile Picture</legend>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t<div class=\"thumbnail\"><img src=\"";
        // line 77
        echo ($context["thumb"] ?? null);
        echo "\" alt=\"\" title=\"\" id=\"thumb-image\"/> <input type=\"hidden\" name=\"image\" value=\"";
        echo ($context["image"] ?? null);
        echo "\" id=\"input-image\"/></div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t\t\t<div class=\"col-sm-2\">
\t\t\t\t\t\t\t\t\t<button type=\"button\" data-toggle=\"image\" data-target=\"#input-image\" data-thumb=\"#thumb-image\" class=\"btn btn-success btn-block\">Browse</button>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"col-sm-2\">
\t\t\t\t\t\t\t\t\t<button type=\"button\" data-toggle=\"clear\" data-target=\"#input-image\" data-thumb=\"#thumb-image\" data-placeholder=\"";
        // line 85
        echo ($context["placeholder"] ?? null);
        echo "\" class=\"btn btn-default btn-block\">Clear</button>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</fieldset>
\t\t\t\t\t<fieldset>
\t\t\t\t\t\t<legend>Notification Preferences</legend>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t\t\t<div class=\"col-sm-6\">
\t\t\t\t\t\t\t\t\t<p class=\"form-control-static control-label\">Notify Extension Updates</p>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"col-sm-6 text-right\">
\t\t\t\t\t\t\t\t\t<div class=\"radio\">
\t\t\t\t\t\t\t\t\t\t";
        // line 99
        if (($context["notify"] ?? null)) {
            // line 100
            echo "\t\t\t\t\t\t\t\t\t\t\t<label class=\"radio-inline\"><input type=\"radio\" name=\"notify\" value=\"1\" checked=\"checked\"/> Yes</label>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 102
            echo "\t\t\t\t\t\t\t\t\t\t\t<label class=\"radio-inline\"><input type=\"radio\" name=\"notify\" value=\"1\"/> Yes</label>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 104
        echo "\t\t\t\t\t\t\t\t\t\t";
        if ( !($context["notify"] ?? null)) {
            // line 105
            echo "\t\t\t\t\t\t\t\t\t\t\t<label class=\"radio-inline\"><input type=\"radio\" name=\"notify\" value=\"0\" checked=\"checked\"/> No</label>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 107
            echo "\t\t\t\t\t\t\t\t\t\t\t<label class=\"radio-inline\"><input type=\"radio\" name=\"notify\" value=\"0\"/> No</label>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 109
        echo "\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</fieldset>
\t\t\t\t\t<div class=\"text-right\"><a href=\"";
        // line 114
        echo ($context["cancel"] ?? null);
        echo "\" class=\"btn btn-link\">Cancel</a>
\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-primary\">Submit</button>
\t\t\t\t\t</div>
\t\t\t\t</form>
\t\t\t</div>
\t\t\t<div class=\"col-sm-3 hidden-xs\">";
        // line 119
        echo ($context["menu"] ?? null);
        echo "</div>
\t\t</div>
\t</div>
</div>
";
        // line 123
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/edit.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  275 => 123,  268 => 119,  260 => 114,  253 => 109,  249 => 107,  245 => 105,  242 => 104,  238 => 102,  234 => 100,  232 => 99,  215 => 85,  202 => 77,  193 => 70,  187 => 68,  185 => 67,  182 => 66,  176 => 65,  168 => 63,  160 => 61,  157 => 60,  153 => 59,  146 => 54,  140 => 52,  138 => 51,  134 => 50,  126 => 45,  118 => 40,  112 => 36,  106 => 34,  104 => 33,  100 => 32,  94 => 28,  88 => 26,  86 => 25,  82 => 24,  76 => 20,  70 => 18,  68 => 17,  64 => 16,  56 => 12,  48 => 8,  46 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/edit.twig", "");
    }
}
