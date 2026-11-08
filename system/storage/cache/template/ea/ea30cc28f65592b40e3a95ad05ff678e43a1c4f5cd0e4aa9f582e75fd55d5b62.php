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

/* account/order_list.twig */
class __TwigTemplate_e0056b2154c6e35ae9343983aa47c79111abac0eb8f4ca222e0c75796948c500 extends Template
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
<div id=\"account-order\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>Order History</h1>
      <p>View the extensions you have previously purchased</p>
    </div>
  </div>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-9\">";
        // line 11
        if (($context["success"] ?? null)) {
            // line 12
            echo "          <div class=\"alert alert-success\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["success"] ?? null);
            echo "
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
          </div>
        ";
        }
        // line 16
        echo "        <fieldset>
          <legend>Your Orders</legend>
          <div class=\"table-responsive\">
            <table class=\"table table-bordered\">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Extension Name</th>
                  <th>Amount</th>
                  <th class=\"text-center\">Status</th>
                  <th>Add Date</th>
                  <th class=\"text-right\">Action</th>
                </tr>
              </thead>
              <tbody>
                ";
        // line 31
        if (($context["orders"] ?? null)) {
            // line 32
            echo "                  ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["orders"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["order"]) {
                // line 33
                echo "                    <tr>
                      <td>";
                // line 34
                echo twig_get_attribute($this->env, $this->source, $context["order"], "order_id", [], "any", false, false, false, 34);
                echo "</td>
                      <td>";
                // line 35
                echo twig_get_attribute($this->env, $this->source, $context["order"], "extension", [], "any", false, false, false, 35);
                echo "</td>
                      <td>";
                // line 36
                echo twig_get_attribute($this->env, $this->source, $context["order"], "total", [], "any", false, false, false, 36);
                echo "</td>
                      <td class=\"text-center\">";
                // line 37
                if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["order"], "order_status_id", [], "any", false, false, false, 37), ($context["config_download_status_id"] ?? null)))) {
                    // line 38
                    echo "                          <span class=\"label label-success\">";
                    echo twig_get_attribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 38);
                    echo "</span>
                        ";
                } elseif ((0 === twig_compare(twig_get_attribute($this->env, $this->source,                 // line 39
$context["order"], "order_status_id", [], "any", false, false, false, 39), ($context["config_order_status_id"] ?? null)))) {
                    // line 40
                    echo "                          <span class=\"label label-warning\">";
                    echo twig_get_attribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 40);
                    echo "</span>
                        ";
                } else {
                    // line 42
                    echo "                          <span class=\"label label-danger\">";
                    echo twig_get_attribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 42);
                    echo "</span>
                        ";
                }
                // line 43
                echo "</td>
                      <td>";
                // line 44
                echo twig_get_attribute($this->env, $this->source, $context["order"], "date_added", [], "any", false, false, false, 44);
                echo "</td>
                      <td class=\"text-right\"><a href=\"";
                // line 45
                echo twig_get_attribute($this->env, $this->source, $context["order"], "href", [], "any", false, false, false, 45);
                echo "\" data-toggle=\"tooltip\" title=\"view\" class=\"btn btn-info\"><i class=\"fa fa-eye\"></i></a></td>
                    </tr>
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 48
            echo "                ";
        } else {
            // line 49
            echo "                  <tr>
                    <td class=\"text-center\" colspan=\"6\">No results!</td>
                  </tr>
                ";
        }
        // line 53
        echo "              </tbody>
            </table>
          </div>
          <nav>";
        // line 56
        echo ($context["pagination"] ?? null);
        echo "</nav>
        </fieldset>
      </div>
      <div class=\"col-md-3 hidden-xs\">";
        // line 59
        echo ($context["menu"] ?? null);
        echo "</div>
    </div>
  </div>
</div>
";
        // line 63
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/order_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  163 => 63,  156 => 59,  150 => 56,  145 => 53,  139 => 49,  136 => 48,  127 => 45,  123 => 44,  120 => 43,  114 => 42,  108 => 40,  106 => 39,  101 => 38,  99 => 37,  95 => 36,  91 => 35,  87 => 34,  84 => 33,  79 => 32,  77 => 31,  60 => 16,  52 => 12,  50 => 11,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/order_list.twig", "");
    }
}
