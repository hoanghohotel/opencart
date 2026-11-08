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

/* common/footer.twig */
class __TwigTemplate_323b67ef9a8fc9a996b6f89c20060548c8ab6ca6e1a7aed3152a38891343d770 extends Template
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
        echo "
<footer>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-sm-2\">
        <section>
          <h5>OpenCart</h5>
          <ul class=\"list-unstyled\">
            <li><a href=\"";
        // line 9
        echo ($context["feature"] ?? null);
        echo "\">Features</a></li>
            ";
        // line 10
        if (($context["cloud"] ?? null)) {
            // line 11
            echo "            <li><a href=\"";
            echo ($context["cloud"] ?? null);
            echo "\">OpenCart Cloud</a></li>
            ";
        }
        // line 13
        echo "            <li><a href=\"";
        echo ($context["showcase"] ?? null);
        echo "\">Showcase</a></li>
            <li><a href=\"";
        // line 14
        echo ($context["demo"] ?? null);
        echo "\">Demo</a></li>
            <li><a href=\"";
        // line 15
        echo ($context["download"] ?? null);
        echo "\">Download</a></li>
            <li><a href=\"";
        // line 16
        echo ($context["marketplace"] ?? null);
        echo "\">Marketplace</a></li>
            <li><a href=\"";
        // line 17
        echo ($context["login"] ?? null);
        echo "\">Login</a></li>
          </ul>
        </section>
      </div>
      <div class=\"col-sm-2\">
        <section>
          <h5>Company</h5>
          <ul class=\"list-unstyled\">
            <li><a href=\"";
        // line 25
        echo ($context["contact"] ?? null);
        echo "\">Contact Us</a></li>
            <li><a href=\"";
        // line 26
        echo ($context["advertise"] ?? null);
        echo "\">Extension Advertising</a></li>
            <li><a href=\"";
        // line 27
        echo ($context["advertise"] ?? null);
        echo "\">Marketplace Advertising</a></li>
            <li><a href=\"";
        // line 28
        echo ($context["company"] ?? null);
        echo "\">About Us</a></li>
            <li><a href=\"";
        // line 29
        echo ($context["terms"] ?? null);
        echo "\">Terms & Conditions</a></li>
            <li><a href=\"";
        // line 30
        echo ($context["privacy"] ?? null);
        echo "\">Privacy Policy</a></li>
            <li><a href=\"";
        // line 31
        echo ($context["refund"] ?? null);
        echo "\">Refund Policy</a></li>
            <li><a href=\"";
        // line 32
        echo ($context["gdpr"] ?? null);
        echo "\">GDPR</a></li>
            ";
        // line 33
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["informations"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["information"]) {
            // line 34
            echo "            <li><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["information"], "href", [], "any", false, false, false, 34);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["information"], "title", [], "any", false, false, false, 34);
            echo "</a></li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['information'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 36
        echo "          </ul>
        </section>
      </div>
      <div class=\"col-sm-2\">
        <section>
          <h5>Support</h5>
          <ul class=\"list-unstyled\">
            <li><a href=\"https://forum.opencart.com\">Community Forum</a></li>
            <li><a href=\"https://dedicated.opencart.com\">Dedicated Support</a></li>
            <li><a href=\"";
        // line 45
        echo ($context["partner"] ?? null);
        echo "\">OpenCart Partners</a></li>
            <li><a href=\"";
        // line 46
        echo ($context["support"] ?? null);
        echo "\">Marketplace Support</a></li>
            <li><a href=\"";
        // line 47
        echo ($context["cart2cart"] ?? null);
        echo "\">Migrate to OpenCart</a></li>
          </ul>
        </section>
      </div>
      <div class=\"col-sm-2\">
        <section>
          <h5>Resources</h5>
          <ul class=\"list-unstyled\">
            <li><a href=\"";
        // line 55
        echo ($context["blog"] ?? null);
        echo "\">OpenCart Blog</a></li>
            <li><a href=\"https://docs.opencart.com\">OpenCart Documentation</a></li>
            <li><a target=\"_blank\" href=\"https://github.com/opencart/opencart\">GitHub</a></li>
            <li><a href=\"https://docs.opencart.com/#additional-reading\">OpenCart Books</a></li>
            <li><a href=\"https://github.com/opencart/opencart/issues\">Github Bug Tracker</a></li>
            <li><a href=\"https://docs.opencart.com/developer/module/\">Developer</a></li>
          </ul>
        </section>
      </div>
      <div class=\"col-sm-2 col-md-4\">
        <section id=\"newsletter\">
          <h5>Newsletter</h5>
          <p>Subscribe to our newsletters and stay informed of new releases and other OpenCart events.</p>
            <div class=\"input-group newsletter\">
              <input type=\"text\" name=\"newsletter\" value=\"\" placeholder=\"Enter your email address\" class=\"form-control\">
              <div class=\"input-group-btn\">
                <button type=\"button\" class=\"btn btn-primary subscribe\"><i class=\"fa fa-angle-right\"></i></button>
              </div>
            </div>
        </section>
      </div>
    </div>
    <div class=\"row\">
      <div class=\"col-sm-6 col-md-6\">
        <div id=\"copyright\">
          <ul class=\"list-unstyled\">
            <li class=\"company-logo\"><img src=\"application/view/image/icon/opencart-logo-white.png\" alt=\"OpenCart\" title=\"OpenCart\" /></li>
            <li class=\"copyright-text\">&copy; Copyright ";
        // line 82
        echo twig_date_format_filter($this->env, "now", "Y");
        echo " OpenCart</li>
          </ul>
        </div>
      </div>
      <div class=\"col-sm-6 col-md-6\">
        <div id=\"social\">
          <ul class=\"list-unstyled\">
            <li class=\"facebook-marketing-partner-logo\"><a href=\"https://www.facebook.com/fmp/commerce/partner-badge\" target=\"_blank\"><img src=\"application/view/image/icon/facebook_marketing_partner.png\" alt=\"Facebook Marketing Partner\" title=\"Facebook Marketing Partner\" /></a></li>
            <li><a href=\"https://www.linkedin.com/company/5224021/\" target=\"_blank\">Linkedin</a></li>
            <li><a href=\"https://www.facebook.com/opencart/?ref=aymt_homepage_panel\" target=\"_blank\">Facebook</a></li>
            <li><a href=\"https://twitter.com/opencart\" target=\"_blank\">Twitter</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
";
        // line 99
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["scripts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["script"]) {
            // line 100
            echo "<script src=\"";
            echo $context["script"];
            echo "\" type=\"text/javascript\"></script>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['script'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 102
        echo "
<script src='https://js.braintreegateway.com/web/3.76.4/js/client.min.js'></script>
<script src='https://js.braintreegateway.com/web/3.76.4/js/three-d-secure.min.js'></script>
<script src='https://js.braintreegateway.com/web/3.76.4/js/hosted-fields.min.js'></script>
<script src=\"https://js.braintreegateway.com/web/3.76.4/js/data-collector.min.js\"></script>
<script src=\"https://js.braintreegateway.com/web/3.76.4/js/paypal-checkout.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js\"></script>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/addons/cleave-phone.i18n.js\"></script>
</body></html>
";
    }

    public function getTemplateName()
    {
        return "common/footer.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  227 => 102,  218 => 100,  214 => 99,  194 => 82,  164 => 55,  153 => 47,  149 => 46,  145 => 45,  134 => 36,  123 => 34,  119 => 33,  115 => 32,  111 => 31,  107 => 30,  103 => 29,  99 => 28,  95 => 27,  91 => 26,  87 => 25,  76 => 17,  72 => 16,  68 => 15,  64 => 14,  59 => 13,  53 => 11,  51 => 10,  47 => 9,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/footer.twig", "");
    }
}
