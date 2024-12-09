# Setting Up OAuth Application on MiniOrange

## 1. Configure PHP App in MiniOrange
&nbsp;1. Follow the guide to configure your PHP application in MiniOrange: [MiniOrange Integration Guide](https://www.miniorange.in/iam/integrations/php-oauth-single-sign-on-sso#step1).

---

## 2. Download the Starter Application
&nbsp;1. Download the **Demo Starter Application** from this [GitHub repository](https://github.com/dev-shubham-mali/miniOrange-PHP-oauth-authentication-example-app/archive/refs/heads/main.zip).  
&nbsp;2. Extract the `phpStarterApplication` folder.  
&nbsp;3. Save the folder to:
   - **XAMPP**: Your `htdocs` folder.
   - **WAMP or other servers**: The root web directory.

---

## 3. Modify the `.env` File
&nbsp;1. Open the `.env` file in the extracted folder.  
&nbsp;2. Replace placeholders like `<YOUR_CLIENT_ID>` with the actual credentials copied during Step 1 from MiniOrange.  
&nbsp;3. Ensure you include the necessary configuration details for the OAuth process.  

---

## 4. Install Dependencies
&nbsp;1. Navigate to the `phpOAuth` directory (where the `composer.json` file is located).  
&nbsp;2. Run the following command to install required dependencies:  
   ```bash
   composer install
   ```
Make sure you have Composer installed to execute this command.
If not, refer to the [installation guide](https://www.javatpoint.com/how-to-install-composer-on-windows). Or download it from [here](https://getcomposer.org/Composer-Setup.exe). 

---

## 5. Start Your Server
&nbsp;1. Using XAMPP or WAMP Locally

* Launch the server software (e.g., XAMPP or WAMP).
* Ensure Apache or an equivalent web server is running.

---

## 6.  Open the Starter App in the Browser

* Open a web browser and enter the URL to access your application:
* For your  local environment go to http://localhost/your-folder-name/ to access the starter application.
[Also make sure to update dashboard Url in your-folder-name/oauth.php at line 40 with your-folder-name/dashboard.php]

---

## 7. Start and Test Authorization

&nbsp;1. initiate the authorization process by clicking the "Start Authorization" button in the starter app. 

&nbsp;2. This should redirect you to the authentication provider (MiniOrange) to complete the login.

&nbsp;3. After a successful login, you should be redirected back to your application, where you can verify the OAuth flow and ensure your user is authenticated.
