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

/* cms/company.twig */
class __TwigTemplate_362c387c19e107f7ee5c3e347f8444d4bf1be2d2daa062c8fb722872fc2414f9 extends Template
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
<div id=\"cms-information\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>Company</h1>
    </div>
  </div>
  <div id=\"information-details\">
    <div id=\"about\">
      <div class=\"container\">
        <div class=\"row\">
          <div class=\"col-md-8 col-md-offset-2\">
            <section>
              <h2>What is OpenCart?</h2>
              <p>Opencart is an easy to-use, powerful, Open Source online store management program that can manage multiple online stores from a single back-end. Administrative area simply by filling in forms and clicking “Save”. There are many professionally-written extensions available to customize the store to your needs.</p>
              <p>An OpenCart store can be ready to take orders soon after installation. All you have to do is have it installed for you (any web hosts do it for free), select a template form the many free or low-cost template sites, and your product descriptions and photos, click a few settings, and you are ready to begin accepting orders. Our free Installation &amp; Quick Start chapters show you how.</p>
              <p>The public side or “Storefront” of OpenCart looks very professional and ready to sell almost as soon as it is installed.</p>
            </section>
            <section>
              <h2>Why OpenCart?</h2>
              <p>Meet OpenCart:<br>
                FREE, open-source and easy to use ecommerce platform!</p>
              <p>No monthly fees, no catches; just an effective and customizable platform for your new ecommerce store. Simply install, choose your template, and add products and you’re ready to start accepting orders.</p>
              <p>Stick with the modern, responsive default theme or choose from thousands of themes online to make your store unique and perfectly suited for your business.</p>
              <p>OpenCart comes with a fully mobile friendly admin area, complete with detailed product, order and customer management, sales reports, marketing tools and even more - allowing you to manage every aspect of your new online store from any device, anywhere in the World. Use the quick and concise dashboard to keep track of your sales, or choose from one of the many menu options to view more detail.</p>
              <p>With a huge range of features included out-of- the-box and over 14,000 additional extensions available to download, OpenCart is perfect for ecommerce stores of any size, any industry, any budget.</p>
            </section>
          </div>
        </div>
      </div>
      <div id=\"milestone\" class=\"container-fluid\">
        <div class=\"container\">
          <section>
            <h2>Milestones</h2>

            <!-- This is a timeline design -->
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>March 2025</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 4.1.0.3 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>March 2025</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 4.1.0.1 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>January 2025</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 4.1.0.0 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>July 2024</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 3.0.4.0 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary\"> <i class=\"fa fa-bar-chart label-success\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>January 2023</h3>
                </div>
                <div id=\"may-2016\" class=\"event\">
                  <div>OpenCart number of merchants using opencart software reaches 347,000</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>August 2022</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 4.0.1.1 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>August 2022</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 4.0.1.0 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>May 2022</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 4.0.0.0 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>August 2021</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 3.0.3.8 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>February 2021</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 3.0.3.7 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary\"> <i class=\"fa fa-trophy label-success\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>December 2021</h3>
                </div>
                <div id=\"year-2013\" class=\"event\">
                  <div>Opencart Wins the most worthy Software in Shopping carts for Q4</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>July 2020</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 3.0.3.6 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>July 2020</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 3.0.3.5 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>May 2020</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 3.0.3.3 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>April 2019</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 3.0.3.2 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>January 2019</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>OpenCart 3.0.3.1 released.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary\"> <i class=\"fa fa-trophy label-success\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>November 2017</h3>
                </div>
                <div id=\"year-2013\" class=\"event\">
                  <div>CMS Critic Awards -Won the best e-commerce solution award</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-check\"> <i class=\"fa fa-check\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>November 2016</h3>
                </div>
                <div id=\"november-2016\" class=\"event\">
                  <div>OpenCart.com website update</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-check\"> <i class=\"fa fa-check\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>August 2016</h3>
                </div>
                <div id=\"november-2016\" class=\"event\">
                  <div>Added the extension store to the opencart admin</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary\"> <i class=\"fa fa-bar-chart label-success\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>May 2016</h3>
                </div>
                <div id=\"may-2016\" class=\"event\">
                  <div>OpenCart number of websites using opencart software reaches 342,000 and surpassed magento by 90,000 sites.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>September 2015</h3>
                </div>
                <div id=\"septemver-2015\" class=\"event\">
                  <div>There are now 15 books written about OpenCart.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary\"> <i class=\"fa fa-bar-chart label-success\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>Year 2015</h3>
                </div>
                <div id=\"year-2015\" class=\"event\">
                  <div>OpenCart reaches 300 000+ live sites.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-check\"> <i class=\"fa fa-check label-primary\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>September 2014</h3>
                </div>
                <div id=\"september-2014\" class=\"event\">
                  <div>OpenCart mentioned in Forbes article “3 Steps To Launch Your First eCommerce Website” and was recommended over shopify because it had more functionality and customisable features.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>Year 2014</h3>
                </div>
                <div id=\"year-2014\" class=\"event\">
                  <div>OpenCart 2.0 released</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary\"> <i class=\"fa fa-bar-chart label-success\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"year-2014\" class=\"event\">
                  <div>Over 10,000 extensions added to OpenCart’s extension store</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary\"> <i class=\"fa fa-trophy label-success\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>Year 2013</h3>
                </div>
                <div id=\"year-2013\" class=\"event\">
                  <div>OpenCart reaches no.1 position in Asia as the most popular used ecommerce script.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary\"> <i class=\"fa fa-bar-chart label-success\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"year-2013\" class=\"event\">
                  <div>OpenCart reaches 231,624 live sites.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-check\"> <i class=\"fa fa-check label-primary\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>November 2012</h3>
                </div>
                <div id=\"november-2012\" class=\"event\">
                  <div>OpenCart mentioned in Forbes</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-check\"> <i class=\"fa fa-check label-primary\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>June 2012</h3>
                </div>
                <div id=\"june-2012\" class=\"event\">
                  <div>Registered OpenCart as an business in Hong Kong.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>Year 2012</h3>
                </div>
                <div id=\"year-2012\" class=\"event\">
                  <div>OpenCart 1.5 released</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary\"> <i class=\"fa fa-bar-chart label-success\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>Year 2011</h3>
                </div>
                <div id=\"year-2011\" class=\"event\">
                  <div>OpenCart reaches 51,601 live sites.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-bookmark\"> <i class=\"fa fa-bookmark label-warning\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>October 2010</h3>
                </div>
                <div id=\"october-2010\" class=\"event\">
                  <div>First book published about OpenCart called the “OpenCart 1.4 Beginner’s Guide”.</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-check\"> <i class=\"fa fa-check label-primary\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"october-2010\" class=\"event\">
                  <div>Added OpenCart extension store to opencart.com</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-check\"> <i class=\"fa fa-check label-primary\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>May to November 2006</h3>
                </div>
                <div id=\"may-november-2006\" class=\"event\">
                  <div>Released OpenCart v0.3 on sourceforge.net</div>
                </div>
              </div>
            </div>
            <div class=\"row\">
              <div id=\"timeline\" class=\"col-xs-2 col-md-2 col-md-offset-1\">
                <div class=\"label label-primary label-check\"> <i class=\"fa fa-check label-primary\"></i> </div>
              </div>
              <div class=\"col-xs-10 col-md-8\">
                <div id=\"date\">
                  <h3>November 2005</h3>
                </div>
                <div id=\"november-2005\" class=\"event\">
                  <div>Registered domain name opencart.com</div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <div id=\"team\" class=\"container\">
        <section>
          <h2>Our Team</h2>
          <div class=\"row\">
            <div class=\"col-xs-12 col-md-6\">
              <p><img src=\"https://image.opencart.com/original/5836c0705c1f7.jpg\" alt=\"Daniel Kerr\" title=\"\" class=\"img-rounded\"></p>
              <p>Daniel</p>
            </div>
            <div class=\"col-xs-12 col-md-6\">
              <p><img src=\"https://image.opencart.com/original/6807951bead98.jpg\" alt=\"Ben Ajenoui\" title=\"\" class=\"img-rounded\"></p>
              <p>Ben</p>
            </div>
          </div>
          ";
        // line 515
        echo "        </section>
      </div>
    </div>
  </div>
</div>
";
        // line 520
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/company.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  545 => 520,  538 => 515,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/company.twig", "");
    }
}
