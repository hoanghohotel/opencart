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

/* checkout/card.twig */
class __TwigTemplate_37c855c0badbdb2ecb51b4c8c28b38932039634d95fbde25d27395e1d61fe162 extends Template
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
        echo "<fieldset id=\"payment-credit-card\">
\t<legend>Please enter your card details below</legend>
\t<div class=\"form-group\">
\t\t<label for=\"input-card-number\">Credit Card Number</label>
\t\t<div id=\"input-card-number\" class=\"form-control\"></div>
\t</div>
\t<div class=\"row\">
\t\t<div class=\"col-xs-6\">
\t\t\t<div class=\"form-group\">
\t\t\t\t<label>Expire Date</label>
\t\t\t\t<div id=\"input-card-expire\" class=\"row\">
\t\t\t\t\t<div class=\"col-xs-6\">
\t\t\t\t\t\t<div id=\"input-card-expire-year\" class=\"form-control\"></div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-xs-6\">
\t\t\t\t\t\t<div id=\"input-card-expire-month\" class=\"form-control\"></div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t<div class=\"col-xs-6\">
\t\t\t<div class=\"form-group\">
\t\t\t\t<label for=\"input-card-cvv\">CVV</label>
\t\t\t\t<div id=\"input-card-cvv\" class=\"form-control\"></div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"form-group\">
\t\t<label><input type=\"checkbox\" name=\"vault\" value=\"1\" id=\"input-vault\"/> Remember My Card</label>
\t</div>
</fieldset>
<input type=\"hidden\" name=\"nonce\" value=\"\" id=\"input-nonce\"/>
<div class=\"text-right\">
\tI agree with the <a href=\"";
        // line 34
        echo ($context["terms"] ?? null);
        echo "\" target=\"_blank\">terms &amp; conditions</a>&nbsp;&nbsp;<input type=\"checkbox\" name=\"agree\" value=\"1\" id=\"agree\"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
\t<button type=\"button\" id=\"button-continue\" class=\"btn btn-primary btn-lg\">Continue</button>
</div>

<div id=\"fadeLoader\">
\t<div id=\"loader\">Loading...</div>
</div>

<script type=\"text/javascript\"><!--
var form = document.querySelector('#payment-credit-card');
var button = document.querySelector('#button-continue');

function showLoader() {
    \$(\"#fadeLoader\").css(\"display\", \"flex\");
    \$('#loader').css(\"display\", \"flex\");
}

function closeLoader() {
    \$(\"#fadeLoader\").css(\"display\", \"none\");
    \$('#loader').css(\"display\", \"none\");
}

showLoader();

setTimeout(function() {
    closeLoader()
}, 1500)

// Connect to Braintree
braintree.client.create({
    authorization: '";
        // line 64
        echo ($context["client_token"] ?? null);
        echo "'
}, function(clientErr, clientInstance) {
    if (clientErr) {
        // Handle error in client creation
        console.log(clientErr);

        return;
    }

    // Credit card Payment
    var option = {
        client: clientInstance,
        styles: {
            'input': {
                'font-size': '16pt',
                'color': '#3A3A3A'
            },
            '.valid': {
                'color': 'green'
            },
            '.invalid': {
                'font-family': 'monospace'
            }
        },
        fields: {
            number: {
                selector: '#input-card-number',
                placeholder: '**** **** **** ****'
            },
            cvv: {
                selector: '#input-card-cvv',
                placeholder: '***'
            },
            expirationMonth: {
                container: '#input-card-expire-month',
                placeholder: 'Month',
                select: true
            },
            expirationYear: {
                container: '#input-card-expire-year',
                placeholder: 'Year',
                select: true
            }
        }
    };

    var callback = function(hostedFieldsErr, hostedFieldsInstance) {
        if (hostedFieldsErr) {
            console.log(hostedFieldsErr);

            return;
        }

        button.removeAttribute('disabled');

        button.addEventListener('click', function(e) {
            e.preventDefault();

            \$('.alert, .text-danger').remove();

            var state = hostedFieldsInstance.getState();

            var formValid = Object.keys(state.fields).every(function(key) {
                return state.fields[key].isValid;
            });

            hostedFieldsInstance.tokenize(function(tokenizeErr, payload) {
                if (tokenizeErr) {
                    if (tokenizeErr.code == 'HOSTED_FIELDS_FIELDS_EMPTY') {
                        \$('#payment-credit-card').prepend('<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> Credit Card Fields are missing!<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');
                    }

                    if (tokenizeErr.details) {
                        for (i in tokenizeErr.details.invalidFieldKeys) {
                            key = tokenizeErr.details.invalidFieldKeys[i];

                            if (key == 'number') {
                                \$('#input-card-number').after('<div class=\"text-danger\">Credit card number is required</div>');
                            }

                            if (key == 'cvv') {
                                \$('#input-card-cvv').after('<div class=\"text-danger\">Security code required</div>');
                            }

                            if (key == 'expirationDate' || key == 'expirationMonth' || key == 'expirationDate') {
                                \$('#input-card-expire').after('<div class=\"text-danger\">Expiration date required</div>');
                            }
                        }
                    }

                    return;
                } else {
                    \$('#input-nonce').val(payload.nonce);

                    \$.ajax({
                        url: 'index.php?route=checkout/payment/prepare&member_token=";
        // line 159
        echo ($context["member_token"] ?? null);
        echo "&extension_id=";
        echo ($context["extension_id"] ?? null);
        echo "&quantity=";
        echo ($context["quantity"] ?? null);
        echo "&type=card&order_id=";
        echo ($context["order_id"] ?? null);
        echo "',
                        type: 'post',
                        dataType: 'html',
                        data: \$('#input-nonce, input[type=\\'checkbox\\']:checked, select option:selected'),
                        cache: false,
                        beforeSend: function() {
                            \$('#button-continue').button('loading');
                        },
                        complete: function(xhr) {
                            \$('#button-continue').button('reset');

                            if (xhr.status == 401) {
                                location = xhr.getResponseHeader('Location');
                            }
                        },
                        success: function(html) {
                            \$('#modal-checkout .modal-body').html(html);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
                        }
                    });
                }
            });
        }, false);
    }

    braintree.hostedFields.create(option, callback);
});
//--></script>";
    }

    public function getTemplateName()
    {
        return "checkout/card.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  203 => 159,  105 => 64,  72 => 34,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "checkout/card.twig", "");
    }
}
