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

/* account/subscription_list.twig */
class __TwigTemplate_f90c74831551fffbe1bc427d7064320b9917bdb12bb5fcabec4ff104b64c74ba extends Template
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
<div id=\"account-subscription\">
    <div class=\"page-header\">
        <div class=\"container\">
            <h1>Cloud Stores</h1>
            <p>View all of your OpenCart Cloud Stores</p>
        </div>
    </div>
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-md-9\">
                <h2>Cloud Stores</h2>
                <div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> Cloud service is currently unavailable for new stores!</div>
                ";
        // line 14
        if (($context["error_warning"] ?? null)) {
            // line 15
            echo "                    <div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "</div>
                ";
        }
        // line 17
        echo "                ";
        if (($context["success"] ?? null)) {
            // line 18
            echo "                    <div class=\"alert alert-success\"><i class=\"fa fa-check-circle\"></i> ";
            echo ($context["success"] ?? null);
            echo "</div>
                ";
        }
        // line 20
        echo "                <div class=\"table-responsive\">
                    <table id=\"subscription-table\" class=\"table table-bordered table-hover\">
                        ";
        // line 22
        if (($context["subscriptions"] ?? null)) {
            // line 23
            echo "                            <thead>
                            <tr>
                                <th class=\"text-left\">Store Name</th>
                                <th class=\"text-left\">Plan</th>
                                <th class=\"text-center\">Status</th>
                                <th class=\"text-left\">Created</th>
                                <th class=\"text-right\">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            ";
            // line 33
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["subscriptions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["subscription"]) {
                // line 34
                echo "                                <tr>
                                    <td class=\"text-left\">";
                // line 35
                echo twig_get_attribute($this->env, $this->source, $context["subscription"], "name", [], "any", false, false, false, 35);
                echo "</td>
                                    <td class=\"text-left\">";
                // line 36
                echo twig_get_attribute($this->env, $this->source, $context["subscription"], "subscription_plan", [], "any", false, false, false, 36);
                echo "</td>
                                    <td class=\"text-center\">
                                        <span ";
                // line 38
                if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["subscription"], "subscription_status_id", [], "any", false, false, false, 38), ($context["subscription_active_status"] ?? null)))) {
                    echo "class=\"label label-success\"";
                } else {
                    echo "class=\"label label-danger\"";
                }
                echo ">";
                echo twig_get_attribute($this->env, $this->source, $context["subscription"], "subscription_status", [], "any", false, false, false, 38);
                echo "</span>
                                    </td>
                                    <td class=\"text-left\">";
                // line 40
                echo twig_get_attribute($this->env, $this->source, $context["subscription"], "date_added", [], "any", false, false, false, 40);
                echo "</td>
                                    <td class=\"text-right\">
                                        <div class=\"btn-group dropdown\">
                                            <button class=\"btn btn-default\"
                                                type=\"button\"
                                                data-toggle=\"dropdown\">
                                                <span>Actions <span class=\"caret\"></span></span>
                                            </button>
                                            <ul class=\"dropdown-menu\">
                                                <li><a href=\"";
                // line 49
                echo twig_get_attribute($this->env, $this->source, $context["subscription"], "backup", [], "any", false, false, false, 49);
                echo "\"><i class=\"fa fa-file\" aria-hidden=\"true\"></i> Filebase Backup</a></li>
                                                <li><a href=\"";
                // line 50
                echo twig_get_attribute($this->env, $this->source, $context["subscription"], "database_backup", [], "any", false, false, false, 50);
                echo "\"><i class=\"fa fa-database\" aria-hidden=\"true\"></i> Database Backup</a></li>
                                                <li><a href=\"";
                // line 51
                echo twig_get_attribute($this->env, $this->source, $context["subscription"], "history_url", [], "any", false, false, false, 51);
                echo "\"><i class=\"fa fa-list\" aria-hidden=\"true\"></i> View Log</a></li>
                                            </ul>
                                        </div>
                                        <a href=\"";
                // line 54
                echo twig_get_attribute($this->env, $this->source, $context["subscription"], "view", [], "any", false, false, false, 54);
                echo "\" class=\"btn btn-info button-click-load\"
                                           data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit Cloud Store\">EDIT</a>
                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['subscription'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 59
            echo "                            </tbody>
                        ";
        } else {
            // line 61
            echo "                            <tbody>
                            <tr>
                                <td class=\"text-center\">No Cloud Stores Found!</td>
                            </tr>
                            </tbody>
                        ";
        }
        // line 67
        echo "                    </table>
                </div>
                <nav>";
        // line 69
        echo ($context["pagination"] ?? null);
        echo "</nav>
                <div class=\"text-right\"><a href=\"";
        // line 70
        echo ($context["cancel"] ?? null);
        echo "\" class=\"btn btn-link\">Cancel</a>
                ";
        // line 72
        echo "                </div>
            </div>
            <div class=\"col-md-3 hidden-xs\">";
        // line 74
        echo ($context["menu"] ?? null);
        echo "</div>
        </div>
    </div>
</div>
<script type=\"text/javascript\">
    \$('.table-responsive').on('show.bs.dropdown', function () {
     \$('.table-responsive').css( \"overflow\", \"inherit\" );
    });

    \$('.table-responsive').on('hide.bs.dropdown', function () {
        \$('.table-responsive').css( \"overflow\", \"auto\" );
    })
</script>
";
        // line 87
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/subscription_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  196 => 87,  180 => 74,  176 => 72,  172 => 70,  168 => 69,  164 => 67,  156 => 61,  152 => 59,  141 => 54,  135 => 51,  131 => 50,  127 => 49,  115 => 40,  104 => 38,  99 => 36,  95 => 35,  92 => 34,  88 => 33,  76 => 23,  74 => 22,  70 => 20,  64 => 18,  61 => 17,  55 => 15,  53 => 14,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/subscription_list.twig", "");
    }
}
