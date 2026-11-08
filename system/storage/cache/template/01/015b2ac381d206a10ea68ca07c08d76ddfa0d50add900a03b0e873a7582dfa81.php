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

/* checkout/checkout.twig */
class __TwigTemplate_a61d9302f283ae7efddbd95a477137eaef44e4afce402540f8df29ad6adfca5b extends Template
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
        echo "<fieldset>
\t<table class=\"table table-bordered\">
\t\t<thead>
\t\t\t<tr>
\t\t\t\t<th class=\"text-left\">Extension Name</th>
\t\t\t\t<th class=\"text-right\">Quantity</th>
\t\t\t\t<th class=\"text-right\">Total</th>
\t\t\t</tr>
\t\t</thead>
\t\t<tbody>
\t\t\t<tr>
\t\t\t\t<td class=\"text-left\">";
        // line 12
        echo ($context["extension"] ?? null);
        echo "</td>
\t\t\t\t<td class=\"text-right\" style=\"min-width: 90px;\"><select name=\"quantity\" class=\"form-control\">
\t\t\t\t\t\t";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["quantities"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
            // line 15
            echo "\t\t\t\t\t\t\t<option value=\"";
            echo $context["value"];
            echo "\"";
            if ((0 === twig_compare($context["value"], ($context["quantity"] ?? null)))) {
                echo " selected";
            }
            echo ">";
            echo $context["value"];
            echo "</option>
\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "\t\t\t\t\t</select></td>
\t\t\t\t<td class=\"text-right\">";
        // line 18
        echo ($context["total"] ?? null);
        echo "</td>
\t\t\t</tr>
\t\t</tbody>
\t</table>
</fieldset>
<fieldset>
\t<legend>Please choose a payment method below</legend>
\t<div class=\"form-group\">
\t\t<select name=\"payment_method\" class=\"form-control\">
\t\t\t";
        // line 27
        if (($context["vaulted"] ?? null)) {
            // line 28
            echo "\t\t\t\t<optgroup label=\"Stored Payment Methods\">
\t\t\t\t\t";
            // line 29
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["vaulted"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["vault"]) {
                // line 30
                echo "\t\t\t\t\t\t<option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["vault"], "value", [], "any", false, false, false, 30);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["vault"], "text", [], "any", false, false, false, 30);
                echo "</option>
\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['vault'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 32
            echo "\t\t\t\t</optgroup>
\t\t\t";
        }
        // line 34
        echo "\t\t\t";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["payment_methods"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["payment_method"]) {
            // line 35
            echo "\t\t\t\t<option value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["payment_method"], "value", [], "any", false, false, false, 35);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["payment_method"], "text", [], "any", false, false, false, 35);
            echo "</option>
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['payment_method'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 37
        echo "\t\t</select>
\t</div>
</fieldset>
<div class=\"text-right\">
\t<button type=\"button\" id=\"button-continue\" class=\"btn btn-primary\">Continue</button>
</div>
<script type=\"text/javascript\">
\$('select[name=\\'quantity\\']').on('change', function(e) {
    var element = this;

    \$.ajax({
        url: 'index.php?route=checkout/checkout&member_token=";
        // line 48
        echo ($context["member_token"] ?? null);
        echo "&extension_id=";
        echo ($context["extension_id"] ?? null);
        echo "&quantity=' + \$(element).val(),
        dataType: 'html',
        beforeSend: function() {
            \$(element).prop('disabled', true);
        },
        complete: function() {
            \$(element).prop('disabled', false);
        },
        success: function(html) {
            \$('#modal-checkout .modal-body').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

\$('#button-continue').on('click', function(e) {
    var element = this;

    \$.ajax({
        url: \$('select[name=\\'payment_method\\']').val(),
        dataType: 'html',
        beforeSend: function() {
            \$(element).button('loading');
        },
        complete: function(xhr) {
            \$(element).prop('disabled', false);

            if (xhr.status == 401) {
                location = xhr.getResponseHeader('Location');
            }
        },
        success: function(html) {
            //console.log(html);

            \$('#modal-checkout .modal-body').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});
</script>";
    }

    public function getTemplateName()
    {
        return "checkout/checkout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  142 => 48,  129 => 37,  118 => 35,  113 => 34,  109 => 32,  98 => 30,  94 => 29,  91 => 28,  89 => 27,  77 => 18,  74 => 17,  59 => 15,  55 => 14,  50 => 12,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "checkout/checkout.twig", "");
    }
}
