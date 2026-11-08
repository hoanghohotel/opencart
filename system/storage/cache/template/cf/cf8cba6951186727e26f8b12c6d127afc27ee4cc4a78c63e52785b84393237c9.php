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

/* account/extension_list.twig */
class __TwigTemplate_d454925d42324a964db7929dda5cf65e2c753aaf85e27985a705a325c4d0a47b extends Template
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
<div id=\"account-extension\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>Extension</h1>
      <p>Manage the extensions you have uploads</p>
    </div>
  </div>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-9\">
        <h2>Extensions</h2>
        ";
        // line 13
        if (($context["error_warning"] ?? null)) {
            // line 14
            echo "          <div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i>";
            echo ($context["error_warning"] ?? null);
            echo "
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
          </div>
        ";
        }
        // line 18
        echo "        ";
        if (($context["success"] ?? null)) {
            // line 19
            echo "          <div class=\"alert alert-success\"><i class=\"fa fa-check-circle\"></i> ";
            echo ($context["success"] ?? null);
            echo "
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
          </div>
        ";
        }
        // line 23
        echo "        <form action=\"";
        echo ($context["delete"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-extension\">
          <div class=\"table-responsive\">
            <table id=\"extension-list\" class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <th class=\"text-left\">Extension Name</th>
                  <th class=\"text-left\">Status</th>
                  <th class=\"text-left\">Date Added</th>
                  <th class=\"text-right\">Action</th>
                </tr>
              </thead>
              <tbody>
                ";
        // line 35
        if (($context["extensions"] ?? null)) {
            // line 36
            echo "                  ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["extensions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["extension"]) {
                // line 37
                echo "                    <tr>
                      <td class=\"text-left\">";
                // line 38
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 38);
                echo "</td>
                      <td class=\"text-left\">";
                // line 39
                if (twig_get_attribute($this->env, $this->source, $context["extension"], "publish", [], "any", false, false, false, 39)) {
                    echo "<span class=\"label label-success\">Enabled</span> ";
                } else {
                    echo " <span class=\"label label-danger\">Disable</span> ";
                }
                echo " </td>
                      <td class=\"text-left\">";
                // line 40
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "date_added", [], "any", false, false, false, 40);
                echo "</td>
                      <td class=\"text-right\"><a href=\"";
                // line 41
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "view", [], "any", false, false, false, 41);
                echo "\" class=\"btn btn-info\">View</a> <a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "edit", [], "any", false, false, false, 41);
                echo "\" class=\"btn btn-primary\">Edit</a> <button type=\"button\" onclick=\"confirm('Are you sure?') ? location = '";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "delete", [], "any", false, false, false, 41);
                echo "' : '';\" class=\"btn btn-danger\">Delete</button></td>
                    </tr>
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['extension'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 44
            echo "                ";
        } else {
            // line 45
            echo "                  <tr>
                    <td class=\"text-center\" colspan=\"4\">No results!</td>
                  </tr>
                ";
        }
        // line 49
        echo "              </tbody>
            </table>
          </div>
          <nav>";
        // line 52
        echo ($context["pagination"] ?? null);
        echo "</nav>
          <div class=\"text-right\"><a href=\"";
        // line 53
        echo ($context["cancel"] ?? null);
        echo "\" class=\"btn btn-link\">Cancel</a> <a href=\"";
        echo ($context["add"] ?? null);
        echo "\" class=\"btn btn-primary\">Add Extension</a></div>
        </form>
      </div>
      <div class=\"col-md-3 hidden-xs\">";
        // line 56
        echo ($context["menu"] ?? null);
        echo "</div>
    </div>
  </div>
</div>
";
        // line 60
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/extension_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  161 => 60,  154 => 56,  146 => 53,  142 => 52,  137 => 49,  131 => 45,  128 => 44,  115 => 41,  111 => 40,  103 => 39,  99 => 38,  96 => 37,  91 => 36,  89 => 35,  73 => 23,  65 => 19,  62 => 18,  54 => 14,  52 => 13,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/extension_list.twig", "");
    }
}
