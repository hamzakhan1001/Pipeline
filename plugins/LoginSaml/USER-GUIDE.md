Matomo SAML authentication module allows users to login to Matomo using SAML Identity Provider (IdP).

If you have a federated environment with a SAML Identity Provider (OneLogin, Okta, Ping Identity, ADFS, Google, Salesforce, SharePoint...), you can use this plugin to inter-operate with it thereby enabling SSO for your Matomo Analytics users.

SAML is a premium feature which is included in our <a href="/hosting/">Cloud-hosted Enterprise plan</a> or you can <a target="_blank" href="https://plugins.matomo.org/LoginSAML" rel="noopener noreferrer">purchase it on the Matomo Marketplace</a> if you <a href="/what-is-on-premise/">self host Matomo On-Premise</a>. <a target="_blank" href="https://plugins.matomo.org/LoginSAML" rel="noopener noreferrer">Learn more about all the benefits and features of Login SAML</a>.

# Installation

## Requirements

* PHP >= 7.3
* Matomo >= 5.x
* Purchase the plugin from the [Marketplace SAML Plugin page](https://plugins.matomo.org/LoginSaml)

## Installation

Install the plugin according to our [plugin installation guide](https://matomo.org/faq/plugins/faq_21/)


After unzip the plugin zip content into the plugins folder, execute
```
console plugin:activate LoginSaml
```

## Configuration

To configure SAML authentication follow these steps:

1. Login as a Super User

2. On the _Administration > Plugins_ page, activate the LoginSaml plugin.

3. Navigate to _Settings > SAML_ page
![image](https://user-images.githubusercontent.com/600897/27044267-39f85890-4f9d-11e7-9fd9-fb01460c58f9.png)

4. Enter and save settings for SAML: add the Identity Provider info, set the attribute mappings and configure the other options as applicable.

5. Share Service Provider metadata with the IdP administrator
![image](https://user-images.githubusercontent.com/600897/27045816-77113102-4fa2-11e7-9623-968645835aed.png)

6. Enable the SAML authentication
![image](https://user-images.githubusercontent.com/600897/27045868-a526fa22-4fa2-11e7-9edb-0b89f2e7d97a.png)

7. You can now open a new browser session and try to login with the SAML Identity Provider.
![image](https://user-images.githubusercontent.com/600897/27044480-f94ccd0c-4f9d-11e7-9216-c08a7e3836fa.png)

## SAML Configuration support

Configuring SAML Authentication properly can be difficult so we offer our services to help you get Matomo Analytics successfully working with SAML and enjoy the great benefits of SSO. Learn more and contact us in the [SAML Support page](https://matomo.org/support/login-saml/).

# SAML plugin settings

Now that you know the main configuration steps, let's provide details about the SAML configuration.

## Status Settings

Once you activate the SAML plugin, you are able to access its settings panel.

![image](https://user-images.githubusercontent.com/600897/27048504-68532940-4fac-11e7-9af2-038a7698eadc.png)

In **Status Settings** section you see **Enable SAML authentication** is disabled. When disabled, all SAML actions are disabled and if a user tries to execute them, she will receive an error notifying that the SAML functionality is disabled.

You may only enable it when the rest of the SAML settings are properly configured.

In SAML, there are 2 different kind of entities:
1. the Identity Providers IdP (the 3rd party entity where the user is authenticated), and
2. the Service Provider SP (the service that protect the app, in this case Matomo).

A circle of trust is defined between IdP and the SP, allowing all IdP users to access the SP under some conditions. That circle of trust is based on the exchange of an XML, named metadata, that describes the Entity ID, the entity endpoints and the public certificates (that will allow validation of signed/encrypted SAML messages).

## Identity Provider Settings

In the **Identity Provider Settings** section, you may register the Identity Provider metadata.

You can directly fill the form:

![image](https://user-images.githubusercontent.com/600897/27048831-9a3b515c-4fad-11e7-885c-0ed40fbd768a.png)

or click on the **Import values from IdP metadata** link:

![image](https://user-images.githubusercontent.com/600897/27048925-edf409f6-4fad-11e7-81a1-3d419a39ab26.png)

This link will redirect to a form where two different methods are offered to let you import the Identity Provider metadata:

1. By metadata URL
2. By string XML

In case the imported metadata contains more than 1 Identity Provider entity description, you can use the **IdP entity ID** to identity the desired entity:

![image](https://user-images.githubusercontent.com/600897/27049031-542f51ee-4fae-11e7-9388-3e448b0b52ec.png)

## Option settings

In **Option settings** section you can define how Matomo SAML integration will act.

[![Option Settings](https://matomo.org/wp-content/uploads/2017/07/login-saml-options-1.png)](https://matomo.org/wp-content/uploads/2017/07/login-saml-options-1.png)

In some scenarios it makes sense to enable the **Just-in-time provisioning** when you want to automatically create user accounts based on the data provided by the Identity Provider on the SAMLResponse.

* If just-in-time provisioning is disabled or the required user data is not provided, an error  will happen during the SSO process since we will not be able to initiate any Matomo account.

* If just-in-time provisioning is enabled, by default any new users (created with just-in-time provisioning) will have no access to Matomo. You may set a default `view` permission ([What is the ‘view’ permission in Matomo?](https://matomo.org/faq/general/faq_70/)) to some Matomo websites. Use the **Initial sites with view access for new users** to set a list of the Matomo Website IDs that the users will be able to view by default (comma separated list of Website IDs).

In order to identify your Matomo user accounts you need to set a value on the **Field to identify the user**, by default the **email** field will be used, but you can select **username** and the Matomo username field will be used.

You may also enable or disable the single logout functionality. Note that if you disable it, the Single Logout Service data will be not published on the Service Provider metadata.

You can also force users to use SAML authentication by enabling the "Force SAML Login" setting. Doing this will redirect all users directly to the Identity Provider, so the Matomo login screen will never be displayed. Super Users will still have to login normally to, for example, configure the SAML plugin. Super Users can login through the Matomo login screen by appending `?normal` to the URL when visiting Matomo. (Note: other users will not be able to login this way.)


To avoid Matomo asking you for password confirmation for specific actions (Invite user, 2FA changes, Create new auth token, ...), make sure to disable the "enable password confirmation" field.

## Attribute Mapping Settings

Depending on the values of **Field to identify the user** and **just-in-time provisioning**, the fields of the **Attribute Mapping Settings** section will be either required or optional.

![image](https://user-images.githubusercontent.com/600897/27050197-f48404ac-4fb1-11e7-846b-6bb41642045f.png)

* If just-in-time is enabled, all mapping fields will be required.
* If just-in-time provisioning is disabled then only the field related to the value of **Field to identify the user** will be required.

Identity Providers sends to the Service Provider the user data with custom attribute names, so you can use the previous form to map names between IdP and Matomo.

If you want to match Attributes of the SAML AttributeStatement using the FriendlyName rather than the Name values of the Attribute elements, make sure to enable at the Advanced settings section them
"Use SAML FriendlyName Attributes" checkbox.


## Access Synchronization settings

In the **Access Synchronization settings** section you can enable the user access synchronization from SAML attributes.

![image](https://user-images.githubusercontent.com/600897/27050908-869e0eb2-4fb4-11e7-83af-541575eea289.png)

LoginSAML supports synchronizing access levels using attributes found in the SAMLResponse provided by the Identity provider. To use this feature, be sure that the IdP is providing access data in 4 different SAML attributes:

- an attribute to specify the sites a user has `view` access to ([What is the view permission?](https://matomo.org/faq/general/faq_70/))
- an attribute to specify the sites a user has `write` access to ([What is the write permission?](https://matomo.org/faq/general/faq_26910/))
- an attribute to specify the sites a user has `admin` access to ([What is the admin permission?](https://matomo.org/faq/general/faq_69/))
- and an attribute used to specify if a user is a `superuser` or not ([What is the Super User in Matomo?](https://matomo.org/faq/general/faq_35/))

Note: You can choose whatever names you want for these attributes. You will then tell LoginSaml about these names in the SAML settings page.

Identity provider access data example:


    <saml:Attribute Name="view" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic">
        <saml:AttributeValue xsi:type="xs:string">all</saml:AttributeValue>
    </saml:Attribute>
    <saml:Attribute Name="admin" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic">
        <saml:AttributeValue xsi:type="xs:string">1,2,3</saml:AttributeValue>
    </saml:Attribute>
    <saml:Attribute Name="superuser" NameFormat="urn:oasis:names:tc:SAML:2.0:attrname-format:basic">
        <saml:AttributeValue xsi:type="xs:string">1</saml:AttributeValue>
    </saml:Attribute>


Then in the SAML settings page, check the **Enable User Access Synchronization from SAML** checkbox and fill out the settings that appear below it.

User access synchronization occurs before the user logs in.

## Managing Access for Multiple Matomo Instances

LoginSaml supports using a single IdP SAML server to manage access for multiple Matomo instances. If you'd like to use this feature, you must specify special values for SAML access attributes. For example:

- `view: mymatomoserver.whatever.com:1,2,3;myotherserver.com:all`
- `write: mymatomoserver.whatever.com:1,2;myotherserver.com:all`
- `admin: mymatomoserver.whatever.com:all;mythirdserver.com:3,4`
- `superuser: myotherserver.com;myotherserver.com/othermatomo`

If you don't want to use URLs in your access attributes, you can use the **Special Name For This Matomo Instance** setting to specify a special name for each of your Matomo instances. For example, if you set it to `matomoServerA` in one Matomo and `matomoServerB` in another, your SAML attributes might look like:

- `view: matomoServerA:1,2,3;matomoServerB:all`
- `write: matomoServerA:1,3`
- `admin: matomoServerA:4,5,6`
- `superuser: matomoServerC`

## Using a custom access attribute format

You can customize the separators used in access attributes by setting the **User Access Attribute Server Specification Delimiter** and **User Access Attribute Server & Site List Separator** settings.

If you set the **User Access Attribute Server Specification Delimiter** option to `#`, access attributes can be specified as:

`view: matomoServerA:1,2,3#matomoServerB:all`

If you set the **User Access Attribute Server & Site List Separator** option to `#`, access attributes can be specified as:

`view: matomoServerA#1,2,3;matomoServerB#all`

## Advanced Settings

In the **Advanced Settings** section you can enable/disable the debug mode and also configure advanced SAML and security parameters.

Those settings match [php-saml](https://github.com/onelogin/php-saml) settings (the underlying PHP library in use in the SAML plugin and provided by OneLogin inc.), so you can review its [documentation](https://github.com/onelogin/php-saml#settings) for more information.

![image](https://user-images.githubusercontent.com/600897/27051290-db8ebf1a-4fb5-11e7-8394-f841ba8433d5.png)

# How does SAML plugin for Matomo work?

This plugin adds the ability to execute SAML Single Sign On (SSO) and Single Logout (SLO) on the Service Provider side, but also on the Identity Provider. This section describes the SAML authentication flows.

## SP-initiated SSO authentication process

![image](https://user-images.githubusercontent.com/600897/27040361-0aa037f4-4f91-11e7-9f3c-a7b73bbfdb7d.png)

1. Redirect to Identity Provider (when "SAML Login" button on login screen is clicked):
    * **Log message**: Initiated the Single Sign On, Redirecting to the IdP (**Log level**: info)
2. When response from Identity Provider has come to Assertion Consumer Service endpoint:
    * **Log message**: Initiated the Assertion Consumer Service (**Log level**: info)
3. SAML validation successful:
    * **Log message**: SAMLResponse validated (**Log level**: info)
    * **Log message**: Attributes + NameId + NameIDFormat + SessionIndex (**Log level**: debug)
4. Or SAML validation returned some errors in response from Identity Provider:
    * **Log message**: SAMLResponse rejected. + Cause (**Log level**: error)
    * **Log message**: SAML Response XML (**Log level**: debug)
5. User creation (Optional step, if account was not found):
    * If user does not exist but Just-In-Time provisioning is enabled and required attributes are provided: **Log message**: Added user (**Log level**: info)
    * If user has no default sites access: **Log message**: SAML settings does not define default sites to provide access to new users in 'Options' section (**Log level**: warning)
    * If user has default sites access: **Log message**: Adding to user USER access to sites: SITES (**Log level**: info)
    * If user does not exists and Just-In-Time provisioning is enabled but process has failed: **Log message**: Just-in-time provisioning error // X mapping is required // X was not provided ( **Log level**: error)
    * If user does not exists and Just-In-Time provisioning disabled: **Log message**: User <user> does not exists and just-in-time provisioning is disabled (**Log level**: error)
6. Sync access (Optional step, if sync access enabled):
    * If user has no data access: **Log message**: User <user> has no access in SAML, but access synchronization is enabled. (**Log level**: warning)
    * If access data defines that user should be assigned as superuser: **Log message**: MatomoAccess synchronised. User <user> is now superuser (   **Log level**: info)
    * If access data defines user access on sites: *Log message**: MatomoAccess synched. Access of user <user> updated (**Log level**: info)
7. Successful login:
    * **Log message**: User with login <user> authenticated in Matomo (**Log level**: info)

## IdP-initiated SSO authentication process

![image](https://user-images.githubusercontent.com/600897/27040508-78f7769a-4f91-11e7-9e3a-8dcf29e019a5.png)

Similar to SP-initiated SSO but without step 1.

## SP-initiated Single Logout authentication process (SLO enabled)

![image](https://user-images.githubusercontent.com/600897/27040603-c7b1b9d0-4f91-11e7-8667-086a58948454.png)

1. Redirect to Identity Provider. (Logout Request sent). When "logout" link clicked and user session initiated with SAML flow:
    * **Log message**: Initiated the Single Log Out for user with login USER (**Log level**: info)
2.  When Logout Response from Identity Provider has come to Single Logout Service endpoint:
    * **Log message**: Initiated the Single Logout Service for user with login USER (**Log level**: info )
3. SAML validation:
    * If SAML Logout Response is valid: **Log message**: Single Logout Service executed. User with login USER logged out (       **Log level**: info  )
    * If there are some errors in Logout Response from Identity Provider: **Log message**: Error at Single Logout Service endpoint. User with login USER. + Error reason (    **Log level**: error)

## IdP-initiated Single Logout authentication process (SLO enabled)

![image](https://user-images.githubusercontent.com/600897/27040844-8b6efbee-4f92-11e7-98d1-f059711caf23.png)

1. When Logout Request from Identity Provider has come to Single Logout Service endpoint:
    * **Log message**: Initiated the Single Logout Service for user with login USER (**Log level**: info)
2. SAML validation:
    * If there are some errors in Logout Request from Identity Provider: **Log message**: Error at Single Logout Service endpoint. User with login USER. + Error reason (**Log level**: error)
3. Redirect to Identity Provider (Logout Response sent)
4. When Logout Response from Identity Provider has come to Single Logout Service endpoint:
    * **Log message**: Initiated the Single Logout Service for user with login USER ( **Log level**: info )
5. SAML validation is successful:
    * **Log message**: Single Logout Service executed. User with login USER logged out (**Log level**: info  )
6. Or SAML validated failed: errors returned in Logout Response from Identity Provider:
    * **Log message**: Error at Single Logout Service endpoint. User with login USER. + Error reason (**Log level**: error)

To learn more about how SAML flows works, visit:

* [medium.com/@BoweiHan/elijd-single-sign-on-saml-and-single-logout-624efd5a224](https://medium.com/@BoweiHan/elijd-single-sign-on-saml-and-single-logout-624efd5a224)
* [www.samltool.com/saml_documentation.php](www.samltool.com/saml_documentation.php)

# Security Considerations

**User passwords**

LoginSAML's generates for new users random hashed passwords. If those users want to use the normal login process, they should assign a valid password for them once authenticated via SAML.

**Token Auths**

SAML has no concept of authentication tokens, so a user's `token_auth` is stored exclusively in Matomo database. If a `token_auth` is compromised, you can re-generate the token in Matomo > Administration > Personal Settings.

**Logging**

LoginSAML uses debug logging extensively so problems can be diagnosed quickly. Some logs entries contain sensitive information, _so be sure to disable DEBUG logging in production_ and also switch off the "debug" mode on the advanced settings section of the SAML settings panel.

Learn more on the [LoginSaml for Matomo Analytics - SAML authentication plugin](https://plugins.matomo.org/LoginSaml) page.

# Troubleshooting

## Debugging

LoginSAML uses debug logging extensively so problems can be diagnosed quickly. Some logs entries contain sensitive information, so be sure to disable DEBUG logging in production and also switch off the `Debug Mode` in the Advanced Settings section of the SAML settings panel.

By default logs related with SAML will be found in Matomo folder `tmp/logs/saml.log` but can be changed defining a new value for the `logger_file_path` setting in the `[LoginSaml]` section of `config/config.ini.php`

The log level can be configured with the 'log_level' parameter and possible values are:

* `ERROR`
* `WARN`
* `INFO`
* `DEBUG`

The higher level, the smaller number of entries in logs. The highest level is `ERROR` level (the lowest is `DEBUG`).

If no `log_level` parameter defined in `[LoginSaml]` section then the default Matomo `log_level` value will be used (`WARN`).

## Using Just-in-time provisioning and getting message "Username was not provided by the IdP and is required in order to execute the SAML Just-in-time provisioning"

The problem is that Service Provider (Matomo) is not able to extract a username value from the SAMLResponse sent by the IdP. There are 2 possible reasons:

* The Attribute Mapping section at the SAML Settings of Matomo is wrong. There you might need to set the username field to the exact name of the attribute that came with the SAMLResponse.
* The IdP is not sending the username at all, so you may need to contact the Identity Provider administrator and ask him to configure the IdP to provide that user info.

Note that even if you are identifying users by the email address, the username is a required field when you are using Just-in-time provisioning: so both email and username must be provided. You can find out more about your SAML response by using SAML Tracer tool (see below).

## How to view the SAML and WS-Federation messages sent through the browser during single sign-on and single logout

There is a [Firefox extension names SAMLTracer](https://addons.mozilla.org/es/firefox/addon/saml-tracer/) that you can use to record and inspect the SAMLResponse sent by the IdP (see how to use it in [this video](https://www.youtube.com/watch?v=DLEif7nuNxg)).


# More saml_documentation

Get a [PDF](http://saml.info/Matomo_LoginSaml_Docs/Matomo.LoginSaml.plugin.pdf) with more documentation.
