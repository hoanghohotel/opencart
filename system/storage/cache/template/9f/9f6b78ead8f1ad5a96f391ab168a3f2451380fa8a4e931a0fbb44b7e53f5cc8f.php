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

/* cms/blog_info.twig */
class __TwigTemplate_24e0799105922f4decba6e59dbe4c48b0c1c644cdfca0d5b27e9cc638ca6b2cf extends Template
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
<div id=\"cms-blog-info\">
  <div class=\"container-fluid\">
    <div id=\"category\" class=\"container\">
      <ul class=\"nav navbar-nav\">
        ";
        // line 6
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["blog_categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["blog_category"]) {
            // line 7
            echo "          ";
            if ((0 === twig_compare(twig_get_attribute($this->env, $this->source, $context["blog_category"], "blog_category_id", [], "any", false, false, false, 7), ($context["filter_blog_category_id"] ?? null)))) {
                // line 8
                echo "            <li class=\"active\"><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["blog_category"], "href", [], "any", false, false, false, 8);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["blog_category"], "name", [], "any", false, false, false, 8);
                echo "</a></li>
          ";
            } else {
                // line 10
                echo "            <li><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["blog_category"], "href", [], "any", false, false, false, 10);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["blog_category"], "name", [], "any", false, false, false, 10);
                echo "</a></li>
          ";
            }
            // line 12
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['blog_category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "      </ul>
    </div>
  </div>
  <div class=\"container\">
    <div class=\"row\">
      <div class=\"col-md-9\">
        <div class=\"blog-item\">
          <section>
            <h2>";
        // line 21
        echo ($context["title"] ?? null);
        echo "</h2>

            <div class=\"pull-right socials\">
              <div class=\"btn-group btn-group-justified visible-xs-block\"><a href=\"https://www.facebook.com/opencart/\" id=\"share-facebook\" class=\"btn btn-facebook\"><i class=\"opencart-icon-social-facebook\"></i> Facebook</a> <a href=\"https://twitter.com/opencart\" id=\"share-twitter\" class=\"btn btn-twitter\"><i class=\"opencart-icon-social-twitter\"></i> Twitter</a></div>
              <div class=\"hidden-xs\"><a href=\"https://www.facebook.com/opencart/\" id=\"share-facebook\" class=\"btn btn-facebook\"><i class=\"opencart-icon-social-facebook\"></i> Facebook</a> <a href=\"https://twitter.com/opencart\" id=\"share-twitter\" class=\"btn btn-twitter\"><i class=\"opencart-icon-social-twitter\"></i> Twitter</a></div>
            </div>
            <ul class=\"list-unstyled\">
              <li>By <a href=\"";
        // line 28
        echo ($context["filter_author"] ?? null);
        echo "\">";
        echo ($context["author"] ?? null);
        echo "</a></li>
              <li>";
        // line 29
        echo ($context["date_added"] ?? null);
        echo "</li>
              <li><a onclick=\"document.getElementById('comment-box').scrollIntoView(true);\" href=\"javascript:void(0);\">";
        // line 30
        echo ($context["comment_total"] ?? null);
        echo " comments</a></li>
            </ul>

            ";
        // line 33
        if ((0 === twig_compare(($context["image_status"] ?? null), 1))) {
            // line 34
            echo "              <figure><img src=\"";
            echo ($context["image"] ?? null);
            echo "\" class=\"img-responsive\"/></figure>
            ";
        }
        // line 36
        echo "
            <div class=\"main\">";
        // line 37
        echo ($context["description"] ?? null);
        echo "</div>
            <div class=\"btn-group btn-group-justified visible-xs-block\"><a href=\"https://www.facebook.com/opencart/\" id=\"share-facebook\" class=\"btn btn-facebook\"><i class=\"opencart-icon-social-facebook\"></i> Facebook</a> <a href=\"https://twitter.com/opencart\" id=\"share-twitter\" class=\"btn btn-twitter\"><i class=\"opencart-icon-social-twitter\"></i> Twitter</a> <a href=\"https://www.reddit.com/r/opencart/\" id=\"share-reddit\" class=\"btn btn-reddit\"><i class=\"opencart-icon-social-reddit\"></i> Reddit</a></div>
            <div id=\"social-button\" class=\"hidden-xs\"><a href=\"https://www.facebook.com/opencart/\" id=\"share-facebook\" class=\"btn btn-facebook\"><i class=\"opencart-icon-social-facebook\"></i> Facebook</a> <a href=\"https://twitter.com/opencart\" id=\"share-twitter\" class=\"btn btn-twitter\"><i class=\"opencart-icon-social-twitter\"></i> Twitter</a> <a href=\"https://www.reddit.com/r/opencart/\" id=\"share-reddit\" class=\"btn btn-reddit\"><i class=\"opencart-icon-social-reddit\"></i> Reddit</a></div>
          </section>
          <section>
            <div id=\"blog-newsletter-bottom\" class=\"newsletter\">
              <h4>OpenCart Newsletter</h4>
              <div class=\"text-center\">
                <p><img src=\"application/view/image/icon/newsletter-subscribe-icon.png\" class=\"img-responsive\"/></p>
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
          </section>
        </div>
        <div id=\"comment-input-box\">";
        // line 59
        if ( !($context["logged"] ?? null)) {
            // line 60
            echo "            <div class=\"login-layer\">
              <p>Login and write down your comment.</p>
              <p><a href=\"";
            // line 62
            echo ($context["login"] ?? null);
            echo "\" class=\"btn btn-primary\">Login my OpenCart Account</a></p>
            </div>
          ";
        }
        // line 65
        echo "          <div class=\"media\">
            <div class=\"media-left\"><img src=\"";
        // line 66
        echo ($context["comment_image"] ?? null);
        echo "\" alt=\"";
        echo ($context["comment_username"] ?? null);
        echo "\" title=\"";
        echo ($context["comment_username"] ?? null);
        echo "\" class=\"media-object\"/></div>
            <div class=\"media-body\">
              <div class=\"form-group\">
                <label for=\"input-comment\">Leave your comment</label> <textarea name=\"comment\" placeholder=\"Write your comment here...\" id=\"input-comment\" class=\"form-control\"></textarea>
              </div>
              <div class=\"text-right\">
                <button type=\"button\" id=\"button-comment\" class=\"btn btn-primary btn-sm\">Comment</button>
              </div>
            </div>
          </div>
        </div>
        <br/>
        <div id=\"comment-box\"></div>
        <br/>
      </div>
      <div class=\"col-md-3\">
        <div id=\"blog-search\">
          <h4>Search articles</h4>
          <form id=\"form-search\">
            <div class=\"input-group\">
              <input type=\"text\" name=\"filter_search\" value=\"";
        // line 86
        echo ($context["filter_search"] ?? null);
        echo "\" class=\"form-control\"/>
              <div class=\"input-group-btn\">
                <button type=\"button\" id=\"button-search\" class=\"btn btn-default btn-xs\"><i class=\"fa fa-search\"></i></button>
              </div>
            </div>
          </form>
        </div>
        <div id=\"blog-newsletter\">
          <h4>OpenCart Newsletter</h4>
          <div class=\"text-center\">
            <p><img src=\"application/view/image/icon/newsletter-subscribe-icon.png\" class=\"img-responsive\"/></p>
            <p>Subscribe to our newsletters and stay informed of new releases and other OpenCart events.</p>
          </div>
          <div>
            <div class=\"input-group newsletter\">
              <input type=\"text\" name=\"newsletter\" value=\"\" placeholder=\"Enter your email\" class=\"form-control\"/>
              <div class=\"input-group-btn\">
                <button type=\"button\" class=\"btn btn-primary\"><i class=\"fa fa-angle-right\"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div id=\"side-banner\">";
        // line 108
        echo ($context["banner"] ?? null);
        echo "</div>
        <div id=\"blog-trending\">
          <h4>Trending</h4>
          <ul class=\"list-unstyled\">
            ";
        // line 112
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["trendings"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["trending"]) {
            // line 113
            echo "              <li><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["trending"], "href", [], "any", false, false, false, 113);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["trending"], "title", [], "any", false, false, false, 113);
            echo "</a></li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['trending'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 115
        echo "          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<script type=\"text/javascript\"><!--
\$('#button-search').on('click', function(e) {
    var url = 'index.php?route=cms/blog';

    var filter_search = \$('input[name=\"filter_search\"]').val();

    if (filter_search != '') {
        url += '&filter_search=' + filter_search;
    }

    location = url;
});

\$('input[name=\"filter_search\"]').keydown(function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();

        \$('#button-search').trigger('click');
    }
});
//--></script>
<script type=\"text/javascript\"><!--


//Start
\$('#comment-box').load('index.php?route=cms/blog/comment&blog_id=";
        // line 146
        echo ($context["blog_id"] ?? null);
        echo "');

// Page
\$('#comment-box').on('click', '.pagination a', function(e) {
    e.preventDefault();

    \$('#comment-box').load(this.href);
});

";
        // line 155
        if (($context["logged"] ?? null)) {
            // line 156
            echo "// Add comment
\$('#button-comment').on('click', function() {
    \$.ajax({
        url: 'index.php?route=cms/blog/addcomment&member_token=";
            // line 159
            echo ($context["member_token"] ?? null);
            echo "&blog_id=";
            echo ($context["blog_id"] ?? null);
            echo "',
        type: 'post',
        dataType: 'json',
        data: 'comment=' + encodeURIComponent(\$('textarea[name=\\'comment\\']').val()),
        beforeSend: function() {
            \$('#button-comment').button('loading');
        },
        complete: function() {
            \$('#button-comment').button('reset');
        },
        success: function(json) {
            \$('.alert').remove();

            if (json['error']) {
                \$('#comment-input-box').before('<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ' + json['error'] + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }

            if (json['success']) {
                \$('#comment-input-box').before('<div class=\"alert alert-success\"><i class=\"fa fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');

                \$('#comment-box').load('index.php?route=cms/blog/comment&blog_id=";
            // line 179
            echo ($context["blog_id"] ?? null);
            echo "');

                \$('textarea[name=\\'comment\\']').val('');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});
";
        }
        // line 190
        echo "
// Next replies
\$('#comment-box').on('click', '.btn-block', function(e) {
    e.preventDefault();

    var element = this;

    \$.ajax({
        url: \$(element).attr('href'),
        dataType: 'html',
        beforeSend: function() {
            \$(element).button('loading');
        },
        complete: function() {
            \$(element).button('reset');
        },
        success: function(html) {
            \$(element).parent().parent().parent().append(html);
            \$(element).parent().remove();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

// Reply
\$('#comment-box').on('click', '.btn-link', function(e) {
    e.preventDefault();

    \$(this).parent().parent().find('.reply-input-box').toggle();
});

// Add reply
\$('#comment-box').on('click', '.btn-primary', function(e) {
    e.preventDefault();

    var element = this;

    \$.ajax({
        url: \$(element).attr('href'),
        type: 'post',
        dataType: 'json',
        data: 'comment=' + encodeURIComponent(\$(element).parents('.reply-input-box').find('textarea[name=\\'comment\\']').val()),
        beforeSend: function() {
            \$(element).button('loading');
        },
        complete: function() {
            \$(element).button('reset');
        },
        success: function(json) {
            \$('.alert').remove();

            if (json['error']) {
                \$(element).parents('.reply-input-box').before('<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ' + json['error'] + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }

            if (json['success']) {
                \$(element).parents('.reply-input-box').before('<div class=\"alert alert-success\"><i class=\"fa fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');

                \$(element).parents('.reply-input-box').parents('.media').find('.reply-refresh').last().trigger('click');

                \$(element).parents('.reply-input-box').find('textarea[name=\\'comment\\']').val('');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

// Remove
\$('#comment-box').on('click', '.comment-remove, .reply-remove', function(e) {
    e.preventDefault();

    var element = this;

    \$.ajax({
        url: \$(element).attr('href'),
        dataType: 'json',
        beforeSend: function() {
            \$(element).button('loading');
        },
        complete: function() {
            \$(element).button('reset');
        },
        success: function(json) {
            \$('.alert').remove();

            if (json['error']) {
                \$(element).parent().before('<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ' + json['error'] + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
            }

            if (json['success']) {
                \$(element).parent().before('<div class=\"alert alert-success\"><i class=\"fa fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');

                \$(element).parents('.media:first').remove();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

// Refresh
\$('#comment-box').on('click', '.reply-refresh', function(e) {
    e.preventDefault();

    var element = this;

    \$.ajax({
        url: \$(element).attr('href'),
        dataType: 'html',
        beforeSend: function() {
            \$(element).button('loading');
        },
        complete: function() {
            \$(element).button('reset');
        },
        success: function(html) {
            \$(element).parent().replaceWith(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});
//--></script>
";
        // line 319
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "cms/blog_info.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  457 => 319,  326 => 190,  312 => 179,  287 => 159,  282 => 156,  280 => 155,  268 => 146,  235 => 115,  224 => 113,  220 => 112,  213 => 108,  188 => 86,  161 => 66,  158 => 65,  152 => 62,  148 => 60,  146 => 59,  121 => 37,  118 => 36,  112 => 34,  110 => 33,  104 => 30,  100 => 29,  94 => 28,  84 => 21,  74 => 13,  68 => 12,  60 => 10,  52 => 8,  49 => 7,  45 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/blog_info.twig", "");
    }
}
