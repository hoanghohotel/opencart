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

/* setting/setting.twig */
class __TwigTemplate_02d255900a45d4a3f6cf48c53956f010f08f26051d0e088fca9d90c0f1f9a850 extends Template
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
        <button type=\"submit\" form=\"form-setting\" data-toggle=\"tooltip\" title=\"";
        // line 6
        echo ($context["button_save"] ?? null);
        echo "\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i></button>
        <a href=\"";
        // line 7
        echo ($context["cancel"] ?? null);
        echo "\" data-toggle=\"tooltip\" title=\"";
        echo ($context["button_cancel"] ?? null);
        echo "\" class=\"btn btn-default\"><i class=\"fa fa-reply\"></i></a></div>
      <h1>";
        // line 8
        echo ($context["heading_title"] ?? null);
        echo "</h1>
      <ul class=\"breadcrumb\">
        ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 11
            echo "        <li><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 11);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 11);
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "      </ul>
    </div>
  </div>
  <div class=\"container-fluid\">
    ";
        // line 17
        if (($context["error_warning"] ?? null)) {
            // line 18
            echo "    <div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ";
            echo ($context["error_warning"] ?? null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
    ";
        }
        // line 22
        echo "    ";
        if (($context["success"] ?? null)) {
            // line 23
            echo "    <div class=\"alert alert-success alert-dismissible\"><i class=\"fa fa-check-circle\"></i> ";
            echo ($context["success"] ?? null);
            echo "
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    </div>
    ";
        }
        // line 27
        echo "    <div class=\"panel panel-default\">
      <div class=\"panel-heading\">
        <h3 class=\"panel-title\"><i class=\"fa fa-pencil\"></i> ";
        // line 29
        echo ($context["text_edit"] ?? null);
        echo "</h3>
      </div>
      <div class=\"panel-body\">
        <form action=\"";
        // line 32
        echo ($context["action"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-setting\" class=\"form-horizontal\">
          <ul class=\"nav nav-tabs\">
            <li class=\"active\"><a href=\"#tab-general\" data-toggle=\"tab\">";
        // line 34
        echo ($context["tab_general"] ?? null);
        echo "</a></li>
            <li><a href=\"#tab-store\" data-toggle=\"tab\">";
        // line 35
        echo ($context["tab_store"] ?? null);
        echo "</a></li>
            <li><a href=\"#tab-local\" data-toggle=\"tab\">";
        // line 36
        echo ($context["tab_local"] ?? null);
        echo "</a></li>
            <li><a href=\"#tab-option\" data-toggle=\"tab\">";
        // line 37
        echo ($context["tab_option"] ?? null);
        echo "</a></li>
            <li><a href=\"#tab-image\" data-toggle=\"tab\">";
        // line 38
        echo ($context["tab_image"] ?? null);
        echo "</a></li>
            <li><a href=\"#tab-mail\" data-toggle=\"tab\">";
        // line 39
        echo ($context["tab_mail"] ?? null);
        echo "</a></li>
            <li><a href=\"#tab-server\" data-toggle=\"tab\">";
        // line 40
        echo ($context["tab_server"] ?? null);
        echo "</a></li>
          </ul>
          <div class=\"tab-content\">
            <!-- General / Meta -->
            <div class=\"tab-pane active\" id=\"tab-general\">
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-meta-title\">";
        // line 46
        echo ($context["entry_meta_title"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_meta_title\" value=\"";
        // line 48
        echo ($context["config_meta_title"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_meta_title"] ?? null);
        echo "\" id=\"input-meta-title\" class=\"form-control\" />
                  ";
        // line 49
        if (($context["error_meta_title"] ?? null)) {
            // line 50
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_meta_title"] ?? null);
            echo "</div>
                  ";
        }
        // line 52
        echo "                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-meta-description\">";
        // line 55
        echo ($context["entry_meta_description"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <textarea name=\"config_meta_description\" rows=\"4\" placeholder=\"";
        // line 57
        echo ($context["entry_meta_description"] ?? null);
        echo "\" id=\"input-meta-description\" class=\"form-control\">";
        echo ($context["config_meta_description"] ?? null);
        echo "</textarea>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-meta-keyword\">";
        // line 61
        echo ($context["entry_meta_keyword"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <textarea name=\"config_meta_keyword\" rows=\"3\" placeholder=\"";
        // line 63
        echo ($context["entry_meta_keyword"] ?? null);
        echo "\" id=\"input-meta-keyword\" class=\"form-control\">";
        echo ($context["config_meta_keyword"] ?? null);
        echo "</textarea>
                </div>
              </div>
            </div>

            <!-- Store & Contact Details -->
            <div class=\"tab-pane\" id=\"tab-store\">
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-name\">";
        // line 71
        echo ($context["entry_name"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_name\" value=\"";
        // line 73
        echo ($context["config_name"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_name"] ?? null);
        echo "\" id=\"input-name\" class=\"form-control\" />
                  ";
        // line 74
        if (($context["error_name"] ?? null)) {
            // line 75
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_name"] ?? null);
            echo "</div>
                  ";
        }
        // line 77
        echo "                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-owner\">";
        // line 80
        echo ($context["entry_owner"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_owner\" value=\"";
        // line 82
        echo ($context["config_owner"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_owner"] ?? null);
        echo "\" id=\"input-owner\" class=\"form-control\" />
                  ";
        // line 83
        if (($context["error_owner"] ?? null)) {
            // line 84
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_owner"] ?? null);
            echo "</div>
                  ";
        }
        // line 86
        echo "                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-address\">";
        // line 89
        echo ($context["entry_address"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <textarea name=\"config_address\" placeholder=\"";
        // line 91
        echo ($context["entry_address"] ?? null);
        echo "\" rows=\"4\" id=\"input-address\" class=\"form-control\">";
        echo ($context["config_address"] ?? null);
        echo "</textarea>
                  ";
        // line 92
        if (($context["error_address"] ?? null)) {
            // line 93
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_address"] ?? null);
            echo "</div>
                  ";
        }
        // line 95
        echo "                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-email\">";
        // line 98
        echo ($context["entry_email"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_email\" value=\"";
        // line 100
        echo ($context["config_email"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_email"] ?? null);
        echo "\" id=\"input-email\" class=\"form-control\" />
                  ";
        // line 101
        if (($context["error_email"] ?? null)) {
            // line 102
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_email"] ?? null);
            echo "</div>
                  ";
        }
        // line 104
        echo "                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-telephone\">";
        // line 107
        echo ($context["entry_telephone"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_telephone\" value=\"";
        // line 109
        echo ($context["config_telephone"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_telephone"] ?? null);
        echo "\" id=\"input-telephone\" class=\"form-control\" />
                  ";
        // line 110
        if (($context["error_telephone"] ?? null)) {
            // line 111
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_telephone"] ?? null);
            echo "</div>
                  ";
        }
        // line 113
        echo "                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-contact-support\">";
        // line 116
        echo ($context["entry_contact_support"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_contact_support\" value=\"";
        // line 118
        echo ($context["config_contact_support"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_contact_support"] ?? null);
        echo "\" id=\"input-contact-support\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-contact-partner\">";
        // line 122
        echo ($context["entry_contact_partner"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_contact_partner\" value=\"";
        // line 124
        echo ($context["config_contact_partner"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_contact_partner"] ?? null);
        echo "\" id=\"input-contact-partner\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-contact-marketing\">";
        // line 128
        echo ($context["entry_contact_marketing"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_contact_marketing\" value=\"";
        // line 130
        echo ($context["config_contact_marketing"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_contact_marketing"] ?? null);
        echo "\" id=\"input-contact-marketing\" class=\"form-control\" />
                </div>
              </div>
            </div>

            <!-- Localisation -->
            <div class=\"tab-pane\" id=\"tab-local\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-country\">";
        // line 138
        echo ($context["entry_country"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_country_id\" id=\"input-country\" class=\"form-control\">
                    ";
        // line 141
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["countries"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 142
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 142), ($context["config_country_id"] ?? null)))) {
                // line 143
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 143);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 143);
                echo "</option>
                    ";
            } else {
                // line 145
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 145);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 145);
                echo "</option>
                    ";
            }
            // line 147
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 148
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-zone\">";
        // line 152
        echo ($context["entry_zone"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_zone_id\" id=\"input-zone\" class=\"form-control\"></select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-language\">";
        // line 158
        echo ($context["entry_language"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_language\" id=\"input-language\" class=\"form-control\">
                    ";
        // line 161
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 162
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 162), ($context["config_language"] ?? null)))) {
                // line 163
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 163);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 163);
                echo "</option>
                    ";
            } else {
                // line 165
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 165);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 165);
                echo "</option>
                    ";
            }
            // line 167
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 168
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-admin-language\">";
        // line 172
        echo ($context["entry_admin_language"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_admin_language\" id=\"input-admin-language\" class=\"form-control\">
                    ";
        // line 175
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 176
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 176), ($context["config_admin_language"] ?? null)))) {
                // line 177
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 177);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 177);
                echo "</option>
                    ";
            } else {
                // line 179
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 179);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 179);
                echo "</option>
                    ";
            }
            // line 181
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 182
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-currency\">";
        // line 186
        echo ($context["entry_currency"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_currency\" id=\"input-currency\" class=\"form-control\">
                    ";
        // line 189
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["currencies"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["currency"]) {
            // line 190
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 190), ($context["config_currency"] ?? null)))) {
                // line 191
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 191);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["currency"], "title", [], "any", false, false, false, 191);
                echo "</option>
                    ";
            } else {
                // line 193
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 193);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["currency"], "title", [], "any", false, false, false, 193);
                echo "</option>
                    ";
            }
            // line 195
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['currency'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 196
        echo "                  </select>
                </div>
              </div>
            </div>

            <!-- Option -->
            <div class=\"tab-pane\" id=\"tab-option\">
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-limit-admin\"><span data-toggle=\"tooltip\" title=\"";
        // line 204
        echo ($context["help_limit_admin"] ?? null);
        echo "\">";
        echo ($context["entry_limit_admin"] ?? null);
        echo "</span></label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_limit_admin\" value=\"";
        // line 206
        echo ($context["config_limit_admin"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_limit_admin"] ?? null);
        echo "\" id=\"input-limit-admin\" class=\"form-control\" />
                  ";
        // line 207
        if (($context["error_limit_admin"] ?? null)) {
            // line 208
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_limit_admin"] ?? null);
            echo "</div>
                  ";
        }
        // line 210
        echo "                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-order-status\"><span data-toggle=\"tooltip\" title=\"";
        // line 213
        echo ($context["help_order_status"] ?? null);
        echo "\">";
        echo ($context["entry_order_status"] ?? null);
        echo "</span></label>
                <div class=\"col-sm-10\">
                  <select name=\"config_order_status_id\" id=\"input-order-status\" class=\"form-control\">
                    ";
        // line 216
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["order_statuses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["order_status"]) {
            // line 217
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 217), ($context["config_order_status_id"] ?? null)))) {
                // line 218
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 218);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 218);
                echo "</option>
                    ";
            } else {
                // line 220
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 220);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 220);
                echo "</option>
                    ";
            }
            // line 222
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order_status'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 223
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-download-status\"><span data-toggle=\"tooltip\" title=\"";
        // line 227
        echo ($context["help_download_status"] ?? null);
        echo "\">";
        echo ($context["entry_download_status"] ?? null);
        echo "</span></label>
                <div class=\"col-sm-10\">
                  <select name=\"config_download_status_id\" id=\"input-download-status\" class=\"form-control\">
                    ";
        // line 230
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["order_statuses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["order_status"]) {
            // line 231
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 231), ($context["config_download_status_id"] ?? null)))) {
                // line 232
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 232);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 232);
                echo "</option>
                    ";
            } else {
                // line 234
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 234);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 234);
                echo "</option>
                    ";
            }
            // line 236
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order_status'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 237
        echo "                  </select>
                </div>
              </div>
            </div>

            <!-- Image -->
            <div class=\"tab-pane\" id=\"tab-image\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-logo\">";
        // line 245
        echo ($context["entry_logo"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\"><a href=\"\" id=\"thumb-logo\" data-toggle=\"image\" class=\"img-thumbnail\"><img src=\"";
        // line 246
        echo ($context["logo"] ?? null);
        echo "\" alt=\"\" title=\"\" data-placeholder=\"";
        echo ($context["placeholder"] ?? null);
        echo "\" /></a>
                  <input type=\"hidden\" name=\"config_logo\" value=\"";
        // line 247
        echo ($context["config_logo"] ?? null);
        echo "\" id=\"input-logo\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-icon\">";
        // line 251
        echo ($context["entry_icon"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\"><a href=\"\" id=\"thumb-icon\" data-toggle=\"image\" class=\"img-thumbnail\"><img src=\"";
        // line 252
        echo ($context["icon"] ?? null);
        echo "\" alt=\"\" title=\"\" data-placeholder=\"";
        echo ($context["placeholder"] ?? null);
        echo "\" /></a>
                  <input type=\"hidden\" name=\"config_icon\" value=\"";
        // line 253
        echo ($context["config_icon"] ?? null);
        echo "\" id=\"input-icon\" />
                </div>
              </div>
            </div>

            <!-- Mail -->
            <div class=\"tab-pane\" id=\"tab-mail\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-engine\">";
        // line 261
        echo ($context["entry_mail_engine"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_mail_engine\" id=\"input-mail-engine\" class=\"form-control\">
                    ";
        // line 264
        if ((0 === twig_compare(($context["config_mail_engine"] ?? null), "mail"))) {
            // line 265
            echo "                    <option value=\"mail\" selected=\"selected\">";
            echo ($context["text_mail"] ?? null);
            echo "</option>
                    ";
        } else {
            // line 267
            echo "                    <option value=\"mail\">";
            echo ($context["text_mail"] ?? null);
            echo "</option>
                    ";
        }
        // line 269
        echo "                    ";
        if ((0 === twig_compare(($context["config_mail_engine"] ?? null), "smtp"))) {
            // line 270
            echo "                    <option value=\"smtp\" selected=\"selected\">";
            echo ($context["text_smtp"] ?? null);
            echo "</option>
                    ";
        } else {
            // line 272
            echo "                    <option value=\"smtp\">";
            echo ($context["text_smtp"] ?? null);
            echo "</option>
                    ";
        }
        // line 274
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-parameter\">";
        // line 278
        echo ($context["entry_mail_parameter"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_parameter\" value=\"";
        // line 280
        echo ($context["config_mail_parameter"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_parameter"] ?? null);
        echo "\" id=\"input-mail-parameter\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-hostname\">";
        // line 284
        echo ($context["entry_mail_smtp_hostname"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_hostname\" value=\"";
        // line 286
        echo ($context["config_mail_smtp_hostname"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_hostname"] ?? null);
        echo "\" id=\"input-mail-smtp-hostname\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-username\">";
        // line 290
        echo ($context["entry_mail_smtp_username"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_username\" value=\"";
        // line 292
        echo ($context["config_mail_smtp_username"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_username"] ?? null);
        echo "\" id=\"input-mail-smtp-username\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-password\">";
        // line 296
        echo ($context["entry_mail_smtp_password"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_password\" value=\"";
        // line 298
        echo ($context["config_mail_smtp_password"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_password"] ?? null);
        echo "\" id=\"input-mail-smtp-password\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-port\">";
        // line 302
        echo ($context["entry_mail_smtp_port"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_port\" value=\"";
        // line 304
        echo ($context["config_mail_smtp_port"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_port"] ?? null);
        echo "\" id=\"input-mail-smtp-port\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-timeout\">";
        // line 308
        echo ($context["entry_mail_smtp_timeout"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_timeout\" value=\"";
        // line 310
        echo ($context["config_mail_smtp_timeout"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_timeout"] ?? null);
        echo "\" id=\"input-mail-smtp-timeout\" class=\"form-control\" />
                </div>
              </div>
              <hr />
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-test-email\"><span data-toggle=\"tooltip\" title=\"";
        // line 315
        echo ($context["help_mail_test"] ?? null);
        echo "\">";
        echo ($context["entry_mail_test_email"] ?? null);
        echo "</span></label>
                <div class=\"col-sm-10\">
                  <div class=\"input-group\">
                    <input type=\"text\" name=\"test_email\" value=\"";
        // line 318
        echo ($context["config_email"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_test_email"] ?? null);
        echo "\" id=\"input-mail-test-email\" class=\"form-control\" />
                    <span class=\"input-group-btn\">
                      <button type=\"button\" id=\"button-test-smtp\" data-loading-text=\"<i class='fa fa-circle-o-notch fa-spin'></i> Testing SMTP...\" class=\"btn btn-info\"><i class=\"fa fa-paper-plane\"></i> ";
        // line 320
        echo ($context["button_test_smtp"] ?? null);
        echo "</button>
                    </span>
                  </div>
                  <div id=\"smtp-test-result\" style=\"margin-top: 10px;\"></div>
                </div>
              </div>
            </div>

            <!-- Server -->
            <div class=\"tab-pane\" id=\"tab-server\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">";
        // line 331
        echo ($context["entry_maintenance"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <label class=\"radio-inline\">
                    ";
        // line 334
        if (($context["config_maintenance"] ?? null)) {
            // line 335
            echo "                    <input type=\"radio\" name=\"config_maintenance\" value=\"1\" checked=\"checked\" />
                    ";
            // line 336
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        } else {
            // line 338
            echo "                    <input type=\"radio\" name=\"config_maintenance\" value=\"1\" />
                    ";
            // line 339
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        }
        // line 341
        echo "                  </label>
                  <label class=\"radio-inline\">
                    ";
        // line 343
        if ( !($context["config_maintenance"] ?? null)) {
            // line 344
            echo "                    <input type=\"radio\" name=\"config_maintenance\" value=\"0\" checked=\"checked\" />
                    ";
            // line 345
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        } else {
            // line 347
            echo "                    <input type=\"radio\" name=\"config_maintenance\" value=\"0\" />
                    ";
            // line 348
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        }
        // line 350
        echo "                  </label>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">";
        // line 354
        echo ($context["entry_seo_url"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <label class=\"radio-inline\">
                    ";
        // line 357
        if (($context["config_seo_url"] ?? null)) {
            // line 358
            echo "                    <input type=\"radio\" name=\"config_seo_url\" value=\"1\" checked=\"checked\" />
                    ";
            // line 359
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        } else {
            // line 361
            echo "                    <input type=\"radio\" name=\"config_seo_url\" value=\"1\" />
                    ";
            // line 362
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        }
        // line 364
        echo "                  </label>
                  <label class=\"radio-inline\">
                    ";
        // line 366
        if ( !($context["config_seo_url"] ?? null)) {
            // line 367
            echo "                    <input type=\"radio\" name=\"config_seo_url\" value=\"0\" checked=\"checked\" />
                    ";
            // line 368
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        } else {
            // line 370
            echo "                    <input type=\"radio\" name=\"config_seo_url\" value=\"0\" />
                    ";
            // line 371
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        }
        // line 373
        echo "                  </label>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-encryption\">";
        // line 377
        echo ($context["entry_encryption"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_encryption\" value=\"";
        // line 379
        echo ($context["config_encryption"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_encryption"] ?? null);
        echo "\" id=\"input-encryption\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">";
        // line 383
        echo ($context["entry_error_display"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <label class=\"radio-inline\">
                    ";
        // line 386
        if (($context["config_error_display"] ?? null)) {
            // line 387
            echo "                    <input type=\"radio\" name=\"config_error_display\" value=\"1\" checked=\"checked\" />
                    ";
            // line 388
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        } else {
            // line 390
            echo "                    <input type=\"radio\" name=\"config_error_display\" value=\"1\" />
                    ";
            // line 391
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        }
        // line 393
        echo "                  </label>
                  <label class=\"radio-inline\">
                    ";
        // line 395
        if ( !($context["config_error_display"] ?? null)) {
            // line 396
            echo "                    <input type=\"radio\" name=\"config_error_display\" value=\"0\" checked=\"checked\" />
                    ";
            // line 397
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        } else {
            // line 399
            echo "                    <input type=\"radio\" name=\"config_error_display\" value=\"0\" />
                    ";
            // line 400
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        }
        // line 402
        echo "                  </label>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">";
        // line 406
        echo ($context["entry_error_log"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <label class=\"radio-inline\">
                    ";
        // line 409
        if (($context["config_error_log"] ?? null)) {
            // line 410
            echo "                    <input type=\"radio\" name=\"config_error_log\" value=\"1\" checked=\"checked\" />
                    ";
            // line 411
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        } else {
            // line 413
            echo "                    <input type=\"radio\" name=\"config_error_log\" value=\"1\" />
                    ";
            // line 414
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        }
        // line 416
        echo "                  </label>
                  <label class=\"radio-inline\">
                    ";
        // line 418
        if ( !($context["config_error_log"] ?? null)) {
            // line 419
            echo "                    <input type=\"radio\" name=\"config_error_log\" value=\"0\" checked=\"checked\" />
                    ";
            // line 420
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        } else {
            // line 422
            echo "                    <input type=\"radio\" name=\"config_error_log\" value=\"0\" />
                    ";
            // line 423
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        }
        // line 425
        echo "                  </label>
                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-error-filename\">";
        // line 429
        echo ($context["entry_error_filename"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_error_filename\" value=\"";
        // line 431
        echo ($context["config_error_filename"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_error_filename"] ?? null);
        echo "\" id=\"input-error-filename\" class=\"form-control\" />
                  ";
        // line 432
        if (($context["error_log"] ?? null)) {
            // line 433
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_log"] ?? null);
            echo "</div>
                  ";
        }
        // line 435
        echo "                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type=\"text/javascript\"><!--
\$('select[name=\\'config_country_id\\']').on('change', function() {
\t\$.ajax({
\t\turl: 'index.php?route=localisation/country/country&user_token=";
        // line 446
        echo ($context["user_token"] ?? null);
        echo "&country_id=' + this.value,
\t\tdataType: 'json',
\t\tbeforeSend: function() {
\t\t\t\$('select[name=\\'config_country_id\\']').prop('disabled', true);
\t\t},
\t\tcomplete: function() {
\t\t\t\$('select[name=\\'config_country_id\\']').prop('disabled', false);
\t\t},
\t\tsuccess: function(json) {
\t\t\thtml = '<option value=\"\">";
        // line 455
        echo ($context["text_select"] ?? null);
        echo "</option>';

\t\t\tif (json['zone'] && json['zone'] != '') {
\t\t\t\tfor (i = 0; i < json['zone'].length; i++) {
\t\t\t\t\thtml += '<option value=\"' + json['zone'][i]['zone_id'] + '\"';

\t\t\t\t\tif (json['zone'][i]['zone_id'] == '";
        // line 461
        echo ($context["config_zone_id"] ?? null);
        echo "') {
\t\t\t\t\t\thtml += ' selected=\"selected\"';
\t\t\t\t\t}

\t\t\t\t\thtml += '>' + json['zone'][i]['name'] + '</option>';
\t\t\t\t}
\t\t\t} else {
\t\t\t\thtml += '<option value=\"0\" selected=\"selected\">";
        // line 468
        echo ($context["text_none"] ?? null);
        echo "</option>';
\t\t\t}

\t\t\t\$('select[name=\\'config_zone_id\\']').html(html);
\t\t},
\t\terror: function(xhr, ajaxOptions, thrownError) {
\t\t\talert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
\t\t}
\t});
});

\$('select[name=\\'config_country_id\\']').trigger('change');

\$('#button-test-smtp').on('click', function() {
\tvar \$btn = \$(this);
\tvar \$result = \$('#smtp-test-result');
\t\$.ajax({
\t\turl: 'index.php?route=setting/setting/testSmtp&user_token=";
        // line 485
        echo ($context["user_token"] ?? null);
        echo "',
\t\ttype: 'post',
\t\tdataType: 'json',
\t\tdata: {
\t\t\tconfig_mail_engine: \$('#input-mail-engine').val(),
\t\t\tconfig_mail_parameter: \$('#input-mail-parameter').val(),
\t\t\tconfig_mail_smtp_hostname: \$('#input-mail-smtp-hostname').val(),
\t\t\tconfig_mail_smtp_username: \$('#input-mail-smtp-username').val(),
\t\t\tconfig_mail_smtp_password: \$('#input-mail-smtp-password').val(),
\t\t\tconfig_mail_smtp_port: \$('#input-mail-smtp-port').val(),
\t\t\tconfig_mail_smtp_timeout: \$('#input-mail-smtp-timeout').val(),
\t\t\tconfig_email: \$('#input-email').val(),
\t\t\tconfig_name: \$('#input-name').val(),
\t\t\ttest_email: \$('#input-mail-test-email').val()
\t\t},
\t\tbeforeSend: function() {
\t\t\t\$btn.button('loading');
\t\t\t\$result.html('');
\t\t},
\t\tcomplete: function() {
\t\t\t\$btn.button('reset');
\t\t},
\t\tsuccess: function(json) {
\t\t\tif (json['error']) {
\t\t\t\t\$result.html('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ' + json['error'] + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
\t\t\t}
\t\t\tif (json['success']) {
\t\t\t\t\$result.html('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
\t\t\t}
\t\t},
\t\terror: function(xhr, ajaxOptions, thrownError) {
\t\t\t\$result.html('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa fa-exclamation-circle\"></i> ' + thrownError + ' ' + xhr.statusText + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
\t\t}
\t});
});
//--></script>
</div>
";
        // line 522
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "setting/setting.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1204 => 522,  1164 => 485,  1144 => 468,  1134 => 461,  1125 => 455,  1113 => 446,  1100 => 435,  1094 => 433,  1092 => 432,  1086 => 431,  1081 => 429,  1075 => 425,  1070 => 423,  1067 => 422,  1062 => 420,  1059 => 419,  1057 => 418,  1053 => 416,  1048 => 414,  1045 => 413,  1040 => 411,  1037 => 410,  1035 => 409,  1029 => 406,  1023 => 402,  1018 => 400,  1015 => 399,  1010 => 397,  1007 => 396,  1005 => 395,  1001 => 393,  996 => 391,  993 => 390,  988 => 388,  985 => 387,  983 => 386,  977 => 383,  968 => 379,  963 => 377,  957 => 373,  952 => 371,  949 => 370,  944 => 368,  941 => 367,  939 => 366,  935 => 364,  930 => 362,  927 => 361,  922 => 359,  919 => 358,  917 => 357,  911 => 354,  905 => 350,  900 => 348,  897 => 347,  892 => 345,  889 => 344,  887 => 343,  883 => 341,  878 => 339,  875 => 338,  870 => 336,  867 => 335,  865 => 334,  859 => 331,  845 => 320,  838 => 318,  830 => 315,  820 => 310,  815 => 308,  806 => 304,  801 => 302,  792 => 298,  787 => 296,  778 => 292,  773 => 290,  764 => 286,  759 => 284,  750 => 280,  745 => 278,  739 => 274,  733 => 272,  727 => 270,  724 => 269,  718 => 267,  712 => 265,  710 => 264,  704 => 261,  693 => 253,  687 => 252,  683 => 251,  676 => 247,  670 => 246,  666 => 245,  656 => 237,  650 => 236,  642 => 234,  634 => 232,  631 => 231,  627 => 230,  619 => 227,  613 => 223,  607 => 222,  599 => 220,  591 => 218,  588 => 217,  584 => 216,  576 => 213,  571 => 210,  565 => 208,  563 => 207,  557 => 206,  550 => 204,  540 => 196,  534 => 195,  526 => 193,  518 => 191,  515 => 190,  511 => 189,  505 => 186,  499 => 182,  493 => 181,  485 => 179,  477 => 177,  474 => 176,  470 => 175,  464 => 172,  458 => 168,  452 => 167,  444 => 165,  436 => 163,  433 => 162,  429 => 161,  423 => 158,  414 => 152,  408 => 148,  402 => 147,  394 => 145,  386 => 143,  383 => 142,  379 => 141,  373 => 138,  360 => 130,  355 => 128,  346 => 124,  341 => 122,  332 => 118,  327 => 116,  322 => 113,  316 => 111,  314 => 110,  308 => 109,  303 => 107,  298 => 104,  292 => 102,  290 => 101,  284 => 100,  279 => 98,  274 => 95,  268 => 93,  266 => 92,  260 => 91,  255 => 89,  250 => 86,  244 => 84,  242 => 83,  236 => 82,  231 => 80,  226 => 77,  220 => 75,  218 => 74,  212 => 73,  207 => 71,  194 => 63,  189 => 61,  180 => 57,  175 => 55,  170 => 52,  164 => 50,  162 => 49,  156 => 48,  151 => 46,  142 => 40,  138 => 39,  134 => 38,  130 => 37,  126 => 36,  122 => 35,  118 => 34,  113 => 32,  107 => 29,  103 => 27,  95 => 23,  92 => 22,  84 => 18,  82 => 17,  76 => 13,  65 => 11,  61 => 10,  56 => 8,  50 => 7,  46 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "setting/setting.twig", "");
    }
}
