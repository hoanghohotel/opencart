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

/* account/download_list.twig */
class __TwigTemplate_5b077c099aff302ccec78a9933eb67fb09d98d1662c3c491c8bc28f19a7a6e12 extends Template
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
<div id=\"account-download\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>My Downloads</h1>
      <p>Your Purchased extensions</p>
    </div>
  </div>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-9\">
        <h1>My Downloads</h1>
        ";
        // line 13
        if (($context["downloads"] ?? null)) {
            // line 14
            echo "
          ";
            // line 15
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["downloads"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["download"]) {
                // line 16
                echo "            <div id=\"downloads-list\">
              <div class=\"row\">
                <div class=\"col-sm-4\"><img src=\"";
                // line 18
                echo twig_get_attribute($this->env, $this->source, $context["download"], "image", [], "any", false, false, false, 18);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["download"], "name", [], "any", false, false, false, 18);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["download"], "name", [], "any", false, false, false, 18);
                echo "\" class=\"img-responsive\"/></div>
                <div class=\"col-sm-8\">
                  <h3>";
                // line 20
                echo twig_get_attribute($this->env, $this->source, $context["download"], "name", [], "any", false, false, false, 20);
                echo "</h3>
                  <ul>
                    <li>Purchased on <strong>";
                // line 22
                echo twig_get_attribute($this->env, $this->source, $context["download"], "date_added", [], "any", false, false, false, 22);
                echo "</strong></li>
                    <li>Last updated on <strong>";
                // line 23
                echo twig_get_attribute($this->env, $this->source, $context["download"], "date_modified", [], "any", false, false, false, 23);
                echo "</strong></li>
                  </ul>
                  <p id=\"download-buttons\"><a href=\"";
                // line 25
                echo twig_get_attribute($this->env, $this->source, $context["download"], "href", [], "any", false, false, false, 25);
                echo "\" class=\"btn btn-primary btn-sm\">Download Extension</a> <a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["download"], "extension", [], "any", false, false, false, 25);
                echo "\" class=\"btn btn-link\">[Go to extension page]</a></p>
                  ";
                // line 26
                if (twig_get_attribute($this->env, $this->source, $context["download"], "license", [], "any", false, false, false, 26)) {
                    // line 27
                    echo "                    ";
                    if (twig_get_attribute($this->env, $this->source, $context["download"], "valid", [], "any", false, false, false, 27)) {
                        // line 28
                        echo "                      <div class=\"support-valid-date\">
                        <p>Support and Updates Available TILL</p>
                        <h4>";
                        // line 30
                        echo twig_get_attribute($this->env, $this->source, $context["download"], "date_valid", [], "any", false, false, false, 30);
                        echo "</h4>
                      </div>
                    ";
                    } else {
                        // line 33
                        echo "                      <div class=\"support-valid-date support-valid-date-expired\">
                        <p>Support and Updates Available TILL</p>
                        <h4>";
                        // line 35
                        echo twig_get_attribute($this->env, $this->source, $context["download"], "date_valid", [], "any", false, false, false, 35);
                        echo "</h4>
                      </div>
                    ";
                    }
                    // line 38
                    echo "                  ";
                }
                // line 39
                echo "                </div>
              </div>
            </div>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['download'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 43
            echo "
          <nav>";
            // line 44
            echo ($context["pagination"] ?? null);
            echo "</nav>
        ";
        } else {
            // line 46
            echo "        <table class=\"table table-bordered table-hover\">
          <tbody>
            <tr>
              <td class=\"text-center\">Sorry, You haven't purchased any items!</td>
            </tr>
          </tbody>
        </table>
        ";
        }
        // line 54
        echo "      </div>
      <div class=\"col-md-3 hidden-xs\">";
        // line 55
        echo ($context["menu"] ?? null);
        echo "</div>
    </div>
  </div>
</div>
";
        // line 59
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/download_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  159 => 59,  152 => 55,  149 => 54,  139 => 46,  134 => 44,  131 => 43,  122 => 39,  119 => 38,  113 => 35,  109 => 33,  103 => 30,  99 => 28,  96 => 27,  94 => 26,  88 => 25,  83 => 23,  79 => 22,  74 => 20,  65 => 18,  61 => 16,  57 => 15,  54 => 14,  52 => 13,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/download_list.twig", "");
    }
}
