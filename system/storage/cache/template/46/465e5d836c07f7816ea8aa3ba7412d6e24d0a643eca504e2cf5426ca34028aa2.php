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

/* cms/download_history.twig */
class __TwigTemplate_5bf00f37ae144aedc01043db43749dcec4b45f9646a69fbf348e02d1c732d73a extends Template
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
<div id=\"cms-download-history\">
  <div class=\"container\">
    <section>
      <div class=\"row\">
        <div class=\"col-md-9\">
          <div id=\"steps\">
            <h2>How to install OpenCart</h2>
            <ul>
              <li>
                <h2>1</h2>
                <h4>Download OpenCart</h4>
                <p>The latest version of OpenCart can be downloaded from the OpenCart website (recommended)</p>
                <div class=\"arrow arrow-color\"></div>
                <div class=\"arrow arrow-border\"></div>
              </li>
              <li>
                <h2>2</h2>
                <h4>Upload files to your server</h4>
                <p>Upload to your web server established and the OpenCart archive extracted. We will now use File Transfer Protocol (FTP) client to upload these uncompressed files to a web server.</p>
                <div class=\"arrow arrow-color\"></div>
                <div class=\"arrow arrow-border\"></div>
              </li>
              <li>
                <h2>3</h2>
                <h4>Run automatic installer</h4>
                <p>Goto the OpenCart location and it will install automatically.</p>
              </li>
            </ul>
          </div>

          <div>
            <h2>Previous & Release Notes</h2>
            <ul class=\"nav nav-tabs\">
              <li class=\"active\"><a href=\"#tab-general\" data-toggle=\"tab\">Previous</a></li>
              <li><a href=\"#tab-history\" data-toggle=\"tab\">Release Notes</a></li>
            </ul>
            <div class=\"tab-content\">
              <div id=\"tab-general\" class=\"tab-pane active\">
                <div class=\"table-responsive\">
                  <table class=\"table table-bordered\">
                    <thead>
                      <tr>
                        <th>Version</th>
                        <th>Release Date</th>
                        <th class=\"text-right\">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      ";
        // line 50
        if (($context["downloads"] ?? null)) {
            // line 51
            echo "                        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["downloads"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["download"]) {
                // line 52
                echo "                          <tr>
                            <td>";
                // line 53
                echo twig_get_attribute($this->env, $this->source, $context["download"], "name", [], "any", false, false, false, 53);
                echo "</td>
                            <td>";
                // line 54
                echo twig_get_attribute($this->env, $this->source, $context["download"], "date_added", [], "any", false, false, false, 54);
                echo "</td>
                            <td class=\"text-right\"><a href=\"";
                // line 55
                echo twig_get_attribute($this->env, $this->source, $context["download"], "href", [], "any", false, false, false, 55);
                echo "\" data-toggle=\"tooltip\" title=\"Download ";
                echo twig_get_attribute($this->env, $this->source, $context["download"], "name", [], "any", false, false, false, 55);
                echo "\" class=\"btn btn-primary\"><i class=\"fa fa-download\"></i></a></td>
                          </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['download'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 58
            echo "                      ";
        } else {
            // line 59
            echo "                        <tr>
                          <td class=\"text-center\" colspan=\"3\">No results!</td>
                        </tr>
                      ";
        }
        // line 63
        echo "                    <tbody>
                  </table>
                </div>
                <nav>";
        // line 66
        echo ($context["pagination"] ?? null);
        echo "</nav>
              </div>
              <div id=\"tab-history\" class=\"tab-pane\">
                <div class=\"table-responsive\">
                  <table class=\"table table-bordered\">
                    <thead>
                      <tr>
                        <th>Version</th>
                        <th>Release Notes</th>
                      </tr>
                    </thead>
                    <tbody>
                      ";
        // line 78
        if (($context["downloads"] ?? null)) {
            // line 79
            echo "                        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["downloads"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["download"]) {
                // line 80
                echo "                          <tr>
                            <td>";
                // line 81
                echo twig_get_attribute($this->env, $this->source, $context["download"], "name", [], "any", false, false, false, 81);
                echo "</td>
                            <td>";
                // line 82
                echo twig_get_attribute($this->env, $this->source, $context["download"], "description", [], "any", false, false, false, 82);
                echo "</td>
                          </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['download'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 85
            echo "                      ";
        } else {
            // line 86
            echo "                        <tr>
                          <td class=\"text-center\" colspan=\"2\">No results!</td>
                        </tr>
                      ";
        }
        // line 90
        echo "                    <tbody>
                  </table>
                </div>
                <nav>";
        // line 93
        echo ($context["pagination"] ?? null);
        echo "</nav>
              </div>
            </div>
          </div>
        </div>
        <div class=\"col-md-3\">
          <div class=\"well\">
            <h3>Other download options</h3>
            <p><img src=\"application/view/image/partner/github.png\" height=\"40\" alt=\"\" title=\"\"/>
              <br/>
              Clone the latest OpenCart version from GitHub. <a href=\"https://github.com/opencart/opencart\">Visit repository</a>.
            </p>
            <p><img src=\"application/view/image/partner/softaculous.gif\" height=\"40\" alt=\"\" title=\"\"/>
              <br/>
              Install OpenCart on your server via Softaculous. <a href=\"https://www.softaculous.com/softaculous/apps/ecommerce/OpenCart\">Learn more</a>.
            </p>
            <p><img src=\"application/view/image/partner/amazon-webservices.png\" height=\"40\" alt=\"\" title=\"\"/>
              <br/>
              Download OpenCart in Amazon Web Services. <a href=\"https://aws.amazon.com/marketplace/search/results?x=0&y=0&searchTerms=opencart&page=1&ref_=nav_search_box\">Learn more</a>.
            </p>
          </div>
          <div id=\"side-banner\">";
        // line 114
        echo ($context["banner"] ?? null);
        echo "</div>
          <div class=\"well\">
            <h3>Requirements</h3>
            These are minimum requirements needed so that OpenCart can be installed and work properly.
            <ul class=\"list-check  list-color-blue\">
              <li>Web Server (Apache suggested)</li>
              <li>PHP (at least 5.3)</li>
              <li>Curl enabled</li>
              <li>Database (MySQLi suggested)</li>
            </ul>
          </div>
        </div>
      </div>
  </div>
  <div class=\"container-fluid\">
    <div class=\"container\">
      <h2>Ready to jump start your OpenCart project?</h2>
      <h3>View our expert OpenCart Partners list</h3>
      <p>
        <a href=\"";
        // line 133
        echo ($context["partner"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg hidden-xs\">View Partners</a> <a href=\"";
        echo ($context["partner"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">View Partners</a>
      </p>
    </div>
  </div>
</div>
";
        // line 138
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/download_history.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  240 => 138,  230 => 133,  208 => 114,  184 => 93,  179 => 90,  173 => 86,  170 => 85,  161 => 82,  157 => 81,  154 => 80,  149 => 79,  147 => 78,  132 => 66,  127 => 63,  121 => 59,  118 => 58,  107 => 55,  103 => 54,  99 => 53,  96 => 52,  91 => 51,  89 => 50,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/download_history.twig", "");
    }
}
