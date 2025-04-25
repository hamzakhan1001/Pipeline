#!/bin/bash
set -e

# Check if MATOMO_DATABASE_DBNAME is set
if [ -z "$MATOMO_DATABASE_DBNAME" ]; then
    echo "Error: MATOMO_DATABASE_DBNAME is not set."
    exit 1
fi

plugins=("AbTesting" "ActivityLog" "Cohorts" "CrashAnalytics" "CustomReports" "Funnels" "LoginSaml" "MediaAnalytics" "MultiChannelConversionAttribution" "RollUpReporting" "SEOWebVitals" "SearchEngineKeywordsPerformance" "UsersFlow" "WhiteLabel")
db_file="/var/www/html/plugins/GhostBrand/files/initial_db.sql"
db_host="matomo.cyabb6bvejrw.us-east-1.rds.amazonaws.com"
db_user="admin"
db_pass="admin1234"
db_name="$MATOMO_DATABASE_DBNAME"

# Check if database has any tables
table_count=$(mysql -h "$db_host" -u "$db_user" -p"$db_pass" -D "$db_name" -sse "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$db_name';")

if [ "$table_count" -gt 0 ]; then
    echo "Database '$db_name' already contains $table_count tables. Skipping import and config update."
else
    # If no tables, proceed with import
    if [ -f "$db_file" ]; then
        echo "No tables found in '$db_name'. Importing database from $db_file..."
        mysql -h "$db_host" -u "$db_user" -p"$db_pass" "$db_name" < "$db_file"
        if [ $? -eq 0 ]; then
            echo "Database imported successfully."

            # Update database name in config.ini.php **only now after successful import**
            config_file="/var/www/html/config/config.ini.php"

            if grep -q "^dbname" "$config_file"; then
                sed -i "s/^dbname.*/dbname = \"$MATOMO_DATABASE_DBNAME\"/" "$config_file"
            else
                sed -i "/^\[database\]/a dbname = \"$MATOMO_DATABASE_DBNAME\"" "$config_file"
            fi

            echo "Database name updated successfully in config.ini.php."

        else
            echo "Failed to import database."
            exit 1
        fi
    else
        echo "Database file not found: $db_file"
        exit 1
    fi
fi

cd /var/www/html/
chmod +x /var/www/html/console
./console core:update --yes
if [ $? -eq 0 ]; then
    echo "Matomo core updated successfully."
else
    echo "Failed to update Matomo core."
    exit 1
fi

echo "Matomo configuration completed."

chown -R www-data:www-data /var/www/html/tmp/cache/tracker/

./console user:reset-password --login=ghost.superuser --new-password=admin1234

echo "Activating all plugins..."

for plugin in "${plugins[@]}"; do
    echo "Activating plugin: $plugin"
    ./console plugin:activate "$plugin"
    if [ $? -eq 0 ]; then
        echo "✅ Plugin $plugin activated successfully."
    else
        echo "❌ Failed to activate plugin $plugin."
    fi
done

echo "All plugins processed."

# Setup postfix service
echo "Configuring Postfix..."
postconf -e 'inet_interfaces = all'
postconf -e 'inet_protocols = ipv4'
postconf -e 'mydestination = localhost'
postconf -e 'relayhost ='

service postfix restart
echo "Postfix configured successfully."

# Setup cron job for Matomo archiving
echo "*/5 * * * * /usr/bin/php /var/www/html/console core:archive --matomo-domain=$MATOMO_CLIENT_DOMAIN > /var/log/cronjob.log 2>&1" | crontab -

if [ $? -eq 0 ]; then
    echo "✅ Cron job added successfully for $MATOMO_CLIENT_DOMAIN."
else
    echo "❌ Failed to add cron job."
    exit 1
fi

echo "Adding Cronjob For Updating Ghost Cloud Permissions"
* * * * * root bash -c 'chown -R www-data:www-data /var/www/html/tmp/ && \
chown -R www-data:www-data /var/www/html/tmp/templates_c/29 && \
chmod -R 0755 /var/www/html/tmp/ && \
chmod -R 0755 /var/www/html/tmp/templates_c/29 && \
rm -rf /var/www/html/tmp/cache/* && \
echo "$(date) - Ownership and permissions updated successfully." >> /var/log/permission.log'

cd /var/www
mkdir -p custom-code
cd /var/www/html
mv Dockerfile configure-matomo.sh default index.nginx-debian.html nginx.conf ../custom-code
echo "Custom code moved to another folder to maintain Matomo integrity."

# echo "Updating Ghost Cloud Permissions"
# chown -R www-data:www-data /var/www/html/tmp/
# chown -R www-data:www-data /var/www/html/tmp/templates_c/29
# chmod -R 0755 /var/www/html/tmp/
# chmod -R 0755 /var/www/html/tmp/templates_c/29
# rm -rf /var/www/html/tmp/cache/*
# echo "Permissions Updated Successfully"

echo "Matomo configuration completed."