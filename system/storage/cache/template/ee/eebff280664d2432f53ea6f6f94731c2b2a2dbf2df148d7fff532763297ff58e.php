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

/* support/partner_list.twig */
class __TwigTemplate_b16b11ed95ee87cfc10b93a7ceb67db26740c4c18e7c7949aaa244cd3f2fc88d extends Template
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
<div id=\"support-partner\">
\t<div class=\"page-header\">
\t\t<div class=\"container\">
\t\t\t<h1>Your eCommerce success delivered by seasoned OpenCart experts</h1>
\t\t\t<p>Connect with the right team to design, develop and build your eCommerce store</p>
\t\t</div>
\t</div>
\t<div class=\"container\">
\t\t<div class=\"row\">
\t\t\t<div class=\"col-sm-4 col-md-3\">
\t\t\t\t<section id=\"partner-country\">
\t\t\t\t\t<h4>Country</h4>
\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t<select class=\"form-control\" onchange=\"location = this.value\">
\t\t\t\t\t\t\t";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["countries"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 17
            echo "\t\t\t\t\t\t\t\t";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 17), ($context["filter_country_id"] ?? null)))) {
                // line 18
                echo "\t\t\t\t\t\t\t\t\t<option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "href", [], "any", false, false, false, 18);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 18);
                echo "</option>
\t\t\t\t\t\t\t\t";
            } else {
                // line 20
                echo "\t\t\t\t\t\t\t\t\t<option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "href", [], "any", false, false, false, 20);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 20);
                echo "</option>
\t\t\t\t\t\t\t\t";
            }
            // line 22
            echo "\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        echo "\t\t\t\t\t\t</select>
\t\t\t\t\t</div>
\t\t\t\t</section>

\t\t\t\t<section id=\"partner-type\">
\t\t\t\t\t<h4>Type</h4>
\t\t\t\t\t";
        // line 29
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["partner_types"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["partner_type"]) {
            // line 30
            echo "\t\t\t\t\t\t";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["partner_type"], "member_partner_type_id", [], "any", false, false, false, 30), ($context["filter_type_id"] ?? null)))) {
                // line 31
                echo "\t\t\t\t\t\t\t<div class=\"radio\">
\t\t\t\t\t\t\t\t<label onclick=\"location = '";
                // line 32
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "href", [], "any", false, false, false, 32);
                echo "'\"> <input type=\"radio\" name=\"partner_type\" value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "href", [], "any", false, false, false, 32);
                echo "\" checked=\"checked\">
\t\t\t\t\t\t\t\t\t";
                // line 33
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "name", [], "any", false, false, false, 33);
                echo "</label>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
            } else {
                // line 36
                echo "\t\t\t\t\t\t\t<div class=\"radio\" onclick=\"location = '";
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "href", [], "any", false, false, false, 36);
                echo "'\">
\t\t\t\t\t\t\t\t<label> <input type=\"radio\" name=\"partner_type\" value=\"";
                // line 37
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "href", [], "any", false, false, false, 37);
                echo "\"/>
\t\t\t\t\t\t\t\t\t";
                // line 38
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "name", [], "any", false, false, false, 38);
                echo "</label>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
            }
            // line 41
            echo "\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['partner_type'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        echo "\t\t\t\t</section>

\t\t\t\t<section id=\"partner-status\">
\t\t\t\t\t<h4>Status</h4>
\t\t\t\t\t";
        // line 46
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["partner_statuses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["partner_status"]) {
            // line 47
            echo "\t\t\t\t\t\t";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["partner_status"], "member_partner_status_id", [], "any", false, false, false, 47), ($context["filter_status_id"] ?? null)))) {
                // line 48
                echo "\t\t\t\t\t\t\t<div class=\"radio\">
\t\t\t\t\t\t\t\t<label onclick=\"location = '";
                // line 49
                echo twig_get_attribute($this->env, $this->source, $context["partner_status"], "href", [], "any", false, false, false, 49);
                echo "'\"> <input type=\"radio\" name=\"partner_status\" value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["partner_status"], "member_partner_status_id", [], "any", false, false, false, 49);
                echo "\" checked=\"checked\">
\t\t\t\t\t\t\t\t\t";
                // line 50
                echo twig_get_attribute($this->env, $this->source, $context["partner_status"], "name", [], "any", false, false, false, 50);
                echo "</label>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
            } else {
                // line 53
                echo "\t\t\t\t\t\t\t<div class=\"radio\">
\t\t\t\t\t\t\t\t<label onclick=\"location = '";
                // line 54
                echo twig_get_attribute($this->env, $this->source, $context["partner_status"], "href", [], "any", false, false, false, 54);
                echo "'\"> <input type=\"radio\" name=\"partner_status\" value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["partner_status"], "member_partner_status_id", [], "any", false, false, false, 54);
                echo "\"/>
\t\t\t\t\t\t\t\t\t";
                // line 55
                echo twig_get_attribute($this->env, $this->source, $context["partner_status"], "name", [], "any", false, false, false, 55);
                echo "</label>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
            }
            // line 58
            echo "\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['partner_status'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 59
        echo "\t\t\t\t</section>
\t\t\t</div>
\t\t\t<div class=\"col-sm-8 col-md-9\">
\t\t\t\t";
        // line 62
        if (($context["country"] ?? null)) {
            // line 63
            echo "\t\t\t\t\t<h3>Partners for ";
            echo ($context["country"] ?? null);
            echo "</h3>
\t\t\t\t";
        } else {
            // line 65
            echo "\t\t\t\t\t<h3>Worldwide Partners</h3>
\t\t\t\t";
        }
        // line 67
        echo "
\t\t\t\t";
        // line 68
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["partners"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["partner"]) {
            // line 69
            echo "\t\t\t\t\t<section id=\"partner-list\">
\t\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t\t<div class=\"col-xs-6\">
\t\t\t\t\t\t\t\t<div class=\"media\">
\t\t\t\t\t\t\t\t\t<div class=\"media-left\"><img src=\"";
            // line 73
            echo twig_get_attribute($this->env, $this->source, $context["partner"], "status_image", [], "any", false, false, false, 73);
            echo "\" title=\"";
            echo twig_get_attribute($this->env, $this->source, $context["partner"], "status_name", [], "any", false, false, false, 73);
            echo "\" alt=\"";
            echo twig_get_attribute($this->env, $this->source, $context["partner"], "status_name", [], "any", false, false, false, 73);
            echo "\" class=\"media-object\"/></div>
\t\t\t\t\t\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t\t\t\t\t\t<h4>";
            // line 75
            echo twig_get_attribute($this->env, $this->source, $context["partner"], "company", [], "any", false, false, false, 75);
            echo "</h4>
\t\t\t\t\t\t\t\t\t\t<h6>";
            // line 76
            echo twig_get_attribute($this->env, $this->source, $context["partner"], "country", [], "any", false, false, false, 76);
            echo "</h6>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t";
            // line 80
            if (twig_get_attribute($this->env, $this->source, $context["partner"], "image", [], "any", false, false, false, 80)) {
                // line 81
                echo "\t\t\t\t\t\t\t\t<div class=\"col-xs-6 text-right\"><img src=\"";
                echo twig_get_attribute($this->env, $this->source, $context["partner"], "image", [], "any", false, false, false, 81);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["partner"], "company", [], "any", false, false, false, 81);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["partner"], "company", [], "any", false, false, false, 81);
                echo "\"/></div>
\t\t\t\t\t\t\t";
            }
            // line 83
            echo "\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t\t<div class=\"col-xs-12\">
\t\t\t\t\t\t\t\t<p>";
            // line 86
            echo twig_get_attribute($this->env, $this->source, $context["partner"], "description", [], "any", false, false, false, 86);
            echo "</p>
\t\t\t\t\t\t\t\t<p><a href=\"";
            // line 87
            echo twig_get_attribute($this->env, $this->source, $context["partner"], "href", [], "any", false, false, false, 87);
            echo "\" class=\"btn btn-primary btn-sm\">View Partner</a></p>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</section>
\t\t\t\t\t<hr/>
\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['partner'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 93
        echo "\t\t\t\t<nav>";
        echo ($context["pagination"] ?? null);
        echo "</nav>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container-fluid\">
\t\t<div class=\"container\">
\t\t\t<div class=\"media\">
\t\t\t\t<div class=\"media-left\"><img src=\"application/view/image/partner/device.png\" title=\"\" alt=\"\" class=\"media-object\"/></div>
\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t<h4 class=\"media-heading\">About the Professional Partners Programme</h4>
\t\t\t\t\t<p>Opencart partner works closely with to strengthen the existence of the project by continuing to improve the services provided to the growing community, and to secure relationships with businesses that care about the projects existence.</p>
\t\t\t\t\t<p>To apply to become a OpenCart Certified Partner please email OpenCart for further details.</p>
\t\t\t\t\t<p><a href=\"";
        // line 105
        echo ($context["add"] ?? null);
        echo "\" class=\"btn btn-primary\">Apply Now</a></p>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
</div>
";
        // line 111
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "support/partner_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  292 => 111,  283 => 105,  267 => 93,  255 => 87,  251 => 86,  246 => 83,  236 => 81,  234 => 80,  227 => 76,  223 => 75,  214 => 73,  208 => 69,  204 => 68,  201 => 67,  197 => 65,  191 => 63,  189 => 62,  184 => 59,  178 => 58,  172 => 55,  166 => 54,  163 => 53,  157 => 50,  151 => 49,  148 => 48,  145 => 47,  141 => 46,  135 => 42,  129 => 41,  123 => 38,  119 => 37,  114 => 36,  108 => 33,  102 => 32,  99 => 31,  96 => 30,  92 => 29,  84 => 23,  78 => 22,  70 => 20,  62 => 18,  59 => 17,  55 => 16,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "support/partner_list.twig", "");
    }
}
