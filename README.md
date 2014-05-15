NK Notifications
================

Overview
--------
This is a stand-alone command line application which makes it easy to send notifications to users from application integrated with nk.pl.
All you need is:
* a PHP with cURL and PECL installed, 
* API credentials which your application uses for usual REST requests and signatures (obtained from nk.pl),
* A text, link's title and link's params to include in each message,
* A list of `person.id`s of recipients


This project is heavily based on :
* http://oauth.googlecode.com/svn/code/php
* https://gist.github.com/rraptorr/4971813

Installation
------------
Download the contents of this repo. 
```
wget https://github.com/qbolec/nk-notifications/archive/master.zip
unzip master.zip
mv nk-notifications-master nk-notifications
cd nk-notifications
```
That's it.

Just make sure you have PHP with cURL installed, by running:
`php -i | grep -i curl`
The output should be something like:
```
Additional .ini files parsed => /etc/php5/cli/conf.d/curl.ini,
curl
cURL support => enabled
cURL Information => 7.18.2
```

Running
-------
To properly authenticate your requests you need to provide two pieces of information,
which you can easily find at https://developers.nk.pl/developers in your app's settings:

* OAuth's Key for your application (this can be found in "Additional Settings" section of app's settings page - actually it is something that the developer provides, so you should already know that)
* OAuth's Secret for your application (this can be found near the OAuth's Key, and is automatically generated by nk.pl and should be kept secret) 

You can send notifications like this:
```
php send_notifications.php --key [OAUTH KEY] --secret [OAUTH SECRET] --body [TEXT MESSAGE] --link_title [LINK TITLE] --uri_params [URI PARAMS]
```
and feed ids of persons to STDIN. For example:
```
php send_notifications.php --key 'myapptestkey' --secret 'qwerty' --body 'You need to milk the cow!' --link_title 'Milk it!' --uri_params 'action=milk&source=notification' <<< "person.123456"
```

You can provide as many person ids as you want - one in each line. This makes it supper easy to send bulk of thousands of messages with a single run of the script - for example:
```
mysql --skip-column-names <<< "SELECT person_id FROM users" | 
php send_notifications.php --key 'myapptestkey' --secret 'qwerty' --body 'X-Mass offer is here!' --link_title 'Visit Shop!' --uri_params 'action=shop&source=ad'
```

The `--body` controls the "black" text of the notification. 

The `--link_title` is the "blue" fragment which is the link to your application. 

Use `--uri_params` to provide extra url parameters which will be forwarded to your game/application when user clicks the link, so that you can react accordingly. It is totaly up to you what parameters you want to pass and what is their meaning in your app.

Current implementation waits till the end of person ids stream before sending notifications, so if you provide `person.id`s using keyboard you might want to finish the list of ids with a single empty line ( or EOF which is CTRL+D under linux and CTRL+Z under windows).
