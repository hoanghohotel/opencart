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

/* marketplace/extension_list.twig */
class __TwigTemplate_5a25837c34eee1b122aa3b278500cb153cc77c48d011991171998fa80977e938 extends Template
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
<div id=\"marketplace-extension\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>Welcome to OpenCart Extension Store</h1>
      <p>With a huge range of features included out-of-the-box and over 13 000+ additional extensions available to download</p>
    </div>
  </div>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-sm-4 col-md-3\">
        <section id=\"extension-search\">
          <h4>Search extensions and themes</h4>
          <div class=\"input-group\">
            <input type=\"text\" name=\"filter_search\" value=\"";
        // line 15
        echo ($context["filter_search"] ?? null);
        echo "\" class=\"form-control\"/> <input type=\"hidden\" name=\"filter_category_id\" value=\"";
        echo ($context["filter_category_id"] ?? null);
        echo "\" class=\"form-control\"/> <input type=\"hidden\" name=\"filter_download_id\" value=\"";
        echo ($context["filter_download_id"] ?? null);
        echo "\" class=\"form-control\"/> <input type=\"hidden\" name=\"filter_rating\" value=\"";
        echo ($context["filter_rating"] ?? null);
        echo "\" class=\"form-control\"/> <input type=\"hidden\" name=\"filter_license\" value=\"";
        echo ($context["filter_license"] ?? null);
        echo "\" class=\"form-control\"/> <input type=\"hidden\" name=\"filter_partner\" value=\"";
        echo ($context["filter_partner"] ?? null);
        echo "\" class=\"form-control\"/> <input type=\"hidden\" name=\"sort\" value=\"";
        echo ($context["sort"] ?? null);
        echo "\" class=\"form-control\"/>
            <div class=\"input-group-btn\">
              <button type=\"button\" id=\"button-search\" class=\"btn btn-default btn-xs\"><i class=\"fa fa-search\"></i></button>
            </div>
          </div>
        </section>
        <div class=\"visible-xs\">
          <button id=\"mobile-switch\" data-target=\"#collapse-filter\" data-toggle=\"collapse\" type=\"button\" class=\"btn btn-primary btn-block btn-lg\">Advanced Search</button>
        </div>
        <div id=\"collapse-filter\" class=\"collapse\">
          <section id=\"extension-category\">
            <h4>Category</h4>
            <ul class=\"list-unstyled\">
              ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 29
            echo "                ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["category"], "extension_category_id", [], "any", false, false, false, 29), ($context["filter_category_id"] ?? null)))) {
                // line 30
                echo "                  <li class=\"active\"><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 30);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 30);
                echo "</a></li>
                ";
            } else {
                // line 32
                echo "                  <li><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 32);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 32);
                echo "</a></li>
                ";
            }
            // line 34
            echo "              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "            </ul>
          </section>
          <section id=\"extension-opencart-version\">
            <h4>OpenCart version</h4>
            <div class=\"form-group\">
              <div class=\"input-group\">
                <select onchange=\"location = this.value\" class=\"form-control\">
                  ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["versions"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["version"]) {
            // line 43
            echo "                    ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["version"], "download_id", [], "any", false, false, false, 43), ($context["filter_download_id"] ?? null)))) {
                // line 44
                echo "                      <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["version"], "href", [], "any", false, false, false, 44);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["version"], "name", [], "any", false, false, false, 44);
                echo "</option>
                    ";
            } else {
                // line 46
                echo "                      <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["version"], "href", [], "any", false, false, false, 46);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["version"], "name", [], "any", false, false, false, 46);
                echo "</option>
                    ";
            }
            // line 48
            echo "                  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['version'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 49
        echo "                </select>
              </div>
            </div>
          </section>
          <section id=\"extension-developed\">
            <h4>Developed by</h4>
            ";
        // line 55
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["partner_types"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["partner_type"]) {
            // line 56
            echo "              ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["partner_type"], "value", [], "any", false, false, false, 56), ($context["filter_partner"] ?? null)))) {
                // line 57
                echo "                <div class=\"radio\">
                  <label><input type=\"radio\" onclick=\"location = '";
                // line 58
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "href", [], "any", false, false, false, 58);
                echo "'\" checked=\"checked\"/>
                    ";
                // line 59
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "text", [], "any", false, false, false, 59);
                echo "</label>
                </div>
              ";
            } else {
                // line 62
                echo "                <div class=\"radio\">
                  <label><input type=\"radio\" onclick=\"location = '";
                // line 63
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "href", [], "any", false, false, false, 63);
                echo "'\"/>
                    ";
                // line 64
                echo twig_get_attribute($this->env, $this->source, $context["partner_type"], "text", [], "any", false, false, false, 64);
                echo "</label>
                </div>
              ";
            }
            // line 67
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['partner_type'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo "</section>
          <section id=\"extension-rating\">
            <h4>Rating</h4>
            <ul class=\"list-unstyled\">
              ";
        // line 71
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["ratings"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["rating"]) {
            // line 72
            echo "                ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["rating"], "value", [], "any", false, false, false, 72), ($context["filter_rating"] ?? null)))) {
                // line 73
                echo "                  <li class=\"active\"><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["rating"], "href", [], "any", false, false, false, 73);
                echo "\">";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(range(1, 5));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    if ((0 <= twig_compare(twig_get_attribute($this->env, $this->source, $context["rating"], "value", [], "any", false, false, false, 73), $context["i"]))) {
                        echo "<i class=\"opencart-icon-star-light\"></i>";
                    } else {
                        echo "<i class=\"opencart-icon-star-light-o\"></i>";
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                echo " and up</a></li>
                ";
            } else {
                // line 75
                echo "                  <li><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["rating"], "href", [], "any", false, false, false, 75);
                echo "\">";
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(range(1, 5));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    if ((0 <= twig_compare(twig_get_attribute($this->env, $this->source, $context["rating"], "value", [], "any", false, false, false, 75), $context["i"]))) {
                        echo "<i class=\"opencart-icon-star-light\"></i>";
                    } else {
                        echo "<i class=\"opencart-icon-star-light-o\"></i>";
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                echo " and up</a></li>
                ";
            }
            // line 77
            echo "              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['rating'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 78
        echo "            </ul>
          </section>
        </div>
      </div>
      <div class=\"col-sm-8 col-md-9\">
        <div class=\"row\">
          <div class=\"col-md-6\">
            <div class=\"btn-group hidden-xs hidden-sm\"> ";
        // line 85
        if (twig_test_empty(($context["filter_license"] ?? null))) {
            echo "<a href=\"";
            echo ($context["license_all"] ?? null);
            echo "\" class=\"btn btn-default btn-lg active\">All</a>";
        } else {
            echo "<a href=\"";
            echo ($context["license_all"] ?? null);
            echo "\" class=\"btn btn-default btn-lg\">All</a>";
        }
        // line 86
        echo "              ";
        if ((0 === twig_compare(($context["filter_license"] ?? null), "1"))) {
            echo "<a href=\"";
            echo ($context["license_paid"] ?? null);
            echo "\" class=\"btn btn-default btn-lg active\">Commercial</a>";
        } else {
            echo "<a href=\"";
            echo ($context["license_paid"] ?? null);
            echo "\" class=\"btn btn-default btn-lg\">Commercial</a>";
        }
        // line 87
        echo "              ";
        if ((0 === twig_compare(($context["filter_license"] ?? null), "0"))) {
            echo "<a href=\"";
            echo ($context["license_free"] ?? null);
            echo "\" class=\"btn btn-default btn-lg active\">Free</a>";
        } else {
            echo "<a href=\"";
            echo ($context["license_free"] ?? null);
            echo "\" class=\"btn btn-default btn-lg\">Free</a>";
        }
        echo "</div>
            <div class=\"btn-group btn-group-justified visible-xs-block visible-sm-block\"> ";
        // line 88
        if (twig_test_empty(($context["filter_license"] ?? null))) {
            echo "<a href=\"";
            echo ($context["license_all"] ?? null);
            echo "\" class=\"btn btn-default btn-lg active\">All</a>";
        } else {
            echo "<a href=\"";
            echo ($context["license_all"] ?? null);
            echo "\" class=\"btn btn-default btn-lg\">All</a>";
        }
        // line 89
        echo "              ";
        if ((0 === twig_compare(($context["filter_license"] ?? null), "1"))) {
            echo "<a href=\"";
            echo ($context["license_paid"] ?? null);
            echo "\" class=\"btn btn-default btn-lg active\">Commercial</a>";
        } else {
            echo "<a href=\"";
            echo ($context["license_paid"] ?? null);
            echo "\" class=\"btn btn-default btn-lg\">Commercial</a>";
        }
        // line 90
        echo "              ";
        if ((0 === twig_compare(($context["filter_license"] ?? null), "0"))) {
            echo "<a href=\"";
            echo ($context["license_free"] ?? null);
            echo "\" class=\"btn btn-default btn-lg active\">Free</a>";
        } else {
            echo "<a href=\"";
            echo ($context["license_free"] ?? null);
            echo "\" class=\"btn btn-default btn-lg\">Free</a>";
        }
        echo "</div>
          </div>
          <div id=\"extension-sorting\" class=\"col-md-6\">
            <form class=\"form-horizontal\">
              <div class=\"form-group\">
                <label for=\"input-sort\" class=\"col-xs-4\">Sort by</label>
                <div class=\"col-xs-8\">
                  <select onchange=\"location = this.value\" id=\"input-sort\" class=\"form-control\">
                    ";
        // line 98
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($context["sorts"]);
        foreach ($context['_seq'] as $context["_key"] => $context["sorts"]) {
            // line 99
            echo "                      ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["sorts"], "value", [], "any", false, false, false, 99), ($context["sort"] ?? null)))) {
                // line 100
                echo "                        <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["sorts"], "href", [], "any", false, false, false, 100);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["sorts"], "text", [], "any", false, false, false, 100);
                echo "</option>
                      ";
            } else {
                // line 102
                echo "                        <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["sorts"], "href", [], "any", false, false, false, 102);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["sorts"], "text", [], "any", false, false, false, 102);
                echo "</option>
                      ";
            }
            // line 104
            echo "                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['sorts'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 105
        echo "                  </select>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div id=\"extension-list\">
          ";
        // line 112
        if ((($context["banner"] ?? null) || ($context["promotions"] ?? null))) {
            // line 113
            echo "            ";
            if (($context["banner"] ?? null)) {
                // line 114
                echo "              <div class=\"promotion-banner\">
                ";
                // line 115
                echo ($context["banner"] ?? null);
                echo "
              </div>
            ";
            }
            // line 118
            echo "            ";
            if (($context["promotions"] ?? null)) {
                // line 119
                echo "              <h3>Featured</h3>
              ";
                // line 120
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_array_batch(($context["promotions"] ?? null), 3));
                foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                    // line 121
                    echo "                <div class=\"row\">
                  ";
                    // line 122
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable($context["row"]);
                    foreach ($context['_seq'] as $context["_key"] => $context["promotion"]) {
                        // line 123
                        echo "                    ";
                        if ($context["promotion"]) {
                            // line 124
                            echo "                      <div class=\"col-md-4\">
                        <section>
                          <div class=\"extension-preview\"><a href=\"";
                            // line 126
                            echo twig_get_attribute($this->env, $this->source, $context["promotion"], "href", [], "any", false, false, false, 126);
                            echo "\">
                              <div class=\"extension-description\">";
                            // line 127
                            echo twig_get_attribute($this->env, $this->source, $context["promotion"], "description", [], "any", false, false, false, 127);
                            echo "</div>
                              <img src=\"";
                            // line 128
                            echo twig_get_attribute($this->env, $this->source, $context["promotion"], "image", [], "any", false, false, false, 128);
                            echo "\" alt=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["promotion"], "name", [], "any", false, false, false, 128);
                            echo "\" title=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["promotion"], "name", [], "any", false, false, false, 128);
                            echo "\" class=\"img-responsive\"/></a>
                          </div>
                          <div class=\"extension-name\">
                            <p><a href=\"";
                            // line 131
                            echo twig_get_attribute($this->env, $this->source, $context["promotion"], "href", [], "any", false, false, false, 131);
                            echo "\">";
                            echo twig_get_attribute($this->env, $this->source, $context["promotion"], "name", [], "any", false, false, false, 131);
                            echo "</a></p>
                            <p><span>";
                            // line 132
                            echo twig_get_attribute($this->env, $this->source, $context["promotion"], "price", [], "any", false, false, false, 132);
                            echo "</span></p>
                            ";
                            // line 133
                            if (twig_get_attribute($this->env, $this->source, $context["promotion"], "recommended", [], "any", false, false, false, 133)) {
                                // line 134
                                echo "                            <img class=\"recommended-label\" src=\"application/view/image/marketplace/recommended-label.svg\"/>
                            ";
                            }
                            // line 136
                            echo "                          </div>
                          <div>
                            <div class=\"row\">
                              <div class=\"col-xs-6\">
                                <div>
                                  ";
                            // line 141
                            $context['_parent'] = $context;
                            $context['_seq'] = twig_ensure_traversable(range(1, 5));
                            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                                // line 142
                                echo "                                    ";
                                if ((0 <= twig_compare(twig_get_attribute($this->env, $this->source, $context["promotion"], "rating", [], "any", false, false, false, 142), $context["i"]))) {
                                    echo "<i class=\"opencart-icon-star-light\"></i>";
                                } else {
                                    echo "<i class=\"opencart-icon-star-light-o\"></i>";
                                }
                                // line 143
                                echo "                                  ";
                            }
                            $_parent = $context['_parent'];
                            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                            $context = array_intersect_key($context, $_parent) + $_parent;
                            // line 144
                            echo "                                </div>
                              </div>
                              <div class=\"col-xs-6\">
                                <div class=\"text-right\"><span>";
                            // line 147
                            echo twig_get_attribute($this->env, $this->source, $context["promotion"], "rating_total", [], "any", false, false, false, 147);
                            echo " reviews</span></div>
                              </div>
                            </div>
                          </div>
                        </section>
                      </div>
                    ";
                        }
                        // line 154
                        echo "                  ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['promotion'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 155
                    echo "                </div>
              ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 157
                echo "            ";
            }
            // line 158
            echo "            <hr/>
          ";
        }
        // line 160
        echo "          ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_array_batch(($context["extensions"] ?? null), 3));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 161
            echo "            <div class=\"row\">
              ";
            // line 162
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["row"]);
            foreach ($context['_seq'] as $context["_key"] => $context["extension"]) {
                // line 163
                echo "                ";
                if ($context["extension"]) {
                    // line 164
                    echo "                  <div class=\"col-md-4\">
                    <section>
                      <div class=\"extension-preview\">
                        <a href=\"";
                    // line 167
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "href", [], "any", false, false, false, 167);
                    echo "\">
                          <div class=\"extension-description\">";
                    // line 168
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "description", [], "any", false, false, false, 168);
                    echo "</div>
                          <img src=\"";
                    // line 169
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "image", [], "any", false, false, false, 169);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 169);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 169);
                    echo "\" class=\"img-responsive\"/> </a>
                      </div>
                      <div class=\"extension-name\">
                        <p><a href=\"";
                    // line 172
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "href", [], "any", false, false, false, 172);
                    echo "\">";
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 172);
                    echo "</a></p>
                        <p><span>";
                    // line 173
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "price", [], "any", false, false, false, 173);
                    echo "</span></p>
                        ";
                    // line 174
                    if (twig_get_attribute($this->env, $this->source, $context["extension"], "recommended", [], "any", false, false, false, 174)) {
                        // line 175
                        echo "                        <img class=\"recommended-label\" src=\"application/view/image/marketplace/recommended-label.svg\"/>
                        ";
                    }
                    // line 177
                    echo "                      </div>
                      <div>
                        <div class=\"row\">
                          <div class=\"col-xs-6\">
                            <div>
                              ";
                    // line 182
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(range(1, 5));
                    foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                        // line 183
                        echo "                                ";
                        if ((0 <= twig_compare(twig_get_attribute($this->env, $this->source, $context["extension"], "rating", [], "any", false, false, false, 183), $context["i"]))) {
                            echo "<i class=\"opencart-icon-star-light\"></i>";
                        } else {
                            echo "<i class=\"opencart-icon-star-light-o\"></i>";
                        }
                        // line 184
                        echo "                              ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 185
                    echo "                            </div>
                          </div>
                          <div class=\"col-xs-6\">
                            <div class=\"text-right\"><span>";
                    // line 188
                    echo twig_get_attribute($this->env, $this->source, $context["extension"], "rating_total", [], "any", false, false, false, 188);
                    echo " reviews</span></div>
                          </div>
                        </div>
                      </div>
                    </section>
                  </div>
                ";
                }
                // line 195
                echo "              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['extension'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 196
            echo "            </div>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 198
        echo "        </div>
        <nav>";
        // line 199
        echo ($context["pagination"] ?? null);
        echo "</nav>
      </div>
    </div>
  </div>
</div>

<script type=\"text/javascript\"><!--
\$('#button-search').on('click', function(e) {
\tvar input = \$('#extension-search :input');

\tvar url = 'index.php?route=marketplace/extension';

\tfor (i = 0; i < input.length; i++) {
\t\tif (\$(input[i]).val() != '' && \$(input[i]).val() != null) {
\t\t\turl += '&' + \$(input[i]).attr('name') + '=' + \$(input[i]).val()
\t\t}
\t}

\tlocation = url;
});

\$('input[name=\\'filter_search\\']').keydown(function(e) {
\tif (e.keyCode == 13) {
\t\te.preventDefault();

\t\t\$('#button-search').trigger('click');
\t}
});
//--></script>
";
        // line 228
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "marketplace/extension_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  646 => 228,  614 => 199,  611 => 198,  604 => 196,  598 => 195,  588 => 188,  583 => 185,  577 => 184,  570 => 183,  566 => 182,  559 => 177,  555 => 175,  553 => 174,  549 => 173,  543 => 172,  533 => 169,  529 => 168,  525 => 167,  520 => 164,  517 => 163,  513 => 162,  510 => 161,  505 => 160,  501 => 158,  498 => 157,  491 => 155,  485 => 154,  475 => 147,  470 => 144,  464 => 143,  457 => 142,  453 => 141,  446 => 136,  442 => 134,  440 => 133,  436 => 132,  430 => 131,  420 => 128,  416 => 127,  412 => 126,  408 => 124,  405 => 123,  401 => 122,  398 => 121,  394 => 120,  391 => 119,  388 => 118,  382 => 115,  379 => 114,  376 => 113,  374 => 112,  365 => 105,  359 => 104,  351 => 102,  343 => 100,  340 => 99,  336 => 98,  316 => 90,  305 => 89,  295 => 88,  282 => 87,  271 => 86,  261 => 85,  252 => 78,  246 => 77,  227 => 75,  208 => 73,  205 => 72,  201 => 71,  190 => 67,  184 => 64,  180 => 63,  177 => 62,  171 => 59,  167 => 58,  164 => 57,  161 => 56,  157 => 55,  149 => 49,  143 => 48,  135 => 46,  127 => 44,  124 => 43,  120 => 42,  111 => 35,  105 => 34,  97 => 32,  89 => 30,  86 => 29,  82 => 28,  54 => 15,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "marketplace/extension_list.twig", "");
    }
}
