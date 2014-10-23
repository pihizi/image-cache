<?php
/**
* @file ImageCache.php
* @brief RPC
* @author Hongjie Zhu
* @version 0.1.0
* @date 2014-10-21
 */

namespace Gini\Controller\API;

class ImageCache extends \Gini\Controller\API
{

    public function actionAuthorize($client_id, $client_secret)
    {
        if (!\Gini\ImageCache\Client::check($client_id, $client_secret)) return false;
        return \Gini\ImageCache\RPC::setCurrentClient($client_id)===true ? true : false;
    }

    public function actionDelete($url, $path=null)
    {
        $client_id = \Gini\ImageCache\RPC::getCurrentClient();
        if (!$client_id) return;
        $client_secret = \Gini\ImageCache\Client::getSecret($client_id);
        if (!$client_secret) return;
        $hash = \Gini\ImageCache\File::hash($url, $client_secret);
        return \Gini\ImageCache\File::globDelete($hash, $path);
    }

} // END class
