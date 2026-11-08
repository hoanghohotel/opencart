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

/* support/partner_info.twig */
class __TwigTemplate_0cde42a8672eebf9fe856c9020174707584eec5f2e1c5d6a9a1b526008b906dd extends Template
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
<div id=\"support-partner-info\">
\t<div class=\"container\">
\t\t<div id=\"partner-details\" class=\"row\">
\t\t\t<div class=\"col-sm-8\">
\t\t\t\t<div class=\"media\">
\t\t\t\t\t<div class=\"media-left\"><a href=\"";
        // line 7
        echo ($context["filter_status"] ?? null);
        echo "\"><img src=\"";
        echo ($context["status_image"] ?? null);
        echo "\" alt=\"";
        echo ($context["status_name"] ?? null);
        echo "\" title=\"";
        echo ($context["status_name"] ?? null);
        echo "\" class=\"media-object img-circle\"/></a></div>
\t\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t\t<h2 class=\"media-heading\">";
        // line 9
        echo ($context["company"] ?? null);
        echo "</h2>
\t\t\t\t\t\t<h6>";
        // line 10
        echo ($context["country"] ?? null);
        echo " | OpenCart Partner since ";
        echo ($context["date_added"] ?? null);
        echo " | <a href=\"";
        echo ($context["website"] ?? null);
        echo "\" target=\"_blank\">View Website</a></h6>
\t\t\t\t\t</div>
\t\t\t\t\t";
        // line 12
        if (($context["image"] ?? null)) {
            // line 13
            echo "\t\t\t\t\t\t<div class=\"media-right\"><a href=\"";
            echo ($context["website"] ?? null);
            echo "\"><img src=\"";
            echo ($context["image"] ?? null);
            echo "\" alt=\"";
            echo ($context["company"] ?? null);
            echo "\" title=\"";
            echo ($context["company"] ?? null);
            echo "\" class=\"media-object\"/></a></div>
\t\t\t\t\t";
        }
        // line 14
        echo " </div>
\t\t\t\t<div>";
        // line 15
        echo ($context["description"] ?? null);
        echo "</div>
\t\t\t</div>
\t\t\t<div class=\"col-sm-4\">
\t\t\t\t<div class=\"well\"><a href=\"";
        // line 18
        echo ($context["contact"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg btn-block\">Contact Partner</a>
\t\t\t\t\t<h4>Phone</h4>
\t\t\t\t\t<p><a href=\"tel:";
        // line 20
        echo ($context["telephone"] ?? null);
        echo "\">";
        echo ($context["telephone"] ?? null);
        echo "</a></p>
\t\t\t\t\t<h4>Address</h4>
\t\t\t\t\t<p>";
        // line 22
        echo ($context["address"] ?? null);
        echo "</p>
\t\t\t\t\t<h4>Partner Status</h4>
\t\t\t\t\t<p>";
        // line 24
        echo ($context["status_name"] ?? null);
        echo "</p>
\t\t\t\t\t";
        // line 25
        if (((($context["facebook"] ?? null) || ($context["twitter"] ?? null)) || ($context["linkedin"] ?? null))) {
            // line 26
            echo "\t\t\t\t\t\t<h4>Social Media</h4>
\t\t\t\t\t\t<p>";
            // line 27
            if (($context["facebook"] ?? null)) {
                echo "<a href=\"";
                echo ($context["facebook"] ?? null);
                echo "\"><img src=\"application/view/image/icon/facebook.jpg\" alt=\"Facebook\" title=\"Facebook\"/></a>";
            }
            // line 28
            echo "\t\t\t\t\t\t\t";
            if (($context["twitter"] ?? null)) {
                echo "<a href=\"";
                echo ($context["twitter"] ?? null);
                echo "\"><img src=\"application/view/image/icon/twitter.jpg\" alt=\"Twitter\" title=\"Twitter\"/></a>";
            }
            // line 29
            echo "\t\t\t\t\t\t\t";
            if (($context["linkedin"] ?? null)) {
                echo "<a href=\"";
                echo ($context["linkedin"] ?? null);
                echo "\"><img src=\"application/view/image/icon/linkedin.jpg\" alt=\"Linkedin\" title=\"Linkedin\"/></a>";
            }
            echo "</p>
\t\t\t\t\t";
        }
        // line 30
        echo "</div>
\t\t\t</div>
\t\t</div>
\t\t";
        // line 33
        if (($context["showcases"] ?? null)) {
            // line 34
            echo "\t\t\t<div id=\"projects\">
\t\t\t\t<h2>Latest Projects</h2>
\t\t\t\t";
            // line 36
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_array_batch(($context["showcases"] ?? null), 3));
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 37
                echo "\t\t\t\t\t<div class=\"row\"> ";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["row"]);
                foreach ($context['_seq'] as $context["_key"] => $context["showcase"]) {
                    // line 38
                    echo "\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t<div class=\"showcase-link\">
\t\t\t\t\t\t\t\t\t<div><a href=\"";
                    // line 40
                    echo twig_get_attribute($this->env, $this->source, $context["showcase"], "link", [], "any", false, false, false, 40);
                    echo "\" target=\"_blank\">View Project</a></div>
\t\t\t\t\t\t\t\t\t<a href=\"";
                    // line 41
                    echo twig_get_attribute($this->env, $this->source, $context["showcase"], "link", [], "any", false, false, false, 41);
                    echo "\" target=\"_blank\"><img src=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["showcase"], "image", [], "any", false, false, false, 41);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["showcase"], "name", [], "any", false, false, false, 41);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["showcase"], "name", [], "any", false, false, false, 41);
                    echo "\"/></a></div>
\t\t\t\t\t\t\t\t<h4>";
                    // line 42
                    echo twig_get_attribute($this->env, $this->source, $context["showcase"], "name", [], "any", false, false, false, 42);
                    echo "</h4>
\t\t\t\t\t\t\t\t<h6>";
                    // line 43
                    echo twig_get_attribute($this->env, $this->source, $context["showcase"], "category", [], "any", false, false, false, 43);
                    echo "</h6>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['showcase'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 45
                echo "</div>
\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 46
            echo "</div>
\t\t";
        }
        // line 47
        echo "</div>
</div>
";
        // line 49
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "support/partner_info.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  208 => 49,  204 => 47,  200 => 46,  193 => 45,  184 => 43,  180 => 42,  170 => 41,  166 => 40,  162 => 38,  157 => 37,  153 => 36,  149 => 34,  147 => 33,  142 => 30,  132 => 29,  125 => 28,  119 => 27,  116 => 26,  114 => 25,  110 => 24,  105 => 22,  98 => 20,  93 => 18,  87 => 15,  84 => 14,  72 => 13,  70 => 12,  61 => 10,  57 => 9,  46 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "support/partner_info.twig", "");
    }
}
