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
class __TwigTemplate_6f3665680a291d1ccf03a9a40c863499a42f577d60430ddf50b1c189e742d002 extends Template
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
            <li><a href=\"#tab-storage\" data-toggle=\"tab\"><i class=\"fa fa-cloud-upload\"></i> ";
        // line 40
        echo ($context["tab_storage"] ?? null);
        echo "</a></li>
            <li><a href=\"#tab-server\" data-toggle=\"tab\">";
        // line 41
        echo ($context["tab_server"] ?? null);
        echo "</a></li>
          </ul>
          <div class=\"tab-content\">
            <!-- General / Meta -->
            <div class=\"tab-pane active\" id=\"tab-general\">
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-meta-title\">";
        // line 47
        echo ($context["entry_meta_title"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_meta_title\" value=\"";
        // line 49
        echo ($context["config_meta_title"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_meta_title"] ?? null);
        echo "\" id=\"input-meta-title\" class=\"form-control\" />
                  ";
        // line 50
        if (($context["error_meta_title"] ?? null)) {
            // line 51
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_meta_title"] ?? null);
            echo "</div>
                  ";
        }
        // line 53
        echo "                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-meta-description\">";
        // line 56
        echo ($context["entry_meta_description"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <textarea name=\"config_meta_description\" rows=\"4\" placeholder=\"";
        // line 58
        echo ($context["entry_meta_description"] ?? null);
        echo "\" id=\"input-meta-description\" class=\"form-control\">";
        echo ($context["config_meta_description"] ?? null);
        echo "</textarea>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-meta-keyword\">";
        // line 62
        echo ($context["entry_meta_keyword"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <textarea name=\"config_meta_keyword\" rows=\"3\" placeholder=\"";
        // line 64
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
        // line 72
        echo ($context["entry_name"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_name\" value=\"";
        // line 74
        echo ($context["config_name"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_name"] ?? null);
        echo "\" id=\"input-name\" class=\"form-control\" />
                  ";
        // line 75
        if (($context["error_name"] ?? null)) {
            // line 76
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_name"] ?? null);
            echo "</div>
                  ";
        }
        // line 78
        echo "                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-owner\">";
        // line 81
        echo ($context["entry_owner"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_owner\" value=\"";
        // line 83
        echo ($context["config_owner"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_owner"] ?? null);
        echo "\" id=\"input-owner\" class=\"form-control\" />
                  ";
        // line 84
        if (($context["error_owner"] ?? null)) {
            // line 85
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_owner"] ?? null);
            echo "</div>
                  ";
        }
        // line 87
        echo "                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-address\">";
        // line 90
        echo ($context["entry_address"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <textarea name=\"config_address\" placeholder=\"";
        // line 92
        echo ($context["entry_address"] ?? null);
        echo "\" rows=\"4\" id=\"input-address\" class=\"form-control\">";
        echo ($context["config_address"] ?? null);
        echo "</textarea>
                  ";
        // line 93
        if (($context["error_address"] ?? null)) {
            // line 94
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_address"] ?? null);
            echo "</div>
                  ";
        }
        // line 96
        echo "                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-email\">";
        // line 99
        echo ($context["entry_email"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_email\" value=\"";
        // line 101
        echo ($context["config_email"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_email"] ?? null);
        echo "\" id=\"input-email\" class=\"form-control\" />
                  ";
        // line 102
        if (($context["error_email"] ?? null)) {
            // line 103
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_email"] ?? null);
            echo "</div>
                  ";
        }
        // line 105
        echo "                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-telephone\">";
        // line 108
        echo ($context["entry_telephone"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_telephone\" value=\"";
        // line 110
        echo ($context["config_telephone"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_telephone"] ?? null);
        echo "\" id=\"input-telephone\" class=\"form-control\" />
                  ";
        // line 111
        if (($context["error_telephone"] ?? null)) {
            // line 112
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_telephone"] ?? null);
            echo "</div>
                  ";
        }
        // line 114
        echo "                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-contact-support\">";
        // line 117
        echo ($context["entry_contact_support"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_contact_support\" value=\"";
        // line 119
        echo ($context["config_contact_support"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_contact_support"] ?? null);
        echo "\" id=\"input-contact-support\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-contact-partner\">";
        // line 123
        echo ($context["entry_contact_partner"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_contact_partner\" value=\"";
        // line 125
        echo ($context["config_contact_partner"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_contact_partner"] ?? null);
        echo "\" id=\"input-contact-partner\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-contact-marketing\">";
        // line 129
        echo ($context["entry_contact_marketing"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_contact_marketing\" value=\"";
        // line 131
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
        // line 139
        echo ($context["entry_country"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_country_id\" id=\"input-country\" class=\"form-control\">
                    ";
        // line 142
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["countries"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 143
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 143), ($context["config_country_id"] ?? null)))) {
                // line 144
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 144);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 144);
                echo "</option>
                    ";
            } else {
                // line 146
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 146);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 146);
                echo "</option>
                    ";
            }
            // line 148
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 149
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-zone\">";
        // line 153
        echo ($context["entry_zone"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_zone_id\" id=\"input-zone\" class=\"form-control\"></select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-language\">";
        // line 159
        echo ($context["entry_language"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_language\" id=\"input-language\" class=\"form-control\">
                    ";
        // line 162
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 163
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 163), ($context["config_language"] ?? null)))) {
                // line 164
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 164);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 164);
                echo "</option>
                    ";
            } else {
                // line 166
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 166);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 166);
                echo "</option>
                    ";
            }
            // line 168
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 169
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-admin-language\">";
        // line 173
        echo ($context["entry_admin_language"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_admin_language\" id=\"input-admin-language\" class=\"form-control\">
                    ";
        // line 176
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 177
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 177), ($context["config_admin_language"] ?? null)))) {
                // line 178
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 178);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 178);
                echo "</option>
                    ";
            } else {
                // line 180
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 180);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 180);
                echo "</option>
                    ";
            }
            // line 182
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 183
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-currency\">";
        // line 187
        echo ($context["entry_currency"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_currency\" id=\"input-currency\" class=\"form-control\">
                    ";
        // line 190
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["currencies"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["currency"]) {
            // line 191
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 191), ($context["config_currency"] ?? null)))) {
                // line 192
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 192);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["currency"], "title", [], "any", false, false, false, 192);
                echo "</option>
                    ";
            } else {
                // line 194
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["currency"], "code", [], "any", false, false, false, 194);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["currency"], "title", [], "any", false, false, false, 194);
                echo "</option>
                    ";
            }
            // line 196
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['currency'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 197
        echo "                  </select>
                </div>
              </div>
            </div>

            <!-- Option -->
            <div class=\"tab-pane\" id=\"tab-option\">
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-limit-admin\"><span data-toggle=\"tooltip\" title=\"";
        // line 205
        echo ($context["help_limit_admin"] ?? null);
        echo "\">";
        echo ($context["entry_limit_admin"] ?? null);
        echo "</span></label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_limit_admin\" value=\"";
        // line 207
        echo ($context["config_limit_admin"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_limit_admin"] ?? null);
        echo "\" id=\"input-limit-admin\" class=\"form-control\" />
                  ";
        // line 208
        if (($context["error_limit_admin"] ?? null)) {
            // line 209
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_limit_admin"] ?? null);
            echo "</div>
                  ";
        }
        // line 211
        echo "                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-order-status\"><span data-toggle=\"tooltip\" title=\"";
        // line 214
        echo ($context["help_order_status"] ?? null);
        echo "\">";
        echo ($context["entry_order_status"] ?? null);
        echo "</span></label>
                <div class=\"col-sm-10\">
                  <select name=\"config_order_status_id\" id=\"input-order-status\" class=\"form-control\">
                    ";
        // line 217
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["order_statuses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["order_status"]) {
            // line 218
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 218), ($context["config_order_status_id"] ?? null)))) {
                // line 219
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 219);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 219);
                echo "</option>
                    ";
            } else {
                // line 221
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 221);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 221);
                echo "</option>
                    ";
            }
            // line 223
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order_status'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 224
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-download-status\"><span data-toggle=\"tooltip\" title=\"";
        // line 228
        echo ($context["help_download_status"] ?? null);
        echo "\">";
        echo ($context["entry_download_status"] ?? null);
        echo "</span></label>
                <div class=\"col-sm-10\">
                  <select name=\"config_download_status_id\" id=\"input-download-status\" class=\"form-control\">
                    ";
        // line 231
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["order_statuses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["order_status"]) {
            // line 232
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 232), ($context["config_download_status_id"] ?? null)))) {
                // line 233
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 233);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 233);
                echo "</option>
                    ";
            } else {
                // line 235
                echo "                    <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 235);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 235);
                echo "</option>
                    ";
            }
            // line 237
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order_status'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 238
        echo "                  </select>
                </div>
              </div>
            </div>

            <!-- Image -->
            <div class=\"tab-pane\" id=\"tab-image\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-logo\">";
        // line 246
        echo ($context["entry_logo"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\"><a href=\"\" id=\"thumb-logo\" data-toggle=\"image\" class=\"img-thumbnail\"><img src=\"";
        // line 247
        echo ($context["logo"] ?? null);
        echo "\" alt=\"\" title=\"\" data-placeholder=\"";
        echo ($context["placeholder"] ?? null);
        echo "\" /></a>
                  <input type=\"hidden\" name=\"config_logo\" value=\"";
        // line 248
        echo ($context["config_logo"] ?? null);
        echo "\" id=\"input-logo\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-icon\">";
        // line 252
        echo ($context["entry_icon"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\"><a href=\"\" id=\"thumb-icon\" data-toggle=\"image\" class=\"img-thumbnail\"><img src=\"";
        // line 253
        echo ($context["icon"] ?? null);
        echo "\" alt=\"\" title=\"\" data-placeholder=\"";
        echo ($context["placeholder"] ?? null);
        echo "\" /></a>
                  <input type=\"hidden\" name=\"config_icon\" value=\"";
        // line 254
        echo ($context["config_icon"] ?? null);
        echo "\" id=\"input-icon\" />
                </div>
              </div>
            </div>

            <!-- Mail -->
            <div class=\"tab-pane\" id=\"tab-mail\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-engine\">";
        // line 262
        echo ($context["entry_mail_engine"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <select name=\"config_mail_engine\" id=\"input-mail-engine\" class=\"form-control\">
                    ";
        // line 265
        if ((0 === twig_compare(($context["config_mail_engine"] ?? null), "mail"))) {
            // line 266
            echo "                    <option value=\"mail\" selected=\"selected\">";
            echo ($context["text_mail"] ?? null);
            echo "</option>
                    ";
        } else {
            // line 268
            echo "                    <option value=\"mail\">";
            echo ($context["text_mail"] ?? null);
            echo "</option>
                    ";
        }
        // line 270
        echo "                    ";
        if ((0 === twig_compare(($context["config_mail_engine"] ?? null), "smtp"))) {
            // line 271
            echo "                    <option value=\"smtp\" selected=\"selected\">";
            echo ($context["text_smtp"] ?? null);
            echo "</option>
                    ";
        } else {
            // line 273
            echo "                    <option value=\"smtp\">";
            echo ($context["text_smtp"] ?? null);
            echo "</option>
                    ";
        }
        // line 275
        echo "                  </select>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-parameter\">";
        // line 279
        echo ($context["entry_mail_parameter"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_parameter\" value=\"";
        // line 281
        echo ($context["config_mail_parameter"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_parameter"] ?? null);
        echo "\" id=\"input-mail-parameter\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-hostname\">";
        // line 285
        echo ($context["entry_mail_smtp_hostname"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_hostname\" value=\"";
        // line 287
        echo ($context["config_mail_smtp_hostname"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_hostname"] ?? null);
        echo "\" id=\"input-mail-smtp-hostname\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-username\">";
        // line 291
        echo ($context["entry_mail_smtp_username"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_username\" value=\"";
        // line 293
        echo ($context["config_mail_smtp_username"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_username"] ?? null);
        echo "\" id=\"input-mail-smtp-username\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-password\">";
        // line 297
        echo ($context["entry_mail_smtp_password"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_password\" value=\"";
        // line 299
        echo ($context["config_mail_smtp_password"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_password"] ?? null);
        echo "\" id=\"input-mail-smtp-password\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-port\">";
        // line 303
        echo ($context["entry_mail_smtp_port"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_port\" value=\"";
        // line 305
        echo ($context["config_mail_smtp_port"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_port"] ?? null);
        echo "\" id=\"input-mail-smtp-port\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-smtp-timeout\">";
        // line 309
        echo ($context["entry_mail_smtp_timeout"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_mail_smtp_timeout\" value=\"";
        // line 311
        echo ($context["config_mail_smtp_timeout"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_smtp_timeout"] ?? null);
        echo "\" id=\"input-mail-smtp-timeout\" class=\"form-control\" />
                </div>
              </div>
              <hr />
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-mail-test-email\"><span data-toggle=\"tooltip\" title=\"";
        // line 316
        echo ($context["help_mail_test"] ?? null);
        echo "\">";
        echo ($context["entry_mail_test_email"] ?? null);
        echo "</span></label>
                <div class=\"col-sm-10\">
                  <div class=\"input-group\">
                    <input type=\"text\" name=\"test_email\" value=\"";
        // line 319
        echo ($context["config_email"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_mail_test_email"] ?? null);
        echo "\" id=\"input-mail-test-email\" class=\"form-control\" />
                    <span class=\"input-group-btn\">
                      <button type=\"button\" id=\"button-test-smtp\" data-loading-text=\"<i class='fa fa-circle-o-notch fa-spin'></i> Testing SMTP...\" class=\"btn btn-info\"><i class=\"fa fa-paper-plane\"></i> ";
        // line 321
        echo ($context["button_test_smtp"] ?? null);
        echo "</button>
                    </span>
                  </div>
                  <div id=\"smtp-test-result\" style=\"margin-top: 10px;\"></div>
                </div>
              </div>
            </div>

            <!-- Cloud Storage (Wasabi, Cloudflare R2, Amazon S3, Google Cloud Storage) -->
            <div class=\"tab-pane\" id=\"tab-storage\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-storage-driver\"><span data-toggle=\"tooltip\" title=\"";
        // line 332
        echo ($context["help_storage_driver"] ?? null);
        echo "\">";
        echo ($context["entry_storage_driver"] ?? null);
        echo "</span></label>
                <div class=\"col-sm-10\">
                  <select name=\"config_storage_driver\" id=\"input-storage-driver\" class=\"form-control\">
                    <option value=\"local\"";
        // line 335
        if (((0 === twig_compare(($context["config_storage_driver"] ?? null), "local")) ||  !($context["config_storage_driver"] ?? null))) {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo ($context["text_storage_local"] ?? null);
        echo "</option>
                    <option value=\"wasabi\"";
        // line 336
        if ((0 === twig_compare(($context["config_storage_driver"] ?? null), "wasabi"))) {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo ($context["text_storage_wasabi"] ?? null);
        echo "</option>
                    <option value=\"cloudflare\"";
        // line 337
        if ((0 === twig_compare(($context["config_storage_driver"] ?? null), "cloudflare"))) {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo ($context["text_storage_cloudflare"] ?? null);
        echo "</option>
                    <option value=\"s3\"";
        // line 338
        if ((0 === twig_compare(($context["config_storage_driver"] ?? null), "s3"))) {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo ($context["text_storage_s3"] ?? null);
        echo "</option>
                    <option value=\"google\"";
        // line 339
        if ((0 === twig_compare(($context["config_storage_driver"] ?? null), "google"))) {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo ($context["text_storage_google"] ?? null);
        echo "</option>
                  </select>
                </div>
              </div>

              <div id=\"cloud-storage-fields\">
                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-storage-bucket\">";
        // line 346
        echo ($context["entry_storage_bucket"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"config_storage_bucket\" value=\"";
        // line 348
        echo ($context["config_storage_bucket"] ?? null);
        echo "\" placeholder=\"my-opencart-uploads\" id=\"input-storage-bucket\" class=\"form-control\" />
                  </div>
                </div>

                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-storage-region\">";
        // line 353
        echo ($context["entry_storage_region"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"config_storage_region\" value=\"";
        // line 355
        echo ($context["config_storage_region"] ?? null);
        echo "\" placeholder=\"us-east-1 / ap-southeast-1 / auto\" id=\"input-storage-region\" class=\"form-control\" />
                  </div>
                </div>

                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-storage-endpoint\"><span data-toggle=\"tooltip\" title=\"";
        // line 360
        echo ($context["help_storage_endpoint"] ?? null);
        echo "\">";
        echo ($context["entry_storage_endpoint"] ?? null);
        echo "</span></label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"config_storage_endpoint\" value=\"";
        // line 362
        echo ($context["config_storage_endpoint"] ?? null);
        echo "\" placeholder=\"https://s3.wasabisys.com or https://<account_id>.r2.cloudflarestorage.com\" id=\"input-storage-endpoint\" class=\"form-control\" />
                  </div>
                </div>

                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-storage-access-key\">";
        // line 367
        echo ($context["entry_storage_access_key"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"config_storage_access_key\" value=\"";
        // line 369
        echo ($context["config_storage_access_key"] ?? null);
        echo "\" placeholder=\"Access Key ID / GCS Interop HMAC Key (GOOG1...)\" id=\"input-storage-access-key\" class=\"form-control\" />
                  </div>
                </div>

                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-storage-secret-key\">";
        // line 374
        echo ($context["entry_storage_secret_key"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"password\" name=\"config_storage_secret_key\" value=\"";
        // line 376
        echo ($context["config_storage_secret_key"] ?? null);
        echo "\" placeholder=\"Secret Access Key / HMAC Secret\" id=\"input-storage-secret-key\" class=\"form-control\" autocomplete=\"new-password\" />
                  </div>
                </div>

                <div class=\"form-group\" id=\"group-storage-gcs-json\">
                  <label class=\"col-sm-2 control-label\" for=\"input-storage-gcs-json\"><span data-toggle=\"tooltip\" title=\"";
        // line 381
        echo ($context["help_storage_gcs_json"] ?? null);
        echo "\">";
        echo ($context["entry_storage_gcs_json"] ?? null);
        echo "</span></label>
                  <div class=\"col-sm-10\">
                    <textarea name=\"config_storage_gcs_json\" rows=\"4\" placeholder='{\"type\": \"service_account\", \"project_id\": \"...\", \"private_key\": \"...\", \"client_email\": \"...\"}' id=\"input-storage-gcs-json\" class=\"form-control\">";
        // line 383
        echo ($context["config_storage_gcs_json"] ?? null);
        echo "</textarea>
                  </div>
                </div>

                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-storage-prefix\">";
        // line 388
        echo ($context["entry_storage_prefix"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"config_storage_prefix\" value=\"";
        // line 390
        echo ($context["config_storage_prefix"] ?? null);
        echo "\" placeholder=\"opencart\" id=\"input-storage-prefix\" class=\"form-control\" />
                  </div>
                </div>

                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-storage-public-url\">";
        // line 395
        echo ($context["entry_storage_public_url"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"config_storage_public_url\" value=\"";
        // line 397
        echo ($context["config_storage_public_url"] ?? null);
        echo "\" placeholder=\"https://cdn.yourdomain.com\" id=\"input-storage-public-url\" class=\"form-control\" />
                  </div>
                </div>

                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\" for=\"input-storage-acl\">";
        // line 402
        echo ($context["entry_storage_acl"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <select name=\"config_storage_acl\" id=\"input-storage-acl\" class=\"form-control\">
                      <option value=\"private\"";
        // line 405
        if (((0 === twig_compare(($context["config_storage_acl"] ?? null), "private")) ||  !($context["config_storage_acl"] ?? null))) {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo ($context["text_acl_private"] ?? null);
        echo "</option>
                      <option value=\"public-read\"";
        // line 406
        if ((0 === twig_compare(($context["config_storage_acl"] ?? null), "public-read"))) {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo ($context["text_acl_public"] ?? null);
        echo "</option>
                    </select>
                  </div>
                </div>

                <div class=\"form-group\">
                  <label class=\"col-sm-2 control-label\"><span data-toggle=\"tooltip\" title=\"";
        // line 412
        echo ($context["help_storage_keep_local"] ?? null);
        echo "\">";
        echo ($context["entry_storage_keep_local"] ?? null);
        echo "</span></label>
                  <div class=\"col-sm-10\">
                    <label class=\"radio-inline\">
                      <input type=\"radio\" name=\"config_storage_keep_local\" value=\"1\"";
        // line 415
        if ((($context["config_storage_keep_local"] ?? null) || (null === ($context["config_storage_keep_local"] ?? null)))) {
            echo " checked=\"checked\"";
        }
        echo " />
                      ";
        // line 416
        echo ($context["text_yes"] ?? null);
        echo "
                    </label>
                    <label class=\"radio-inline\">
                      <input type=\"radio\" name=\"config_storage_keep_local\" value=\"0\"";
        // line 419
        if ((0 === twig_compare(($context["config_storage_keep_local"] ?? null), "0"))) {
            echo " checked=\"checked\"";
        }
        echo " />
                      ";
        // line 420
        echo ($context["text_no"] ?? null);
        echo "
                    </label>
                  </div>
                </div>
              </div>

              <hr />
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">";
        // line 428
        echo ($context["button_test_storage"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <button type=\"button\" id=\"button-test-storage\" data-loading-text=\"<i class='fa fa-circle-o-notch fa-spin'></i> Testing Storage...\" class=\"btn btn-info\"><i class=\"fa fa-cloud-upload\"></i> ";
        // line 430
        echo ($context["button_test_storage"] ?? null);
        echo "</button>
                  <div id=\"storage-test-result\" style=\"margin-top: 10px;\"></div>
                </div>
              </div>
            </div>

            <!-- Server -->
            <div class=\"tab-pane\" id=\"tab-server\">
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">";
        // line 439
        echo ($context["entry_maintenance"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <label class=\"radio-inline\">
                    ";
        // line 442
        if (($context["config_maintenance"] ?? null)) {
            // line 443
            echo "                    <input type=\"radio\" name=\"config_maintenance\" value=\"1\" checked=\"checked\" />
                    ";
            // line 444
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        } else {
            // line 446
            echo "                    <input type=\"radio\" name=\"config_maintenance\" value=\"1\" />
                    ";
            // line 447
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        }
        // line 449
        echo "                  </label>
                  <label class=\"radio-inline\">
                    ";
        // line 451
        if ( !($context["config_maintenance"] ?? null)) {
            // line 452
            echo "                    <input type=\"radio\" name=\"config_maintenance\" value=\"0\" checked=\"checked\" />
                    ";
            // line 453
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        } else {
            // line 455
            echo "                    <input type=\"radio\" name=\"config_maintenance\" value=\"0\" />
                    ";
            // line 456
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        }
        // line 458
        echo "                  </label>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">";
        // line 462
        echo ($context["entry_seo_url"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <label class=\"radio-inline\">
                    ";
        // line 465
        if (($context["config_seo_url"] ?? null)) {
            // line 466
            echo "                    <input type=\"radio\" name=\"config_seo_url\" value=\"1\" checked=\"checked\" />
                    ";
            // line 467
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        } else {
            // line 469
            echo "                    <input type=\"radio\" name=\"config_seo_url\" value=\"1\" />
                    ";
            // line 470
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        }
        // line 472
        echo "                  </label>
                  <label class=\"radio-inline\">
                    ";
        // line 474
        if ( !($context["config_seo_url"] ?? null)) {
            // line 475
            echo "                    <input type=\"radio\" name=\"config_seo_url\" value=\"0\" checked=\"checked\" />
                    ";
            // line 476
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        } else {
            // line 478
            echo "                    <input type=\"radio\" name=\"config_seo_url\" value=\"0\" />
                    ";
            // line 479
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        }
        // line 481
        echo "                  </label>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\" for=\"input-encryption\">";
        // line 485
        echo ($context["entry_encryption"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_encryption\" value=\"";
        // line 487
        echo ($context["config_encryption"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_encryption"] ?? null);
        echo "\" id=\"input-encryption\" class=\"form-control\" />
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">";
        // line 491
        echo ($context["entry_error_display"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <label class=\"radio-inline\">
                    ";
        // line 494
        if (($context["config_error_display"] ?? null)) {
            // line 495
            echo "                    <input type=\"radio\" name=\"config_error_display\" value=\"1\" checked=\"checked\" />
                    ";
            // line 496
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        } else {
            // line 498
            echo "                    <input type=\"radio\" name=\"config_error_display\" value=\"1\" />
                    ";
            // line 499
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        }
        // line 501
        echo "                  </label>
                  <label class=\"radio-inline\">
                    ";
        // line 503
        if ( !($context["config_error_display"] ?? null)) {
            // line 504
            echo "                    <input type=\"radio\" name=\"config_error_display\" value=\"0\" checked=\"checked\" />
                    ";
            // line 505
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        } else {
            // line 507
            echo "                    <input type=\"radio\" name=\"config_error_display\" value=\"0\" />
                    ";
            // line 508
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        }
        // line 510
        echo "                  </label>
                </div>
              </div>
              <div class=\"form-group\">
                <label class=\"col-sm-2 control-label\">";
        // line 514
        echo ($context["entry_error_log"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <label class=\"radio-inline\">
                    ";
        // line 517
        if (($context["config_error_log"] ?? null)) {
            // line 518
            echo "                    <input type=\"radio\" name=\"config_error_log\" value=\"1\" checked=\"checked\" />
                    ";
            // line 519
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        } else {
            // line 521
            echo "                    <input type=\"radio\" name=\"config_error_log\" value=\"1\" />
                    ";
            // line 522
            echo ($context["text_yes"] ?? null);
            echo "
                    ";
        }
        // line 524
        echo "                  </label>
                  <label class=\"radio-inline\">
                    ";
        // line 526
        if ( !($context["config_error_log"] ?? null)) {
            // line 527
            echo "                    <input type=\"radio\" name=\"config_error_log\" value=\"0\" checked=\"checked\" />
                    ";
            // line 528
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        } else {
            // line 530
            echo "                    <input type=\"radio\" name=\"config_error_log\" value=\"0\" />
                    ";
            // line 531
            echo ($context["text_no"] ?? null);
            echo "
                    ";
        }
        // line 533
        echo "                  </label>
                </div>
              </div>
              <div class=\"form-group required\">
                <label class=\"col-sm-2 control-label\" for=\"input-error-filename\">";
        // line 537
        echo ($context["entry_error_filename"] ?? null);
        echo "</label>
                <div class=\"col-sm-10\">
                  <input type=\"text\" name=\"config_error_filename\" value=\"";
        // line 539
        echo ($context["config_error_filename"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_error_filename"] ?? null);
        echo "\" id=\"input-error-filename\" class=\"form-control\" />
                  ";
        // line 540
        if (($context["error_log"] ?? null)) {
            // line 541
            echo "                  <div class=\"text-danger\">";
            echo ($context["error_log"] ?? null);
            echo "</div>
                  ";
        }
        // line 543
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
        // line 554
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
        // line 563
        echo ($context["text_select"] ?? null);
        echo "</option>';

\t\t\tif (json['zone'] && json['zone'] != '') {
\t\t\t\tfor (i = 0; i < json['zone'].length; i++) {
\t\t\t\t\thtml += '<option value=\"' + json['zone'][i]['zone_id'] + '\"';

\t\t\t\t\tif (json['zone'][i]['zone_id'] == '";
        // line 569
        echo ($context["config_zone_id"] ?? null);
        echo "') {
\t\t\t\t\t\thtml += ' selected=\"selected\"';
\t\t\t\t\t}

\t\t\t\t\thtml += '>' + json['zone'][i]['name'] + '</option>';
\t\t\t\t}
\t\t\t} else {
\t\t\t\thtml += '<option value=\"0\" selected=\"selected\">";
        // line 576
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
        // line 593
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

function updateStorageUI() {
\tvar driver = \$('#input-storage-driver').val();
\tif (driver === 'local') {
\t\t\$('#cloud-storage-fields').slideUp(150);
\t} else {
\t\t\$('#cloud-storage-fields').slideDown(150);
\t\tif (driver === 'google') {
\t\t\t\$('#group-storage-gcs-json').show();
\t\t} else {
\t\t\t\$('#group-storage-gcs-json').hide();
\t\t}
\t\tif (driver === 'cloudflare' && (\$('#input-storage-region').val() === '' || \$('#input-storage-region').val() === 'us-east-1')) {
\t\t\t\$('#input-storage-region').val('auto');
\t\t}
\t}
}

\$('#input-storage-driver').on('change', updateStorageUI);
updateStorageUI();

\$('#button-test-storage').on('click', function() {
\tvar \$btn = \$(this);
\tvar \$result = \$('#storage-test-result');
\t\$.ajax({
\t\turl: 'index.php?route=setting/setting/testStorage&user_token=";
        // line 653
        echo ($context["user_token"] ?? null);
        echo "',
\t\ttype: 'post',
\t\tdataType: 'json',
\t\tdata: {
\t\t\tconfig_storage_driver: \$('#input-storage-driver').val(),
\t\t\tconfig_storage_bucket: \$('#input-storage-bucket').val(),
\t\t\tconfig_storage_region: \$('#input-storage-region').val(),
\t\t\tconfig_storage_endpoint: \$('#input-storage-endpoint').val(),
\t\t\tconfig_storage_access_key: \$('#input-storage-access-key').val(),
\t\t\tconfig_storage_secret_key: \$('#input-storage-secret-key').val(),
\t\t\tconfig_storage_gcs_json: \$('#input-storage-gcs-json').val(),
\t\t\tconfig_storage_prefix: \$('#input-storage-prefix').val(),
\t\t\tconfig_storage_public_url: \$('#input-storage-public-url').val(),
\t\t\tconfig_storage_acl: \$('#input-storage-acl').val(),
\t\t\tconfig_storage_keep_local: \$('input[name=\"config_storage_keep_local\"]:checked').val()
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
        // line 691
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
        return array (  1515 => 691,  1474 => 653,  1411 => 593,  1391 => 576,  1381 => 569,  1372 => 563,  1360 => 554,  1347 => 543,  1341 => 541,  1339 => 540,  1333 => 539,  1328 => 537,  1322 => 533,  1317 => 531,  1314 => 530,  1309 => 528,  1306 => 527,  1304 => 526,  1300 => 524,  1295 => 522,  1292 => 521,  1287 => 519,  1284 => 518,  1282 => 517,  1276 => 514,  1270 => 510,  1265 => 508,  1262 => 507,  1257 => 505,  1254 => 504,  1252 => 503,  1248 => 501,  1243 => 499,  1240 => 498,  1235 => 496,  1232 => 495,  1230 => 494,  1224 => 491,  1215 => 487,  1210 => 485,  1204 => 481,  1199 => 479,  1196 => 478,  1191 => 476,  1188 => 475,  1186 => 474,  1182 => 472,  1177 => 470,  1174 => 469,  1169 => 467,  1166 => 466,  1164 => 465,  1158 => 462,  1152 => 458,  1147 => 456,  1144 => 455,  1139 => 453,  1136 => 452,  1134 => 451,  1130 => 449,  1125 => 447,  1122 => 446,  1117 => 444,  1114 => 443,  1112 => 442,  1106 => 439,  1094 => 430,  1089 => 428,  1078 => 420,  1072 => 419,  1066 => 416,  1060 => 415,  1052 => 412,  1039 => 406,  1031 => 405,  1025 => 402,  1017 => 397,  1012 => 395,  1004 => 390,  999 => 388,  991 => 383,  984 => 381,  976 => 376,  971 => 374,  963 => 369,  958 => 367,  950 => 362,  943 => 360,  935 => 355,  930 => 353,  922 => 348,  917 => 346,  903 => 339,  895 => 338,  887 => 337,  879 => 336,  871 => 335,  863 => 332,  849 => 321,  842 => 319,  834 => 316,  824 => 311,  819 => 309,  810 => 305,  805 => 303,  796 => 299,  791 => 297,  782 => 293,  777 => 291,  768 => 287,  763 => 285,  754 => 281,  749 => 279,  743 => 275,  737 => 273,  731 => 271,  728 => 270,  722 => 268,  716 => 266,  714 => 265,  708 => 262,  697 => 254,  691 => 253,  687 => 252,  680 => 248,  674 => 247,  670 => 246,  660 => 238,  654 => 237,  646 => 235,  638 => 233,  635 => 232,  631 => 231,  623 => 228,  617 => 224,  611 => 223,  603 => 221,  595 => 219,  592 => 218,  588 => 217,  580 => 214,  575 => 211,  569 => 209,  567 => 208,  561 => 207,  554 => 205,  544 => 197,  538 => 196,  530 => 194,  522 => 192,  519 => 191,  515 => 190,  509 => 187,  503 => 183,  497 => 182,  489 => 180,  481 => 178,  478 => 177,  474 => 176,  468 => 173,  462 => 169,  456 => 168,  448 => 166,  440 => 164,  437 => 163,  433 => 162,  427 => 159,  418 => 153,  412 => 149,  406 => 148,  398 => 146,  390 => 144,  387 => 143,  383 => 142,  377 => 139,  364 => 131,  359 => 129,  350 => 125,  345 => 123,  336 => 119,  331 => 117,  326 => 114,  320 => 112,  318 => 111,  312 => 110,  307 => 108,  302 => 105,  296 => 103,  294 => 102,  288 => 101,  283 => 99,  278 => 96,  272 => 94,  270 => 93,  264 => 92,  259 => 90,  254 => 87,  248 => 85,  246 => 84,  240 => 83,  235 => 81,  230 => 78,  224 => 76,  222 => 75,  216 => 74,  211 => 72,  198 => 64,  193 => 62,  184 => 58,  179 => 56,  174 => 53,  168 => 51,  166 => 50,  160 => 49,  155 => 47,  146 => 41,  142 => 40,  138 => 39,  134 => 38,  130 => 37,  126 => 36,  122 => 35,  118 => 34,  113 => 32,  107 => 29,  103 => 27,  95 => 23,  92 => 22,  84 => 18,  82 => 17,  76 => 13,  65 => 11,  61 => 10,  56 => 8,  50 => 7,  46 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "setting/setting.twig", "");
    }
}
