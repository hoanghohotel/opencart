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

/* cloud/landing.twig */
class __TwigTemplate_ded3193c85d41eb11acd20cd4aba25f8fe37827659c997f3acdf9ef1e9a7e813 extends Template
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
<div id=\"cloud_landing\">
\t<div class=\"container-fluid cloud-welcome--outer\">
\t\t<div class=\"container cloud-welcome--inner\">
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-welcome--logo-block\">
\t\t\t\t\t\t\t<img src=\"image/application/cloud/opencart_cloud_logo.png\" width=\"175px\"/>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-welcome--wording-block\">
\t\t\t\t\t\t\t<span class=\"cloud-welcome--wording\">You own your OpenCart.</br>\t\t\t\t\t\t\tWe take care of the rest</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-welcome--button-block\">
\t\t\t\t\t\t\t<a href=\"";
        // line 15
        echo ($context["create"] ?? null);
        echo "\" class=\"btn btn-primary cloud-welcome--button\">GET STARTED</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12\">
\t\t\t\t\t\t\t<span class=\"cloud-welcome--enjoy-text\">* Enjoy a FREE trial for 7 days. Create your STORE within 5 Minutes</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 cloud-welcome--photo-block\">
\t\t\t\t\t<img class=\"cloud-welcome--photo\" src=\"image/application/cloud/site-telephone.png\"/>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container-fluid cloud-how-it-works--outer\">
\t\t<div class=\"container cloud-how-it-works--inner\">
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-md-12 text-center cloud-how-it-works--heading-block\">
\t\t\t\t\t<span class=\"cloud-how-it-works--heading\">How it works?</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-4 col-sm-4 cloud-how-it-works--feature\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-centered-block\">
\t\t\t\t\t\t\t<img src=\"image/application/cloud/account.png\" class=\"cloud-how-it-works--feature_image\"/>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-how-it-works--feature_heading-block text-center\">
\t\t\t\t\t\t\t<span class=\"cloud-how-it-works--feature_heading\">Create an account</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-how-it-works--feature_description-block text-center\">
\t\t\t\t\t\t<span class=\"cloud-how-it-works--feature_description\">
\t\t\t\t\t\t\tProvide your email and password to<br>create an account
\t\t\t\t\t\t</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-4 col-sm-4 cloud-how-it-works--feature\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-centered-block\">
\t\t\t\t\t\t\t<img src=\"image/application/cloud/payment.png\" class=\"cloud-how-it-works--feature_image\"/>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-how-it-works--feature_heading-block text-center\">
\t\t\t\t\t\t\t<span class=\"cloud-how-it-works--feature_heading\">Add payment method</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-how-it-works--feature_description-block text-center\">
\t\t\t\t\t\t<span class=\"cloud-how-it-works--feature_description\">
\t\t\t\t\t\t\tWe accept credit cards and<br>PayPal as payments
\t\t\t\t\t\t</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-4 col-sm-4 cloud-how-it-works--feature\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-centered-block\">
\t\t\t\t\t\t\t<img src=\"image/application/cloud/launch.png\" class=\"cloud-how-it-works--feature_image\"/>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-how-it-works--feature_heading-block text-center\">
\t\t\t\t\t\t\t<span class=\"cloud-how-it-works--feature_heading\">Launch your OpenCart</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-how-it-works--feature_description-block text-center\">
\t\t\t\t\t\t<span class=\"cloud-how-it-works--feature_description\">
\t\t\t\t\t\t\tClick create store and<br>enjoy selling on-line
\t\t\t\t\t\t</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container-fluid cloud-utility--outer\">
\t\t<div class=\"container cloud-utility--inner\">
\t\t\t<div class=\"row cloud-utility--column\">
\t\t\t\t<div class=\"col-md-6 cloud-utility--text-block utility-order-1\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-utility--text-block_heading\">Quick and easy</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-utility--text-block_description\">It has never been easier to setup your OpenCart store until now. OpenCart Cloud lets you launch your online business in minutes. Name your store and click create. No more uploading files and going through an installation process.</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 cloud-centered-block utility-order-2\">
\t\t\t\t\t<img src=\"image/application/cloud/utility-1.png\" width=\"100%\"/>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 cloud-centered-block utility-order-4\">
\t\t\t\t\t<img src=\"image/application/cloud/utility-2.png\" width=\"100%\"/>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 cloud-utility--text-block utility-order-3\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-utility--text-block_heading\">Hosted on Amazon</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-utility--text-block_description\">The Cloud is today's modern way of hosting. Almost everything is now on the cloud from music, TV & movies to your personal photos. With OpenCart Cloud you get the benefits of the best ecommerce solution hosted on AWS servers.</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 cloud-utility--text-block utility-order-5\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-utility--text-block_heading\">No transaction fees</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-utility--text-block_description\">We don't charge you any transaction fees, unlike other hosted ecommerce solutions. We stay true to our cause, providing the best open-source ecommerce solution. We just help you host it, that's all.</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 cloud-centered-block utility-order-6\">
\t\t\t\t\t<img src=\"image/application/cloud/utility-3.png\" width=\"100%\"/>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 cloud-centered-block utility-order-8\">
\t\t\t\t\t<img src=\"image/application/cloud/utility-4.png\" width=\"100%\"/>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-6 cloud-utility--text-block utility-order-7\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-utility--text-block_heading\">Themes and Extensions</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-utility--text-block_description\">A brand new extension store has been built for our Cloud Stores, allowing merchants to search and install with one click. No uploading of files is needed and every extension goes through a verification stage before reaching the cloud.</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container cloud-security--outer\">
\t\t<div class=\"container cloud-security--inner\">
\t\t\t<div class=\"col-md-6 col-md-offset-6 cloud-security--text-block\">
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-12\">
\t\t\t\t\t\t<span class=\"cloud-security--heading\">Security by default</span>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-12\">
\t\t\t\t\t\t<span class=\"cloud-security--description\">From the first conversation to the final line of code, security has always been our priority. Built on AWS, our whole network is monitored constantly and our security solutions are constantly evolving.</span>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container cloud-support--outer\">
\t\t<div class=\"container cloud-support--inner\">
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-md-12 cloud-centered-block cloud-support--image-block\">
\t\t\t\t\t<img src=\"image/application/cloud/support.png\" class=\"cloud-support--image\"/>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-12 text-center cloud-support--heading-block\">
\t\t\t\t\t<span class=\"cloud-support--heading\">Outstanding support</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-12 text-center\">
\t\t\t\t<span class=\"cloud-support--description\">Our support team have helped over
\t\t\t\t\t<span class=\"cloud-semi-bold\">400,000 businesses,</span>
\t\t\t\t\tachieve their goals and we’re here to help you too. You’re in safe hands, when it comes to guidance and anything technical.</span>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container-fluid cloud-paypal--outer\">
\t\t<div class=\"container cloud-paypal--inner\">
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-md-12 cloud-centered-block paypal-pluc-oc-block\">
\t\t\t\t\t<img src=\"image/application/cloud/logo_paypal.svg\"/><span class=\"cloud-paypal--plus\">+</span><img src=\"image/application/cloud/logo_opencart.svg\"/>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-12 text-center cloud-paypal--text-block_heading-block\">
\t\t\t\t\t<span class=\"cloud-paypal--text-block_heading\">Partnered with Paypal</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-12 text-center\">
\t\t\t\t\t<span class=\"cloud-paypal--text-block_description\">OpenCart has partnered with Paypal to bring you the best payment experience the web can offer. Starting from ease of setup through PayPal's new on-boarding flow to offering a wast variety of payment solutions beyond PayPal itself.</span>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container cloud-pricing--outer\">
\t\t<div class=\"container cloud-pricing--inner\">
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-md-12 cloud-pricing--heading-block text-center\">
\t\t\t\t\t<span class=\"cloud-pricing--heading\">Pricing</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-4 col-sm-4 cloud-pricing--card-block\" style=\"height: 280px;\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-pricing--card-block_heading-block text-center\">
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_heading\">Bronze</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-pricing--card-block_price-block text-center\">
\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_price\">
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_price__amount\">59</span>
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_price__monthly\">/Mo</span>
\t\t\t\t\t\t</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 col-md-12 cloud-pricing--card-block_description-block text-center\">
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_description\">Perfect for smaller stores (1CPU 2GB)</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-4 col-sm-4 cloud-pricing--card-block cloud-relative\" style=\"height: 280px;\">
\t\t\t\t\t<img src=\"image/application/cloud/recommended.svg\" class=\"cloud-pricing--card-block_recommended-image\"/>
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-pricing--card-block_heading-block text-center\">
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_heading\">Silver</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-pricing--card-block_price-block text-center\">
\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_price\">
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_price__amount\">99</span>
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_price__monthly\">/Mo</span>
\t\t\t\t\t\t</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 col-md-12 cloud-pricing--card-block_description-block text-center\">
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_description\">Designed for SME (2CPU 4GB)</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-4 col-sm-4 cloud-pricing--card-block\" style=\"height: 280px;\">
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-md-12 cloud-pricing--card-block_heading-block text-center\">
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_heading\">Gold</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 cloud-pricing--card-block_price-block text-center\">
\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_price\">
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_price__amount\">199</span>
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_price__monthly\">/Mo</span>
\t\t\t\t\t\t</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-md-12 col-md-12 cloud-pricing--card-block_description-block text-center\">
\t\t\t\t\t\t\t<span class=\"cloud-pricing--card-block_description\">Perfect for Enterprise (4CPU 8GB)</span>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container compare--outer\">
\t\t<div class=\"container compare--inner\">
\t\t\t<div id=\"compare-table\">
\t\t\t\t";
        // line 374
        echo "\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container try-for-free--outer\">
\t\t<div class=\"container try-for-free--inner\">
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-md-12 col-sm-12 text-center\">
\t\t\t\t\t<span class=\"try-for-free--heading\">Try OpenCart Cloud for free</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-12 col-sm-12 text-center\">
\t\t\t\t\t<span class=\"try-for-free--description\">Start your OpenCart in 5 minutes with our <span class=\"cloud-green\">7 days free</span> trial</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-12 col-sm-12 text-center try-for-free--button-block\">
\t\t\t\t\t<a href=\"";
        // line 387
        echo ($context["create"] ?? null);
        echo "\" class=\"btn btn-primary cloud-welcome--button\">GET STARTED</a>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
</div>

<script type=\"text/javascript\">
<!--
\$('#start-button').on('click', function(e) {
    e.preventDefault();

    \$.ajax({
        url: 'index.php?route=cloud/cloud',
        dataType: 'html',
        beforeSend: function() {
            \$(this).prop('disabled', true);
        },
        complete: function() {
            \$(this).prop('disabled', false);
        },
        success: function(html) {
            \$('#modal-cloud').remove();

            \$('body').append(html);

            \$('#modal-cloud').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});
//--></script>
<style>
    @font-face {
        font-family: 'Source Sans Pro';
        src: url('application/view/stylesheet/fonts/SourceSansPro-Regular.ttf');
    }

    @font-face {
        font-family: 'Source Sans Pro Semi-Bold';
        src: url('application/view/stylesheet/fonts/SourceSansPro-SemiBold.ttf');
    }

    @font-face {
        font-family: 'Source Sans Pro Light-Italic';
        src: url('application/view/stylesheet/fonts/SourceSansPro-LightItalic.ttf');
    }

    @font-face {
        font-family: 'Source Sans Pro Light';
        src: url('application/view/stylesheet/fonts/SourceSansPro-Light.ttf');
    }

    @font-face {
        font-family: 'Source Sans Pro Semi-Bold-Italic';
        src: url('application/view/stylesheet/fonts/SourceSansPro-SemiBoldItalic.ttf');
    }

    /* Cloud Landing */
    .cloud-centered-block {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cloud-relative {
        position: relative;
    }

    .cloud-green {
        color: green;
        font-family: \"Source Sans Pro Semi-Bold-Italic\", sans-serif;
    }

    .cloud-light-blue {
        background-color: #3A78E2;
    }

    .cloud-dark-blue {
        background-color: #0B48B1;
    }

    .cloud-semi-bold {
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
    }

    .cloud-welcome--outer {
        background: url(\"image/application/cloud/main_banner_back.svg\") no-repeat padding-box, linear-gradient(324deg, #174499 0%, #2E86CE 100%);
    }

    .cloud-welcome--inner {
        padding-top: 120px;
        padding-bottom: 100px;
    }

    .cloud-welcome--logo-block {
        padding-bottom: 15px;
    }

    .cloud-welcome--wording-block {
        padding-bottom: 35px;
    }

    .cloud-welcome--wording {
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        font-size: 50px;
        color: white;
        line-height: 1.4;
    }

    .cloud-welcome--button-block {
        padding-bottom: 30px;
    }

    .cloud-welcome--button {
        font-size: 18px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        padding: 19px 45px;
    }

    .cloud-welcome--enjoy-text {
        font-size: 25px;
        font-family: \"Source Sans Pro Light-Italic\", sans-serif;
        letter-spacing: 0.25px;
        color: #FFFFFF;
    }

    .cloud-welcome--photo-block {
        position: relative;
    }

    .cloud-welcome--photo {
        position: absolute;
        width: 720px;
        top: -90px;
        left: -85px;
    }

    .cloud-how-it-works--outer {
        background-color: #FFFFFF;
    }

    .cloud-how-it-works--inner {
        padding-top: 250px;
        padding-bottom: 200px;
    }

    .cloud-how-it-works--heading-block {
        padding-bottom: 55px;
    }

    .cloud-how-it-works--heading {
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        font-size: 50px;
    }

    .cloud-how-it-works--feature_heading-block {
        padding-bottom: 12px;
    }

    .cloud-how-it-works--feature_image {
        width: 190px;
    }

    .cloud-how-it-works--feature_heading {
        letter-spacing: 0.25px;
        font-size: 25px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
    }

    .cloud-how-it-works--feature_description {
        letter-spacing: 0.16px;
        font-size: 16px;
    }

    .cloud-utility--outer {
        background-color: #FFFFFF;
    }

    .cloud-utility--column {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        -webkit-flex-flow: row wrap;
        flex-flow: row wrap;
    }

    .cloud-utility--column > [class*='col-'] {
        display: flex;
        flex-direction: column;
    }

    .cloud-utility--text-block {
        display: flex;
        justify-content: center;
    }

    .cloud-utility--text-block_heading {
        font-size: 50px;
        letter-spacing: 0.5px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
    }

    .cloud-utility--text-block_description {
        font-size: 16px;
        letter-spacing: 0.16px;
        font-family: \"Source Sans Pro Light\", sans-serif;
    }

    .cloud-security--outer {
        margin-top: 150px;
        margin-bottom: 150px;
        background: url(\"image/application/cloud/security.png\") no-repeat padding-box;
    }

    .cloud-security--inner {
        padding-top: 160px;
        padding-bottom: 160px;
    }

    .cloud-security--text-block {
        max-width: 455px;
    }

    .cloud-security--heading {
        font-size: 50px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        letter-spacing: 0.5px;
        color: #E2EEFD;
    }

    .cloud-security--description {
        font-size: 22px;
        font-family: \"Source Sans Pro Light\", sans-serif;
        letter-spacing: 0.11px;
        color: #ECF3FC;
    }

    .cloud-support--outer {
        margin-bottom: 150px;
    }

    .cloud-support--inner {
        max-width: 750px;
    }

    .cloud-support--image {
        max-width: 510px;
        width: 100%;
    }

    .cloud-support--heading {
        font-size: 50px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        letter-spacing: 0.5px;
    }

    .cloud-support--description {
        font-size: 22px;
        font-family: \"Source Sans Pro Light\", sans-serif;
        letter-spacing: 0.22px;
    }

    .cloud-support--image-block {
        padding-bottom: 50px;
    }

    .cloud-support--heading-block {
        padding-bottom: 30px;
    }

    .cloud-paypal--outer {
        background: url(\"image/application/cloud/paypal_banner.svg\") no-repeat padding-box;
        margin-bottom: 100px;
    }

    .cloud-paypal--inner {
        max-width: 720px;
        padding-top: 75px;
        padding-bottom: 120px;
    }

    .cloud-paypal--text-block_heading-block {
        padding-bottom: 15px;
    }

    .cloud-paypal--text-block_heading {
        font-size: 50px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        letter-spacing: 0.5px;
        color: #FFFFFF;
    }

    .cloud-paypal--text-block_description {
        font-size: 16px;
        letter-spacing: 0.16px;
        font-family: \"Source Sans Pro Light\", sans-serif;
        color: #FFFFFF;
    }

    .cloud-paypal--plus {
        font-size: 30px;
        color: #FFF;
    }

    .cloud-pricing--inner {
        max-width: 1035px;
    }

    .cloud-pricing--heading-block {
        padding-bottom: 65px;
    }

    .cloud-pricing--heading {
        font-size: 50px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        letter-spacing: 0.5px;
    }

    .cloud-pricing--card-block {
        margin-left: 15px;
        margin-right: 15px;
        max-width: 310px;
    }

    .cloud-pricing--card-block_heading-block {
        padding-top: 23px;
    }

    .cloud-pricing--card-block_heading::after {
        content: '';
        width: 90%;
        position: absolute;
        left: 15px;
        bottom: 1px;
        border-width: 0 0 1px;
        border-style: solid;
        border-color: #D8D8D8;
    }

    .cloud-pricing--card-block_heading {
        font-size: 45px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        letter-spacing: 0.45px;
    }

    .cloud-pricing--card-block {
        border: 1px solid #D8D8D8;
        border-radius: 10px;
    }

    .cloud-pricing--outer {
        margin-bottom: 40px;
    }

    .cloud-pricing--card-block_price__amount {
        font-size: 50px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        letter-spacing: 0.5px;
        position: relative;
    }

    .cloud-pricing--card-block_price__amount::before {
        content: '\$';
        font-size: 20px;
        vertical-align: top;
        position: absolute;
        top: 10%;
        left: -25%;
    }

    .cloud-pricing--card-block_price__monthly {
        font-size: 20px;
    }

    .cloud-pricing--card-block_description {
        font-size: 20px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
    }

    .cloud-pricing--card-block_info-block div {
        border-radius: 10px;
    }

    .cloud-pricing--card-block_description-block {
        padding-bottom: 40px;
    }

    .cloud-pricing--card-block_info-block {
        padding-bottom: 10px;
    }

    .cloud-pricing--card-block_info {
        padding-top: 10px;
        padding-bottom: 10px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
        font-size: 18px;
        color: white;
    }

    .cloud-pricing--card-block_recommended-image {
        position: absolute;
        width: 170px;
        top: -7%;
        left: 50%;
        margin-left: -85px;
    }

    .try-for-free--outer {
        padding-top: 150px;
    }

    .try-for-free--heading {
        font-size: 50px;
        font-family: \"Source Sans Pro Semi-Bold\", sans-serif;
    }

    .try-for-free--description {
        font-size: 22px;
        font-family: \"Source Sans Pro Light-Italic\", sans-serif;
    }

    .try-for-free--button-block {
        padding-top: 30px;
    }

    /* Cloud Landing Adaptive*/
    @media screen and (min-device-width: 320px) and (max-device-width: 650px) and (orientation: portrait) {
        .cloud-welcome--enjoy-text {
            font-size: 20px;
        }

        .cloud-welcome--inner {
            padding-top: 85px;
        }

        .cloud-welcome--photo {
            position: absolute;
            width: 100%;
            top: -25px;
            left: 0;
        }

        .cloud-welcome--wording {
            font-size: 30px;
        }

        .cloud-how-it-works--feature {
            padding-bottom: 45px;
        }

        .cloud-how-it-works--inner {
            padding-bottom: 85px;
        }

        .cloud-utility--text-block_heading {
            text-align: center;
            font-size: 40px;
            line-height: 45px;
            padding-bottom: 30px;
        }

        .cloud-utility--text-block_description {
            padding-bottom: 40px;
        }

        .cloud-security--outer {
            margin-top: 85px;
            margin-bottom: 85px;
            background: #3A78E2;
        }

        .cloud-security--inner {
            padding-top: 85px;
            padding-bottom: 85px;
        }

        .cloud-security--heading {
            font-size: 40px;
            line-height: 45px;
        }

        .cloud-support--heading {
            font-size: 40px;
            line-height: 50px;
        }

        .cloud-paypal--outer {
            background: #0B48B1;
            margin-bottom: 85px;
        }

        .paypal-pluc-oc-block {
            display: grid;
        }

        .cloud-paypal--text-block_heading-block {
            font-size: 40px;
            line-height: 60px;
        }

        .cloud-paypal--plus {
            text-align: center;
        }

        .cloud-pricing--card-block {
            margin-bottom: 45px;
            max-width: 100%;
            margin-left: 0px;
            margin-right: 0px;
        }

        .try-for-free--heading {
            font-size: 40px;
        }

        .try-for-free--outer {
            padding-top: 80px;
        }

        .utility-order-1 {
            order: 1;
        }

        .utility-order-2 {
            order: 2;
        }

        .utility-order-3 {
            order: 3;
        }

        .utility-order-4 {
            order: 4;
        }

        .utility-order-5 {
            order: 5;
        }

        .utility-order-6 {
            order: 6;
        }

        .utility-order-7 {
            order: 7;
        }

        .utility-order-8 {
            order: 8;
        }
    }

    @media screen and (min-device-width: 651px) and (max-device-width: 799px) and (orientation: portrait) {
        .cloud-utility--text-block_heading {
            text-align: center;
            padding-bottom: 30px;
        }

        .cloud-security--outer {
            background: #0B48B1;
        }

        .cloud-security--text-block {
            max-width: 100%;
            text-align: center;
        }

        .cloud-how-it-works--inner {
            padding-top: 85px;
            padding-bottom: 100px;
        }

        .cloud-welcome--photo {
            display: none;
        }

        .cloud-pricing--card-block {
            margin-left: 2px;
            margin-right: 2px;
            max-width: 240px;
        }

        .cloud-utility--text-block_description {
            text-align: center;
            padding-bottom: 40px;
        }

        .utility-order-1 {
            order: 1;
        }

        .utility-order-2 {
            order: 2;
        }

        .utility-order-3 {
            order: 3;
        }

        .utility-order-4 {
            order: 4;
        }

        .utility-order-5 {
            order: 5;
        }

        .utility-order-6 {
            order: 6;
        }

        .utility-order-7 {
            order: 7;
        }

        .utility-order-8 {
            order: 8;
        }
    }

    @media screen and (min-device-width: 800px) and (max-device-width: 1200px) and (orientation: portrait) {
        .cloud-pricing--card-block {
            max-width: 285px;
        }

        .cloud-welcome--photo {
            width: 655px;
        }

        .cloud-paypal--outer {
            margin-bottom: 130px;
        }

        .cloud-welcome--outer {
            overflow: hidden;
        }
    }
</style>
";
        // line 1030
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cloud/landing.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  934 => 1030,  288 => 387,  273 => 374,  54 => 15,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cloud/landing.twig", "");
    }
}
