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

/* support/support.twig */
class __TwigTemplate_e69907d843356ded604b5f08f9b7792a6c7920788c6d7a1816a7192b0f19138e extends Template
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
<div id=\"support-support\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>Support</h1>
    </div>
  </div>
  <div class=\"container\">
    <h2>Dedicated Support</h2>
    <div class=\"row\">
      <div class=\"col-md-6\">
        <div id=\"support-ticket\">
          <h3>Open a support ticket</h3>
          <p>Having trouble with the OpenCart Marketplace or having a general OpenCart question? Get in touch with our support team.</p>
          <p>Our support hours are Monday - Friday (8 AM - 5 PM)
            <br/>
            GMT +8:00
          </p>
          <p><a href=\"";
        // line 19
        echo ($context["support"] ?? null);
        echo "\" class=\"btn btn-primary\">Open A Ticket</a></p>
        </div>
      </div>
      <div class=\"col-md-6\">
        <div class=\"methods\"><a href=\"https://docs.opencart.com/\" target=\"_blank\">
            <div id=\"documentation\" class=\"media\">
              <div class=\"media-left\"><img src=\"application/view/image/support/icon-document.png\" class=\"media-object\"/></div>
              <div class=\"media-body\">
                <h4 class=\"media-heading\">Documentation</h4>
                <p>Explore every feature OpenCart has to offer</p>
              </div>
            </div>
          </a><a href=\"https://forum.opencart.com/\" target=\"_blank\">
            <div id=\"cs\" class=\"media\">
              <div class=\"media-left\"><img src=\"application/view/image/support/icon-cs.png\" class=\"media-object\"/></div>
              <div class=\"media-body\">
                <h4 class=\"media-heading\">Community support</h4>
                <p>Get support by visiting the OpenCart forum</p>
              </div>
            </div>
          </a><a href=\"https://dedicated.opencart.com/\" target=\"_blank\">
            <div id=\"ds\" class=\"media\">
              <div class=\"media-left\"><img src=\"application/view/image/support/icon-ds.png\" class=\"media-object\"/></div>
              <div class=\"media-body\">
                <h4 class=\"media-heading\">Dedicated support</h4>
                <p>Get professional dedicated technical support</p>
              </div>
            </div>
          </a></div>
      </div>
    </div>
    <div id=\"resources\">
      <h2>More Resources</h2>
      <div class=\"row\">
        <div class=\"col-sm-4\">
          <div class=\"box\">
            <div class=\"box-overlay\"><a href=\"https://docs.opencart.com\" target=\"_blank\"><span>View More</span></a></div>
            <div><img src=\"application/view/image/support/icon-github.png\"/></div>
            <h4>Developer Documentation</h4>
            <p>Browse the Github changelog</p>
          </div>
        </div>
        <div class=\"col-sm-4\">
          <div class=\"box\">
            <div class=\"box-overlay\"><a href=\"";
        // line 63
        echo ($context["partner"] ?? null);
        echo "\"><span>View More</span></a></div>
            <div><img src=\"application/view/image/support/icon-partners.png\"/></div>
            <h4>Partners</h4>
            <p>Looking to start your OpenCart Project or get Certified developer help?</p>
          </div>
        </div>
        <div class=\"col-sm-4\">
          <div class=\"box\">
            <div class=\"box-overlay\"><a href=\"";
        // line 71
        echo ($context["marketplace"] ?? null);
        echo "\"><span>View More</span></a></div>
            <div><img src=\"application/view/image/support/icon-marketplace.png\"/></div>
            <h4>Marketplace</h4>
            <p>With 13 000 modules and themes OpenCart offers a module for just about everything </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
";
        // line 81
        echo ($context["footer"] ?? null);
        echo " ";
    }

    public function getTemplateName()
    {
        return "support/support.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 81,  116 => 71,  105 => 63,  58 => 19,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "support/support.twig", "");
    }
}
