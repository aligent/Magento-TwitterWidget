# Magento Twitter Feed
Gets a feed of a twitter users tweets from Twitter API v1.1

## Requirements
1. Twitter account to create Developer App (to generate oAuth keys)
2. PHP oAuth PECL extension

## Installation
1. Install oAuth php extension
````
sudo pecl install oAuth
````
2. If you get an error comaining about prec not being available install that via
````
apt-get install libpcre3-dev
````
Then run the oAuth install again
3. Add the extension to php.ini
````
extension=oauth.so
````
4. Restart Apache
````
service apache2 restart
````
5. Install module
6. Login to Twitter developer site and create a new app (doesn't have to be on the account the feed will be pulled from)
7. Create access tokens
8. In magento admin system config find Aligent Feeds under Advanced and enter the consumer key/secret and access token/secret, enter the screen name for the twitter account to get the feed for as well as the amount of tweets to request, save config
9. Add Aligent Feeds block in layout xml
````xml
<block type="aligent_feeds/twitter" name="social" template="aligent/feeds/twitter.phtml" />
````
10. Twitter feed!

## Notes
1. The same application can be used for multiple feeds
2. The Twitter API is strange in that the get replies option is filtered after the amount is retrieved, so if you request 20 tweets, and to exclude replies, you may end up with only 10 tweets. So if you want 20 tweets excluding replies you'll need to request either heaps and then trim to 20 (still not guaranteed), or keep requesting until you get your 20 tweets.
