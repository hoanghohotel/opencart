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

/* cms/blog_list.twig */
class __TwigTemplate_4391e7fb3f6cf3621ff0b91cf793f4dddfca65c62b041afddc87d75688c1da2b extends Template
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
<div id=\"cms-blog\">
  <div class=\"page-header\">
    <div class=\"container\">
      <h1>Welcome to OpenCart Ecommerce Blog</h1>
      <p>Stay tuned with OpenCart latest news feature article</p>
    </div>
  </div>
  <div class=\"container-fluid\">
    <div id=\"category\" class=\"container\">
      <ul class=\"nav navbar-nav\">
        ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["blog_categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["blog_category"]) {
            // line 13
            echo "        ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["blog_category"], "blog_category_id", [], "any", false, false, false, 13), ($context["filter_blog_category_id"] ?? null)))) {
                // line 14
                echo "        <li class=\"active\"><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["blog_category"], "href", [], "any", false, false, false, 14);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["blog_category"], "name", [], "any", false, false, false, 14);
                echo "</a></li>
        ";
            } else {
                // line 16
                echo "        <li><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["blog_category"], "href", [], "any", false, false, false, 16);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["blog_category"], "name", [], "any", false, false, false, 16);
                echo "</a></li>
        ";
            }
            // line 18
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['blog_category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "      </ul>
    </div>
  </div>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-9\">

        ";
        // line 26
        if ((($context["is_search"] ?? null) &&  !($context["has_search_results"] ?? null))) {
            // line 27
            echo "        <h3>Sorry but we couldn't find what you are looking for. Here are our latest posts.</h3>
        <hr />
        ";
        }
        // line 29
        echo "   

        ";
        // line 31
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["blogs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["blog"]) {
            // line 32
            echo "        <div class=\"blog-item\">
          <a href=\"";
            // line 33
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "href", [], "any", false, false, false, 33);
            echo "\"><h2 class=\"blog-title\">";
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "title", [], "any", false, false, false, 33);
            echo "</h2></a>
          <ul class=\"list-unstyled\">
            <li>By <a href=\"";
            // line 35
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "filter_author", [], "any", false, false, false, 35);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "author", [], "any", false, false, false, 35);
            echo "</a></li>
            <li>";
            // line 36
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "date_added", [], "any", false, false, false, 36);
            echo "</li>
            <li>";
            // line 37
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "comment_total", [], "any", false, false, false, 37);
            echo " Comments</li>
          </ul>
          <div class=\"blog-image\"><a href=\"";
            // line 39
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "href", [], "any", false, false, false, 39);
            echo "\"><img src=\"";
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "image", [], "any", false, false, false, 39);
            echo "\" title=\"";
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "title", [], "any", false, false, false, 39);
            echo "\" alt=\"";
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "title", [], "any", false, false, false, 39);
            echo "\" class=\"img-responsive\" /></a></div>
          <div class=\"blog-excerpt\">";
            // line 40
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "description", [], "any", false, false, false, 40);
            echo "</div>
          <a href=\"";
            // line 41
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "href", [], "any", false, false, false, 41);
            echo "\" class=\"btn btn-primary hidden-xs\">Continue Reading</a> <a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["blog"], "href", [], "any", false, false, false, 41);
            echo "\" class=\"btn btn-primary btn-block visible-xs-block\">Continue Reading</a>
        </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['blog'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "
        <div id=\"paypal-banner-ad\">
          <a href=\"index.php?route=cloud/landing\">
            <img src=\"https://image.opencart.com/original/59ae4157d77e2.jpg\" alt=\"\" title=\"\" class=\"img-responsive\" />
          </a>
        </div>

        <nav>";
        // line 51
        echo ($context["pagination"] ?? null);
        echo "</nav>
      </div>
      <div class=\"col-md-3\">
        <div id=\"blog-search\">
          <h4>Search articles</h4>
          <form id=\"form-search\">
            <div class=\"input-group\">
              <input type=\"text\" name=\"filter_search\" value=\"";
        // line 58
        echo ($context["filter_search"] ?? null);
        echo "\" class=\"form-control\" />
              <div class=\"input-group-btn\">
                <button type=\"button\" id=\"button-search\" class=\"btn btn-default btn-xs\"><i class=\"fa fa-search\"></i></button>
              </div>
            </div>
          </form>
        </div>

        <div id=\"paypal-banner-ad\">
          <a href=\"index.php?route=cloud/landing\">
            <img src=\"https://image.opencart.com/original/6aaaf0de522d0.jpg\" alt=\"\" title=\"\" class=\"img-responsive\" />
          </a>
        </div>
        <div id=\"blog-newsletter\">
          <h4>OpenCart Newsletter</h4>
          <div class=\"text-center\">
            <p><img src=\"application/view/image/icon/newsletter-subscribe-icon.png\" class=\"img-responsive\" /></p>
            <p>Subscribe to our newsletters and stay informed of new releases and other OpenCart events.</p>
          </div>
          <div>
            <div class=\"input-group newsletter\">
              <input type=\"text\" name=\"newsletter\" value=\"\" placeholder=\"Enter your email\" class=\"form-control\">
              <div class=\"input-group-btn\">
                <button class=\"btn btn-primary\" type=\"button\"><i class=\"fa fa-angle-right\"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div id=\"side-banner\">";
        // line 86
        echo ($context["banner"] ?? null);
        echo "</div>
        <div id=\"blog-trending\">
          <h4>Trending</h4>
          <ul class=\"list-unstyled\">
            ";
        // line 90
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["trendings"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["trending"]) {
            // line 91
            echo "            <li><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["trending"], "href", [], "any", false, false, false, 91);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["trending"], "title", [], "any", false, false, false, 91);
            echo "</a></li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['trending'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 93
        echo "          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
  <script type=\"text/javascript\"><!--
  \$('#button-search').on('click', function(e) {
  \tvar url = 'index.php?route=cms/blog';

  \tvar filter_search = \$('input[name=\"filter_search\"]').val();

  \tif (filter_search != '') {
  \t\turl += '&filter_search=' + filter_search;
  \t}

  \tlocation = url;
  });

  \$('input[name=\"filter_search\"]').keydown(function(e) {
  \tif (e.keyCode == 13) {
  \t\te.preventDefault();

  \t\t\$('#button-search').trigger('click');
  \t}
  });
  //--></script>
";
        // line 120
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/blog_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  255 => 120,  226 => 93,  215 => 91,  211 => 90,  204 => 86,  173 => 58,  163 => 51,  154 => 44,  143 => 41,  139 => 40,  129 => 39,  124 => 37,  120 => 36,  114 => 35,  107 => 33,  104 => 32,  100 => 31,  96 => 29,  91 => 27,  89 => 26,  80 => 19,  74 => 18,  66 => 16,  58 => 14,  55 => 13,  51 => 12,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/blog_list.twig", "");
    }
}
