## How to install this project

To do that, at first you should set your env variables, 
for this part you can use this command:
#### cp .env.example .env
Next step is filling the variables of .env file according to
what you have on your device.
Then you sould run these commands:

#### cd src
#### composer install
#### php database/seeds/dbseed.php
#### php -S localhost:8000 -t public

## How to run the tests

To do that you can run this command

#### vendor/bin/phpunit tests/UrlTest.php


## About this project

A URL shortener service creates a short url/aliases/tiny url against a long url.Moreover, when user click on the tiny url, he gets redirected to original url.
Tiny url are exceedingly handy to share through sms/tweets (where there is limit to number of characters that can be messaged/tweeted) and also when they are printed in books/magazines etc.(Less character implies less printing cost). In addition, it is easy and less error prone to type a short url when compared to its longer version.

### For example:

#### Long URL: https://aparat.com/live/dfdvrghn
#### Short URL : https://tinyurl.com/3sh2ps6v

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
