; <?php exit; ?> DO NOT REMOVE THIS LINE
;
; This common.config.ini.php file is read right before config.ini.php

[General]
force_ssl = 1
always_load_commands_from_plugin=ExtraTools
noreply_email_address = "noreply@ghostmetrics.cloud"
noreply_email_name = "Ghost Metrics"
contact_email_address = "support@ghostmetrics.cloud"
feedback_email_address = "support@ghostmetrics.cloud"
show_update_notification_to_superusers_only = 1
enable_custom_logo = 0
piwik_professional_support_ads_enabled = 0
enable_marketplace = 0

[mail]
transport = "smtp"
port = 587
host = "email-smtp.us-east-1.amazonaws.com"
type = "Plain"
username = "AKIA4ZPFCZXYZEPTXX75"
password = "BHSdJB5girLwZOMK383XLuzWyQoRZlNSoOSA4zx0/kpW"
encryption = "tls"

[database]
host = "appghost.cyabb6bvejrw.us-east-1.rds.amazonaws.com"
tables_prefix = "ghost_"
schema = "Mariadb"
charset = "utf8mb4"

; Do not allow users to trigger the Matomo archiving process.
; Ensures that no unexpected data processing triggers from UI or API.
enable_browser_archiving_triggering = 0

