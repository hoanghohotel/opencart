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

/* cms/feature.twig */
class __TwigTemplate_8cfac2351517256fd34ad47dca42ea1fbbc4963c7ad0e31d36ec9e33ad5c279d extends Template
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
<div id=\"cms-feature\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>OpenCart Features</h1>
      <p>No monthly fees, no catches; just an effective and customizable platform for your new ecommerce store.</p>
    </div>
  </div>
  <div class=\"container\">
    <ul class=\"nav nav-tabs\">
      <li class=\"active\"><a href=\"#tab-admin\" data-toggle=\"tab\">Admin</a></li>
      <li><a href=\"#tab-unlimited\" data-toggle=\"tab\">Unlimited everything</a></li>
      <li><a href=\"#tab-customer\" data-toggle=\"tab\">Customer</a></li>
      <li><a href=\"#tab-shipping\" data-toggle=\"tab\">Shipping, Payments and Reports</a></li>
      <li><a href=\"#tab-extension\" data-toggle=\"tab\">Extensions</a></li>
      <li><a href=\"#tab-mobile\" data-toggle=\"tab\">Mobile &amp; SEO</a></li>
      <li><a href=\"#tab-developer\" data-toggle=\"tab\">Developer</a></li>
    </ul>
  </div>
  <div class=\"tab-content\">
    <div id=\"tab-admin\" class=\"tab-pane active\">
      <div class=\"container\">
        <h1 class=\"text-center\">Add products and you’re ready to start accepting orders.</h1>
        <div class=\"row\">
          <div class=\"col-sm-7\"><img src=\"application/view/image/feature/admin/dashboard.png\" alt=\"Administrator Dashboard\" title=\"Administrator Dashboard\" class=\"img-responsive\" /></div>
          <div class=\"col-sm-5\">
            <h2>Administrator Dashboard</h2>
            <p>All the important information available at a glimpse. Get a full overview of what is important with total orders, sales, customers, people online, sales analytics and many more widgets</p>
          </div>
        </div>
        <div class=\"row\">
          <div class=\"col-sm-6\">
            <h2>User Management</h2>
            <p>In order to successfully organize an online store you will need to cooperate with many people, each performing different roles. OpenCart allows you to set advanced user privileges and separate access for user groups and users.</p>
          </div>
          <div class=\"col-sm-6\"><img src=\"application/view/image/feature/admin/table.png\" alt=\"User Management\" title=\"User Management\" class=\"img-responsive\" /></div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\"><img src=\"application/view/image/feature/admin/mutle-store.png\" alt=\"Multi-Store\" title=\"Multi-Store\" class=\"img-responsive\" /></div>
            <div class=\"col-sm-6\">
              <h2>Multi-Store</h2>
              <p>Manage multiple stores from one admin interface. Set products to appear on different stores. Choose a different theme for each store. Localize store settings. Set per store product prices.</p>
            </div>
          </div>
        </div>
      </div>
      <div class=\"container\">
        <div class=\"row\">
          <div class=\"col-sm-6\">
            <h2>Options, attributes</h2>
            <p>Products come in different options. Some feature sizes, while others colors, length, height. No matter the case OpenCart offers a solution on adding extra important product variables.</p>
          </div>
          <div class=\"col-sm-6\"><img src=\"application/view/image/feature/admin/attributes.png\" alt=\"Options, attributes\" title=\"Options, attributes\" class=\"img-responsive\" /></div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-4\">
              <div><img src=\"application/view/image/feature/admin/affiliates.png\" alt=\"Affiliates\" title=\"Affiliates\" class=\"img-responsive\" /></div>
              <h3>Affiliates</h3>
              <p>OpenCart comes with an inbuilt Affiliate system, where affiliates can promote specific products and get paid for this. Set different percentages. Offer different payment options such as cheque, Paypal and a bank transfer.</p>
            </div>
            <div class=\"col-sm-4\">
              <div><img src=\"application/view/image/feature/admin/discount.png\" alt=\"Discounts, coupons, specials\" title=\"Discounts, coupons, specials\" class=\"img-responsive\" /></div>
              <h3>Discounts, coupons, specials</h3>
              <p>Retailers often have to lower their prices to keep up with their competition. OpenCart offers discounts, coupons and specials to cover the most popular ways to get attention and increase sales.</p>
            </div>
            <div class=\"col-sm-4\">
              <div><img src=\"application/view/image/feature/admin/backup.png\" alt=\"Back-up and restore\" title=\"Back-up and restore\" class=\"img-responsive\" /></div>
              <h3>Back-up and restore</h3>
              <p>Case of emergency? OpenCart allows you to set up your own back-ups and restorations. Looking for an easy way to update and bulk edit products, categories and everything else OpenCart? Discover the popular extensions in the marketplace</p>
            </div>
          </div>
        </div>
      </div>
      <div class=\"bottom-link\">
        <h6>Next Page</h6>
        <a onclick=\"\$('a[href=\\'#tab-unlimited\\']').click();\" class=\"btn btn-lg\">Unlimited everything <i class=\"fa fa-angle-right\"></i></a></div>
    </div>
    <div id=\"tab-unlimited\" class=\"tab-pane\">
      <div class=\"container\">
        <h1 class=\"text-center\">Unlimited Categories & Products </h1>
        <div class=\"row\">
          <div class=\"col-sm-5 col-md-5\">
            <h2>Free to download and use</h2>
            <p>OpenCart is open source and free. Open source means transparency, open code and community vision. Free means we are giving you the option to modify, share and edit OpenCart for your project. Get your copy today and get started in minutes not days.</p>
            <a href=\"";
        // line 91
        echo ($context["download"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg hidden-xs\">Download Now</a>
            <a href=\"";
        // line 92
        echo ($context["download"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">Download Now</a>
          </div>
          <div class=\"col-sm-7\"><img src=\"application/view/image/feature/unlimited-everything/download.png\" alt=\"Free to download and use\" title=\"Free to download and use\"  class=\"img-responsive\" /></div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\"><img src=\"application/view/image/feature/unlimited-everything/unlimited-categories.png\" alt=\"Unlimited Categories\" title=\"Unlimited Categories\" class=\"img-responsive\" /></div>
            <div class=\"col-sm-6\">
              <h2>Unlimited Categories</h2>
              <p>Create unlimited categories and subcategories and assign products to them.</p>
            </div>
          </div>
        </div>
      </div>
      <div class=\"container\">
        <div class=\"row\">
          <div class=\"col-sm-4\">
            <h2>Unlimited Products</h2>
            <p>No Matter if you want to sell 1 or 1 000 000 products, OpenCart has your back.</p>
          </div>
          <div class=\"col-sm-8\"><img src=\"application/view/image/feature/unlimited-everything/unlimited-products.png\" alt=\"Unlimited Products\" title=\"Unlimited Products\" class=\"img-responsive\" /></div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-4\">
              <div><img src=\"application/view/image/feature/unlimited-everything/downloadable-product.png\" alt=\"Downloadable Products Ready\" title=\"Downloadable Products Ready\" class=\"img-responsive\" /></div>
              <h3>Downloadable Products Ready</h3>
              <p>OpenCart makes it easy to sell digital products. All you need to do is click a button, upload the product and set the price. Voila! Your products are ready to be sold.</p>
            </div>
            <div class=\"col-sm-4\">
              <div><img src=\"application/view/image/feature/unlimited-everything/product-review-rating.png\" alt=\"Product Reviews & Retings\" title=\"Product Reviews & Retings\" class=\"img-responsive\" /></div>
              <h3>Product Reviews & Ratings</h3>
              <p>Customer product reviews are among the most important factors that trigger the buy or don’t buy decisions customers make. OpenCart comes with a powerful integrated comments, reviews and ratings system.</p>
            </div>
            <div class=\"col-sm-4\">
              <div><img src=\"application/view/image/feature/unlimited-everything/reward-points.png\" alt=\"Reward Points\" title=\"Reward Points\" class=\"img-responsive\" /></div>
              <h3>Reward Points</h3>
              <p>A reward program that drives results. Increase customer lifetime value and return purchases.</p>
            </div>
          </div>
        </div>
      </div>
      <div class=\"bottom-link\">
        <h6>Next Page</h6>
        <a onclick=\"\$('a[href=\\'#tab-customer\\']').click();\" class=\"btn btn-lg\">Customer <i class=\"fa fa-angle-right\"></i></a></div>
    </div>
    <div id=\"tab-customer\" class=\"tab-pane\">
      <div class=\"container\">
        <h1 class=\"text-center\">Easy find - Easy buy</h1>


        <div class=\"row\">
          <div class=\"col-sm-7\"><img src=\"application/view/image/feature/customer/filter.png\" alt=\"Filters\" title=\"Filters\" class=\"img-responsive\" /></div>
          <div class=\"col-sm-5\">
            <h2>Filters</h2>
            <p>Create filters in the same way you create categories. This is a great way for customers to refine and narrow down just about anything in your store. Easy find - easy buy.</p>
          </div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\">
              <h2>Multi-currency</h2>
              <p>Sell in any currency, anywhere in the world. Get automatic rates updates. Set up different taxes. Ecommerce selling made easy.</p>
            </div>
            <div class=\"col-sm-6\"><img src=\"application/view/image/feature/customer/multi-currency.png\" alt=\"Multi-currency\" title=\"Multi-currency\" class=\"img-responsive\" /></div>
          </div>
        </div>
      </div>
      <div class=\"container\">
        <div class=\"row\">
          <div class=\"col-sm-6\"><img src=\"application/view/image/feature/customer/multi-lingual.png\" alt=\"Multi-lingual\" title=\"Multi-lingual\" class=\"img-responsive\" /></div>
          <div class=\"col-sm-6\">
            <h2>Multi-lingual</h2>
            <p>Available in more than 40 languages and counting! Easily handles Chinese, Japanese, Greek, and even right-to-left languages such as Arabic and Hebrew</p>
          </div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\">
              <h2>Turn mail to your advantage</h2>
              <p>OpenCart offers an easy way for customers to get subscribed to your newsletter. Once they do this you can easily get started with your email marketing campaigns.</p>
            </div>
            <div class=\"col-sm-6\"><img src=\"application/view/image/feature/customer/email.png\" alt=\"Turn mail to your advantage\" title=\"Turn mail to your advantage\" class=\"img-responsive\" /></div>
          </div>
        </div>
      </div>
      <div class=\"bottom-link\">
        <h6>Next Page</h6>
        <a onclick=\"\$('a[href=\\'#tab-shipping\\']').click();\" class=\"btn btn-lg\">Shipping, Payments and Reports <i class=\"fa fa-angle-right\"></i></a></div>
    </div>
    <div id=\"tab-shipping\" class=\"tab-pane\">
      <div class=\"container\">
        <h1 class=\"text-center\">Comprehensive payment gateways</h1>
        <div class=\"row\">
          <div class=\"col-sm-7\"><img src=\"application/view/image/feature/shipping-payment/payment-gateway.png\" alt=\"Payment Gateways\" title=\"Payment Gateways\" class=\"img-responsive\" /></div>
          <div class=\"col-sm-5\">
            <h2>Payment Gateways</h2>
            <p>Authorize.Net, Amazon Payments, First Data, Klarna, LiqPay, Skrill, PayPal, SagePay and many more. Choose any of the 36 Payment methods that come integrated with OpenCart or download among hundreds more available via the OpenCart marketplace. </p>
          </div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\">
              <h2>Recurring payments</h2>
              <p>Set up recurring payments for your customers. If you plan to sell products by subscription, if you are promoting a discount or member's club, or if you are simply breaking up payments into smaller portions. This feature gives the store owner more control over how customers are charged for products or services.</p>
            </div>
            <div class=\"col-sm-6\"><img src=\"application/view/image/feature/shipping-payment/recurring-payments.png\" alt=\"Recurring payments\" title=\"Recurring payments\" class=\"img-responsive\" /></div>
          </div>
        </div>
      </div>
      <div class=\"container\">
        <div class=\"row\">
          <div class=\"col-sm-7\"><img src=\"application/view/image/feature/shipping-payment/shipping-method.png\" alt=\"Shipping Methods\" title=\"Shipping Methods\" class=\"img-responsive\" /></div>
          <div class=\"col-sm-5\">
            <h2>Shipping Methods</h2>
            <p>The most world-renowned Shipping methods, integrated for you. OpenCart has integrations with Australia Post, Citylink, FedEx, Parcelforce, Royal mail, UPS, USPS and much more. There are also hundreds of other shipping methods available in the OpenCart Marketplace.</p>
          </div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\">
              <h2>Sales reports</h2>
              <p>Get analytical. OpenCart comes powered up with a sales report, viewed products and purchased products report. If you want to get additional reporting functionality you can view some of the popular reporting extensions.</p>
            </div>
            <div class=\"col-sm-6\"><img src=\"application/view/image/feature/shipping-payment/sales-report.png\" alt=\"Sales reports\" title=\"Sales reports\" class=\"img-responsive\" /></div>
          </div>
        </div>
      </div>
      <div class=\"bottom-link\">
        <h6>Next Page</h6>
        <a onclick=\"\$('a[href=\\'#tab-extension\\']').click();\" class=\"btn btn-lg\">Extensions <i class=\"fa fa-angle-right\"></i></a></div>
    </div>
    <div id=\"tab-extension\" class=\"tab-pane\">
      <div class=\"container\">
        <h1 class=\"text-center\">Easily extend the functionality</h1>
        <div class=\"row\">
          <div class=\"col-sm-7\"><img src=\"application/view/image/feature/extensions/extensions.png\" alt=\"OpenCart Extensions\" title=\"OpenCart Extensions\" class=\"img-responsive\" /></div>
          <div class=\"col-sm-5\">
            <h2>OpenCart Extensions</h2>
            <p>OpenCart is a module based system which allows users to easily extend the functionality for their needs. Easy quick and modify: Bestsellers, Category, Featured, Latest, Specials, Bestsellers, Manufacturers, Information, Google analytics and many more pages.</p>
          </div>
          <div class=\"col-sm-6\">
            <h2>Extension installer</h2>
            <p>Expanding your store functionality is a piece of cake. The Extension Installer allows you to upload modules with a few clicks and no technical knowledge.</p>
          </div>
          <div class=\"col-sm-6\"><img src=\"application/view/image/feature/extensions/installation.png\" alt=\"Extension installer\" title=\"Extension installer\" class=\"img-responsive\" /></div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container text-center\">
          <div class=\"row\">
            <div class=\"col-sm-12\">
              <h2>Marketplace</h2>
              <p>The OpenCart Marketplace features more than 13 000 modules and themes to jump-start, grow and expand your business. You can find beautiful themes for just about any business, service integrations, payment providers, conversion modules and many more.</p>
              <ul class=\"list-inline\">
                <li><img src=\"application/view/image/feature/extensions/icon-paypal.png\" alt=\"PayPal\" title=\"PayPal\" class=\"img-responsive\" /></li>
                <li><img src=\"application/view/image/feature/extensions/icon-ebay.png\" alt=\"eBay\" title=\"eBay\" class=\"img-responsive\" /></li>
                <li><img src=\"application/view/image/feature/extensions/icon-amazon.png\" alt=\"Amazon\" title=\"Amazon\" class=\"img-responsive\" /></li>
                <li><img src=\"application/view/image/feature/extensions/icon-mailchimp.png\" alt=\"MailChimp\" title=\"MailChimp\" class=\"img-responsive\" /></li>
                <li><img src=\"application/view/image/feature/extensions/icon-google-analytics.png\" alt=\"Google Analytics\" title=\"Google Analytics\" class=\"img-responsive\" /></li>
                <li><img src=\"application/view/image/feature/extensions/icon-facebook.png\" alt=\"Facebook\" title=\"Facebook\" class=\"img-responsive\" /></li>
                <li><img src=\"application/view/image/feature/extensions/icon-wordpress.png\" alt=\"Word Press\" title=\"Word Press\" class=\"img-responsive\" /></li>
                <li><img src=\"application/view/image/feature/extensions/icon-excel.png\" alt=\"Excel\" title=\"Excel\" class=\"img-responsive\" /></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class=\"container\">
        <div class=\"row\">
          <div class=\"col-sm-6\">
            <h2>100% translatable</h2>
            <p>OpenCart is 100% translatable. Use OpenCart in your language, get started selling in your language or expand your business by selling in another language. It is that easy.</p>
          </div>
          <div class=\"col-sm-6\"><img src=\"application/view/image/feature/extensions/translatable.png\" alt=\"100% translatable\" title=\"100% translatable\" class=\"img-responsive\" /></div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\"><img src=\"application/view/image/partner/device.png\" alt=\"Partners around the world\" title=\"Partners around the world\" class=\"img-responsive\" /></div>
            <div class=\"col-sm-6\">
              <h2>Partners around the world</h2>
              <p>Looking for professional help for your project? Get help from our Certified partners around the world.</p>
              <p>
                <a href=\"";
        // line 289
        echo ($context["partner"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg hidden-xs\">View Partners</a>
                <a href=\"";
        // line 290
        echo ($context["partner"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg btn-block visible-xs-block\">View Partners</a>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class=\"bottom-link\">
        <h6>Next Page</h6>
        <a onclick=\"\$('a[href=\\'#tab-mobile\\']').click();\" class=\"btn btn-lg\">Mobile and SEO <i class=\"fa fa-angle-right\"></i></a> </div>
    </div>
    <div id=\"tab-mobile\" class=\"tab-pane\">
      <div class=\"container\">
        <h1 class=\"text-center\">Responsive & SEO friendly</h1>
        <div class=\"row\">
          <div class=\"col-sm-5\">
            <h2>Mobile/Tablet</h2>
            <p>OpenCart is responsive by default. This means your site will look awesome no matter the device. Mobile, tablet, desktop or a large screen you will certainly make an impression. You can also check out some of the community developed themes on ThemeForest or TemplateMonster.</p>
          </div>
          <div class=\"col-sm-7\"><img src=\"application/view/image/feature/mobile-seo/device.png\" alt=\"Mobile / Tablet\" title=\"Mobile / Tablet\" class=\"img-responsive\" /></div>
        </div>
        <div class=\"row\">
          <div class=\"col-sm-6\"><img src=\"application/view/image/feature/mobile-seo/seo.png\" alt=\"SEO\" title=\"SEO\" class=\"img-responsive\" /></div>
          <div class=\"col-sm-6\">
            <h2>SEO</h2>
            <p>Don’t waste time & money to get your website higher in Search Engines. We know how important this it so we take care of this for you. You can further <a href=\"https://www.seopapa.co.uk\" target=\"_blank\">enhance SEO</a> in OpenCart with some of our Popular SEO Extensions.</p>
          </div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-5\">
              <h2>Marketing</h2>
              <p>No need for expensive add ons. The Marketing in your OpenCart dashboard allows you to add and track the marketing campaigns you create.</p>
            </div>
            <div class=\"col-sm-7\"><img src=\"application/view/image/feature/mobile-seo/marketing.png\" alt=\"Marketing\" title=\"Marketing\" class=\"img-responsive\" /></div>
          </div>
        </div>
      </div>
      <div class=\"container\">
        <div class=\"row\">
          <div class=\"col-sm-6\"><img src=\"application/view/image/feature/mobile-seo/product-feed.png\" alt=\"Product Feeds\" title=\"Product Feeds\" class=\"img-responsive\" /></div>
          <div class=\"col-sm-6\">
            <h2>Product Feeds</h2>
            <p>Connect to Google base and Google sitemap and set how Google lists and views your products</p>
          </div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\">
              <h2>Guest and Registered user Checkout</h2>
              <p>When it comes to the most important step and converting a customer - the checkout, OpenCart provides both Guest and Registered user checkout. The choice is yours.</p>
            </div>
            <div class=\"col-sm-6\"><img src=\"application/view/image/feature/mobile-seo/guest-checkout.png\" alt=\"Guest and Registered user Checkout\" title=\"Guest and Registered user Checkout\" class=\"img-responsive\" /></div>
          </div>
        </div>
      </div>
      <div class=\"bottom-link\">
        <h6>Next Page</h6>
        <a onclick=\"\$('a[href=\\'#tab-developer\\']').click();\" data-toggle=\"tab\" class=\"btn btn-lg\">Developer <i class=\"fa fa-angle-right\"></i></a></div>
    </div>
    <div id=\"tab-developer\" class=\"tab-pane\">
      <div class=\"container\">
        <h1 class=\"text-center\">Sell your modules and themes on the OpenCart marketplaces.</h1>
        <div class=\"row\">
          <div class=\"col-sm-7\"><img src=\"application/view/image/feature/developer/marketplace.png\" alt=\"Marketplace for third-party extensions\" title=\"Marketplace for third-party extensions\" class=\"img-responsive\" /></div>
          <div class=\"col-sm-5 col-md-5\">
            <h2>Marketplace for third-party extensions</h2>
            <p>We have provided over 13 000 and more extensions &amp; themes on the OpenCart marketplace, little or no bureaucracy and competitive commission rates based on your sales. OpenCart is one of the best places to give your ideas review application. Start today and sell your modules and themes on the OpenCart marketplaces.</p>
          </div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\">
              <h2>MVC-L architecture</h2>
              <p>Get started with OpenCart's MVC-L (Model-View-Controller-Language framework) MVC is a popular software architectural pattern which is extended in OpenCart by including a language entity. </p>
            </div>
            <div class=\"col-sm-6\"><img src=\"application/view/image/feature/developer/mvc-l.png\" alt=\"MVC-L architecture\" title=\"MVC-L architecture\" class=\"img-responsive\"  /></div>
          </div>
        </div>
      </div>
      <div class=\"container\">
        <div class=\"row\">
          <div class=\"col-sm-6\"><img src=\"application/view/image/feature/developer/api.png\" alt=\"API\" title=\"API\" class=\"img-responsive\"  /></div>
          <div class=\"col-sm-6\">
            <h2>API</h2>
            <p>OpenCart features a API which allows third party applications to talk to your OpenCart store for better integration capabilities. <a href=\"#\">View API</a>.</p>
          </div>
        </div>
      </div>
      <div class=\"container-fluid\">
        <div class=\"container\">
          <div class=\"row\">
            <div class=\"col-sm-6\">
              <h2>Open-Source</h2>
              <p>Open source means transparency, open code and community vision. Get started and view the project in Github</p>
            </div>
            <div class=\"col-sm-6\"><img src=\"application/view/image/feature/developer/open-source.png\" alt=\"Open-Source\" title=\"Open-Source\" class=\"img-responsive\"  /></div>
          </div>
        </div>
      </div>
      <div class=\"bottom-link\">
        <h6>Next Page</h6>
        <a onclick=\"\$('a[href=\\'#tab-admin\\']').click();\" class=\"btn btn-lg\">Admin <i class=\"fa fa-angle-right\"></i></a>
      </div>
    </div>

  </div>
</div>


";
        // line 405
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/feature.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  456 => 405,  338 => 290,  334 => 289,  134 => 92,  130 => 91,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/feature.twig", "");
    }
}
