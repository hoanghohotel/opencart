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

/* cms/download_thank_you.twig */
class __TwigTemplate_a4f6838579d7cf69623f1df9e678c47d extends Template
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
<div id=\"cms-download\">
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-9\">
        <div class=\"thank-you-message\">
          <div class=\"message\">
            <img src=\"application/view/image/icon/download-cart.png\" class=\"img-responsive\"/>
            <h2>Thank you</h2>
            <h3>for downloading OpenCart!</h3>
            <p>Your download will begin shortly. Or <a href=\"";
        // line 11
        echo ($context["download"] ?? null);
        echo "\">click to download</a> manually.</p>
          </div>

          <hr/>
          <div class=\"follow\">
            <p class=\"text-center\">
              If you want to receive the latest news from us,<br/> please follow our social media and subscribe our e-newsletter!
            </p>
            <div class=\"row\">

              <div class=\"col-sm-4\">
                <h3 class=\"text-center hidden\">Facebook</h3>
                <p class=\"h2 text-center\"><a href=\"https://www.facebook.com/opencart/\" target=\"_blank\" class=\"btn btn-facebook btn-block btn-lg\">
                  <i class=\"fa fa-facebook-square fa-3x\"></i><br/>
                  Like our page now!</a>
                </p>
              </div>

              <div class=\"col-sm-4\">
                <h3 class=\"text-center hidden\">Twitter</h3>
                <p class=\"h2 text-center\"><a href=\"https://twitter.com/OpenCart\"  target=\"_blank\" class=\"btn btn-twitter btn-block btn-lg\" data-show-count=\"false\" data-size=\"large\"><i class=\"fa fa-twitter-square fa-3x\"></i><br/>
                Follow @OpenCart</a>
                </p>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
              </div>

              <div class=\"col-sm-4\">
                <h3 class=\"text-center hidden\">eNews</h3>
                <p class=\"h2 text-center\"><a role=\"button\" id=\"follow-subscribe-newsletter\" class=\"btn btn-primary btn-block btn-lg subscribe\">
                  <i class=\"fa fa-paper-plane fa-3x\"></i><br/>
                  OPENCART NEWSLETTER</a>
                </p>
              </div>
            </div>
          </div>
        </div>

        <hr/>
        <div class=\"row\">
          <div class=\"col-md-12\">
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
            <div id=\"extension-list\"> ";
        // line 75
        if (($context["extensions"] ?? null)) {
            // line 76
            echo "              <h2>Add extensions</h2>
              <div class=\"row\"> ";
            // line 77
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["extensions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["extension"]) {
                // line 78
                echo "                <div class=\"col-md-4\">
                  <section>
                    <div class=\"extension-preview\"><a href=\"";
                // line 80
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "href", [], "any", false, false, false, 80);
                echo "\">
                      <div class=\"extension-description\">";
                // line 81
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "description", [], "any", false, false, false, 81);
                echo "</div>
                      <img src=\"";
                // line 82
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "image", [], "any", false, false, false, 82);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 82);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 82);
                echo "\" class=\"img-responsive\" /></a> </div>
                    <div class=\"extension-name\">
                      <p><a href=\"";
                // line 84
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "href", [], "any", false, false, false, 84);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 84);
                echo "</a></p>
                      <p><span>";
                // line 85
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "price", [], "any", false, false, false, 85);
                echo "</span></p>
                    </div>
                    <div>
                      <div class=\"row\">
                        <div class=\"col-xs-6\">
                          <div>";
                // line 90
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(range(1, 4));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 91
                    echo "                            ";
                    if (($context["i"] >= ($context["rating"] ?? null))) {
                        echo "<i class=\"opencart-icon-star-light-o\"></i>";
                    } else {
                        echo "<i class=\"opencart-icon-star-light\"></i>";
                    }
                    // line 92
                    echo "                            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                echo "</div>
                        </div>
                        <div class=\"col-xs-6\">
                          <div class=\"text-right\"><span>";
                // line 95
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "rating_total", [], "any", false, false, false, 95);
                echo " reviews</span></div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['extension'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 101
            echo "</div>
              ";
        }
        // line 103
        echo "
              ";
        // line 104
        if (($context["themes"] ?? null)) {
            // line 105
            echo "              <h2>Choose a theme</h2>
              <div class=\"row\"> ";
            // line 106
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["themes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["theme"]) {
                // line 107
                echo "                <div class=\"col-md-4\">
                  <section>
                    <div class=\"extension-preview\"><a href=\"";
                // line 109
                echo twig_get_attribute($this->env, $this->source, $context["theme"], "href", [], "any", false, false, false, 109);
                echo "\">
                      <div class=\"extension-description\">";
                // line 110
                echo twig_get_attribute($this->env, $this->source, $context["theme"], "description", [], "any", false, false, false, 110);
                echo "</div>
                      <img src=\"";
                // line 111
                echo twig_get_attribute($this->env, $this->source, $context["theme"], "image", [], "any", false, false, false, 111);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, false, 111);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, false, 111);
                echo "\" class=\"img-responsive\" /></a></div>
                    <div class=\"extension-name\">
                      <p><a href=\"";
                // line 113
                echo twig_get_attribute($this->env, $this->source, $context["theme"], "href", [], "any", false, false, false, 113);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, false, 113);
                echo "</a></p>
                      <p><span>";
                // line 114
                echo twig_get_attribute($this->env, $this->source, $context["theme"], "price", [], "any", false, false, false, 114);
                echo "</span></p>
                    </div>
                    <div>
                      <div class=\"row\">
                        <div class=\"col-xs-6\">
                          <div>";
                // line 119
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(range(1, 4));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 120
                    echo "                            ";
                    if (($context["i"] >= ($context["rating"] ?? null))) {
                        echo "<i class=\"opencart-icon-star-light-o\"></i>";
                    } else {
                        echo "<i class=\"opencart-icon-star-light\"></i>";
                    }
                    // line 121
                    echo "                            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                echo " </div>
                        </div>
                        <div class=\"col-xs-6\">
                          <div class=\"text-right\"><span>";
                // line 124
                echo twig_get_attribute($this->env, $this->source, $context["theme"], "rating_total", [], "any", false, false, false, 124);
                echo " reviews<span></div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['theme'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 130
            echo " </div>
              ";
        }
        // line 131
        echo "</div>
          </div>
        </div>
      </div>
      <div class=\"col-md-3\">
        <div class=\"well\">
          <h3>Other download options</h3>
          <div><img src=\"application/view/image/partner/github.png\" alt=\"GitHub\" title=\"GitHub\" class=\"img-responsive\" />
            <p>Clone the latest OpenCart version from GitHub. <a href=\"https://github.com/opencart/opencart\">Visit repository</a>.</p>
          </div>
          <div><img src=\"application/view/image/partner/softaculous.gif\" alt=\"Softaculous\" title=\"Softaculous\" class=\"img-responsive\" />
            <p>Install OpenCart on your server via Softaculous. <a href=\"https://www.softaculous.com/softaculous/apps/ecommerce/OpenCart\">Learn more</a>.</p>
          </div>
          <div><img src=\"application/view/image/partner/amazon-webservices.png\" class=\"img-responsive\" />
            <p>Download OpenCart in Amazon Web Services. <a href=\"https://aws.amazon.com/marketplace/search/results?x=0&y=0&searchTerms=opencart&page=1&ref_=nav_search_box\">Learn more</a>.</p>
          </div>
        </div>
        <div id=\"side-banner\">";
        // line 148
        echo ($context["banner"] ?? null);
        echo "</div>
        <div class=\"well\">
          <h3>Requirements</h3>
          <p>These are minimum requirements needed so that OpenCart can be installed and work properly.</p>
          <ul class=\"list-check list-color-blue\">
            <li>Web Server (Apache suggested)</li>
            <li>PHP (at least 5.4)</li>
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
      <p> <a href=\"";
        // line 166
        echo ($context["partner"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg hidden-xs\">View Partners</a> <a href=\"";
        echo ($context["partner"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">View Partners</a> </p>
    </div>
  </div>
</div>

<script> setTimeout(function(){ window.location.href ='";
        // line 171
        echo ($context["download"] ?? null);
        echo "'; }, 3000); </script>
";
        // line 172
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/download_thank_you.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  338 => 172,  334 => 171,  324 => 166,  303 => 148,  284 => 131,  280 => 130,  267 => 124,  257 => 121,  250 => 120,  246 => 119,  238 => 114,  232 => 113,  223 => 111,  219 => 110,  215 => 109,  211 => 107,  207 => 106,  204 => 105,  202 => 104,  199 => 103,  195 => 101,  182 => 95,  172 => 92,  165 => 91,  161 => 90,  153 => 85,  147 => 84,  138 => 82,  134 => 81,  130 => 80,  126 => 78,  122 => 77,  119 => 76,  117 => 75,  50 => 11,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/download_thank_you.twig", "");
    }
}
