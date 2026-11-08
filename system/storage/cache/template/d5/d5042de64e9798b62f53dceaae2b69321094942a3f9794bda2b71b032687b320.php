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

/* mail/register.twig */
class __TwigTemplate_1aff7f0d6b4d517292eef9d9cf1cec5f2b0a50e58d5edc838b55d41f420a3ca5 extends Template
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

<!-- START OF FEATURED AREA BLOCK-->

<table bgcolor=\"#ffffff\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
    <td valign=\"top\" width=\"100%\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr>
          <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td class=\"spacer\" width=\"30\"></td>
                      <td width=\"540\" style=\"\"><table class=\"full\" bgcolor=\"#23A1D1\" background=\"https://s3-us-west-2.amazonaws.com/opencart-email-asset/featured-background-image.png\" align=\"left\" width=\"540\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-radius:10px; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;  height:320px;\">
                          <!--[if gte mso 9]>
                                          <v:rect xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"true\" stroke=\"false\" style=\"width:540px;height:320px;\">
                                            <v:fill type=\"tile\" src=\"https://s3-us-west-2.amazonaws.com/opencart-email-asset/featured-background-image.png\" color=\"#23A1D1\"/>
                                            <v:textbox inset=\"0,0,0,0\"><![endif]-->
                          <tr>
                            <td><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                <!-- START OF HEADING-->
                                <tr>
                                  <td class=\"center\" align=\"center\" style=\"padding: 60px 30px 10px 30px; text-transform: uppercase; font-weight: bold; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#ffffff; font-size:32px; line-height:42px; mso-line-height-rule: exactly;\"><span>Welcome to OpenCart!</span></td>
                                </tr>
                                <!-- END OF HEADING-->

                                <!-- START OF TEXT-->
                                <tr>
                                  <td class=\"center\" align=\"center\" style=\"padding: 0px 30px; margin: 0; font-weight: bold; font-size:24px ; color:#ffffff; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 34px; mso-line-height-rule: exactly;\"><span>Please, click to verify account:</span></td>
                                </tr>
                                <!-- END OF TEXT-->

                                <!-- START BUTTON-->
                                <tr>
                                  <td align=\"center\" valign=\"top\" style=\"padding-top: 20px; padding-right: 30px; padding-bottom: 60px; padding-left: 30px;\"><table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0; border-radius:3px; \">
                                      <tr>
                                        <td align=\"center\" valign=\"middle\" bgcolor=\"#ffffff\" style=\"padding: 10px 25px; border-radius:3px; font-weight: bold; font-size: 18px; line-height: 28px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#23A1D1; margin: 0 !important; \"><a href=\"";
        // line 37
        echo ($context["verification_link"] ?? null);
        echo "&utm_source=Register+Account&utm_medium=email&utm_campaign=Transactional+Email\" style=\"font-weight: bold; font-style: normal; color:#23A1D1; text-decoration: none;\"> Verify </a></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <!-- END BUTTON-->
                              </table></td>
                          </tr>
                          <!--[if gte mso 9]></v:textbox>
                                        </v:rect><![endif]-->
                        </table></td>
                      <td class=\"spacer\" width=\"30\"></td>
                    </tr>
                  </table></td>
              </tr>
            </table>

            <!-- START OF VERTICAL SPACER-->

            <table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\" height=\"40\">&nbsp;</td>
              </tr>
            </table>

            <!-- END OF VERTICAL SPACER--></td>
        </tr>
      </table></td>
  </tr>
</table>

<!-- END OF FEATURED AREA BLOCK-->

<!-- START OF DIVIDER IMAGE BLOCK-->

<table bgcolor=\"#ffffff\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
    <td valign=\"top\" width=\"100%\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr>
          <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\"><table align=\"center\" width=\"540\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td align=\"center\" style=\"margin: 0; font-size:14px ; color:#aaaaaa; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 0;\"><span> <img class=\"divider\" src=\"https://s3-us-west-2.amazonaws.com/opencart-email-asset/divider-image.png\" alt=\"divider image\" width=\"540\" height=\"1\" border=\"0\" style=\"display: inline-block;\" /> </span></td>
                    </tr>
                  </table></td>
              </tr>
            </table>

            <!-- START OF VERTICAL SPACER-->

            <table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\" height=\"40\">&nbsp;</td>
              </tr>
            </table>

            <!-- END OF VERTICAL SPACER--></td>
        </tr>
      </table></td>
  </tr>
</table>

<!-- END OF DIVIDER IMAGE BLOCK-->

<!-- START OF 1/1 (FULL WIDTH) COLUMN BLOCK-->

<table bgcolor=\"#ffffff\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
    <td valign=\"top\" width=\"100%\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr>
          <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td class=\"spacer\" width=\"30\"></td>
                      <td width=\"540\"><table class=\"full\" align=\"left\" width=\"540\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\">

                          <!-- START OF TEXT-->
                          <tr>
                            <td class=\"center\" align=\"left\" style=\"margin: 0; font-size:13px ; color:#aaaaaa; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;\">
                              <p style=\"text-align:left;\"><br />
                                Many thanks,<br />
                                The ";
        // line 119
        echo ($context["store"] ?? null);
        echo " team</p></td>
                          </tr>
                          <!-- END OF TEXT-->
                        </table></td>
                      <td class=\"spacer\" width=\"30\"></td>
                    </tr>
                  </table></td>
              </tr>
            </table>

            <!-- START OF VERTICAL SPACER-->

            <table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\" height=\"40\">&nbsp;</td>
              </tr>
            </table>

            <!-- END OF VERTICAL SPACER--></td>
        </tr>
      </table></td>
  </tr>
</table>

<!-- END OF 1/1 (FULL WIDTH) COLUMN BLOCK-->




";
        // line 148
        if (($context["promotions"] ?? null)) {
            // line 149
            echo "<!-- START OF DIVIDER IMAGE BLOCK-->

<table bgcolor=\"#ffffff\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
    <td valign=\"top\" width=\"100%\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr>
          <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\"><table align=\"center\" width=\"540\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td align=\"center\" style=\"margin: 0; font-size:14px ; color:#aaaaaa; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 0;\"><span> <img class=\"divider\" src=\"https://s3-us-west-2.amazonaws.com/opencart-email-asset/divider-image.png\" alt=\"divider image\" width=\"540\" height=\"1\" border=\"0\" style=\"display: inline-block;\" /> </span></td>
                    </tr>
                  </table></td>
              </tr>
            </table>

            <!-- START OF VERTICAL SPACER-->

            <table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\" height=\"40\">&nbsp;</td>
              </tr>
            </table>

            <!-- END OF VERTICAL SPACER--></td>
        </tr>
      </table></td>
  </tr>
</table>

<!-- END OF DIVIDER IMAGE BLOCK-->
<!-- START OF 1/1 (FULL WIDTH) COLUMN BLOCK-->

<table bgcolor=\"#ffffff\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
    <td valign=\"top\" width=\"100%\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr>
          <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td class=\"spacer\" width=\"30\"></td>
                      <td width=\"540\"><table class=\"full\" align=\"left\" width=\"540\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\">
                          <!-- START OF HEADING-->
                          <tr>
                            <td class=\"center\" align=\"left\" style=\"padding: 0px; font-weight: bold; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#23A1D1; font-size:22px; line-height:32px; mso-line-height-rule: exactly;\"><span> <a class=\"heading-link\" href=\"#\" style=\"color:#23A1D1; text-decoration: none; font-style: normal; font-weight: bold;\"> Featured Extensions </a> </span></td>
                          </tr>
                          <!-- END OF HEADING-->
                        </table></td>
                      <td class=\"spacer\" width=\"30\"></td>
                    </tr>
                  </table></td>
              </tr>
            </table>

            <!-- START OF VERTICAL SPACER-->

            <table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\" height=\"40\">&nbsp;</td>
              </tr>
            </table>

            <!-- END OF VERTICAL SPACER--></td>
        </tr>
      </table></td>
  </tr>
</table>

<!-- END OF 1/1 (FULL WIDTH) COLUMN BLOCK-->
";
            // line 219
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["promotions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["promotion"]) {
                // line 220
                echo "<!-- START OF 1/3 AND 2/3 COL LEFT IMAGE BLOCK-->

<table bgcolor=\"#ffffff\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
    <td valign=\"top\" width=\"100%\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr>
          <td width=\"100%\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td class=\"spacer\" width=\"30\"></td>
                      <td width=\"540\"><!-- START OF LEFT COLUMN-->

                        <table class=\"full\" align=\"left\" width=\"160\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\">
                          <tr>
                            <td class=\"center\" align=\"left\" style=\"margin: 0; font-size:13px ; color:#aaaaaa; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 23px;\"><span> <a href=\"";
                // line 235
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "link", [], "any", false, false, false, 235);
                echo "\" style=\"color:#23A1D1;\"> <img src=\"";
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "image", [], "any", false, false, false, 235);
                echo "\" alt=\"img-160-93\" width=\"160\" height=\"93\" border=\"0\" style=\"display: inline-block;\" /> </a> </span></td>
                          </tr>
                        </table>

                        <!-- END OF LEFT COLUMN-->

                        <!-- START OF SPACER-->

                        <table width=\"25\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\">
                          <tr>
                            <td width=\"100%\" height=\"30\"></td>
                          </tr>
                        </table>

                        <!-- END OF SPACER-->

                        <!-- START OF RIGHT COLUMN-->

                        <table class=\"full\" align=\"right\" width=\"350\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\">
                          <!-- START OF HEADING-->
                          <tr>
                            <td class=\"center\" align=\"left\" style=\"padding-bottom: 10px; font-weight: bold; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#23A1D1; font-size:22px; line-height:32px; mso-line-height-rule: exactly;\"><span> <a class=\"heading-link\" href=\"";
                // line 256
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "link", [], "any", false, false, false, 256);
                echo "\" style=\"color:#23A1D1; text-decoration: none; font-style: normal; font-weight: bold;\">";
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "name", [], "any", false, false, false, 256);
                echo "</a></span></td>
                          </tr>
                          <!-- END OF HEADING-->

                          <!-- START OF TEXT-->
                          <tr>
                            <td class=\"center\" align=\"left\" style=\"margin: 0; font-size:13px ; color:#aaaaaa; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;\"><span>";
                // line 262
                echo twig_get_attribute($this->env, $this->source, $context["promotion"], "description", [], "any", false, false, false, 262);
                echo "</span></td>
                          </tr>
                          <!-- END OF TEXT-->

                          <!-- START BUTTON-->
                          <tr>
                            <td align=\"left\" valign=\"top\" style=\"padding-top: 17px;\"><table border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-radius: 2px; margin: 0;\">
                                <tr>
                                  <td align=\"center\" valign=\"middle\" bgcolor=\"#23A1D1\" style=\"border-radius: 2px; padding: 6px 15px; font-weight: bold;  font-size: 13px; line-height: 18px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#ffffff; margin: 0 !important; \"><a href=\"";
                // line 270
                echo twig_get_attribute($this->env, $this->source, ($context["extension"] ?? null), "link", [], "any", false, false, false, 270);
                echo "\" style=\"border: none; font-weight: bold; font-style: normal; color:#ffffff; text-decoration: none;\">Read more</a></td>
                                </tr>
                              </table></td>
                          </tr>
                          <!-- END BUTTON-->
                        </table>

                        <!-- END OF RIGHT COLUMN--></td>
                      <td class=\"spacer\" width=\"30\"></td>
                    </tr>
                  </table></td>
              </tr>
            </table>

            <!-- START OF VERTICAL SPACER-->

            <table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\" height=\"40\">&nbsp;</td>
              </tr>
            </table>

            <!-- END OF VERTICAL SPACER--></td>
        </tr>
      </table></td>
  </tr>
</table>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['promotion'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 299
        echo "



";
        // line 303
        if (($context["extensions"] ?? null)) {
            // line 304
            echo "<!-- START OF DIVIDER IMAGE BLOCK-->

<table bgcolor=\"#ffffff\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
    <td valign=\"top\" width=\"100%\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr>
          <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\"><table align=\"center\" width=\"540\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td align=\"center\" style=\"margin: 0; font-size:14px ; color:#aaaaaa; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 0;\"><span> <img class=\"divider\" src=\"https://s3-us-west-2.amazonaws.com/opencart-email-asset/divider-image.png\" alt=\"divider image\" width=\"540\" height=\"1\" border=\"0\" style=\"display: inline-block;\" /> </span></td>
                    </tr>
                  </table></td>
              </tr>
            </table>

            <!-- START OF VERTICAL SPACER-->

            <table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\" height=\"40\">&nbsp;</td>
              </tr>
            </table>

            <!-- END OF VERTICAL SPACER--></td>
        </tr>
      </table></td>
  </tr>
</table>

<!-- END OF DIVIDER IMAGE BLOCK-->
<!-- START OF 1/1 (FULL WIDTH) COLUMN BLOCK-->

<table bgcolor=\"#ffffff\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
    <td valign=\"top\" width=\"100%\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr>
          <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td class=\"spacer\" width=\"30\"></td>
                      <td width=\"540\"><table class=\"full\" align=\"left\" width=\"540\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\">
                          <!-- START OF HEADING-->
                          <tr>
                            <td class=\"center\" align=\"left\" style=\"padding: 0px; font-weight: bold; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#23A1D1; font-size:22px; line-height:32px; mso-line-height-rule: exactly;\"><span> <a class=\"heading-link\" href=\"#\" style=\"color:#23A1D1; text-decoration: none; font-style: normal; font-weight: bold;\"> Latest Extensions </a> </span></td>
                          </tr>
                          <!-- END OF HEADING-->
                        </table></td>
                      <td class=\"spacer\" width=\"30\"></td>
                    </tr>
                  </table></td>
              </tr>
            </table>

            <!-- START OF VERTICAL SPACER-->

            <table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\" height=\"40\">&nbsp;</td>
              </tr>
            </table>

            <!-- END OF VERTICAL SPACER--></td>
        </tr>
      </table></td>
  </tr>
</table>

<!-- END OF 1/1 (FULL WIDTH) COLUMN BLOCK-->
";
            // line 374
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["extensions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["extension"]) {
                // line 375
                echo "<!-- START OF 1/3 AND 2/3 COL LEFT IMAGE BLOCK-->

<table bgcolor=\"#ffffff\" width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
  <tr>
    <td valign=\"top\" width=\"100%\"><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
        <tr>
          <td width=\"100%\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\"><table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                    <tr>
                      <td class=\"spacer\" width=\"30\"></td>
                      <td width=\"540\"><!-- START OF LEFT COLUMN-->

                        <table class=\"full\" align=\"left\" width=\"160\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\">
                          <tr>
                            <td class=\"center\" align=\"left\" style=\"margin: 0; font-size:13px ; color:#aaaaaa; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 23px;\"><span> <a href=\"";
                // line 390
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "link", [], "any", false, false, false, 390);
                echo "\" style=\"color:#23A1D1;\"> <img src=\"";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "image", [], "any", false, false, false, 390);
                echo "\" alt=\"img-160-93\" width=\"160\" height=\"93\" border=\"0\" style=\"display: inline-block;\" /> </a> </span></td>
                          </tr>
                        </table>

                        <!-- END OF LEFT COLUMN-->

                        <!-- START OF SPACER-->

                        <table width=\"25\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\">
                          <tr>
                            <td width=\"100%\" height=\"30\"></td>
                          </tr>
                        </table>

                        <!-- END OF SPACER-->

                        <!-- START OF RIGHT COLUMN-->

                        <table class=\"full\" align=\"right\" width=\"350\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\">
                          <!-- START OF HEADING-->
                          <tr>
                            <td class=\"center\" align=\"left\" style=\"padding-bottom: 10px; font-weight: bold; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#23A1D1; font-size:22px; line-height:32px; mso-line-height-rule: exactly;\"><span> <a class=\"heading-link\" href=\"";
                // line 411
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "link", [], "any", false, false, false, 411);
                echo "\" style=\"color:#23A1D1; text-decoration: none; font-style: normal; font-weight: bold;\">";
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "name", [], "any", false, false, false, 411);
                echo "</a></span></td>
                          </tr>
                          <!-- END OF HEADING-->

                          <!-- START OF TEXT-->
                          <tr>
                            <td class=\"center\" align=\"left\" style=\"margin: 0; font-size:13px ; color:#aaaaaa; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 23px;mso-line-height-rule: exactly;\"><span>";
                // line 417
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "description", [], "any", false, false, false, 417);
                echo "</span></td>
                          </tr>
                          <!-- END OF TEXT-->

                          <!-- START BUTTON-->
                          <tr>
                            <td align=\"left\" valign=\"top\" style=\"padding-top: 17px;\"><table border=\"0\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-radius: 2px; margin: 0;\">
                                <tr>
                                  <td align=\"center\" valign=\"middle\" bgcolor=\"#23A1D1\" style=\"border-radius: 2px; padding: 6px 15px; font-weight: bold;  font-size: 13px; line-height: 18px; font-family: 'Open Sans', Helvetica, Arial, sans-serif; color:#ffffff; margin: 0 !important; \"><a href=\"";
                // line 425
                echo twig_get_attribute($this->env, $this->source, $context["extension"], "link", [], "any", false, false, false, 425);
                echo "\" style=\"border: none; font-weight: bold; font-style: normal; color:#ffffff; text-decoration: none;\">Read more</a></td>
                                </tr>
                              </table></td>
                          </tr>
                          <!-- END BUTTON-->
                        </table>

                        <!-- END OF RIGHT COLUMN--></td>
                      <td class=\"spacer\" width=\"30\"></td>
                    </tr>
                  </table></td>
              </tr>
            </table>

            <!-- START OF VERTICAL SPACER-->

            <table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
              <tr>
                <td width=\"100%\" height=\"40\">&nbsp;</td>
              </tr>
            </table>

            <!-- END OF VERTICAL SPACER--></td>
        </tr>
      </table></td>
  </tr>
</table>

<!-- END OF 1/3 AND 2/3 COL LEFT IMAGE BLOCK-->
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['extension'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        // line 456
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "mail/register.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  557 => 456,  520 => 425,  509 => 417,  498 => 411,  472 => 390,  455 => 375,  451 => 374,  379 => 304,  377 => 303,  371 => 299,  336 => 270,  325 => 262,  314 => 256,  288 => 235,  271 => 220,  267 => 219,  195 => 149,  193 => 148,  161 => 119,  76 => 37,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "mail/register.twig", "");
    }
}
