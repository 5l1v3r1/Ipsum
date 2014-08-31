## Ipsum, application for Network to register YouTube Channel.

![Ipsum App](http://i.gyazo.com/14613e6757950d98a8087e8bc62f883c.png)

## How to use it ?

* Installation : 
```
git clone https://github.com/martialdidit/Ipsum.git
cd Ipsum
composet install
cd public
bower install --allow-root
```

* Configuration :

 Informations about the network :
 ```
  nano public/config/network.json
 ```

 Change this lines by your own informations : 
 ```
 {

    "name": "beta_test", //name of your network
    "email": "test@test.com", //email to contact you
    "analytics": 200, //the average view during 30 days to accept a channel
    "default_language": "en" //the default language. fr or en
    ...
 }
 ```

* Add your contract :

 ```
  nano ipsum/public/config/contract.html
 ```

 Add your contract between this line. If a channel pass the average view and want to enter in your network, she need to accept your contract

 ```
 <!--not delete --><p class="contract"><!--not delete -->

 Your contract

 <!--not delete --></p><!--not delete -->

 ```

 ####Register valid channel into your database :

 * Create the database
 
  ```
  mysql -u user - p > ipsum/app/database.sql
 
  ```

 * Add database information

  ```
   nano ipsum/app/config.php
  ```
   Change with your informations : 
 
  ```
$host = "localhost";
$dbname = "name of the database";
$user = "user";
$password = "password";
$userMail = "the mail of the network"; //ipsum will send you a mail when a channel accept the contract to join your network
$passwordMail = "password"; //password of the mail
  
 ```
 
If you don't recieve a mail, check the [wiki](https://github.com/martialdidit/Ipsum/wiki)

### Difficult part : Allow connection with Google

You need OAuth 2.0 credentials, including a client ID and client secret, to authenticate users and gain access to Google's APIs.

To find your project's client ID and client secret, do the following:

1. Go to the [Google Developers Console](https://console.developers.google.com/project).
2. Select a project, or create a new one.
3. In the sidebar on the left, expand APIs & auth. Next, click APIs. In the list of APIs, make sure all of the APIs you are using show a status of ON.
 - Google+ API
 - YouTube Analytics API
 - YouTube Data API v3
4. In the sidebar on the left, select Credentials.
5. If you haven't done so already, create your project's OAuth 2.0 credentials by clicking Create new Client ID, and providing the information needed to create the credentials.
6. Creat a public key by clicking on "Creat new key" -> "server key" -> "new key"

Use this informations to complete the file 

```
nano ipsum/public/app/service/gapsi.js

Line : 

var OAUTH2_CLIENT_ID = 'YOUR CLIEND ID';
var APIKEY = "YOUR API KEY";
```


You can follow this tutorial for more customisation : https://developers.google.com/accounts/docs/OAuth2Login


## Add Apache subdomain or alias : 

If you want user access to this application with custom url like : apply.yourdomain.com

* Alias :

```
Alias /ipsum/ "path/Ipsum/public/" 

<Directory "path/Ipsum/public/">
    Options Indexes FollowSymLinks MultiViews
    AllowOverride all
        Order allow,deny
    Allow from all
</Directory>
```

* Subdomain 

```
ServerName apply.domain.com 
DocumentRoot "path/Ipsum/public/"
<Directory "path/Ipsum/public/">
    Options Indexes FollowSymLinks MultiViews
    AllowOverride all
        Order allow,deny
    Allow from all
</Directory>
```

That's all ! 

### Add a language and contribute to Ipsum

 See the [wiki](https://github.com/martialdidit/Ipsum/wiki) page, explain how to add your own language.
