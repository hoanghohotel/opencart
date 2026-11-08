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

/* marketplace/extension_info.twig */
class __TwigTemplate_7f9ea0d6183d3a882b596a98f8a5ac79c3fb60a88f97d776eac5cb53b931d6fe extends Template
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
<div id=\"marketplace-extension-info\">
\t<div class=\"container-fluid\">
\t\t<div class=\"container\">
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-md-8\">
\t\t\t\t\t<ul class=\"breadcrumb\">
\t\t\t\t\t\t";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 9
            echo "\t\t\t\t\t\t\t<li><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 9);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 9);
            echo "</a></li>
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        echo "\t\t\t\t\t</ul>
\t\t\t\t</div>
\t\t\t\t<div class=\"col-md-4\">
\t\t\t\t\t<div id=\"extension-search\" class=\"input-group\">
\t\t\t\t\t\t<input type=\"text\" name=\"filter_search\" value=\"";
        // line 15
        echo ($context["filter_search"] ?? null);
        echo "\" placeholder=\"Search for extensions and themes\" class=\"form-control\"> <input type=\"hidden\" name=\"filter_category_id\" value=\"";
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
\t\t\t\t\t\t<div class=\"input-group-btn\">
\t\t\t\t\t\t\t<button type=\"button\" id=\"button-search\" class=\"btn btn-link\"><i class=\"fa fa-search\"></i></button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container\">
\t\t<h3>";
        // line 25
        echo ($context["name"] ?? null);
        echo "</h3>
\t\t<div class=\"row\">
\t\t\t<div class=\"col-md-8\">
\t\t\t\t";
        // line 28
        if (($context["banner"] ?? null)) {
            // line 29
            echo "\t\t\t\t\t<div class=\"well\"><img src=\"";
            echo ($context["banner"] ?? null);
            echo "\" alt=\"";
            echo ($context["name"] ?? null);
            echo "\" title=\"";
            echo ($context["name"] ?? null);
            echo "\" class=\"img-responsive\"/></div>
\t\t\t\t";
        }
        // line 31
        echo "\t\t\t\t";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_array_batch(($context["images"] ?? null), 6));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 32
            echo "\t\t\t\t\t<div class=\"row\">";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["row"]);
            foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
                // line 33
                echo "\t\t\t\t\t\t\t";
                if ($context["image"]) {
                    // line 34
                    echo "\t\t\t\t\t\t\t\t<div class=\"col-xs-4 col-sm-2 col-md-2\"><a href=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["image"], "popup", [], "any", false, false, false, 34);
                    echo "\" class=\"thumbnail\" data-lightbox=\"lightbox-thumbnail\"><img src=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["image"], "thumb", [], "any", false, false, false, 34);
                    echo "\" alt=\"\" title=\"\" class=\"img-responsive\"/></a></div>
\t\t\t\t\t\t\t";
                }
                // line 36
                echo "\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['image'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo "</div>
\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 38
        echo "\t\t\t\t<div>";
        echo ($context["description"] ?? null);
        echo "</div>
\t\t\t\t";
        // line 39
        if ((($context["reviews"] ?? null) && ($context["reviews_enabled"] ?? null))) {
            // line 40
            echo "\t\t\t\t\t<div class=\"extension-review\">
\t\t\t\t\t\t<h3 class=\"text-center\">What customers say about ";
            // line 41
            echo ($context["name"] ?? null);
            echo "</h3>
\t\t\t\t\t\t";
            // line 42
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["reviews"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["review"]) {
                // line 43
                echo "\t\t\t\t\t\t\t<div class=\"media\">
\t\t\t\t\t\t\t\t<div class=\"media-left\"><img src=\"";
                // line 44
                echo twig_get_attribute($this->env, $this->source, $context["review"], "image", [], "any", false, false, false, 44);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["review"], "member", [], "any", false, false, false, 44);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["review"], "member", [], "any", false, false, false, 44);
                echo "\" class=\"media-object\"/></div>
\t\t\t\t\t\t\t\t<div class=\"media-body\">";
                // line 45
                echo twig_get_attribute($this->env, $this->source, $context["review"], "comment", [], "any", false, false, false, 45);
                echo "
\t\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t\t<em>~";
                // line 47
                echo twig_get_attribute($this->env, $this->source, $context["review"], "member", [], "any", false, false, false, 47);
                echo "</em></div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['review'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 50
            echo "\t\t\t\t\t</div>
\t\t\t\t";
        }
        // line 52
        echo "\t\t\t\t<br/>
\t\t\t\t<br/>
                ";
        // line 54
        if (($context["comments_enabled"] ?? null)) {
            // line 55
            echo "\t\t\t\t<div id=\"comment-input-box\">
\t\t\t\t\t";
            // line 56
            if ( !($context["logged"] ?? null)) {
                // line 57
                echo "\t\t\t\t\t\t<div class=\"login-layer\">
\t\t\t\t\t\t\t<p>Login and write down your comment.</p>
\t\t\t\t\t\t\t<p><a href=\"";
                // line 59
                echo ($context["login"] ?? null);
                echo "\" class=\"btn btn-primary\">Login my OpenCart Account</a></p>
\t\t\t\t\t\t</div>
\t\t\t\t\t";
            }
            // line 62
            echo "\t\t\t\t\t<div class=\"media\">
\t\t\t\t\t\t<div class=\"media-left\"><img src=\"";
            // line 63
            echo ($context["comment_image"] ?? null);
            echo "\" alt=\"";
            echo ($context["comment_username"] ?? null);
            echo "\" title=\"";
            echo ($context["comment_username"] ?? null);
            echo "\" class=\"media-object\"/></div>
\t\t\t\t\t\t<div class=\"media-body\">
\t\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t\t<label for=\"input-comment\">Leave your comment</label> <textarea name=\"comment\" placeholder=\"Write your comment here...\" id=\"input-comment\" class=\"form-control\"></textarea>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"text-right\">
\t\t\t\t\t\t\t\t<button type=\"button\" id=\"button-comment\" class=\"btn btn-primary btn-sm\">Comment</button>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<br/>
\t\t\t\t<div id=\"comment-box\"></div>
                ";
        }
        // line 77
        echo "\t\t\t\t<br/>
\t\t\t</div>
\t\t\t<div class=\"col-md-4\">
\t\t\t\t<div id=\"buy\" class=\"well\">";
        // line 80
        if (($context["download"] ?? null)) {
            echo "<a href=\"";
            echo ($context["download"] ?? null);
            echo "\" class=\"btn btn-success btn-lg btn-block\">Download</a>";
        } else {
            echo "<button type=\"button\" id=\"button-purchase\" class=\"btn btn-success btn-lg btn-block\">Buy</button>";
        }
        // line 81
        echo "\t\t\t\t\t";
        if (($context["license"] ?? null)) {
            // line 82
            echo "\t\t\t\t\t\t<div id=\"price\" class=\"row\">
\t\t\t\t\t\t\t<div class=\"col-xs-5\"><strong>Price</strong></div>
\t\t\t\t\t\t\t<div class=\"col-xs-7 text-right\">";
            // line 84
            echo ($context["price"] ?? null);
            echo "</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t";
        }
        // line 87
        echo "\t\t\t\t\t<hr/>
\t\t\t\t\t<ul class=\"list-check\">
\t\t\t\t\t\t";
        // line 89
        if (($context["partner_status"] ?? null)) {
            // line 90
            echo "\t\t\t\t\t\t\t<li>Developed by OpenCart Partner</li>
\t\t\t\t\t\t";
        } else {
            // line 92
            echo "\t\t\t\t\t\t\t<li>Developed by OpenCart Community</li>
\t\t\t\t\t\t";
        }
        // line 94
        echo "\t\t\t\t\t\t";
        if (($context["license_period"] ?? null)) {
            // line 95
            echo "\t\t\t\t\t\t\t<li>";
            echo ($context["license_period"] ?? null);
            echo " Months Free Support</li>
\t\t\t\t\t\t";
        }
        // line 97
        echo "\t\t\t\t\t\t<li>Documentation Included</li>
                        ";
        // line 98
        if (($context["recommended"] ?? null)) {
            // line 99
            echo "\t\t\t\t\t\t\t<img class=\"recommended-label\" src=\"application/view/image/marketplace/recommended-label.svg\"/>
\t\t\t\t\t\t";
        }
        // line 101
        echo "\t\t\t\t\t</ul>
\t\t\t\t\t<hr/>
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-xs-5\"><strong>Rating</strong></div>
\t\t\t\t\t\t<div class=\"col-xs-7\">
\t\t\t\t\t\t\t";
        // line 106
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range(1, 5));
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 107
            echo "\t\t\t\t\t\t\t\t";
            if ((0 <= twig_compare(($context["rating"] ?? null), $context["i"]))) {
                echo "<i class=\"opencart-icon-star-light\"></i>";
            } else {
                echo "<i class=\"opencart-icon-star-light-o\"></i>";
            }
            // line 108
            echo "\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 109
        echo "\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<hr/>
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-xs-5\"><strong>Compatibility</strong></div>
\t\t\t\t\t\t<div class=\"col-xs-7\">";
        // line 114
        echo ($context["compatibility"] ?? null);
        echo "</div>
\t\t\t\t\t</div>
\t\t\t\t\t<hr/>
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-xs-5\"><strong>Last Update</strong></div>
\t\t\t\t\t\t<div class=\"col-xs-7\">";
        // line 119
        echo ($context["date_modified"] ?? null);
        echo "</div>
\t\t\t\t\t</div>
\t\t\t\t\t<hr/>
\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t<div class=\"col-xs-5\"><strong>Created</strong></div>
\t\t\t\t\t\t<div class=\"col-xs-7\">";
        // line 124
        echo ($context["date_added"] ?? null);
        echo "</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div id=\"sales\" class=\"well\">
\t\t\t\t\t";
        // line 128
        if (($context["license"] ?? null)) {
            // line 129
            echo "\t\t\t\t\t\t<i class=\"opencart-icon-cart-mini\"></i> <strong>";
            echo ($context["sales"] ?? null);
            echo "</strong> Sales
\t\t\t\t\t";
        } else {
            // line 131
            echo "\t\t\t\t\t\t<i class=\"fa fa-cloud-download\"></i> <strong>";
            echo ($context["downloaded"] ?? null);
            echo "</strong> Downloads
\t\t\t\t\t";
        }
        // line 132
        echo "</div>
\t\t\t\t<div id=\"comment\" class=\"well\"><i class=\"opencart-icon-comment\"></i> <strong>";
        // line 133
        echo ($context["comment_total"] ?? null);
        echo "</strong> Comments</div>
\t\t\t\t<div id=\"comment\" class=\"well text-center\">
                    <div class=\"fb-share-button\" data-href=\"";
        // line 135
        echo ($context["url"] ?? null);
        echo "\" data-layout=\"button\" data-size=\"large\"><a target=\"_blank\" href=\"https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse\" class=\"fb-xfbml-parse-ignore\">Share</a></div>
                </div>
\t\t\t\t<div class=\"well\">
\t\t\t\t\t<div class=\"media\">
\t\t\t\t\t\t<div class=\"media-left media-middle\"><img src=\"";
        // line 139
        echo ($context["member_image"] ?? null);
        echo "\" alt=\"";
        echo ($context["member_username"] ?? null);
        echo "\" title=\"";
        echo ($context["member_username"] ?? null);
        echo "\" class=\"media-object img-circle\"/></div>
\t\t\t\t\t\t<div class=\"media-body\"><span>";
        // line 140
        echo ($context["member_username"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t<small>Member since: ";
        // line 142
        echo ($context["member_date_added"] ?? null);
        echo "</small>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<br/>
\t\t\t\t\t<a href=\"";
        // line 146
        echo ($context["filter_member"] ?? null);
        echo "\" class=\"btn btn-primary btn-lg btn-block\">View all extensions</a> <a href=\"";
        echo ($context["support"] ?? null);
        echo "\" class=\"btn btn-ghost-dark btn-lg btn-block\">Get Support</a></div>
\t\t\t</div>
\t\t</div>
\t</div>
</div>
<script type=\"text/javascript\"><!--
\$('#button-search').on('click', function(e) {
    var url = 'index.php?route=marketplace/extension';

    var input = \$('#extension-search :input');

    for (i = 0; i < input.length; i++) {
        if (\$(input[i]).val() != '' && \$(input[i]).val() != null) {
            url += '&' + \$(input[i]).attr('name') + '=' + \$(input[i]).val()
        }
    }

    location = url;
});

\$('input[name=\\'filter_search\\']').keydown(function(e) {
    if (e.keyCode == 13) {
        e.preventDefault();

        \$('#button-search').trigger('click');
    }
});
//--></script>
<script type=\"text/javascript\"><!--
\$('#button-purchase').on('click', function() {
    var element = this;

    \$('#modal-checkout').remove();

    \$.ajax({
        url: 'index.php?route=checkout/checkout&extension_id=";
        // line 181
        echo ($context["extension_id"] ?? null);
        if (($context["member_token"] ?? null)) {
            echo "&member_token=";
            echo ($context["member_token"] ?? null);
        }
        echo "',
        dataType: 'html',
        beforeSend: function() {
            \$(element).prop('disabled', true);
        },
        complete: function(xhr, status) {
            \$(element).prop('disabled', false);

            if (xhr.status == 401) {
                location = xhr.getResponseHeader('Location');
            }
        },
        success: function(html) {
            string = '<div id=\"modal-checkout\" class=\"modal\">';
            string += '  <div class=\"modal-dialog\">';
            string += '    <div class=\"modal-content\">';
            string += '      <div class=\"modal-header\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button><h5 class=\"modal-title\">Buy an extension license</h5></div>';
            string += '      <div class=\"modal-body\">' + html + '</div>';
            string += '    </div>';
            string += '  </div>';
            string += '</div>';

            \$('body').append(string);

            \$('#modal-checkout').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {

        }
    });
});

";
        // line 213
        if (($context["logged"] ?? null)) {
            // line 214
            echo "let searchParams = new URLSearchParams(window.location.search);

if (searchParams.has('purchase')) {
    \$('#button-purchase').trigger('click', function() {
    });
}
";
        }
        // line 221
        echo "


//Start
\$('#comment-box').load('index.php?route=marketplace/extension/comment&extension_id=";
        // line 225
        echo ($context["extension_id"] ?? null);
        echo "');

// Page
\$('#comment-box').on('click', '.pagination a', function(e) {
    e.preventDefault();

    \$('#comment-box').load(this.href);
});

";
        // line 234
        if (($context["logged"] ?? null)) {
            // line 235
            echo "// Add comment
\$('#button-comment').on('click', function() {
    \$.ajax({
        url: 'index.php?route=marketplace/extension/addcomment&member_token=";
            // line 238
            echo ($context["member_token"] ?? null);
            echo "&extension_id=";
            echo ($context["extension_id"] ?? null);
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

                \$('#comment-box').load('index.php?route=marketplace/extension/comment&extension_id=";
            // line 258
            echo ($context["extension_id"] ?? null);
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
        // line 269
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
            \$(element).parentsUntil('.reply-page').parent().after(html);

            \$(element).remove();
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
        // line 399
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "marketplace/extension_info.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  683 => 399,  551 => 269,  537 => 258,  512 => 238,  507 => 235,  505 => 234,  493 => 225,  487 => 221,  478 => 214,  476 => 213,  437 => 181,  397 => 146,  390 => 142,  385 => 140,  377 => 139,  370 => 135,  365 => 133,  362 => 132,  356 => 131,  350 => 129,  348 => 128,  341 => 124,  333 => 119,  325 => 114,  318 => 109,  312 => 108,  305 => 107,  301 => 106,  294 => 101,  290 => 99,  288 => 98,  285 => 97,  279 => 95,  276 => 94,  272 => 92,  268 => 90,  266 => 89,  262 => 87,  256 => 84,  252 => 82,  249 => 81,  241 => 80,  236 => 77,  215 => 63,  212 => 62,  206 => 59,  202 => 57,  200 => 56,  197 => 55,  195 => 54,  191 => 52,  187 => 50,  178 => 47,  173 => 45,  165 => 44,  162 => 43,  158 => 42,  154 => 41,  151 => 40,  149 => 39,  144 => 38,  132 => 36,  124 => 34,  121 => 33,  116 => 32,  111 => 31,  101 => 29,  99 => 28,  93 => 25,  68 => 15,  62 => 11,  51 => 9,  47 => 8,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "marketplace/extension_info.twig", "");
    }
}
