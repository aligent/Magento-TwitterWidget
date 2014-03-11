<?php

class Aligent_FeedsReader_Block_Twitter extends Mage_Core_Block_Template
{

    function __construct()
    {
        $this->addData(array(
            'cache_lifetime'    => 3600,
            'cache_tags'        => array(Mage_Core_Model_Store::CACHE_TAG, Mage_Cms_Model_Block::CACHE_TAG)
        ));
    }

    function getTweets($count = null, $trimUser = null, $replies = null)
    {
        $enabled = Mage::getStoreConfig('aligentfeedsreader/twitter/enabled');
        if (!$enabled) return array();
        $count = $count ? $count : Mage::getStoreConfig('aligentfeedsreader/twitter/tweet_amount');
        $trimUser = $trimUser ? $trimUser : Mage::getStoreConfig('aligentfeedsreader/twitter/user_data');
        $trimUser = $trimUser ? '0' : '1';
        $replies = $replies ? $replies : Mage::getStoreConfig('aligentfeedsreader/twitter/get_replies');
        $replies = $replies ? '0' : '1';
        $screenName = Mage::getStoreConfig('aligentfeedsreader/twitter/screen_name');
        $consumerKey = Mage::getStoreConfig('aligentfeedsreader/twitter/consumer_key');
        $consumerSecret = Mage::getStoreConfig('aligentfeedsreader/twitter/consumer_secret');
        $accessToken = Mage::getStoreConfig('aligentfeedsreader/twitter/access_token');
        $accessTokenSecret = Mage::getStoreConfig('aligentfeedsreader/twitter/access_token_secret');
        $requestUrl = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $screenName .  '&count=' . $count . '&trim_user=' . $trimUser . '&exclude_replies=' . $replies;

        try {
            $oauth = new OAuth($consumerKey, $consumerSecret);
            $oauth->setToken($accessToken, $accessTokenSecret);
            $oauth->fetch($requestUrl);
            $response = json_decode($oauth->getLastResponse());
            if (!is_array($response)) $response = array();
        } catch (Exception $e) {
            $response = array();
        }

        return $response;
    }

    public function getCacheKeyInfo()
    {
        return array(
            'ALIGENT_FEEDS_TWITTER_BLOCK',
            Mage::app()->getStore()->getId(),
            (int)Mage::app()->getStore()->isCurrentlySecure(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template')
        );
    }

}

