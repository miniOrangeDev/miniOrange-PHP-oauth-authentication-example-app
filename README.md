# miniOrange-PHP-oauth-authentication-example-app
This guide outlines the steps to quickly integrate OAUTH authentication into your PHP app using miniOrange as the identity provider

## Configure MiniOrange 
### 1.Create an OAuth application in the miniOrange Dashboard 
visit this link to create [OAuth application](https://www.miniorange.com/iam/content-library/admin-docs/how-to-add-oauth-app)

# Installation 
You can fork this repository or download these files and save it in your **htdocs** folder (for XAMPP)  or the root web directory of your server (for WAMP or another local server).

# Modify the .env File 
In this step, you need to provide your client credentials that we've copied earlier from previous steps and configuration details by modifying the .env file. These credentials are required for the OAuth process to authenticate and authorize users.

Also make sure to replace the placeholders (<Your_Client_ID>, etc). with the actual values provided by MiniOrange.

    CLIENT_ID=<YOUR_CLIENT_ID>
    CLIENT_SECRET=<YOUR_CLIENT_SECRET>
    BASE_URL=<YOUR_BASE_URI>
    REDIRECT_URI=<YOUR_REDIRECT_URI>
    PEM_CERTIFICATE_PATH=<PEM_CERTIFICATE_PATH> # Note: Use forward slashes (/) for paths
    SCOPE=<ENTER_SCOPE_HERE> # Supported scopes => openid, email, profile
    GRANT_TYPE=<YOUR_GRANT_TYPE> # Default is authorization_code, supported grant types =>   implicit, authorization_code_pkce, authorization_code
In this step, you need to ensure that the credentials and configuration details in the .env file are accurate, especially the PEM certificate path and other key parameters.

# Install Dependencied:
navigate to phpOauth Directory where the composer.json file is located and run the following command to install all required dependencies:

### `composer install`

Make sure you have Composer installed to execute this command. If not , refer to the [installation guide](https://www.javatpoint.com/how-to-install-composer-on-windows). Or download it from [here](https://getcomposer.org/Composer-Setup.exe)

# Start Your Server 

If using XAMPP or WAMP locally : Launch the server software (eg,XAMPP OR WAMP) and ensure Apache (or an equivalent web server) is running.

# Open Starter App in Browser 
Open a web browser and enter the URL to access your application: 

For your local environment go to HTTP://localhost/<your-folder-name>/to access the starter application

# Start and Test Authorization

initiate the authorization process by clicking the "Start Authorization" button in the starter app. This should redirect you to the authentication provider (MiniOrange) to complete the login.
After a successful login, you should be redirected back to your application, where you can verify the OAuth flow and ensure your user is authenticated.
Or You can Enter your username and password for password grant and test OAuth Flow.



