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

/* account/security.twig */
class __TwigTemplate_fec9336946346c192b6535ab7864eb51be0d0dfad214892b7575f046d7d1c6b0 extends Template
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
<div id=\"account-security\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>PIN Security Check</h1>
    </div>
  </div>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-8\">";
        // line 10
        if ((0 <= twig_compare(($context["pin_total"] ?? null), 3))) {
            // line 11
            echo "          <div class=\"alert alert-danger\">
            <p><i class=\"fa fa-exclamation-circle\"></i> You have exceeded the allowed number of PIN attempts! Please use the <strong>Reset PIN button</strong> or <a href=\"";
            // line 12
            echo ($context["contact"] ?? null);
            echo "\" class=\"alert-link\">contact us</a> page to request your account to be unlocked.</p>
          </div>
        ";
        } elseif (        // line 14
($context["error_warning"] ?? null)) {
            // line 15
            echo "          <div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "</div>
        ";
        }
        // line 17
        echo "        <h2>Please confirm who you are!</h2>
        <p>Please enter your 4 digit PIN number. This PIN number is to protect your account. When ever you logon from a new device you will be asked for this PIN.</p>
        <p>Do not give your PIN to any one including developers. If you require an extension seller to install an extension for you then you should email them the required extension.</p>
        <form action=\"";
        // line 20
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\">

          <div class=\"form-group\">
            <label for=\"input-pin\">PIN</label>
            <div class=\"input-group\">
            <input type=\"password\" name=\"pin\" value=\"";
        // line 25
        echo ($context["pin"] ?? null);
        echo "\" placeholder=\"PIN\" id=\"input-pin\" class=\"form-control\"/>
              <div class=\"input-group-btn\"><button type=\"button\" id=\"button-reset\" class=\"btn btn-danger btn-lg\"><i class=\"fa fa-refresh\"></i> Reset Pin</button></div>
            </div>
          </div>

          <div class=\"form-group\">
            <button type=\"submit\" class=\"btn btn-primary btn-lg\">Continue</button>
            <input type=\"hidden\" name=\"redirect\" value=\"";
        // line 32
        echo ($context["redirect"] ?? null);
        echo "\" />
          </div>

        </form>
      </div>
      <div class=\"col-md-4\">
        <div id=\"side-banner\">";
        // line 38
        echo ($context["banner"] ?? null);
        echo "</div>
      </div>
    </div>
  </div>
</div>
<script type=\"text/javascript\"><!--
\$('#button-reset').on('click', function () {
    \$.ajax({
        url: 'index.php?route=account/security/reset',
        dataType: 'json',
        crossDomain: true,
        beforeSend: function () {
            \$('#button-reset').button('loading');
        },
        complete: function () {
            \$('#button-reset').button('reset');
        },
        success: function (json) {
            \$('.alert').remove();

            if (json['success']) {
                \$('.container .col-md-8').prepend('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});
//--></script>
";
        // line 68
        echo ($context["footer"] ?? null);
        echo " ";
    }

    public function getTemplateName()
    {
        return "account/security.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  132 => 68,  99 => 38,  90 => 32,  80 => 25,  72 => 20,  67 => 17,  61 => 15,  59 => 14,  54 => 12,  51 => 11,  49 => 10,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/security.twig", "");
    }
}
