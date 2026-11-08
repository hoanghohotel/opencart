<?php
// Heading
$_['heading_title']                  = 'Payment Methods (Stripe, Braintree & PayPal)';

// Text
$_['text_success']                   = 'Success: You have modified payment method settings!';
$_['text_edit']                      = 'Configure Payment Gateways (Test Mode & Live Mode)';
$_['text_enabled']                   = 'Enabled';
$_['text_disabled']                  = 'Disabled';
$_['text_yes']                       = 'Yes';
$_['text_no']                        = 'No';
$_['text_mode_test']                 = 'Test Mode (Sandbox)';
$_['text_mode_live']                 = 'Live Mode (Production)';
$_['text_capture_auto']              = 'Automatic (Immediate Charge)';
$_['text_capture_manual']            = 'Manual (Authorize Only)';
$_['text_gateway_stripe']            = 'Stripe (Elements & PaymentIntents API)';
$_['text_gateway_braintree']         = 'Braintree (Hosted Fields & GraphQL API)';
$_['text_badge_test']                = 'TEST MODE';
$_['text_badge_live']                = 'LIVE MODE';
$_['text_badge_sandbox']             = 'TEST MODE (SANDBOX)';
$_['text_badge_production']          = 'LIVE MODE (PRODUCTION)';
$_['text_stripe_test_legend']        = 'Stripe Test API Keys';
$_['text_stripe_live_legend']        = 'Stripe Live API Keys';
$_['text_stripe_options']            = 'Stripe Payment Options';
$_['text_braintree_sb_legend']       = 'Braintree Sandbox API Keys';
$_['text_braintree_prod_legend']     = 'Braintree Production API Keys';
$_['text_braintree_options']         = 'Braintree Options';
$_['text_paypal_sb_legend']          = 'PayPal Sandbox REST API Credentials';
$_['text_paypal_live_legend']        = 'PayPal Live REST API Credentials';
$_['text_paypal_options']            = 'PayPal Options';

// Tabs
$_['tab_stripe']                     = 'Stripe (Test & Live API)';
$_['tab_braintree']                  = 'Braintree (Sandbox & Production API)';
$_['tab_paypal']                     = 'PayPal REST API (Sandbox & Live)';
$_['tab_general']                    = 'General Routing';

// Entry
$_['entry_stripe_status']            = 'Stripe Status';
$_['entry_api_mode']                 = 'API Mode';
$_['entry_environment']              = 'Environment (Mode)';
$_['entry_stripe_test_pk']           = 'Test Publishable Key';
$_['entry_stripe_test_sk']           = 'Test Secret Key';
$_['entry_stripe_test_wh']           = 'Test Webhook Secret';
$_['entry_stripe_live_pk']           = 'Live Publishable Key';
$_['entry_stripe_live_sk']           = 'Live Secret Key';
$_['entry_stripe_live_wh']           = 'Live Webhook Secret';
$_['entry_currency']                 = 'Currency';
$_['entry_capture_method']           = 'Capture Method';
$_['entry_three_d_secure']           = '3D Secure (SCA)';
$_['entry_three_d_secure_2']         = '3D Secure 2.0';
$_['entry_braintree_status']         = 'Braintree Status';
$_['entry_bt_sb_mid']                = 'Sandbox Merchant ID';
$_['entry_bt_sb_pub']                = 'Sandbox Public Key';
$_['entry_bt_sb_priv']               = 'Sandbox Private Key';
$_['entry_bt_sb_maid']               = 'Sandbox Merchant Account ID';
$_['entry_bt_prod_mid']              = 'Production Merchant ID';
$_['entry_bt_prod_pub']              = 'Production Public Key';
$_['entry_bt_prod_priv']             = 'Production Private Key';
$_['entry_bt_prod_maid']             = 'Production Merchant Account ID';
$_['entry_paypal_status']            = 'PayPal Status';
$_['entry_pp_sb_cid']                = 'Sandbox Client ID';
$_['entry_pp_sb_sec']                = 'Sandbox Secret';
$_['entry_pp_live_cid']              = 'Live Client ID';
$_['entry_pp_live_sec']              = 'Live Secret';
$_['entry_card_gateway']             = 'Default Credit Card Gateway';

// Buttons
$_['button_test_stripe_test']        = 'Test Stripe (Test Mode)';
$_['button_test_stripe_live']        = 'Test Stripe (Live Mode)';
$_['button_test_bt_sandbox']         = 'Test Braintree (Sandbox)';
$_['button_test_bt_live']            = 'Test Braintree (Live)';
$_['button_test_pp_sandbox']         = 'Test PayPal (Sandbox)';
$_['button_test_pp_live']            = 'Test PayPal (Live)';

// Help
$_['help_api_mode']                  = 'Select Test Mode (pk_test_ / sk_test_) or Live Mode (pk_live_ / sk_live_)';
$_['help_card_gateway']              = 'Determines the default gateway used on index.php?route=account/payment/card. Note: Users can also select Stripe, Braintree, or PayPal directly on the Payment Methods and Checkout screens.';

// Error
$_['error_permission']               = 'Warning: You do not have permission to modify payment method settings!';
$_['error_warning']                  = 'Warning: Please check the form carefully for errors!';
