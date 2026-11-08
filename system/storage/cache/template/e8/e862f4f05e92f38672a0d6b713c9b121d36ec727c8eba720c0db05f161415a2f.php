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

/* setting/payment.twig */
class __TwigTemplate_96a8fcfa069bc729d6ebb08c33218601c79978c24ebf4203f8b28282d5ce7151 extends Template
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
        echo ($context["column_left"] ?? null);
        echo "
<div id=\"content\">
  <div class=\"page-header\">
    <div class=\"container-fluid\">
      <div class=\"pull-right\">
        <button type=\"submit\" form=\"form-payment\" data-toggle=\"tooltip\" title=\"";
        // line 6
        echo ($context["button_save"] ?? null);
        echo "\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i></button>
        <a href=\"";
        // line 7
        echo ($context["cancel"] ?? null);
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo ($context["button_cancel"] ?? null);
        echo "\" class=\"btn btn-default\"><i class=\"fa fa-reply\"></i></a>
      </div>
      <h1>";
        // line 9
        echo ($context["heading_title"] ?? null);
        echo "</h1>
      <ul class=\"breadcrumb\">
        ";
        // line 11
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 12
            echo "        <li><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 12);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 12);
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "      </ul>
    </div>
  </div>
  <div class=\"container-fluid\">
    ";
        // line 18
        if (($context["error_warning"] ?? null)) {
            // line 19
            echo "    <div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
    ";
        }
        // line 23
        echo "    ";
        if (($context["success"] ?? null)) {
            // line 24
            echo "    <div class=\"alert alert-success alert-dismissible\"><i class=\"fa fa-check-circle\"></i> ";
            echo ($context["success"] ?? null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
    ";
        }
        // line 28
        echo "    <div id=\"api-test-alert\"></div>
    <div class=\"panel panel-default\">
      <div class=\"panel-heading\">
        <h3 class=\"panel-title\"><i class=\"fa fa-credit-card\"></i> ";
        // line 31
        echo ($context["text_edit"] ?? null);
        echo "</h3>
      </div>
      <div class=\"panel-body\">
        <form action=\"";
        // line 34
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-payment\" class=\"form-horizontal\">
          <ul class=\"nav nav-tabs\">
            <li class=\"active\"><a href=\"#tab-stripe\" data-toggle=\"tab\"><i class=\"fa fa-cc-stripe\"></i> Stripe (Test &amp; Live API)</a></li>
            <li><a href=\"#tab-braintree\" data-toggle=\"tab\"><i class=\"fa fa-credit-card-alt\"></i> Braintree (Sandbox &amp; Production API)</a></li>
            <li><a href=\"#tab-paypal\" data-toggle=\"tab\"><i class=\"fa fa-paypal\"></i> PayPal REST API (Sandbox &amp; Live)</a></li>
            <li><a href=\"#tab-general\" data-toggle=\"tab\"><i class=\"fa fa-cog\"></i> General Routing</a></li>
          </ul>
          <div class=\"tab-content\">
            <!-- STRIPE TAB -->
            <div class=\"tab-pane active\" id=\"tab-stripe\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-stripe-status\">Stripe Status</label>
                <div class=\"col-sm-10\">
                  <select name=\"payment_stripe_status\" id=\"input-stripe-status\" class=\"form-control\">
                    ";
        // line 48
        if (($context["payment_stripe_status"] ?? null)) {
            // line 49
            echo "                    <option value=\"1\" selected=\"selected\">Enabled</option>
                    <option value=\"0\">Disabled</option>
                    ";
        } else {
            // line 52
            echo "                    <option value=\"1\">Enabled</option>
                    <option value=\"0\" selected=\"selected\">Disabled</option>
                    ";
        }
        // line 55
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-stripe-environment\"><span data-toggle=\"tooltip\" title=\"Select Test Mode (pk_test_ / sk_test_) or Live Mode (pk_live_ / sk_live_)\">API Mode</span></label>
                <div class=\"col-sm-10\">
                  <select name=\"payment_stripe_environment\" id=\"input-stripe-environment\" class=\"form-control\">
                    ";
        // line 62
        if ((0 === twig_compare(($context["payment_stripe_environment"] ?? null), "live"))) {
            // line 63
            echo "                    <option value=\"test\">Test Mode (Sandbox)</option>
                    <option value=\"live\" selected=\"selected\">Live Mode (Production)</option>
                    ";
        } else {
            // line 66
            echo "                    <option value=\"test\" selected=\"selected\">Test Mode (Sandbox)</option>
                    <option value=\"live\">Live Mode (Production)</option>
                    ";
        }
        // line 69
        echo "                  </select>
                </div>
              </div>

              <fieldset>
                <legend><span class=\"label label-warning\">TEST MODE</span> Stripe Test API Keys (<code>https://api.stripe.com/v1</code>)</legend>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-stripe-test-pk\">Test Publishable Key</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_stripe_test_publishable_key\" value=\"";
        // line 78
        echo ($context["payment_stripe_test_publishable_key"] ?? null);
        echo "\" placeholder=\"pk_test_...\" id=\"input-stripe-test-pk\" class=\"form-control\" />
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-stripe-test-sk\">Test Secret Key</label>
                  <div class=\"col-sm-10\">
                    <div class=\"input-group\">
                      <input type=\"password\" name=\"payment_stripe_test_secret_key\" value=\"";
        // line 85
        echo ($context["payment_stripe_test_secret_key"] ?? null);
        echo "\" placeholder=\"sk_test_...\" id=\"input-stripe-test-sk\" class=\"form-control\" />
                      <span class=\"input-group-btn\">
                        <button type=\"button\" class=\"btn btn-warning btn-test-stripe\" data-env=\"test\" data-target=\"#input-stripe-test-sk\"><i class=\"fa fa-plug\"></i> Test Stripe (Test Mode)</button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-stripe-test-wh\">Test Webhook Secret</label>
                  <div class=\"col-sm-10\">
                    <input type=\"password\" name=\"payment_stripe_test_webhook_secret\" value=\"";
        // line 95
        echo ($context["payment_stripe_test_webhook_secret"] ?? null);
        echo "\" placeholder=\"whsec_...\" id=\"input-stripe-test-wh\" class=\"form-control\" />
                  </div>
                </div>
              </fieldset>

              <fieldset>
                <legend><span class=\"label label-success\">LIVE MODE</span> Stripe Live API Keys (<code>https://api.stripe.com/v1</code>)</legend>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-stripe-live-pk\">Live Publishable Key</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_stripe_live_publishable_key\" value=\"";
        // line 105
        echo ($context["payment_stripe_live_publishable_key"] ?? null);
        echo "\" placeholder=\"pk_live_...\" id=\"input-stripe-live-pk\" class=\"form-control\" />
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-stripe-live-sk\">Live Secret Key</label>
                  <div class=\"col-sm-10\">
                    <div class=\"input-group\">
                      <input type=\"password\" name=\"payment_stripe_live_secret_key\" value=\"";
        // line 112
        echo ($context["payment_stripe_live_secret_key"] ?? null);
        echo "\" placeholder=\"sk_live_...\" id=\"input-stripe-live-sk\" class=\"form-control\" />
                      <span class=\"input-group-btn\">
                        <button type=\"button\" class=\"btn btn-success btn-test-stripe\" data-env=\"live\" data-target=\"#input-stripe-live-sk\"><i class=\"fa fa-plug\"></i> Test Stripe (Live Mode)</button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-stripe-live-wh\">Live Webhook Secret</label>
                  <div class=\"col-sm-10\">
                    <input type=\"password\" name=\"payment_stripe_live_webhook_secret\" value=\"";
        // line 122
        echo ($context["payment_stripe_live_webhook_secret"] ?? null);
        echo "\" placeholder=\"whsec_...\" id=\"input-stripe-live-wh\" class=\"form-control\" />
                  </div>
                </div>
              </fieldset>

              <fieldset>
                <legend>Stripe Payment Options</legend>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-stripe-currency\">Currency</label>
                  <div class=\"col-sm-10\">
                    <select name=\"payment_stripe_currency\" id=\"input-stripe-currency\" class=\"form-control\">
                      ";
        // line 133
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["currencies"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["currency"]) {
            // line 134
            echo "                      <option value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 134);
            echo "\"";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 134), ($context["payment_stripe_currency"] ?? null)))) {
                echo " selected=\"selected\"";
            }
            echo ">";
            echo twig_get_attribute($this->env, $this->source, $context["currency"], "title", [], "any", false, false, false, 134);
            echo " (";
            echo twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 134);
            echo ")</option>
                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['currency'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 136
        echo "                    </select>
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-stripe-capture\">Capture Method</label>
                  <div class=\"col-sm-10\">
                    <select name=\"payment_stripe_capture_method\" id=\"input-stripe-capture\" class=\"form-control\">
                      ";
        // line 143
        if ((0 === twig_compare(($context["payment_stripe_capture_method"] ?? null), "manual"))) {
            // line 144
            echo "                      <option value=\"automatic\">Automatic (Immediate Charge)</option>
                      <option value=\"manual\" selected=\"selected\">Manual (Authorize Only)</option>
                      ";
        } else {
            // line 147
            echo "                      <option value=\"automatic\" selected=\"selected\">Automatic (Immediate Charge)</option>
                      <option value=\"manual\">Manual (Authorize Only)</option>
                      ";
        }
        // line 150
        echo "                    </select>
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-stripe-3ds\">3D Secure (SCA)</label>
                  <div class=\"col-sm-10\">
                    <select name=\"payment_stripe_three_d_secure\" id=\"input-stripe-3ds\" class=\"form-control\">
                      ";
        // line 157
        if (($context["payment_stripe_three_d_secure"] ?? null)) {
            // line 158
            echo "                      <option value=\"1\" selected=\"selected\">Enabled</option>
                      <option value=\"0\">Disabled</option>
                      ";
        } else {
            // line 161
            echo "                      <option value=\"1\">Enabled</option>
                      <option value=\"0\" selected=\"selected\">Disabled</option>
                      ";
        }
        // line 164
        echo "                    </select>
                  </div>
                </div>
              </fieldset>
            </div>

            <!-- BRAINTREE TAB -->
            <div class=\"tab-pane\" id=\"tab-braintree\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-bt-status\">Braintree Status</label>
                <div class=\"col-sm-10\">
                  <select name=\"payment_braintree_status\" id=\"input-bt-status\" class=\"form-control\">
                    ";
        // line 176
        if (($context["payment_braintree_status"] ?? null)) {
            // line 177
            echo "                    <option value=\"1\" selected=\"selected\">Enabled</option>
                    <option value=\"0\">Disabled</option>
                    ";
        } else {
            // line 180
            echo "                    <option value=\"1\">Enabled</option>
                    <option value=\"0\" selected=\"selected\">Disabled</option>
                    ";
        }
        // line 183
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-bt-environment\">Environment (Mode)</label>
                <div class=\"col-sm-10\">
                  <select name=\"payment_braintree_environment\" id=\"input-bt-environment\" class=\"form-control\">
                    ";
        // line 190
        if ((0 === twig_compare(($context["payment_braintree_environment"] ?? null), "production"))) {
            // line 191
            echo "                    <option value=\"sandbox\">Test Mode (Sandbox)</option>
                    <option value=\"production\" selected=\"selected\">Live Mode (Production)</option>
                    ";
        } else {
            // line 194
            echo "                    <option value=\"sandbox\" selected=\"selected\">Test Mode (Sandbox)</option>
                    <option value=\"production\">Live Mode (Production)</option>
                    ";
        }
        // line 197
        echo "                  </select>
                </div>
              </div>

              <fieldset>
                <legend><span class=\"label label-warning\">TEST MODE (SANDBOX)</span> Braintree Sandbox API Keys (<code>https://payments.sandbox.braintree-api.com/graphql</code>)</legend>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-bt-sb-mid\">Sandbox Merchant ID</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_braintree_sandbox_merchant_id\" value=\"";
        // line 206
        echo ($context["payment_braintree_sandbox_merchant_id"] ?? null);
        echo "\" placeholder=\"Sandbox Merchant ID\" id=\"input-bt-sb-mid\" class=\"form-control\" />
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-bt-sb-pub\">Sandbox Public Key</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_braintree_sandbox_public_key\" value=\"";
        // line 212
        echo ($context["payment_braintree_sandbox_public_key"] ?? null);
        echo "\" placeholder=\"Sandbox Public Key\" id=\"input-bt-sb-pub\" class=\"form-control\" />
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-bt-sb-priv\">Sandbox Private Key</label>
                  <div class=\"col-sm-10\">
                    <div class=\"input-group\">
                      <input type=\"password\" name=\"payment_braintree_sandbox_private_key\" value=\"";
        // line 219
        echo ($context["payment_braintree_sandbox_private_key"] ?? null);
        echo "\" placeholder=\"Sandbox Private Key\" id=\"input-bt-sb-priv\" class=\"form-control\" />
                      <span class=\"input-group-btn\">
                        <button type=\"button\" class=\"btn btn-warning btn-test-braintree\" data-env=\"sandbox\" data-mid=\"#input-bt-sb-mid\" data-pub=\"#input-bt-sb-pub\" data-priv=\"#input-bt-sb-priv\"><i class=\"fa fa-plug\"></i> Test Braintree (Sandbox)</button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-bt-sb-maid\">Sandbox Merchant Account ID</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_braintree_sandbox_merchant_account_id\" value=\"";
        // line 229
        echo ($context["payment_braintree_sandbox_merchant_account_id"] ?? null);
        echo "\" placeholder=\"Optional default Merchant Account ID\" id=\"input-bt-sb-maid\" class=\"form-control\" />
                  </div>
                </div>
              </fieldset>

              <fieldset>
                <legend><span class=\"label label-success\">LIVE MODE (PRODUCTION)</span> Braintree Production API Keys (<code>https://payments.braintree-api.com/graphql</code>)</legend>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-bt-prod-mid\">Production Merchant ID</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_braintree_production_merchant_id\" value=\"";
        // line 239
        echo ($context["payment_braintree_production_merchant_id"] ?? null);
        echo "\" placeholder=\"Production Merchant ID\" id=\"input-bt-prod-mid\" class=\"form-control\" />
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-bt-prod-pub\">Production Public Key</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_braintree_production_public_key\" value=\"";
        // line 245
        echo ($context["payment_braintree_production_public_key"] ?? null);
        echo "\" placeholder=\"Production Public Key\" id=\"input-bt-prod-pub\" class=\"form-control\" />
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-bt-prod-priv\">Production Private Key</label>
                  <div class=\"col-sm-10\">
                    <div class=\"input-group\">
                      <input type=\"password\" name=\"payment_braintree_production_private_key\" value=\"";
        // line 252
        echo ($context["payment_braintree_production_private_key"] ?? null);
        echo "\" placeholder=\"Production Private Key\" id=\"input-bt-prod-priv\" class=\"form-control\" />
                      <span class=\"input-group-btn\">
                        <button type=\"button\" class=\"btn btn-success btn-test-braintree\" data-env=\"production\" data-mid=\"#input-bt-prod-mid\" data-pub=\"#input-bt-prod-pub\" data-priv=\"#input-bt-prod-priv\"><i class=\"fa fa-plug\"></i> Test Braintree (Live)</button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-bt-prod-maid\">Production Merchant Account ID</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_braintree_production_merchant_account_id\" value=\"";
        // line 262
        echo ($context["payment_braintree_production_merchant_account_id"] ?? null);
        echo "\" placeholder=\"Optional default Merchant Account ID\" id=\"input-bt-prod-maid\" class=\"form-control\" />
                  </div>
                </div>
              </fieldset>

              <fieldset>
                <legend>Braintree Options</legend>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-bt-3ds\">3D Secure 2.0</label>
                  <div class=\"col-sm-10\">
                    <select name=\"payment_braintree_three_d_secure\" id=\"input-bt-3ds\" class=\"form-control\">
                      ";
        // line 273
        if (($context["payment_braintree_three_d_secure"] ?? null)) {
            // line 274
            echo "                      <option value=\"1\" selected=\"selected\">Enabled</option>
                      <option value=\"0\">Disabled</option>
                      ";
        } else {
            // line 277
            echo "                      <option value=\"1\">Enabled</option>
                      <option value=\"0\" selected=\"selected\">Disabled</option>
                      ";
        }
        // line 280
        echo "                    </select>
                  </div>
                </div>
              </fieldset>
            </div>

            <!-- PAYPAL TAB -->
            <div class=\"tab-pane\" id=\"tab-paypal\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-pp-status\">PayPal Status</label>
                <div class=\"col-sm-10\">
                  <select name=\"payment_paypal_status\" id=\"input-pp-status\" class=\"form-control\">
                    ";
        // line 292
        if (($context["payment_paypal_status"] ?? null)) {
            // line 293
            echo "                    <option value=\"1\" selected=\"selected\">Enabled</option>
                    <option value=\"0\">Disabled</option>
                    ";
        } else {
            // line 296
            echo "                    <option value=\"1\">Enabled</option>
                    <option value=\"0\" selected=\"selected\">Disabled</option>
                    ";
        }
        // line 299
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-pp-environment\">Environment (Mode)</label>
                <div class=\"col-sm-10\">
                  <select name=\"payment_paypal_environment\" id=\"input-pp-environment\" class=\"form-control\">
                    ";
        // line 306
        if ((0 === twig_compare(($context["payment_paypal_environment"] ?? null), "live"))) {
            // line 307
            echo "                    <option value=\"sandbox\">Test Mode (Sandbox)</option>
                    <option value=\"live\" selected=\"selected\">Live Mode (Production)</option>
                    ";
        } else {
            // line 310
            echo "                    <option value=\"sandbox\" selected=\"selected\">Test Mode (Sandbox)</option>
                    <option value=\"live\">Live Mode (Production)</option>
                    ";
        }
        // line 313
        echo "                  </select>
                </div>
              </div>

              <fieldset>
                <legend><span class=\"label label-warning\">TEST MODE (SANDBOX)</span> PayPal Sandbox REST API Credentials (<code>https://api-m.sandbox.paypal.com</code>)</legend>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-pp-sb-cid\">Sandbox Client ID</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_paypal_sandbox_client_id\" value=\"";
        // line 322
        echo ($context["payment_paypal_sandbox_client_id"] ?? null);
        echo "\" placeholder=\"PayPal Sandbox Client ID\" id=\"input-pp-sb-cid\" class=\"form-control\" />
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-pp-sb-sec\">Sandbox Secret</label>
                  <div class=\"col-sm-10\">
                    <div class=\"input-group\">
                      <input type=\"password\" name=\"payment_paypal_sandbox_secret\" value=\"";
        // line 329
        echo ($context["payment_paypal_sandbox_secret"] ?? null);
        echo "\" placeholder=\"PayPal Sandbox Secret\" id=\"input-pp-sb-sec\" class=\"form-control\" />
                      <span class=\"input-group-btn\">
                        <button type=\"button\" class=\"btn btn-warning btn-test-paypal\" data-env=\"sandbox\" data-cid=\"#input-pp-sb-cid\" data-sec=\"#input-pp-sb-sec\"><i class=\"fa fa-plug\"></i> Test PayPal (Sandbox)</button>
                      </span>
                    </div>
                  </div>
                </div>
              </fieldset>

              <fieldset>
                <legend><span class=\"label label-success\">LIVE MODE (PRODUCTION)</span> PayPal Live REST API Credentials (<code>https://api-m.paypal.com</code>)</legend>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-pp-live-cid\">Live Client ID</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"payment_paypal_live_client_id\" value=\"";
        // line 343
        echo ($context["payment_paypal_live_client_id"] ?? null);
        echo "\" placeholder=\"PayPal Live Client ID\" id=\"input-pp-live-cid\" class=\"form-control\" />
                  </div>
                </div>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-pp-live-sec\">Live Secret</label>
                  <div class=\"col-sm-10\">
                    <div class=\"input-group\">
                      <input type=\"password\" name=\"payment_paypal_live_secret\" value=\"";
        // line 350
        echo ($context["payment_paypal_live_secret"] ?? null);
        echo "\" placeholder=\"PayPal Live Secret\" id=\"input-pp-live-sec\" class=\"form-control\" />
                      <span class=\"input-group-btn\">
                        <button type=\"button\" class=\"btn btn-success btn-test-paypal\" data-env=\"live\" data-cid=\"#input-pp-live-cid\" data-sec=\"#input-pp-live-sec\"><i class=\"fa fa-plug\"></i> Test PayPal (Live)</button>
                      </span>
                    </div>
                  </div>
                </div>
              </fieldset>

              <fieldset>
                <legend>PayPal Options</legend>
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-pp-currency\">Currency</label>
                  <div class=\"col-sm-10\">
                    <select name=\"payment_paypal_currency\" id=\"input-pp-currency\" class=\"form-control\">
                      ";
        // line 365
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["currencies"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["currency"]) {
            // line 366
            echo "                      <option value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 366);
            echo "\"";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 366), ($context["payment_paypal_currency"] ?? null)))) {
                echo " selected=\"selected\"";
            }
            echo ">";
            echo twig_get_attribute($this->env, $this->source, $context["currency"], "title", [], "any", false, false, false, 366);
            echo " (";
            echo twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 366);
            echo ")</option>
                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['currency'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 368
        echo "                    </select>
                  </div>
                </div>
              </fieldset>
            </div>

            <!-- GENERAL ROUTING TAB -->
            <div class=\"tab-pane\" id=\"tab-general\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-card-gateway\">Default Credit Card Gateway</label>
                <div class=\"col-sm-10\">
                  <select name=\"payment_card_gateway\" id=\"input-card-gateway\" class=\"form-control\">
                    ";
        // line 380
        if ((0 === twig_compare(($context["payment_card_gateway"] ?? null), "braintree"))) {
            // line 381
            echo "                    <option value=\"stripe\">Stripe (Elements &amp; PaymentIntents API)</option>
                    <option value=\"braintree\" selected=\"selected\">Braintree (Hosted Fields &amp; GraphQL API)</option>
                    ";
        } else {
            // line 384
            echo "                    <option value=\"stripe\" selected=\"selected\">Stripe (Elements &amp; PaymentIntents API)</option>
                    <option value=\"braintree\">Braintree (Hosted Fields &amp; GraphQL API)</option>
                    ";
        }
        // line 387
        echo "                  </select>
                  <span class=\"help-block\">Determines the default gateway used on <code>index.php?route=account/payment/card</code>. Note: Users can also select Stripe, Braintree, or PayPal directly on the Payment Methods and Checkout screens.</span>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type=\"text/javascript\"><!--
\$('.btn-test-stripe').on('click', function() {
    var btn = \$(this);
    var env = btn.data('env');
    var sk = \$(btn.data('target')).val();

    \$.ajax({
        url: 'index.php?route=setting/payment/testStripe&user_token=";
        // line 405
        echo ($context["user_token"] ?? null);
        echo "',
        type: 'post',
        dataType: 'json',
        data: { environment: env, secret_key: sk },
        beforeSend: function() {
            btn.button('loading');
        },
        complete: function() {
            btn.button('reset');
        },
        success: function(json) {
            \$('#api-test-alert').empty();
            if (json.error) {
                \$('#api-test-alert').html('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ' + json.error + '<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }
            if (json.success) {
                \$('#api-test-alert').html('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa fa-check-circle\"></i> ' + json.success + '<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }
        }
    });
});

\$('.btn-test-braintree').on('click', function() {
    var btn = \$(this);
    var env = btn.data('env');
    var mid = \$(btn.data('mid')).val();
    var pub = \$(btn.data('pub')).val();
    var priv = \$(btn.data('priv')).val();

    \$.ajax({
        url: 'index.php?route=setting/payment/testBraintree&user_token=";
        // line 435
        echo ($context["user_token"] ?? null);
        echo "',
        type: 'post',
        dataType: 'json',
        data: { environment: env, merchant_id: mid, public_key: pub, private_key: priv },
        beforeSend: function() {
            btn.button('loading');
        },
        complete: function() {
            btn.button('reset');
        },
        success: function(json) {
            \$('#api-test-alert').empty();
            if (json.error) {
                \$('#api-test-alert').html('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ' + json.error + '<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }
            if (json.success) {
                \$('#api-test-alert').html('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa fa-check-circle\"></i> ' + json.success + '<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }
        }
    });
});

\$('.btn-test-paypal').on('click', function() {
    var btn = \$(this);
    var env = btn.data('env');
    var cid = \$(btn.data('cid')).val();
    var sec = \$(btn.data('sec')).val();

    \$.ajax({
        url: 'index.php?route=setting/payment/testPaypal&user_token=";
        // line 464
        echo ($context["user_token"] ?? null);
        echo "',
        type: 'post',
        dataType: 'json',
        data: { environment: env, client_id: cid, secret: sec },
        beforeSend: function() {
            btn.button('loading');
        },
        complete: function() {
            btn.button('reset');
        },
        success: function(json) {
            \$('#api-test-alert').empty();
            if (json.error) {
                \$('#api-test-alert').html('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ' + json.error + '<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }
            if (json.success) {
                \$('#api-test-alert').html('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa fa-check-circle\"></i> ' + json.success + '<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }
        }
    });
});
//--></script>
";
        // line 486
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "setting/payment.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  743 => 486,  718 => 464,  686 => 435,  653 => 405,  633 => 387,  628 => 384,  623 => 381,  621 => 380,  607 => 368,  590 => 366,  586 => 365,  568 => 350,  558 => 343,  541 => 329,  531 => 322,  520 => 313,  515 => 310,  510 => 307,  508 => 306,  499 => 299,  494 => 296,  489 => 293,  487 => 292,  473 => 280,  468 => 277,  463 => 274,  461 => 273,  447 => 262,  434 => 252,  424 => 245,  415 => 239,  402 => 229,  389 => 219,  379 => 212,  370 => 206,  359 => 197,  354 => 194,  349 => 191,  347 => 190,  338 => 183,  333 => 180,  328 => 177,  326 => 176,  312 => 164,  307 => 161,  302 => 158,  300 => 157,  291 => 150,  286 => 147,  281 => 144,  279 => 143,  270 => 136,  253 => 134,  249 => 133,  235 => 122,  222 => 112,  212 => 105,  199 => 95,  186 => 85,  176 => 78,  165 => 69,  160 => 66,  155 => 63,  153 => 62,  144 => 55,  139 => 52,  134 => 49,  132 => 48,  115 => 34,  109 => 31,  104 => 28,  96 => 24,  93 => 23,  85 => 19,  83 => 18,  77 => 14,  66 => 12,  62 => 11,  57 => 9,  50 => 7,  46 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "setting/payment.twig", "");
    }
}
