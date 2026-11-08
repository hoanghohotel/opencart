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

/* account/register.twig */
class __TwigTemplate_224b524704c99d95c47e7e5d594b9c2c3b03428d8aeaf0354ed033cf595ca5bd extends Template
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
<div id=\"account-register\">
  <div id=\"register\" class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-7\">
        <h3>Register for OpenCart account</h3>
        ";
        // line 7
        if (($context["error_warning"] ?? null)) {
            // line 8
            echo "        <div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "
          <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        </div>
        ";
        }
        // line 12
        echo "        <form action=\"";
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\">
          <div class=\"form-group required\">
            <label class=\"control-label\" for=\"input-username\">Username</label>
            <input type=\"text\" name=\"username\" value=\"";
        // line 15
        echo ($context["username"] ?? null);
        echo "\" placeholder=\"Username\" id=\"input-username\" class=\"form-control\"/>
            ";
        // line 16
        if (($context["error_username"] ?? null)) {
            // line 17
            echo "            <div class=\"text-danger\">";
            echo ($context["error_username"] ?? null);
            echo "</div>
            ";
        }
        // line 19
        echo "          </div>
          <div class=\"row\">
            <div class=\"col-sm-6\">
              <div class=\"form-group required\">
                <label class=\"control-label\" for=\"input-firstname\">First Name</label>
                <input type=\"text\" name=\"firstname\" value=\"";
        // line 24
        echo ($context["firstname"] ?? null);
        echo "\" placeholder=\"First Name\" id=\"input-firstname\" class=\"form-control\" />
                ";
        // line 25
        if (($context["error_firstname"] ?? null)) {
            // line 26
            echo "                <div class=\"text-danger\">";
            echo ($context["error_firstname"] ?? null);
            echo "</div>
                ";
        }
        // line 28
        echo "              </div>
            </div>
            <div class=\"col-sm-6\">
              <div class=\"form-group required\">
                <label class=\"control-label\" for=\"input-lastname\">Last Name</label>
                <input type=\"text\" name=\"lastname\" value=\"";
        // line 33
        echo ($context["lastname"] ?? null);
        echo "\" placeholder=\"Last Name\" id=\"input-lastname\" class=\"form-control\" />
                ";
        // line 34
        if (($context["error_lastname"] ?? null)) {
            // line 35
            echo "                <div class=\"text-danger\">";
            echo ($context["error_lastname"] ?? null);
            echo "</div>
                ";
        }
        // line 37
        echo "              </div>
            </div>
          </div>
          <div class=\"form-group required\">
            <label class=\"control-label\" for=\"input-email\">E-Mail</label>
            <input type=\"text\" name=\"email\" value=\"";
        // line 42
        echo ($context["email"] ?? null);
        echo "\" placeholder=\"E-Mail\" id=\"input-email\" class=\"form-control\" />
            ";
        // line 43
        if (($context["error_email"] ?? null)) {
            // line 44
            echo "            <div class=\"text-danger\">";
            echo ($context["error_email"] ?? null);
            echo "</div>
            ";
        }
        // line 46
        echo "          </div>
          <div class=\"form-group required\">
            <label class=\"control-label\" for=\"input-country\">Country</label>
            <select name=\"country_id\" id=\"input-country\" class=\"form-control\">
              <option value=\"\"></option>
              ";
        // line 51
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["countries"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 52
            echo "              ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 52), ($context["country_id"] ?? null)))) {
                // line 53
                echo "              <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 53);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 53);
                echo "</option>
              ";
            } else {
                // line 55
                echo "              <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 55);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 55);
                echo "</option>
              ";
            }
            // line 57
            echo "              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 58
        echo "            </select>
            ";
        // line 59
        if (($context["error_country"] ?? null)) {
            // line 60
            echo "            <div class=\"text-danger\">";
            echo ($context["error_country"] ?? null);
            echo "</div>
            ";
        }
        // line 62
        echo "          </div>
          <div class=\"form-group required\">
            <label class=\"control-label\" for=\"input-password\">Password</label>
            <input type=\"password\" name=\"password\" value=\"";
        // line 65
        echo ($context["password"] ?? null);
        echo "\" id=\"input-password\" class=\"form-control\" />
            ";
        // line 66
        if (($context["error_password"] ?? null)) {
            // line 67
            echo "            <div class=\"text-danger\">";
            echo ($context["error_password"] ?? null);
            echo "</div>
            ";
        }
        // line 69
        echo "          </div>
          ";
        // line 78
        echo "          <div id=\"button-register\" class=\"form-group\">
            <button type=\"submit\" class=\"btn btn-primary btn-lg hidden-xs\">Register</button>
            <button type=\"submit\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Register</button>
          </div>
          <input type=\"hidden\" name=\"redirect\" value=\"";
        // line 82
        echo ($context["redirect"] ?? null);
        echo "\" />
        </form>
      </div>
      <div class=\"col-md-5\">
        <div class=\"well\">
          <h3>Why join OpenCart.com?</h3>
          <ul class=\"list-check\">
            <li>You will be in good hands. More than 350 000+ live stores</li>
            <li>You will have access to 13 000+ Modules and themes in the <a href=\"";
        // line 90
        echo ($context["extension"] ?? null);
        echo "\">OpenCart Marketplace</a>.</li>
            <li>Post questions to the <a href=\"https://forum.opencart.com\">OpenCart Community forum</a> where we have more than 110 000 registered members</li>
            <li>Get a free subscription to our newsletter</li>
            <li>You can apply for an OpenCart Developer account <a href=\"";
        // line 93
        echo ($context["seller"] ?? null);
        echo "\">here</a>.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
";
        // line 100
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/register.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  232 => 100,  222 => 93,  216 => 90,  205 => 82,  199 => 78,  196 => 69,  190 => 67,  188 => 66,  184 => 65,  179 => 62,  173 => 60,  171 => 59,  168 => 58,  162 => 57,  154 => 55,  146 => 53,  143 => 52,  139 => 51,  132 => 46,  126 => 44,  124 => 43,  120 => 42,  113 => 37,  107 => 35,  105 => 34,  101 => 33,  94 => 28,  88 => 26,  86 => 25,  82 => 24,  75 => 19,  69 => 17,  67 => 16,  63 => 15,  56 => 12,  48 => 8,  46 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/register.twig", "");
    }
}
