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

/* account/login.twig */
class __TwigTemplate_b0432f514ac1fbc08d41e42fb9d4bb83ef93c0835733f6f1e5650c7950ece9f2 extends Template
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
<div id=\"account-login\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>Log in to your OpenCart account</h1>
    </div>
  </div>
  <div class=\"container\">
    ";
        // line 9
        if (($context["error_warning"] ?? null)) {
            // line 10
            echo "      <div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
      </div>
    ";
        }
        // line 14
        echo "    ";
        if (($context["success"] ?? null)) {
            // line 15
            echo "      <div class=\"alert alert-success\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["success"] ?? null);
            echo "
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
      </div>
    ";
        }
        // line 19
        echo "    <div class=\"row\">
      <div class=\"col-sm-6 col-md-6\">
        <h3>Login</h3>
        <form action=\"";
        // line 22
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\">
          <div class=\"form-group\">
            <label for=\"input-email\">Email</label> <input type=\"text\" name=\"email\" value=\"";
        // line 24
        echo ($context["email"] ?? null);
        echo "\" placeholder=\"Email\" id=\"input-email\" class=\"form-control\"/>
          </div>
          <div class=\"form-group\">
            <label for=\"input-password\">Password</label> <input type=\"password\" name=\"password\" value=\"";
        // line 27
        echo ($context["password"] ?? null);
        echo "\" placeholder=\"Password\" id=\"input-password\" class=\"form-control\"/>
          </div>
          <div class=\"row\">
            <div class=\"col-sm-6\">
              <button type=\"submit\" class=\"btn btn-primary btn-lg hidden-xs\">Login</button>
              <button type=\"submit\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Login</button>
            </div>
            <div class=\"col-sm-6 text-right\"><a href=\"";
        // line 34
        echo ($context["forgotten"] ?? null);
        echo "\" class=\"btn-link\">Forgot your password?</a></div>
          </div>
          <input type=\"hidden\" name=\"redirect\" value=\"";
        // line 36
        echo ($context["redirect"] ?? null);
        echo "\"/>
        </form>
      </div>
      <div class=\"col-sm-6 col-md-6\">
        <h3 class=\"right\">Do not have an account?</h3>
        <p><a href=\"";
        // line 41
        echo ($context["register"] ?? null);
        echo "\">Create an OpenCart account</a>. By creating an account with our store, you will be able to download more features through marketplace, uploading showcase and become Partner and Seller.
          <br/>
        </p>
        <div id=\"need-help\" class=\"media\">
          <div class=\"media-left\"><img src=\"application/view/image/account/icon_ds_star.png\" alt=\"\" title=\"\"/></div>
          <div class=\"media-body\">Looking for professional support for your project?
            <br/>
            OpenCart now offers dedicated technical support.
            <p><a href=\"https://dedicated.opencart.com/\">Learn more about Dedicated Support</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
";
        // line 56
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  126 => 56,  108 => 41,  100 => 36,  95 => 34,  85 => 27,  79 => 24,  74 => 22,  69 => 19,  61 => 15,  58 => 14,  50 => 10,  48 => 9,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/login.twig", "");
    }
}
