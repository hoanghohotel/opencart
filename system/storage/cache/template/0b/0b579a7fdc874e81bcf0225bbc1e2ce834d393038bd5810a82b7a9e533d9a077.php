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

/* cms/blog_comment.twig */
class __TwigTemplate_fe5d2cd44772653d59da28a673dbb786b6571022062efdf8ebb34222b0b6311a extends Template
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
        if (($context["comments"] ?? null)) {
            // line 2
            echo "  ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["comments"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["comment"]) {
                // line 3
                echo "    <div id=\"comment";
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "blog_comment_id", [], "any", false, false, false, 3);
                echo "\" class=\"media\">
      <div class=\"media-left\"><img src=\"";
                // line 4
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "image", [], "any", false, false, false, 4);
                echo "\" alt=\"";
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "member", [], "any", false, false, false, 4);
                echo "\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "member", [], "any", false, false, false, 4);
                echo "\" class=\"media-object\"/></div>
      <div class=\"media-body\">";
                // line 5
                if (twig_get_attribute($this->env, $this->source, $context["comment"], "remove", [], "any", false, false, false, 5)) {
                    // line 6
                    echo "          <div class=\"pull-right\"><a href=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["comment"], "remove", [], "any", false, false, false, 6);
                    echo "\" class=\"btn btn-link btn-xs comment-remove\">Remove</a></div>
        ";
                }
                // line 8
                echo "        <p class=\"media-heading\">";
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "member", [], "any", false, false, false, 8);
                echo " <span>";
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "date_added", [], "any", false, false, false, 8);
                echo "</span></p>
        <p>";
                // line 9
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "comment", [], "any", false, false, false, 9);
                echo "</p>
        <div class=\"reply\">
          <div class=\"reply-box\">
            <div>
              ";
                // line 13
                if (twig_get_attribute($this->env, $this->source, $context["comment"], "reply", [], "any", false, false, false, 13)) {
                    // line 14
                    echo "
                ";
                    // line 15
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["comment"], "reply", [], "any", false, false, false, 15));
                    foreach ($context['_seq'] as $context["_key"] => $context["reply"]) {
                        // line 16
                        echo "                  <div class=\"media\">
                    <div class=\"media-left\"><img src=\"";
                        // line 17
                        echo twig_get_attribute($this->env, $this->source, $context["reply"], "image", [], "any", false, false, false, 17);
                        echo "\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["reply"], "member", [], "any", false, false, false, 17);
                        echo "\" title=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["reply"], "member", [], "any", false, false, false, 17);
                        echo "\" class=\"media-object\"/></div>
                    <div class=\"media-body\">";
                        // line 18
                        if (twig_get_attribute($this->env, $this->source, $context["reply"], "remove", [], "any", false, false, false, 18)) {
                            // line 19
                            echo "                        <div class=\"pull-right\"><a href=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["reply"], "remove", [], "any", false, false, false, 19);
                            echo "\" class=\"btn btn-link btn-xs reply-remove\">Remove</a></div>
                      ";
                        }
                        // line 21
                        echo "                      <p class=\"media-heading\">";
                        echo twig_get_attribute($this->env, $this->source, $context["reply"], "member", [], "any", false, false, false, 21);
                        echo " <span>";
                        echo twig_get_attribute($this->env, $this->source, $context["reply"], "date_added", [], "any", false, false, false, 21);
                        echo "</span></p>
                      <p>";
                        // line 22
                        echo twig_get_attribute($this->env, $this->source, $context["reply"], "comment", [], "any", false, false, false, 22);
                        echo "</p>
                    </div>
                  </div>
                ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['reply'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 26
                    echo "
                ";
                    // line 27
                    if (twig_get_attribute($this->env, $this->source, $context["comment"], "next", [], "any", false, false, false, 27)) {
                        // line 28
                        echo "                  <div class=\"text-center\"><a href=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["comment"], "next", [], "any", false, false, false, 28);
                        echo "\" class=\"btn btn-block\">see more replies...</a></div>
                ";
                    }
                    // line 30
                    echo "
              ";
                }
                // line 31
                echo " <a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "refresh", [], "any", false, false, false, 31);
                echo "\" class=\"reply-refresh hide\">refresh</a>
            </div>
          </div>
          <p class=\"text-right\"> ";
                // line 34
                if (($context["logged"] ?? null)) {
                    // line 35
                    echo "              <button type=\"button\" data-toggle=\"tooltip\" data-title=\"Reply\" class=\"btn btn-link btn-sm\">Reply</button>
            ";
                } else {
                    // line 37
                    echo "              <button type=\"button\" class=\"btn btn-link btn-xs\" disabled=\"disabled\">Reply</button>
            ";
                }
                // line 38
                echo " </p>
          <div class=\"reply-input-box\" style=\"display: none;\">
            <div class=\"media\">
              <div class=\"media-left\"><img src=\"";
                // line 41
                echo ($context["comment_image"] ?? null);
                echo "\" alt=\"";
                echo ($context["comment_username"] ?? null);
                echo "\" title=\"";
                echo ($context["comment_username"] ?? null);
                echo "\" class=\"media-object\"/></div>
              <div class=\"media-body\">
                <div class=\"form-group\">
                  <label for=\"input-comment";
                // line 44
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "blog_comment_id", [], "any", false, false, false, 44);
                echo "\">Leave your comment</label> <textarea name=\"comment\" placeholder=\"Write your comment here...\" id=\"input-comment";
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "blog_comment_id", [], "any", false, false, false, 44);
                echo "\" class=\"form-control\"></textarea>
                </div>
                <div class=\"text-right\"><a href=\"";
                // line 46
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "add", [], "any", false, false, false, 46);
                echo "\" class=\"btn btn-primary btn-sm\">Comment</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['comment'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 54
            echo "  <br/>
  <div class=\"text-center\">";
            // line 55
            echo ($context["pagination"] ?? null);
            echo "</div>
";
        }
        // line 56
        echo " 
";
    }

    public function getTemplateName()
    {
        return "cms/blog_comment.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  200 => 56,  195 => 55,  192 => 54,  178 => 46,  171 => 44,  161 => 41,  156 => 38,  152 => 37,  148 => 35,  146 => 34,  139 => 31,  135 => 30,  129 => 28,  127 => 27,  124 => 26,  114 => 22,  107 => 21,  101 => 19,  99 => 18,  91 => 17,  88 => 16,  84 => 15,  81 => 14,  79 => 13,  72 => 9,  65 => 8,  59 => 6,  57 => 5,  49 => 4,  44 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "cms/blog_comment.twig", "");
    }
}
