<?php
// Heading
$_['heading_title']                  = 'Settings';

// Text
$_['text_stores']                    = 'Stores';
$_['text_success']                   = 'Success: You have modified settings!';
$_['text_edit']                      = 'Edit Setting';
$_['text_mail']                      = 'Mail';
$_['text_smtp']                      = 'SMTP';
$_['text_general']                   = 'General';
$_['text_security']                  = 'Security';
$_['text_upload']                    = 'Uploads';
$_['text_error']                     = 'Error Handling';

// Entry
$_['entry_meta_title']               = 'Meta Title';
$_['entry_meta_description']         = 'Meta Tag Description';
$_['entry_meta_keyword']             = 'Meta Tag Keywords';
$_['entry_name']                     = 'Platform Name';
$_['entry_owner']                    = 'Company / Owner';
$_['entry_address']                  = 'Address';
$_['entry_email']                    = 'Primary E-Mail';
$_['entry_telephone']                = 'Telephone';
$_['entry_contact_support']          = 'Support E-Mail';
$_['entry_contact_partner']          = 'Partner Inquiry E-Mail';
$_['entry_contact_marketing']        = 'Marketing / Advertising E-Mail';
$_['entry_country']                  = 'Country';
$_['entry_zone']                     = 'Region / State';
$_['entry_language']                 = 'Language';
$_['entry_admin_language']           = 'Administration Language';
$_['entry_currency']                 = 'Currency';
$_['entry_limit_admin']              = 'Default Items Per Page (Admin)';
$_['entry_order_status']             = 'Default Order Status';
$_['entry_download_status']          = 'Complete / Download Order Status';
$_['entry_logo']                     = 'Platform Logo';
$_['entry_icon']                     = 'Favicon';
$_['entry_mail_engine']              = 'Mail Engine';
$_['entry_mail_parameter']           = 'Mail Parameters';
$_['entry_mail_smtp_hostname']       = 'SMTP Hostname';
$_['entry_mail_smtp_username']       = 'SMTP Username';
$_['entry_mail_smtp_password']       = 'SMTP Password';
$_['entry_mail_smtp_port']           = 'SMTP Port';
$_['entry_mail_smtp_timeout']        = 'SMTP Timeout';
$_['entry_mail_test_email']          = 'Test Recipient E-Mail';
$_['button_test_smtp']               = 'Test SMTP Before Save';
$_['help_mail_test']                 = 'Test your current SMTP configuration and send a test email before saving settings.';
$_['entry_maintenance']              = 'Maintenance Mode';
$_['entry_seo_url']                  = 'Use SEO URLs';
$_['entry_encryption']               = 'Encryption Key';
$_['entry_error_display']            = 'Display Errors';
$_['entry_error_log']                = 'Log Errors';
$_['entry_error_filename']           = 'Error Log Filename';

// Cloud Storage
$_['tab_storage']                    = 'Cloud Storage';
$_['text_storage_local']             = 'Local Disk Storage (Default)';
$_['text_storage_s3']                = 'Amazon S3 (AWS S3)';
$_['text_storage_wasabi']            = 'Wasabi Hot Cloud Storage';
$_['text_storage_cloudflare']        = 'Cloudflare R2 Storage';
$_['text_storage_google']            = 'Google Cloud Storage (GCS)';
$_['text_acl_private']               = 'Private (Secure Pre-Signed Download URLs)';
$_['text_acl_public']                = 'Public Read (Direct / CDN URL)';
$_['entry_storage_driver']           = 'Storage Provider';
$_['entry_storage_bucket']           = 'Bucket Name';
$_['entry_storage_region']           = 'Region';
$_['entry_storage_endpoint']         = 'Custom Endpoint / Account ID';
$_['entry_storage_access_key']       = 'Access Key ID / HMAC Key';
$_['entry_storage_secret_key']       = 'Secret Access Key / HMAC Secret';
$_['entry_storage_gcs_json']         = 'Google Service Account JSON (Optional)';
$_['entry_storage_prefix']           = 'Bucket Folder Prefix (Optional)';
$_['entry_storage_public_url']       = 'Custom CDN / Public URL (Optional)';
$_['entry_storage_acl']              = 'Object Access Control (ACL)';
$_['entry_storage_keep_local']       = 'Keep Local Copy on Server';
$_['button_test_storage']            = 'Test Cloud Storage Connection';
$_['help_storage_driver']            = 'Select where uploaded files (Marketplace extensions, releases, user uploads, and images) are stored.';
$_['help_storage_endpoint']          = 'For Cloudflare R2: enter your Account ID or https://<account_id>.r2.cloudflarestorage.com. For Wasabi/S3/GCS: leave blank to use the default regional endpoint, or enter a custom endpoint URL.';
$_['help_storage_gcs_json']          = 'For Google Cloud Storage: you can either use S3-compatible Interoperability HMAC keys above, or paste your full Service Account JSON key here for native OAuth2 authentication.';
$_['help_storage_keep_local']        = 'If enabled, a copy of uploaded files is kept on local disk in addition to Cloud Storage. If disabled, large upload/download archives are served directly from Cloud Storage via signed URLs.';

// Help
$_['help_limit_admin']               = 'Determines how many admin items are shown per page (orders, extensions, members, etc).';
$_['help_order_status']              = 'Set the default order status when a marketplace order is placed.';
$_['help_download_status']           = 'Set the order status required before a buyer is allowed to download purchased extensions.';

// Error
$_['error_warning']                  = 'Warning: Please check the form carefully for errors!';
$_['error_permission']               = 'Warning: You do not have permission to modify settings!';
$_['error_meta_title']               = 'Title must be between 3 and 32 characters!';
$_['error_name']                     = 'Platform Name must be between 3 and 32 characters!';
$_['error_owner']                    = 'Owner must be between 3 and 64 characters!';
$_['error_address']                  = 'Address must be between 10 and 256 characters!';
$_['error_email']                    = 'E-Mail Address does not appear to be valid!';
$_['error_telephone']                = 'Telephone must be between 3 and 32 characters!';
$_['error_limit']                    = 'Limit required!';
$_['error_log_required']             = 'Error Log Filename required!';
