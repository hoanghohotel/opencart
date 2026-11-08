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

/* common/dashboard.twig */
class __TwigTemplate_42dd5362e7d776cd1678358f26fbd56e6da5fd81560e67ebcab45c8d17c0cf1c extends Template
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
        <button type=\"button\" id=\"button-developer\" title=\"";
        // line 6
        echo ($context["button_developer"] ?? null);
        echo "\" data-loading-text=\"";
        echo ($context["text_loading"] ?? null);
        echo "\" class=\"btn btn-info\"><i class=\"fa fa-cog\"></i></button>
      </div>
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
        if (($context["error_install"] ?? null)) {
            // line 18
            echo "    <div class=\"alert alert-danger alert-dismissible\">
      <button type=\"button\" class=\"close pull-right\" data-dismiss=\"alert\">&times;</button>
      <i class=\"fa fa-exclamation-circle\"></i> ";
            // line 20
            echo ($context["error_install"] ?? null);
            echo "
    </div>
    ";
        }
        // line 23
        echo "
    <!-- 4 KPI Summary Cards -->
    <div class=\"row\">
      <div class=\"col-lg-3 col-md-3 col-sm-6\">
        <div class=\"tile tile-primary\">
          <div class=\"tile-heading\">";
        // line 28
        echo ($context["text_total_extensions"] ?? null);
        echo " <span class=\"pull-right\">";
        echo ($context["total_downloads"] ?? null);
        echo " DL</span></div>
          <div class=\"tile-body\"><i class=\"fa fa-puzzle-piece\"></i>
            <h2 class=\"pull-right\">";
        // line 30
        echo ($context["total_extensions"] ?? null);
        echo "</h2>
          </div>
          <div class=\"tile-footer\"><a href=\"";
        // line 32
        echo ($context["link_extensions"] ?? null);
        echo "\">";
        echo ($context["text_view_more"] ?? null);
        echo "</a></div>
        </div>
      </div>
      <div class=\"col-lg-3 col-md-3 col-sm-6\">
        <div class=\"tile tile-success\">
          <div class=\"tile-heading\">";
        // line 37
        echo ($context["text_total_members"] ?? null);
        echo " <span class=\"pull-right\">";
        echo ($context["total_sellers"] ?? null);
        echo " Sellers</span></div>
          <div class=\"tile-body\"><i class=\"fa fa-users\"></i>
            <h2 class=\"pull-right\">";
        // line 39
        echo ($context["total_members"] ?? null);
        echo "</h2>
          </div>
          <div class=\"tile-footer\"><a href=\"";
        // line 41
        echo ($context["link_members"] ?? null);
        echo "\">";
        echo ($context["text_view_more"] ?? null);
        echo "</a></div>
        </div>
      </div>
      <div class=\"col-lg-3 col-md-3 col-sm-6\">
        <div class=\"tile tile-warning\">
          <div class=\"tile-heading\">";
        // line 46
        echo ($context["text_total_orders"] ?? null);
        echo " <span class=\"pull-right\">";
        echo ($context["total_revenue"] ?? null);
        echo "</span></div>
          <div class=\"tile-body\"><i class=\"fa fa-shopping-cart\"></i>
            <h2 class=\"pull-right\">";
        // line 48
        echo ($context["total_orders"] ?? null);
        echo "</h2>
          </div>
          <div class=\"tile-footer\"><a href=\"";
        // line 50
        echo ($context["link_orders"] ?? null);
        echo "\">";
        echo ($context["text_view_more"] ?? null);
        echo "</a></div>
        </div>
      </div>
      <div class=\"col-lg-3 col-md-3 col-sm-6\">
        <div class=\"tile tile-danger\">
          <div class=\"tile-heading\">";
        // line 55
        echo ($context["text_total_partners_showcase"] ?? null);
        echo " <span class=\"pull-right\">";
        echo ($context["total_showcases"] ?? null);
        echo " Stores</span></div>
          <div class=\"tile-body\"><i class=\"fa fa-handshake-o\"></i>
            <h2 class=\"pull-right\">";
        // line 57
        echo ($context["total_partners"] ?? null);
        echo " / ";
        echo ($context["total_showcases"] ?? null);
        echo "</h2>
          </div>
          <div class=\"tile-footer\"><a href=\"";
        // line 59
        echo ($context["link_partners"] ?? null);
        echo "\">";
        echo ($context["text_view_more"] ?? null);
        echo "</a></div>
        </div>
      </div>
    </div>

    <div class=\"row\">
      <!-- Recent Marketplace Orders -->
      <div class=\"col-lg-6 col-md-12\">
        <div class=\"panel panel-default\">
          <div class=\"panel-heading\">
            <h3 class=\"panel-title\"><i class=\"fa fa-shopping-cart\"></i> ";
        // line 69
        echo ($context["text_recent_orders"] ?? null);
        echo "</h3>
          </div>
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td class=\"text-right\">";
        // line 75
        echo ($context["column_order_id"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 76
        echo ($context["column_member"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 77
        echo ($context["column_extension"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 78
        echo ($context["column_status"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 79
        echo ($context["column_total"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 80
        echo ($context["column_action"] ?? null);
        echo "</td>
                </tr>
              </thead>
              <tbody>
                ";
        // line 84
        if (($context["orders"] ?? null)) {
            // line 85
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["orders"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["order"]) {
                // line 86
                echo "                <tr>
                  <td class=\"text-right\">#";
                // line 87
                echo twig_get_attribute($this->env, $this->source, $context["order"], "order_id", [], "any", false, false, false, 87);
                echo "</td>
                  <td class=\"text-left\">";
                // line 88
                echo twig_get_attribute($this->env, $this->source, $context["order"], "buyer", [], "any", false, false, false, 88);
                echo "</td>
                  <td class=\"text-left\">";
                // line 89
                echo twig_get_attribute($this->env, $this->source, $context["order"], "extension", [], "any", false, false, false, 89);
                echo "</td>
                  <td class=\"text-left\"><span class=\"label ";
                // line 90
                echo ((twig_get_attribute($this->env, $this->source, $context["order"], "status_class", [], "any", false, false, false, 90)) ? (twig_get_attribute($this->env, $this->source, $context["order"], "status_class", [], "any", false, false, false, 90)) : ("label-success"));
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["order"], "status", [], "any", false, false, false, 90);
                echo "</span></td>
                  <td class=\"text-right\">";
                // line 91
                echo twig_get_attribute($this->env, $this->source, $context["order"], "total", [], "any", false, false, false, 91);
                echo "</td>
                  <td class=\"text-right\"><a href=\"";
                // line 92
                echo twig_get_attribute($this->env, $this->source, $context["order"], "view", [], "any", false, false, false, 92);
                echo "\" data-toggle=\"tooltip\" title=\"";
                echo ($context["button_view"] ?? null);
                echo "\" class=\"btn btn-info btn-xs\"><i class=\"fa fa-eye\"></i></a></td>
                </tr>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 95
            echo "                ";
        } else {
            // line 96
            echo "                <tr>
                  <td class=\"text-center\" colspan=\"6\">";
            // line 97
            echo ($context["text_no_results"] ?? null);
            echo "</td>
                </tr>
                ";
        }
        // line 100
        echo "              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Latest Registered Members -->
      <div class=\"col-lg-6 col-md-12\">
        <div class=\"panel panel-default\">
          <div class=\"panel-heading\">
            <h3 class=\"panel-title\"><i class=\"fa fa-users\"></i> ";
        // line 110
        echo ($context["text_latest_members"] ?? null);
        echo "</h3>
          </div>
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td class=\"text-left\">";
        // line 116
        echo ($context["column_username"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 117
        echo ($context["column_name"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 118
        echo ($context["column_email"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 119
        echo ($context["column_status"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 120
        echo ($context["column_date_added"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 121
        echo ($context["column_action"] ?? null);
        echo "</td>
                </tr>
              </thead>
              <tbody>
                ";
        // line 125
        if (($context["members"] ?? null)) {
            // line 126
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["members"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["member"]) {
                // line 127
                echo "                <tr>
                  <td class=\"text-left\"><strong>";
                // line 128
                echo twig_get_attribute($this->env, $this->source, $context["member"], "username", [], "any", false, false, false, 128);
                echo "</strong></td>
                  <td class=\"text-left\">";
                // line 129
                echo twig_get_attribute($this->env, $this->source, $context["member"], "name", [], "any", false, false, false, 129);
                echo "</td>
                  <td class=\"text-left\">";
                // line 130
                echo twig_get_attribute($this->env, $this->source, $context["member"], "email", [], "any", false, false, false, 130);
                echo "</td>
                  <td class=\"text-left\">";
                // line 131
                echo twig_get_attribute($this->env, $this->source, $context["member"], "status", [], "any", false, false, false, 131);
                echo "</td>
                  <td class=\"text-left\">";
                // line 132
                echo twig_get_attribute($this->env, $this->source, $context["member"], "date_added", [], "any", false, false, false, 132);
                echo "</td>
                  <td class=\"text-right\"><a href=\"";
                // line 133
                echo twig_get_attribute($this->env, $this->source, $context["member"], "edit", [], "any", false, false, false, 133);
                echo "\" data-toggle=\"tooltip\" title=\"";
                echo ($context["button_edit"] ?? null);
                echo "\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-pencil\"></i></a></td>
                </tr>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['member'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 136
            echo "                ";
        } else {
            // line 137
            echo "                <tr>
                  <td class=\"text-center\" colspan=\"6\">";
            // line 138
            echo ($context["text_no_results"] ?? null);
            echo "</td>
                </tr>
                ";
        }
        // line 141
        echo "              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Latest Marketplace Extensions -->
    <div class=\"row\">
      <div class=\"col-lg-12 col-md-12\">
        <div class=\"panel panel-default\">
          <div class=\"panel-heading\">
            <h3 class=\"panel-title\"><i class=\"fa fa-puzzle-piece\"></i> ";
        // line 153
        echo ($context["text_latest_extensions"] ?? null);
        echo "</h3>
          </div>
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td class=\"text-left\">";
        // line 159
        echo ($context["column_name"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 160
        echo ($context["column_category"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 161
        echo ($context["column_username"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 162
        echo ($context["column_price"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 163
        echo ($context["column_downloads"] ?? null);
        echo "</td>
                  <td class=\"text-left\">";
        // line 164
        echo ($context["column_status"] ?? null);
        echo "</td>
                  <td class=\"text-right\">";
        // line 165
        echo ($context["column_action"] ?? null);
        echo "</td>
                </tr>
              </thead>
              <tbody>
                ";
        // line 169
        if (($context["extensions"] ?? null)) {
            // line 170
            echo "                ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["extensions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["extension"]) {
                // line 171
                echo "                <tr>
                  <td class=\"text-left\"><strong>";
                // line 172
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 172);
                echo "</strong></td>
                  <td class=\"text-left\">";
                // line 173
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "category", [], "any", false, false, false, 173);
                echo "</td>
                  <td class=\"text-left\">";
                // line 174
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "seller", [], "any", false, false, false, 174);
                echo "</td>
                  <td class=\"text-right\">";
                // line 175
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "price", [], "any", false, false, false, 175);
                echo "</td>
                  <td class=\"text-right\">";
                // line 176
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "stats", [], "any", false, false, false, 176);
                echo "</td>
                  <td class=\"text-left\">";
                // line 177
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "status", [], "any", false, false, false, 177);
                echo "</td>
                  <td class=\"text-right\"><a href=\"";
                // line 178
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "edit", [], "any", false, false, false, 178);
                echo "\" data-toggle=\"tooltip\" title=\"";
                echo ($context["button_edit"] ?? null);
                echo "\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-pencil\"></i></a></td>
                </tr>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['extension'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 181
            echo "                ";
        } else {
            // line 182
            echo "                <tr>
                  <td class=\"text-center\" colspan=\"7\">";
            // line 183
            echo ($context["text_no_results"] ?? null);
            echo "</td>
                </tr>
                ";
        }
        // line 186
        echo "              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type=\"text/javascript\"><!--
\$('#button-developer').on('click', function() {
\t\$.ajax({
\t\turl: 'index.php?route=common/developer&user_token=";
        // line 196
        echo ($context["user_token"] ?? null);
        echo "',
\t\tdataType: 'html',
\t\tbeforeSend: function() {
\t\t\t\$('#button-developer').button('loading');
\t\t},
\t\tcomplete: function() {
\t\t\t\$('#button-developer').button('reset');
\t\t},
\t\tsuccess: function(html) {
\t\t\t\$('#modal-developer').remove();
\t\t\t
\t\t\t\$('body').prepend('<div id=\"modal-developer\" class=\"modal\">' + html + '</div>');
\t\t\t
\t\t\t\$('#modal-developer').modal('show');
\t\t},
\t\terror: function(xhr, ajaxOptions, thrownError) {
\t\t\talert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
\t\t}
\t});\t
});\t
//--></script>
</div>
";
        // line 218
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "common/dashboard.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  533 => 218,  508 => 196,  496 => 186,  490 => 183,  487 => 182,  484 => 181,  473 => 178,  469 => 177,  465 => 176,  461 => 175,  457 => 174,  453 => 173,  449 => 172,  446 => 171,  441 => 170,  439 => 169,  432 => 165,  428 => 164,  424 => 163,  420 => 162,  416 => 161,  412 => 160,  408 => 159,  399 => 153,  385 => 141,  379 => 138,  376 => 137,  373 => 136,  362 => 133,  358 => 132,  354 => 131,  350 => 130,  346 => 129,  342 => 128,  339 => 127,  334 => 126,  332 => 125,  325 => 121,  321 => 120,  317 => 119,  313 => 118,  309 => 117,  305 => 116,  296 => 110,  284 => 100,  278 => 97,  275 => 96,  272 => 95,  261 => 92,  257 => 91,  251 => 90,  247 => 89,  243 => 88,  239 => 87,  236 => 86,  231 => 85,  229 => 84,  222 => 80,  218 => 79,  214 => 78,  210 => 77,  206 => 76,  202 => 75,  193 => 69,  178 => 59,  171 => 57,  164 => 55,  154 => 50,  149 => 48,  142 => 46,  132 => 41,  127 => 39,  120 => 37,  110 => 32,  105 => 30,  98 => 28,  91 => 23,  85 => 20,  81 => 18,  79 => 17,  73 => 13,  62 => 11,  58 => 10,  53 => 8,  46 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/dashboard.twig", "");
    }
}
