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

/* support/contact.twig */
class __TwigTemplate_61541372de032efb15dd07f5dc07fca5dcbd932bf6f8d4324795223c7afbbe53 extends Template
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
<div id=\"support-contact\">
\t<div class=\"page-header\">
\t\t<div class=\"container\">
\t\t\t<h1>Contact Us</h1>
\t\t\t<p>Stay connected with us</p>
\t\t</div>
\t</div>
\t<div class=\"container\">
\t\t<div class=\"row\">
\t\t\t<div id=\"support-contact\" class=\"col-md-8\">
\t\t\t\t<div class=\"alert alert-info\"><i class=\"fa fa-info-circle\"></i> Please provide as much information <u>in the form below</u> for our agents to be able to assist you.
\t\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t\t\t</div>
\t\t\t\t<div class=\"form-group required\">
\t\t\t\t\t<label for=\"input-reason\">How can we help you?</label> <select name=\"reason\" id=\"input-reason\" class=\"form-control\">
\t\t\t\t\t\t<option value=\"\"></option>
\t\t\t\t\t\t<option value=\"account\">I would like to report an account issue</option>
\t\t\t\t\t\t<option value=\"order\">I would like to report an order issue</option>
\t\t\t\t\t\t<option value=\"partner\">I have a partnership question</option>
\t\t\t\t\t\t<option value=\"fraud\">I want to report a fraudulent extension</option>
\t\t\t\t\t\t<option value=\"support\">I am experiencing technical issues</option>
\t\t\t\t\t\t<option value=\"other\">I would like to report a quality assurance policy ticket</option>
\t\t\t\t\t</select>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-5\">
\t\t\t\t\t\t<div class=\"form-group required\">
\t\t\t\t\t\t\t<label for=\"input-name\" class=\"control-label\">What is your name?</label> <input type=\"text\" name=\"name\" value=\"";
        // line 29
        echo ($context["name"] ?? null);
        echo "\" placeholder=\"Name\" id=\"input-name\" class=\"form-control\">
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-7\">
\t\t\t\t\t\t<div class=\"form-group required\">
\t\t\t\t\t\t\t<label for=\"input-email\" class=\"control-label\">E-Mail</label> <input type=\"text\" name=\"email\" value=\"";
        // line 34
        echo ($context["email"] ?? null);
        echo "\" placeholder=\"Email\" id=\"input-email\" class=\"form-control\"/>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div id=\"contact\"></div>
\t\t\t\t<div class=\"form-group required\">
\t\t\t\t\t<label for=\"input-enquiry\" class=\"control-label\">Message</label> <textarea name=\"enquiry\" rows=\"7\" id=\"input-enquiry\" class=\"form-control\"></textarea>
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t";
        // line 48
        echo "\t\t\t\t\t<div class=\"col-md-7\">
\t\t\t\t\t\t<button type=\"button\" id=\"button-send\" class=\"btn btn-primary btn-xl btn-block\">Send Message</button>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t<div class=\"col-md-4\">
\t\t\t\t<div class=\"well\">
\t\t\t\t\t<h4>General Information</h4>
\t\t\t\t\t<hr>
\t\t\t\t\t<p><a href=\"mailto:";
        // line 57
        echo ($context["contact_support"] ?? null);
        echo "\">";
        echo ($context["contact_support"] ?? null);
        echo "</a></p>
\t\t\t\t\t<h4>Support</h4>
\t\t\t\t\t<p><a href=\"mailto:support@opencart.com\">support@opencart.com</a>
\t\t\t\t\t\t<br/>
\t\t\t\t\t\tAvailable every day from 09:30 to 18:30 (HK Time).
\t\t\t\t\t\t<br/>
\t\t\t\t\t\tProvide your feedback regarding <a href=\"https://support.opencart.com/anonymous_requests/new\" target=\"_blank\">support</a> or an <a href=\"https://support.opencart.com/anonymous_requests/new\" target=\"_blank\">extension</a> .
\t\t\t\t\t\t<br/>
\t\t\t\t\t</p>
\t\t\t\t\t<h4>Partnerships</h4>
\t\t\t\t\t<p><a href=\"tel:";
        // line 67
        echo ($context["contact_telephone"] ?? null);
        echo "\">";
        echo ($context["contact_telephone"] ?? null);
        echo "</a>
\t\t\t\t\t\t<br/>
\t\t\t\t\t\t<a href=\"mailto:";
        // line 69
        echo ($context["contact_partner"] ?? null);
        echo "\">";
        echo ($context["contact_partner"] ?? null);
        echo "</a></p>
\t\t\t\t\t<h4>Press And Media</h4>
\t\t\t\t\t<p><a href=\"tel:";
        // line 71
        echo ($context["contact_telephone"] ?? null);
        echo "\">";
        echo ($context["contact_telephone"] ?? null);
        echo "</a>
\t\t\t\t\t\t<br/>
\t\t\t\t\t\t<a href=\"mailto:";
        // line 73
        echo ($context["contact_marketing"] ?? null);
        echo "\">";
        echo ($context["contact_marketing"] ?? null);
        echo "</a></p>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t\t<div id=\"address\">
\t\t\t<h2>Our Office</h2>
\t\t\t<div class=\"row\">
\t\t\t\t<div class=\"col-md-12\">
\t\t\t\t\t<div id=\"map-hk\" class=\"map\"></div>
\t\t\t\t\t<div class=\"office\">
\t\t\t\t\t\t<div class=\"row\">
\t\t\t\t\t\t\t<div class=\"col-sm-6\">
\t\t\t\t\t\t\t\t<h4>Address</h4>
\t\t\t\t\t\t\t\t<p>OpenCart Limited,
\t\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t\tUnit G 2/F Tower 2 Avignon,
\t\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t\t1 Kwun Chui Road, So Kwan Wat,
\t\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t\tTuen Mun,
\t\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t\tHong Kong
\t\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"col-sm-6\">
\t\t\t\t\t\t\t\t<h4>Office Hours</h4>
\t\t\t\t\t\t\t\t<p>Monday to Friday, 09:30 - 18:30
\t\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t\tLunch Time: 13:00 - 14:00
\t\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t\tClosed on general holidays
\t\t\t\t\t\t\t\t</p>
\t\t\t\t\t\t\t\t<h4>Telephone</h4>
\t\t\t\t\t\t\t\t<p>+44 07521191748</p>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
\t<div class=\"container-fluid\">
\t\t<div class=\"container\">
\t\t\t<p>Looking for dedicated technical support for your OpenCart Project?
\t\t\t\t<br/>
\t\t\t\tView our new Dedicated Support.
\t\t\t</p>
\t\t\t<p><a href=\"https://dedicated.opencart.com/\" target=\"_blank\" class=\"btn btn-primary btn-lg\">Learn More</a></p>
\t\t</div>
\t</div>
\t<script type=\"text/javascript\"><!--
  \$('#input-reason').change(function(e) {
      e.preventDefault();

      var element = this;

      \$.ajax({
          url: 'index.php?route=support/contact/reason&reason=' + encodeURIComponent(\$('#input-reason').val()),
          dataType: 'html',
          beforeSend: function() {
              \$(element).prop('disabled', true);
          },
          complete: function() {
              \$(element).prop('disabled', false);
          },
          success: function(html) {
              \$('#contact').html(html).fadeIn(200);
          },
          error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
          }
      });
  });

  \$('#button-send').on('click', function() {
      \$.ajax({
          url: 'index.php?route=support/contact/send',
          type: 'post',
          data: \$('#support-contact :input, #input-country select, #input-enquiry textarea'),
          dataType: 'json',
          beforeSend: function() {
              \$('#button-send').button('loading');
          },
          complete: function() {
              \$('#button-send').button('reset');
          },
          success: function(json) {
              \$('.alert, .text-danger').remove();
              \$('.form-group').removeClass('has-error');

              if (json['redirect']) {
                  location = json['redirect'];
              }

              if (json['error']) {
                  \$('.alert-info').after('<div class=\"alert alert-danger\"><i class=\"fa fa-exclamation-circle\"></i> ' + json['error']['warning'] + '<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>');

                  for (i in json['error']) {
                      var element = \$('#input-' + i.replace('_', '-'));

                      if (\$(element).parent().hasClass('form-group')) {
                          \$(element).after('<div class=\"text-danger\">' + json['error'][i] + '</div>');
                      } else {
                          \$(element).after('<div class=\"text-danger\">' + json['error'][i] + '</div>');
                      }
                  }

                  // Highlight any found errors
                  \$('.text-danger').parent().addClass('has-error');
              }
          },
          error: function(xhr, ajaxOptions, thrownError) {
              alert(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
          }
      });
  });
  //--></script>
\t<script type=\"text/javascript\"><!--
  var officeHK;
  var officeUK;

  function initMap() {
      officeHK = new google.maps.Map(document.getElementById('map-hk'), {
          center: {lat: 22.3812002, lng: 113.9718091},
          zoom: 16,
          scaleControl: false,
          scrollwheel: false,
          disableDefaultUI: true,
          draggable: false,
          styles: [
              {\"featureType\": \"water\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#e9e9e9\"}, {\"lightness\": 17}]},
              {\"featureType\": \"landscape\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#f5f5f5\"}, {\"lightness\": 20}]},
              {\"featureType\": \"road.highway\", \"elementType\": \"geometry.fill\", \"stylers\": [{\"color\": \"#ffffff\"}, {\"lightness\": 17}]},
              {\"featureType\": \"road.highway\", \"elementType\": \"geometry.stroke\", \"stylers\": [{\"color\": \"#ffffff\"}, {\"lightness\": 29}, {\"weight\": 0.2}]},
              {\"featureType\": \"road.arterial\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#bdefff\"}, {\"lightness\": 18}]},
              {\"featureType\": \"road.local\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#bdefff\"}, {\"lightness\": 16}]},
              {\"featureType\": \"poi\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#f5f5f5\"}, {\"lightness\": 21}]},
              {\"featureType\": \"poi.park\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#dedede\"}, {\"lightness\": 21}]},
              {\"elementType\": \"labels.text.stroke\", \"stylers\": [{\"visibility\": \"on\"}, {\"color\": \"#ffffff\"}, {\"lightness\": 16}]},
              {\"elementType\": \"labels.text.fill\", \"stylers\": [{\"saturation\": 36}, {\"color\": \"#333333\"}, {\"lightness\": 40}]},
              {\"elementType\": \"labels.icon\", \"stylers\": [{\"visibility\": \"off\"}]},
              {\"featureType\": \"transit\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#f2f2f2\"}, {\"lightness\": 19}]},
              {\"featureType\": \"administrative\", \"elementType\": \"geometry.fill\", \"stylers\": [{\"color\": \"#fefefe\"}, {\"lightness\": 20}]},
              {\"featureType\": \"administrative\", \"elementType\": \"geometry.stroke\", \"stylers\": [{\"color\": \"#fefefe\"}, {\"lightness\": 17}, {\"weight\": 1.2}]}
          ]
      });

      officeUK = new google.maps.Map(document.getElementById('map-uk'), {
          center: {lat: 53.793713, lng: -1.5414682},
          zoom: 16,
          scaleControl: false,
          scrollwheel: false,
          disableDefaultUI: true,
          draggable: false,
          styles: [
              {\"featureType\": \"water\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#e9e9e9\"}, {\"lightness\": 17}]},
              {\"featureType\": \"landscape\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#f5f5f5\"}, {\"lightness\": 20}]},
              {\"featureType\": \"road.highway\", \"elementType\": \"geometry.fill\", \"stylers\": [{\"color\": \"#ffffff\"}, {\"lightness\": 17}]},
              {\"featureType\": \"road.highway\", \"elementType\": \"geometry.stroke\", \"stylers\": [{\"color\": \"#ffffff\"}, {\"lightness\": 29}, {\"weight\": 0.2}]},
              {\"featureType\": \"road.arterial\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#bdefff\"}, {\"lightness\": 18}]},
              {\"featureType\": \"road.local\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#bdefff\"}, {\"lightness\": 16}]},
              {\"featureType\": \"poi\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#f5f5f5\"}, {\"lightness\": 21}]},
              {\"featureType\": \"poi.park\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#dedede\"}, {\"lightness\": 21}]},
              {\"elementType\": \"labels.text.stroke\", \"stylers\": [{\"visibility\": \"on\"}, {\"color\": \"#ffffff\"}, {\"lightness\": 16}]},
              {\"elementType\": \"labels.text.fill\", \"stylers\": [{\"saturation\": 36}, {\"color\": \"#333333\"}, {\"lightness\": 40}]},
              {\"elementType\": \"labels.icon\", \"stylers\": [{\"visibility\": \"off\"}]},
              {\"featureType\": \"transit\", \"elementType\": \"geometry\", \"stylers\": [{\"color\": \"#f2f2f2\"}, {\"lightness\": 19}]},
              {\"featureType\": \"administrative\", \"elementType\": \"geometry.fill\", \"stylers\": [{\"color\": \"#fefefe\"}, {\"lightness\": 20}]},
              {\"featureType\": \"administrative\", \"elementType\": \"geometry.stroke\", \"stylers\": [{\"color\": \"#fefefe\"}, {\"lightness\": 17}, {\"weight\": 1.2}]}
          ]
      });

      var image = 'application/view/image/icon/location.png';

      var beachMarker = new google.maps.Marker({
          position: {
              lat: 22.3811875,
              lng: 113.9718991
          },
          map: officeHK,
          icon: image
      });

      var beachMarkerUK = new google.maps.Marker({
          position: {
              lat: 53.793713,
              lng: -1.5414682
          },
          map: officeUK,
          icon: image
      });
  }

  //--></script>
\t<script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyCZ17uWaMWWm7xKUHR7I_To4KviOSS7zEQ&callback=initMap\" async defer></script>
</div>
";
        // line 269
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "support/contact.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  336 => 269,  135 => 73,  128 => 71,  121 => 69,  114 => 67,  99 => 57,  88 => 48,  76 => 34,  68 => 29,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "support/contact.twig", "");
    }
}
