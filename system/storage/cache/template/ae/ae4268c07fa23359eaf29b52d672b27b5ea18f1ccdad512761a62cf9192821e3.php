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

/* marketplace/extension_comment.twig */
class __TwigTemplate_26edf2c7fb47712b1547afc2dbe827a1c97966288282b374a556678dba3855c3 extends Template
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
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "extension_comment_id", [], "any", false, false, false, 3);
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
            <div class=\"reply-page\">";
                // line 14
                if (twig_get_attribute($this->env, $this->source, $context["comment"], "reply", [], "any", false, false, false, 14)) {
                    // line 15
                    echo "                ";
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
                    echo "                ";
                    if (twig_get_attribute($this->env, $this->source, $context["comment"], "next", [], "any", false, false, false, 26)) {
                        // line 27
                        echo "                  <div class=\"text-center\"><a href=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["comment"], "next", [], "any", false, false, false, 27);
                        echo "\" class=\"btn btn-lg btn-block\">see more replies...</a></div>
                ";
                    }
                    // line 29
                    echo "              ";
                }
                // line 30
                echo "              <a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "refresh", [], "any", false, false, false, 30);
                echo "\" class=\"reply-refresh hide\">refresh</a>
            </div>
          </div>



          <p class=\"text-right\">";
                // line 36
                if (($context["logged"] ?? null)) {
                    // line 37
                    echo "              <button type=\"button\" data-toggle=\"tooltip\" data-title=\"Reply\" class=\"btn btn-link btn-sm\">Reply</button>
            ";
                } else {
                    // line 39
                    echo "              <button type=\"button\" class=\"btn btn-link btn-xs\" disabled=\"disabled\">Reply</button>
            ";
                }
                // line 40
                echo "</p>
          <div class=\"reply-input-box\" style=\"display: none;\">
            <div class=\"media\">
              <div class=\"media-left\"><img src=\"";
                // line 43
                echo ($context["comment_image"] ?? null);
                echo "\" alt=\"";
                echo ($context["comment_username"] ?? null);
                echo "\" title=\"";
                echo ($context["comment_username"] ?? null);
                echo "\" class=\"media-object\"/></div>
              <div class=\"media-body\">
                <div class=\"form-group\">
                  <label for=\"input-comment";
                // line 46
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "extension_comment_id", [], "any", false, false, false, 46);
                echo "\">Leave your comment</label>
                  <textarea name=\"comment\" placeholder=\"Write your comment here...\" id=\"input-comment";
                // line 47
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "extension_comment_id", [], "any", false, false, false, 47);
                echo "\" class=\"form-control\"></textarea>
                </div>
                <div class=\"text-right\"><a href=\"";
                // line 49
                echo twig_get_attribute($this->env, $this->source, $context["comment"], "add", [], "any", false, false, false, 49);
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
            // line 57
            echo "  <br/>
  <div class=\"text-center\">";
            // line 58
            echo ($context["pagination"] ?? null);
            echo "</div>
";
        }
        // line 59
        echo " ";
    }

    public function getTemplateName()
    {
        return "marketplace/extension_comment.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  201 => 59,  196 => 58,  193 => 57,  179 => 49,  174 => 47,  170 => 46,  160 => 43,  155 => 40,  151 => 39,  147 => 37,  145 => 36,  135 => 30,  132 => 29,  126 => 27,  123 => 26,  113 => 22,  106 => 21,  100 => 19,  98 => 18,  90 => 17,  87 => 16,  82 => 15,  80 => 14,  72 => 9,  65 => 8,  59 => 6,  57 => 5,  49 => 4,  44 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "marketplace/extension_comment.twig", "");
    }
}
