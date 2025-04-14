## Setting Up LoginTokenAuth in Matomo

1. **Log In as Super User**
    - Access your Matomo account as a Super User.
    - Navigate to the Settings section.
    - Click on Marketplace.

2. **Install and Activate the Plugin**
    - Search for the LoginTokenAuth plugin.
    - Install the plugin.
    - After installation, click Activate.

3. **Use the logme Method for Login**
    - To log in using the token, use the following URL format:

      `https://matomo.example.com/index.php?module=LoginTokenAuth&action=logme&token_auth=YOUR_TOKEN_STRING`
      
    - TokenAuth login is available for all users except Super Users.
    - You can include any parameters that are allowed by the default `logme` method of the standard Matomo Login Plugin.

## Creating a Token

You can create a token by either:
1. Navigating to the user’s security page within Matomo.
2. Using the Matomo API to generate the token.