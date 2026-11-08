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

/* account/account.twig */
class __TwigTemplate_0ef2e149c0958ba12304193171c238ccf8e40688eb2d2ad31cc803cc61259f71 extends Template
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
<div id=\"account-account\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>Account</h1>
      <p>Welcome to OpenCart!</p>
    </div>
  </div>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-9\">
        ";
        // line 12
        if (($context["success"] ?? null)) {
            // line 13
            echo "          <div class=\"alert alert-success\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["success"] ?? null);
            echo "
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
          </div>
        ";
        }
        // line 17
        echo "        <div id=\"short-cut\">
          <p id=\"pp-banner\"><a href=\"index.php?route=marketplace/extension/info&extension_id=38358\"><img width=\"100%\" src=\"application/view/image/banner/paypal_banner_large.jpg\" alt=\"paypal\"/></a></p>
          <h2>Account</h2>
          <div class=\"row\">
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
        // line 23
        echo ($context["edit"] ?? null);
        echo "\"><img src=\"application/view/image/account/icons/account_details.svg\" alt=\"Account\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
        // line 25
        echo ($context["edit"] ?? null);
        echo "\">Account Details</a></h4>
                  <p><a href=\"";
        // line 26
        echo ($context["edit"] ?? null);
        echo "\">Edit your account details</a></p>
                </div>
              </div>
            </div>
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
        // line 32
        echo ($context["password"] ?? null);
        echo "\"><img src=\"application/view/image/account/icons/change_password.svg\" alt=\"Change password\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
        // line 34
        echo ($context["password"] ?? null);
        echo "\">Change Password</a></h4>
                  <p><a href=\"";
        // line 35
        echo ($context["password"] ?? null);
        echo "\">Reset your password</a></p>
                </div>
              </div>
            </div>
          </div>

          <div class=\"row\">
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
        // line 44
        echo ($context["payment"] ?? null);
        echo "\"><img src=\"application/view/image/account/icons/payment_methods.svg\" alt=\"Payment Methods\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
        // line 46
        echo ($context["payment"] ?? null);
        echo "\">Payment Methods</a></h4>
                  <p><a href=\"";
        // line 47
        echo ($context["payment"] ?? null);
        echo "\">Modify your payment methods</a></p>
                </div>
              </div>
            </div>
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
        // line 53
        echo ($context["showcase"] ?? null);
        echo "\"><img src=\"application/view/image/account/icons/showcase.svg\" alt=\"Showcase\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
        // line 55
        echo ($context["showcase"] ?? null);
        echo "\">Showcase</a></h4>
                  <p><a href=\"";
        // line 56
        echo ($context["showcase"] ?? null);
        echo "\">Submit your store to OpenCart's showcase</a></p>
                </div>
              </div>
            </div>
          </div>

          <div class=\"row\">
            ";
        // line 63
        if ( !($context["partner_status"] ?? null)) {
            // line 64
            echo "              <div class=\"col-md-6\">
                <div class=\"media\">
                  <div class=\"media-left\"><a href=\"";
            // line 66
            echo ($context["partner"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/partner_up.svg\" alt=\"Apply to become a partner\" class=\"media-object\"/></a></div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\"><a href=\"";
            // line 68
            echo ($context["partner"] ?? null);
            echo "\">Partner Up</a></h4>
                    <p><a href=\"";
            // line 69
            echo ($context["partner"] ?? null);
            echo "\">Apply to become a partner</a></p>
                  </div>
                </div>
              </div>
            ";
        } else {
            // line 74
            echo "              <div class=\"col-md-6\">
                <div class=\"media\">
                  <div class=\"media-left\"><a href=\"";
            // line 76
            echo ($context["partner"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/partner_edit.svg\" alt=\"Edit Partner Information\" class=\"media-object\"/></a></div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\"><a href=\"";
            // line 78
            echo ($context["partner"] ?? null);
            echo "\">Edit Partner Information</a></h4>
                    <p><a href=\"";
            // line 79
            echo ($context["partner"] ?? null);
            echo "\">Change your address, logo</a></p>
                  </div>
                </div>
              </div>
            ";
        }
        // line 84
        echo "          </div>

          ";
        // line 86
        if (($context["moderator"] ?? null)) {
            // line 87
            echo "            <h2>Cloud Stores</h2>
            <div class=\"row\">
              <div class=\"col-md-6\">
                <div class=\"media\">
                  <div class=\"media-left\"><a href=\"";
            // line 91
            echo ($context["subscription"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/showcase.svg\" alt=\"Cloud Stores\" class=\"media-object\"/></a></div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\"><a href=\"";
            // line 93
            echo ($context["subscription"] ?? null);
            echo "\">Cloud Stores</a></h4>
                    <p><a href=\"";
            // line 94
            echo ($context["subscription"] ?? null);
            echo "\">View all of your OpenCart subscriptions</a></p>
                  </div>
                </div>
              </div>
            </div>
          ";
        }
        // line 100
        echo "
          <h2>Purchases</h2>
          <div class=\"row\">
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
        // line 105
        echo ($context["order"] ?? null);
        echo "\"><img src=\"application/view/image/account/icons/your_orders.svg\" alt=\"Your Orders\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
        // line 107
        echo ($context["order"] ?? null);
        echo "\">Your Orders</a></h4>
                  <p><a href=\"";
        // line 108
        echo ($context["order"] ?? null);
        echo "\">View the extensions you have previously purchased</a></p>
                </div>
              </div>
            </div>
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
        // line 114
        echo ($context["download"] ?? null);
        echo "\"><img src=\"application/view/image/account/icons/your_downloads.svg\" alt=\"Your Downloads\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
        // line 116
        echo ($context["download"] ?? null);
        echo "\">Your Downloads</a></h4>
                  <p><a href=\"";
        // line 117
        echo ($context["download"] ?? null);
        echo "\">Your Purchased extensions</a></p>
                </div>
              </div>
            </div>
          </div>
          <div class=\"row\">
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
        // line 125
        echo ($context["store"] ?? null);
        echo "\"><img src=\"application/view/image/account/icons/your_stores.svg\" alt=\"Your Stores\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
        // line 127
        echo ($context["store"] ?? null);
        echo "\">Your Stores</a></h4>
                  <p><a href=\"";
        // line 128
        echo ($context["store"] ?? null);
        echo "\">Register your store to access the marketplace API</a></p>
                </div>
              </div>
            </div>
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
        // line 134
        echo ($context["rating"] ?? null);
        echo "\"><img src=\"application/view/image/account/icons/rate_your_downloads.svg\" alt=\"Rate your Downloads\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
        // line 136
        echo ($context["rating"] ?? null);
        echo "\">Rate your Downloads</a></h4>
                  <p><a href=\"";
        // line 137
        echo ($context["rating"] ?? null);
        echo "\">Rate your previously downloaded extensions</a></p>
                </div>
              </div>
            </div>
          </div>

          <h2>Extensions</h2>
          <div class=\"row\">
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
        // line 147
        echo ($context["extension"] ?? null);
        echo "\"><img src=\"application/view/image/account/icons/manage_your_extentions.svg\" alt=\"Manage your Extensions\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
        // line 149
        echo ($context["extension"] ?? null);
        echo "\">Manage your Extensions</a></h4>
                  <p><a href=\"";
        // line 150
        echo ($context["extension"] ?? null);
        echo "\">Manage the extensions you have uploaded</a></p>
                </div>
              </div>
            </div>

            ";
        // line 155
        if ( !($context["seller_status"] ?? null)) {
            // line 156
            echo "              <div class=\"col-md-6\">
                <div class=\"media\">
                  <div class=\"media-left\"><a href=\"";
            // line 158
            echo ($context["seller"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/apply_to_become_a_seller.svg\" alt=\"Apply to become a seller\" class=\"media-object\"/></a></div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\"><a href=\"";
            // line 160
            echo ($context["seller"] ?? null);
            echo "\">Apply to become a seller</a></h4>
                    <p><a href=\"";
            // line 161
            echo ($context["seller"] ?? null);
            echo "\">Get paid by selling your work!</a></p>
                  </div>
                </div>
              </div>
            ";
        } else {
            // line 166
            echo "              <div class=\"col-md-6\">
                <div class=\"media\">
                  <div class=\"media-left\"><a href=\"";
            // line 168
            echo ($context["seller"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/apply_to_become_a_seller.svg\" alt=\"Edit Seller Information\" class=\"media-object\"/></a></div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\"><a href=\"";
            // line 170
            echo ($context["seller"] ?? null);
            echo "\">Edit Seller Information</a></h4>
                    <p><a href=\"";
            // line 171
            echo ($context["seller"] ?? null);
            echo "\">Modify your current seller details</a></p>
                  </div>
                </div>
              </div>
            ";
        }
        // line 176
        echo "
          </div>

          ";
        // line 179
        if (($context["seller_status"] ?? null)) {
            // line 180
            echo "            <div class=\"row\">
              <div class=\"col-md-6\">
                <div class=\"media\">
                  <div class=\"media-left\"><a href=\"";
            // line 183
            echo ($context["sale"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/sales.svg\" alt=\"Sales\" class=\"media-object\"/></a></div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\"><a href=\"";
            // line 185
            echo ($context["sale"] ?? null);
            echo "\">Sales</a></h4>
                    <p><a href=\"";
            // line 186
            echo ($context["sale"] ?? null);
            echo "\">View your Sales</a></p>
                  </div>
                </div>
              </div>
              <div class=\"col-md-6\">
                <div class=\"media\">
                  <div class=\"media-left\"><a href=\"";
            // line 192
            echo ($context["transaction"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/transactions.svg\" alt=\"Transactions\" class=\"media-object\"/></a></div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\"><a href=\"";
            // line 194
            echo ($context["transaction"] ?? null);
            echo "\">Transactions</a></h4>
                    <p><a href=\"";
            // line 195
            echo ($context["transaction"] ?? null);
            echo "\">View your commission rate for sales</a></p>
                  </div>
                </div>
              </div>
            </div>
          ";
        }
        // line 201
        echo "
          ";
        // line 202
        if (false) {
            // line 203
            echo "            <div class=\"row\">
              <div class=\"col-md-6\">
                <div class=\"media\">
                  <div class=\"media-left\"><a href=\"";
            // line 206
            echo ($context["promotion"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/promote-extensions.png\" alt=\"Promote Extensions\" class=\"media-object\"/></a></div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\"><a href=\"";
            // line 208
            echo ($context["promotion"] ?? null);
            echo "\">Promote Extensions</a></h4>
                    <p></p>
                  </div>
                </div>
              </div>
            </div>
          ";
        }
        // line 215
        echo "
          ";
        // line 216
        if (($context["comment"] ?? null)) {
            // line 217
            echo "          <div class=\"row\">
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
            // line 220
            echo ($context["comment"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/manage_your_extensions_comments.svg\" alt=\"Manage your Extensions Comments\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
            // line 222
            echo ($context["comment"] ?? null);
            echo "\">Manage your Extensions Comments</a></h4>
                  <p><a href=\"";
            // line 223
            echo ($context["comment"] ?? null);
            echo "\">Manage the comments member left under your extensions</a></p>
                </div>
              </div>
            </div>
          </div>
          ";
        }
        // line 229
        echo "          
          ";
        // line 230
        if (($context["cloud"] ?? null)) {
            // line 231
            echo "          <h2>Cloud Stores</h2>
          <div class=\"row\">
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
            // line 235
            echo ($context["subscription"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/cloud_stores.svg\" alt=\"Cloud Stores\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
            // line 237
            echo ($context["subscription"] ?? null);
            echo "\">Cloud Stores</a></h4>
                  <p><a href=\"";
            // line 238
            echo ($context["subscription"] ?? null);
            echo "\">View all of your OpenCart Cloud Stores</a></p>
                </div>
              </div>
            </div>
            <div class=\"col-md-6\">
              <div class=\"media\">
                <div class=\"media-left\"><a href=\"";
            // line 244
            echo ($context["subscription_domain"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/cloud_stores.svg\" alt=\"Cloud Domains\" class=\"media-object\"/></a></div>
                <div class=\"media-body\">
                  <h4 class=\"media-heading\"><a href=\"";
            // line 246
            echo ($context["subscription_domain"] ?? null);
            echo "\">Cloud Domains</a></h4>
                  <p><a href=\"";
            // line 247
            echo ($context["subscription_domain"] ?? null);
            echo "\">View all of your OpenCart Cloud Domains</a></p>
                </div>
              </div>
            </div>
            <div class=\"col-md-6\">
                <div class=\"media\">
                  <div class=\"media-left\"><a href=\"";
            // line 253
            echo ($context["subscription_invoice"] ?? null);
            echo "\"><img src=\"application/view/image/account/icons/invoices.svg\" alt=\"Edit seller information\" class=\"media-object\"/></a></div>
                  <div class=\"media-body\">
                    <h4 class=\"media-heading\"><a href=\"";
            // line 255
            echo ($context["subscription_invoice"] ?? null);
            echo "\">Invoices</a></h4>
                    <p><a href=\"";
            // line 256
            echo ($context["subscription_invoice"] ?? null);
            echo "\">Check your subscription invoice(s)</a></p>
                  </div>
                </div>
              </div>
          </div>
          ";
        }
        // line 262
        echo "        </div>
      
      </div>
      <div class=\"col-md-3 hidden-xs\">";
        // line 265
        echo ($context["menu"] ?? null);
        echo "
      <p><a href=\"index.php?route=marketplace/extension/info&extension_id=38358\"><img width=\"100%\" src=\"application/view/image/banner/paypal_banner.jpg\" alt=\"paypal\"/></a></p>
      </div>
    </div>
  </div>
</div>
";
        // line 271
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "account/account.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  545 => 271,  536 => 265,  531 => 262,  522 => 256,  518 => 255,  513 => 253,  504 => 247,  500 => 246,  495 => 244,  486 => 238,  482 => 237,  477 => 235,  471 => 231,  469 => 230,  466 => 229,  457 => 223,  453 => 222,  448 => 220,  443 => 217,  441 => 216,  438 => 215,  428 => 208,  423 => 206,  418 => 203,  416 => 202,  413 => 201,  404 => 195,  400 => 194,  395 => 192,  386 => 186,  382 => 185,  377 => 183,  372 => 180,  370 => 179,  365 => 176,  357 => 171,  353 => 170,  348 => 168,  344 => 166,  336 => 161,  332 => 160,  327 => 158,  323 => 156,  321 => 155,  313 => 150,  309 => 149,  304 => 147,  291 => 137,  287 => 136,  282 => 134,  273 => 128,  269 => 127,  264 => 125,  253 => 117,  249 => 116,  244 => 114,  235 => 108,  231 => 107,  226 => 105,  219 => 100,  210 => 94,  206 => 93,  201 => 91,  195 => 87,  193 => 86,  189 => 84,  181 => 79,  177 => 78,  172 => 76,  168 => 74,  160 => 69,  156 => 68,  151 => 66,  147 => 64,  145 => 63,  135 => 56,  131 => 55,  126 => 53,  117 => 47,  113 => 46,  108 => 44,  96 => 35,  92 => 34,  87 => 32,  78 => 26,  74 => 25,  69 => 23,  61 => 17,  53 => 13,  51 => 12,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "account/account.twig", "");
    }
}
