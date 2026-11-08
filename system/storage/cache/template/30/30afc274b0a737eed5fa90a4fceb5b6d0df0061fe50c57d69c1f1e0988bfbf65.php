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

/* cms/showcase.twig */
class __TwigTemplate_eec32d39a4b7aad284e20da21cd2c14f536410fe0bf5fc6549e704407448573f extends Template
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
<div id=\"cms-showcase\">
  <div class=\"container-fluid\">
    <div class=\"container\">

      <div class=\"page-header\">
        <h1>OpenCart Success Stories</h1>
        <h2>How one business experienced the dream of every entrepreneur - rapid growth.</h2>
      </div>

      ";
        // line 11
        if (( !($context["filter_showcase_category_id"] ?? null) && (0 === twig_compare(($context["page"] ?? null), "1")))) {
            // line 12
            echo "      <div id=\"carousel-show-case\" class=\"carousel slide\" data-ride=\"carousel\">
        <!-- Indicators -->
        <ol class=\"carousel-indicators\">
          <li data-target=\"#carousel-show-case\" data-slide-to=\"0\" class=\"active\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"1\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"2\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"3\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"4\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"5\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"6\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"7\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"8\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"9\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"10\"></li>
          <li data-target=\"#carousel-show-case\" data-slide-to=\"11\"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class=\"carousel-inner\" role=\"listbox\">

          <div class=\"item active\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/fundraisefactory.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>I have been with Opencart for over 3 years now, it's such an easy system to use and the staff find it easy to  navigate around. As we are launching our brand to many countries, the APPS and integrations have been integral to our growth.  Ultimately what I love about Opencart is anything is possible. This fits with my glass is half full kind of attitude. I'm looking forward to growing our business and working within the Opencart platform.
                        </h4>
                        <div class=\"showcase-story-writter\">
                          <h5>Bo Burns</h5>
                          <span>Founder of fundraisefactory.com</span>
                        </div>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://fundraisefactory.com\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/fundraisefactory.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://www.fundraisefactory.com\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>


          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/eclipse-organics.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>Eclipseorganics.com.au is a healthy snacks company located in Australia. The company sells Safe Health Food You Can Trust. “ We love the Opencart open source platform as it has allowed out to grow our company online within years. We have thousands of products and the website loads within seconds. We are really happy with what we have achieved by moving into a different e-commerce platform”. Opencart Rocks!
                        </h4>
                        <div class=\"showcase-story-writter\">
                          <h5>Brett Monaghan</h5>
                          <span>Founder of Eclipseorganics.com.au</span>
                        </div>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://www.eclipseorganics.com.au/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/eclipse-organics.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://www.eclipseorganics.com.au/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/mitzybitz.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>The UK's Leading Mitsubishi 4x4 parts company - new, used and reclaimed parts. Mitzybitz have been using opencart for over 5 years now, and continually invest into the development of the website. The base opencart offering is great, and with it being open source Mitzy have had many extra bespoke features coded up by dijitul, and added to the website. It is now very bespoke but still has the rock-solid foundation that is provided by Opencart.
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://www.mitzybitz.com/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/mitzybitz.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://www.mitzybitz.com/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/phoenixvaping.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>We chose to move to Opencart from a popular website builder system. Every issue faced with the old website has been resolved and the whole website management is done in house now, by people that are not technically minded. The admin UI is intuitive enough for anyone to figure out. Great!
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://www.phoenixvaping.co.uk/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/phoenixvaping.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://www.phoenixvaping.co.uk/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/cheekysmokelancing.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>This website was Cheeky Smoke's first website - and they couldn't be happier. Their chosen payment gateway was already supported, shipping modules they needed were also available out the box. They are working with dijitul to now take theings to the next level and introduce a stock management system with barcode scanners, so the website will become the central hub for everything.
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://cheekysmokelancing.co.uk/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/cheekysmokelancing.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://cheekysmokelancing.co.uk/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/ifancyone.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>One of the countries leading vape companies, pioneering new brands and getting cost effective products to the masses. They had a slow, bogged down, broken WordPress eCommerce store and it was not suitable for their needs. We moved them to Opencart and they have never looked back. All integrated with their accounts package, inventory management system and bespoke payment gateway - their website allows them to go from strength to strength without fear of things getting slow, and bogged down.
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://ifancyone.com/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/ifancyone.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://ifancyone.com/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/aspire-uk.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>Aspire UK are one of the best known vape brands in the world - and our customer is one of the UK's leading distributers of their products. They wanted an Aspire site to be linked to their other websites so they had one easy to use admin interface. We did that, and they are now able to manage order more efficiently without logging in and out of a bunch of different admin interfaces.
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://aspire-uk.net/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/aspire-uk.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://aspire-uk.net/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/wickliquor.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>A cool website for a cool brand - Wick Liquor moved from WooCommerce as they were having issues with attacks and hacks. We moved them to Opencart and applied various security methods - they've never been hacked since. We also created a bespoke payment gateway for them as their alternative provider was not properly supported.
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://wickliquor.com/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/wickliquor.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://wickliquor.com/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/kmdtuning.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>The Euro Car Doctor. KMD lead the way in regards to modifying and tuning European cars. They are based in New Jersey, and are famous in their circles. Their website is a heavily modified version of Opencart that duplicates the entire category functionality, meaning no compromises were made and the user could map products to categories exactly how they wanted to.
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://www.kmdtuning.com/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/kmdtuning.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://www.kmdtuning.com/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/anglo-agriparts.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>The number 1 choice for tractor parts in the UK - the design of this website does not sway too far from the default theme, but its packed with custom features, and awesome additions to make the user experience a great one! Its a industry favourite not only because of how well website operates - but the business itself is a true family business with amazing family values.
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://www.anglo-agriparts.com/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/anglo-agriparts.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://www.anglo-agriparts.com/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/thewasabicompany.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>The best wasabi in the world - grown by experts in the UK. The Wasabi Company's products are in supermarkets but you can also buy them off their website. Its based on Opencart and uses teh multi site feature to branch the trade hub off as a separate website. The website is not only an eComerce platform but is also a media hub, filled with recipes, news and Wasabi related goodies! Opencart is the best, most flexible platform for the job.
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://thewasabicompany.co.uk/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/thewasabicompany.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://thewasabicompany.co.uk/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

          <div class=\"item\">
            <div class=\"showcase-story\">
              <div class=\"showcase-story-cover visible-xs-block\"><img src=\"application/view/image/feature/showcase/biog.png\" class=\"img-responsive\" alt=\"\" title=\"\" /></div>

                <div class=\"showcase-story-casestudy\">
                  <div class=\"row\">
                    <div class=\"col-sm-5\">
                      <div class=\"showcase-story-about\">
                        <h4>Bio G Cosmetics is a Bulgarian brand behind which are the professional and creative efforts of qualified experts engaged in the development and production of natural cosmetic products for babies, children, and the whole family. Since 2011, we have been one of the few in the world that combine silver water with 100% natural plant oils and ingredients, the highest grade herbal extracts, and technologies over 200 years old that preserve the vitamins, antioxidants, and specific properties of each single sprig. We do not use any artificial:preservatives /including parabens/, colors, artificial foaming agents, synthetic emulsifiers and fragrances in the production of our products.
                        </h4>
                        <div class=\"showcase-story-link\">
                          <a href=\"https://biog.store/\" class=\"btn btn-primary btn-lg hidden-xs\">Visit Website</a>
                        </div>
                      </div>

                    </div>
                    <div class=\"col-sm-7\">
                      <div class=\"showcase-story-cover hidden-xs\">
                        <img src=\"application/view/image/feature/showcase/biog.png\" class=\"img-responsive\" alt=\"\" title=\"\" />
                      </div>
                    </div>
                  </div>
              </div>

              <div class=\"showcase-story-link\">
                <a href=\"https://biog.store/\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Visit Website</a>
              </div>
            </div>
          </div>

        </div>

      </div>
      ";
        }
        // line 405
        echo "
    </div>
  </div>

  <div class=\"container\">
    <ul class=\"nav nav-tabs\">
      ";
        // line 411
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["showcase_categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["showcase_category"]) {
            // line 412
            echo "      ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["showcase_category"], "showcase_category_id", [], "any", false, false, false, 412), ($context["filter_showcase_category_id"] ?? null)))) {
                // line 413
                echo "      <li class=\"active\"><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["showcase_category"], "href", [], "any", false, false, false, 413);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["showcase_category"], "name", [], "any", false, false, false, 413);
                echo "</a></li>
      ";
            } else {
                // line 415
                echo "      <li><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["showcase_category"], "href", [], "any", false, false, false, 415);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["showcase_category"], "name", [], "any", false, false, false, 415);
                echo "</a></li>
      ";
            }
            // line 417
            echo "      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['showcase_category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 418
        echo "    </ul>
    ";
        // line 419
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_array_batch(($context["showcases"] ?? null), 3));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 420
            echo "    <div class=\"row\">
       ";
            // line 421
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["row"]);
            foreach ($context['_seq'] as $context["_key"] => $context["showcase"]) {
                // line 422
                echo "       <div class=\"col-sm-4\">

         <div class=\"showcase-link\">
           <div>
             <a href=\"";
                // line 426
                echo twig_get_attribute($this->env, $this->source, $context["showcase"], "link", [], "any", false, false, false, 426);
                echo "\" target=\"_blank\">View Project</a>
           </div>
            <a href=\"";
                // line 428
                echo twig_get_attribute($this->env, $this->source, $context["showcase"], "link", [], "any", false, false, false, 428);
                echo "\" target=\"_blank\"><img src=\"";
                echo twig_get_attribute($this->env, $this->source, $context["showcase"], "image", [], "any", false, false, false, 428);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["showcase"], "name", [], "any", false, false, false, 428);
                echo "\"  title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["showcase"], "name", [], "any", false, false, false, 428);
                echo "\" class=\"img-responsive\" /></a>
        </div>
         <h4>";
                // line 430
                echo twig_get_attribute($this->env, $this->source, $context["showcase"], "name", [], "any", false, false, false, 430);
                echo "</h4>
         <h6>";
                // line 431
                echo twig_get_attribute($this->env, $this->source, $context["showcase"], "category", [], "any", false, false, false, 431);
                echo "</h6>
       </div>
       ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['showcase'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 434
            echo "     </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 436
        echo "    <nav>";
        echo ($context["pagination"] ?? null);
        echo "</nav>
  </div>
</div>
";
        // line 439
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/showcase.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  547 => 439,  540 => 436,  533 => 434,  524 => 431,  520 => 430,  509 => 428,  504 => 426,  498 => 422,  494 => 421,  491 => 420,  487 => 419,  484 => 418,  478 => 417,  470 => 415,  462 => 413,  459 => 412,  455 => 411,  447 => 405,  52 => 12,  50 => 11,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/showcase.twig", "");
    }
}
