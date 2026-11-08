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

/* cms/download.twig */
class __TwigTemplate_6a561f582ec4287540efb29aaf7ed67b12cf9ac4706371a15b8d79c9e68173d5 extends Template
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
        <div class=\"row\">
          <div class=\"col-md-12\">
            <div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-4\">
                <div class=\"row\">
                  <div class=\"col-md-12\"><a href=\"https://www.scalahosting.com/opencart-hosting.html#67c83d5d66431\"
                      style=\"display: flex; position: relative; float: left; text-align:center; height: 74px;\" target=\"_blank\"
                      onclick=\"ga('send', 'event', 'Downloads', 'Referral image', 'Scalahosting');\"> <img
                        src=\"application/view/image/partner/a2_hosting/scalahosting.svg\" alt=\"Get started Now\"
                        style=\"width: 255px; margin-top:5px; margin-left:10px;\"></a></div>
                </div>
                <div class=\"row\">
                  <div class=\"col-md-12\">
                    <h4 style=\"margin-bottom: 0px;\" class=\"text-center\">Easy set-up by our hosting partner</h4>
                    <p class=\"text-center\"><a
                        href=\"https://www.scalahosting.com/opencart-hosting.html#67c83d5d66431\" target=\"_blank\"
                        onclick=\"ga('send', 'event', 'Downloads', 'Referral link', 'Scalahosting');\">Click here to get
                        started now</a></p>
                    <ul style=\"padding-left:15px;\">
                      <li>Scalable OpenCart Hosting for Growing Online Stores</li>
                      <li>Free and Effortless OpenCart Migration</li>
                      <li>24/7 Ecommerce Support You Can Rely On</li>
                      <li>Anytime Money-back Guarantee</li>
                    </ul>
                  </div>
                </div>
              </div>
              
              ";
        // line 40
        echo "              <div class=\"col-md-4\">
                <div class=\"row\">
                  <div class=\"col-md-12 text-center\"> <a title=\"Download OpenCart\" href=\"";
        // line 42
        echo ($context["download"] ?? null);
        echo "\"
                      onclick=\"ga('send', 'event', 'Downloads', 'Download link', '";
        // line 43
        echo ($context["name"] ?? null);
        echo "');\"><img
                        src=\"application/view/image/partner/a2_hosting/download_now_button.png\"
                        alt=\"Download OpenCart now\" style=\"width: 220px;top: 12px;position: relative;\"></a> </div>
                </div>
                <div class=\"row\">
                  <div class=\"col-md-12\">
                    <h4 style=\"margin-bottom: 0px;\" class=\"text-center\">Download &amp; host your own</h4>
                    <p class=\"text-center\">v";
        // line 50
        echo ($context["name"] ?? null);
        echo " ";
        echo ($context["date_added"] ?? null);
        echo ". <a href=\" ";
        echo ($context["history"] ?? null);
        echo " \">Release notes</a></p>
                    <ul>
                      <li>Download <strong>OpenCart ";
        // line 52
        echo ($context["name"] ?? null);
        echo "</strong> for free</li>
                      <li><a target=\"_blank\"
                          href=\"https://www.scalahosting.com/opencart-hosting.html#67c83d5d66431\">Customise your own hosting solution</a></li>
                      <li>Install and configure your store</li>
                      <li>Paid support from <a
                          href=\"index.php?route=support/partner&filter_type_id=1\">approved
                          partners</a></li>
                      <li>Or clone the OpenCart <a href=\"https://github.com/opencart/opencart\">GitHub repository</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              ";
        // line 92
        echo "            </div>
            <div class=\"row\">
              <div class=\"col-md-12 text-center\"> Check out the <a href=\" ";
        // line 94
        echo ($context["history"] ?? null);
        echo " \">previous releases</a> </div>
            </div>
            <hr />
          </div>
        </div>
        <div class=\"row\">
          <div class=\"col-md-12\">
            <div id=\"steps\">
              <h2>How to install OpenCart</h2>
              <div class=\"tutorial-video\">
                <iframe width=\"100%\" height=\"315\" src=\"https://www.youtube.com/embed/v02DwbbQAFU?si=D60t0exG8oESKJGM\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>              
              </div>
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
                  <p>Upload to your web server established and the OpenCart archive extracted. We will now use File
                    Transfer Protocol (FTP) client to upload these uncompressed files to a web server.</p>
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
        // line 129
        if (($context["extensions"] ?? null)) {
            // line 130
            echo "              <h2>Add extensions</h2>
              <div class=\"row\"> ";
            // line 131
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["extensions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["extension"]) {
                // line 132
                echo "                <div class=\"col-md-4\">
                  <section>
                    <div class=\"extension-preview\"><a href=\"";
                // line 134
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "href", [], "any", false, false, false, 134);
                echo "\">
                        <div class=\"extension-description\">";
                // line 135
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "description", [], "any", false, false, false, 135);
                echo "</div>
                        <img src=\"";
                // line 136
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "image", [], "any", false, false, false, 136);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 136);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 136);
                echo "\"
                          class=\"img-responsive\" />
                      </a> </div>
                    <div class=\"extension-name\">
                      <p><a href=\"";
                // line 140
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "href", [], "any", false, false, false, 140);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 140);
                echo "</a></p>
                      <p><span>";
                // line 141
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "price", [], "any", false, false, false, 141);
                echo "</span></p>
                    </div>
                    <div>
                      <div class=\"row\">
                        <div class=\"col-xs-6\">
                          <div>";
                // line 146
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(range(1, 4));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 147
                    echo "                            ";
                    if ((0 <= twig_compare($context["i"], ($context["rating"] ?? null)))) {
                        echo "<i class=\"opencart-icon-star-light-o\"></i>";
                    } else {
                        echo "<i
                              class=\"opencart-icon-star-light\"></i>";
                    }
                    // line 149
                    echo "                            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                echo "</div>
                        </div>
                        <div class=\"col-xs-6\">
                          <div class=\"text-right\"><span>";
                // line 152
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "rating_total", [], "any", false, false, false, 152);
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
            // line 159
            echo "              </div>
              ";
        }
        // line 161
        echo "
              ";
        // line 162
        if (($context["themes"] ?? null)) {
            // line 163
            echo "              <h2>Choose a theme</h2>
              ";
            // line 164
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_array_batch(($context["themes"] ?? null), 3));
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 165
                echo "              <div class=\"row\">
                ";
                // line 166
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable($context["row"]);
                foreach ($context['_seq'] as $context["_key"] => $context["theme"]) {
                    // line 167
                    echo "                ";
                    if ($context["theme"]) {
                        // line 168
                        echo "                <div class=\"col-md-4\">
                  <section>
                    <div class=\"extension-preview\">
                      <a href=\"";
                        // line 171
                        echo twig_get_attribute($this->env, $this->source, $context["theme"], "href", [], "any", false, false, false, 171);
                        echo "\">
                        <div class=\"extension-description\">";
                        // line 172
                        echo twig_get_attribute($this->env, $this->source, $context["theme"], "description", [], "any", false, false, false, 172);
                        echo "</div>
                        <img src=\"";
                        // line 173
                        echo twig_get_attribute($this->env, $this->source, $context["theme"], "image", [], "any", false, false, false, 173);
                        echo "\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, false, 173);
                        echo "\" title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, false, 173);
                        echo "\"
                          class=\"img-responsive\" />
                      </a>
                    </div>
                    <div class=\"extension-name\">
                      <p><a href=\"";
                        // line 178
                        echo twig_get_attribute($this->env, $this->source, $context["theme"], "href", [], "any", false, false, false, 178);
                        echo "\">";
                        echo twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, false, 178);
                        echo "</a></p>
                      <p><span>";
                        // line 179
                        echo twig_get_attribute($this->env, $this->source, $context["theme"], "price", [], "any", false, false, false, 179);
                        echo "</span></p>
                    </div>
                    <div>
                      <div class=\"row\">
                        <div class=\"col-xs-6\">
                          <div>
                            ";
                        // line 185
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(range(1, 5));
                        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                            // line 186
                            echo "                            ";
                            if ((0 <= twig_compare(twig_get_attribute($this->env, $this->source, $context["theme"], "rating", [], "any", false, false, false, 186), $context["i"]))) {
                                echo "<i class=\"opencart-icon-star-light\"></i>";
                            } else {
                                echo "<i
                              class=\"opencart-icon-star-light-o\"></i>";
                            }
                            // line 188
                            echo "                            ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 189
                        echo "                          </div>
                        </div>
                        <div class=\"col-xs-6\">
                          <div class=\"text-right\"><span>";
                        // line 192
                        echo twig_get_attribute($this->env, $this->source, $context["theme"], "rating_total", [], "any", false, false, false, 192);
                        echo " reviews</span></div>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
                ";
                    }
                    // line 199
                    echo "                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['theme'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 200
                echo "              </div>
              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 202
            echo "              ";
        }
        // line 203
        echo "            </div>
          </div>
        </div>
      </div>
      <div class=\"col-md-3\">
        <div class=\"well\">
          <h3>Other download options</h3>
          <div><img src=\"application/view/image/partner/github.png\" alt=\"GitHub\" title=\"GitHub\"
              class=\"img-responsive\" />
            <p>Clone the latest OpenCart version from GitHub. <a href=\"https://github.com/opencart/opencart\">Visit
                repository</a>.</p>
          </div>
          <div><img src=\"application/view/image/partner/softaculous.gif\" alt=\"Softaculous\" title=\"Softaculous\"
              class=\"img-responsive\" />
            <p>Install OpenCart on your server via Softaculous. <a
                href=\"https://www.softaculous.com/softaculous/apps/ecommerce/OpenCart\">Learn more</a>.</p>
          </div>
          <div><img src=\"application/view/image/partner/amazon-webservices.png\" class=\"img-responsive\" />
            <p>Download OpenCart in Amazon Web Services. <a
                href=\"https://aws.amazon.com/marketplace/search/results?x=0&y=0&searchTerms=opencart&page=1&ref_=nav_search_box\">Learn
                more</a>.</p>
          </div>
        </div>
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
        // line 243
        echo ($context["partner"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg hidden-xs\">View Partners</a> <a href=\"";
        echo ($context["partner"] ?? null);
        echo "\"
          class=\"btn btn-primary btn-lg btn-block visible-xs-block\">View Partners</a> </p>
    </div>
  </div>
</div>
";
        // line 248
        echo ($context["footer"] ?? null);
    }

    public function getTemplateName()
    {
        return "cms/download.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  407 => 248,  397 => 243,  355 => 203,  352 => 202,  345 => 200,  339 => 199,  329 => 192,  324 => 189,  318 => 188,  310 => 186,  306 => 185,  297 => 179,  291 => 178,  279 => 173,  275 => 172,  271 => 171,  266 => 168,  263 => 167,  259 => 166,  256 => 165,  252 => 164,  249 => 163,  247 => 162,  244 => 161,  240 => 159,  227 => 152,  217 => 149,  209 => 147,  205 => 146,  197 => 141,  191 => 140,  180 => 136,  176 => 135,  172 => 134,  168 => 132,  164 => 131,  161 => 130,  159 => 129,  121 => 94,  117 => 92,  101 => 52,  92 => 50,  82 => 43,  78 => 42,  74 => 40,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/download.twig", "");
    }
}
