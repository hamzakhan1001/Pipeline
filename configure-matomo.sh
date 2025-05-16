#!/bin/bash
set -e  

###############################
# Configuration & Validation
###############################

# Ensure required environment variable is set
if [ -z "$MATOMO_DATABASE_DBNAME" ]; then
    echo "❌ Error: MATOMO_DATABASE_DBNAME is not set."
    exit 1
fi

# Define database and file variables
db_file="/var/www/html/plugins/GhostBrand/files/initial_db.sql"
db_host="matomo.cyabb6bvejrw.us-east-1.rds.amazonaws.com"
db_user="admin"
db_pass="admin1234"
db_name="$MATOMO_DATABASE_DBNAME"
database_imported=false  # Flag to track DB import status

###############################
# Import Initial Database If Empty
###############################

# Check if database has existing tables
table_count=$(mysql -h "$db_host" -u "$db_user" -p"$db_pass" -D "$db_name" -sse \
    "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$db_name';")

if [ "$table_count" -gt 0 ]; then
    echo "✅ Database '$db_name' already contains tables ($table_count). Skipping import."
else
    if [ -f "$db_file" ]; then
        echo "No tables found in Database '$db_name' 📥 Importing database into it"
        mysql -h "$db_host" -u "$db_user" -p"$db_pass" "$db_name" < "$db_file"
        if [ $? -eq 0 ]; then
            echo "✅ Database imported successfully."
            database_imported=true
        else
            echo "❌ Failed to import database."
            exit 1
        fi
    else
        echo "❌ Database file not found: $db_file"
        exit 1
    fi
fi

###############################
# Update Matomo Config File
###############################

config_file="/var/www/html/config/config.ini.php"

# Update or insert the database name in config.ini.php
if grep -q "^dbname" "$config_file"; then
    sed -i "s/^dbname.*/dbname = \"$MATOMO_DATABASE_DBNAME\"/" "$config_file"
else
    sed -i "/^\[database\]/a dbname = \"$MATOMO_DATABASE_DBNAME\"" "$config_file"
fi

echo "✅ Database name updated in config.ini.php."

###############################
# Reset Superuser Password (Only If DB Imported)
###############################

if [ "$database_imported" = true ]; then
    ./console user:reset-password --login=ghost.superuser --new-password=admin1234
    if [ $? -eq 0 ]; then
        echo "✅ Superuser password reset successfully."
    else
        echo "❌ Failed to reset superuser password."
        exit 1
    fi
else
    echo "Skipping superuser password reset because database already existed."
fi

###############################
# Plugin Activation Based on Plan
###############################

echo
echo "⚙️ Activating plugins based on subscription plan..."

#Additional plugins=("AbTesting" "Cohorts" "CrashAnalytics" "LoginSaml" "SEOWebVitals" "WhiteLabel")
#Errored_premium_plugins=("HeatmapSessionRecording" "FormAnalytics")
starter_plugins=("ActivityLog")
standard_plugins=("ActivityLog" "SearchEngineKeywordsPerformance")
premium_plugins=("ActivityLog" "SearchEngineKeywordsPerformance" "AdvertisingConversionExport" "CustomReports" "Funnels" "MediaAnalytics" "MultiChannelConversionAttribution" "RollUpReporting" "UsersFlow")

SUBSCRIPTION_PLAN=${SUBSCRIPTION_PLAN,,}  # Convert to lowercase

case "$SUBSCRIPTION_PLAN" in
    starter)
        plugins=("${starter_plugins[@]}")
        ;;
    standard)
        plugins=("${standard_plugins[@]}")
        ;;
    premium)
        plugins=("${premium_plugins[@]}")
        ;;
    *)
        echo "❌ Invalid or missing SUBSCRIPTION_PLAN: '$SUBSCRIPTION_PLAN'"
        echo "Accepted values: starter, standard, premium"
        exit 1
        ;;
esac

echo
echo "🔌 Plugins to be activated for '$SUBSCRIPTION_PLAN' subscription plan are: ${plugins[*]}"
echo

for plugin in "${plugins[@]}"; do
    echo "Activating plugin: $plugin"
    ./console plugin:activate "$plugin"
    if [ $? -eq 0 ]; then
        echo "✅ Plugin $plugin activated successfully."
        echo 
    else
        echo "❌ Failed to activate plugin $plugin."
    fi
done

echo "🔌 Plugins activation completed."

###############################
# Update Matomo Core
###############################

chmod +x ./console
./console core:update --yes

if [ $? -eq 0 ]; then
    echo "✅ Matomo core updated successfully."
else
    echo "❌ Failed to update Matomo core."
    exit 1
fi

echo "✅ Matomo configuration completed."

###############################
# Postfix Configuration
###############################

echo "📬 Configuring Postfix..."

postconf -e 'inet_interfaces = all'
postconf -e 'inet_protocols = ipv4'
postconf -e 'mydestination = localhost'
postconf -e 'relayhost ='

service postfix restart
echo "✅ Postfix configured and restarted."

###############################
# Setup Cron Job for Archiving
###############################

echo
echo "⏱️ Setting up Matomo archiving cron job..."
#echo "*/5 * * * * /usr/bin/php /var/www/html/console core:archive --matomo-domain=$MATOMO_CLIENT_DOMAIN > /var/log/cronjob.log 2>&1" | crontab -
#echo "*/5 * * * * /usr/bin/php /var/www/html/console core:archive --matomo-domain=$MATOMO_CLIENT_DOMAIN > /var/log/cronjob.log 2>&1" | crontab -u www-data -
echo "*/5 * * * * chown -R www-data:www-data /var/www/html/tmp && su -s /bin/bash www-data -c '/usr/bin/php /var/www/html/console core:archive --matomo-domain=$MATOMO_CLIENT_DOMAIN' >> /var/log/cronjob.log 2>&1" | crontab -

if [ $? -eq 0 ]; then
    echo "✅ Cron job added successfully for $MATOMO_CLIENT_DOMAIN."
else
    echo "❌ Failed to add cron job."
    exit 1
fi

###############################
# Move Custom Files & Clean Structure
###############################

cd /var/www
mkdir -p custom-code
cd /var/www/html

mv Dockerfile configure-matomo.sh default index.nginx-debian.html nginx.conf ../custom-code
echo "📁 Custom code moved to maintain Matomo integrity."

###############################
# Fix Permissions
###############################

chown -R www-data:www-data /var/www/html/tmp
find /var/www/html/tmp -type d -exec chmod 2775 {} \;
find /var/www/html/tmp -type f -exec chmod 664 {} \;

###############################
# Final Success Message
###############################

echo
echo "🎉 Ghost Cloud configuration completed successfully."