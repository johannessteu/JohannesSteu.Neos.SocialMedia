<?php
namespace JohannesSteu\Neos\SocialMedia\Helper;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.Eel".             *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Facebook\Facebook;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Eel\ProtectedContextAwareInterface;

/**
 *
 */
class FacebookHelper implements ProtectedContextAwareInterface
{

    /**
     * @Flow\InjectConfiguration(package="JohannesSteu.Neos.SocialMedia", path="facebook")
     */
    protected $configuration;

    /**
     *
     */
    public function newsStream()
    {
        $fb = new Facebook($this->configuration);
        $posts = $fb->get('/me/feed')->getGraphEdge();

        $streamPosts = [];

        foreach ($posts as $post) {
            /** @var \Facebook\GraphNodes\GraphNode $post */
            $postId = $post->getField('id');

            $thePost = $fb->get('/'.$postId.'?fields=picture,description,caption,created_time,full_picture,link,source,message');
            $streamPosts[] = $thePost->getGraphNode()->asArray();
        }

        return $streamPosts;
    }

    /**
     * @param string $methodName
     * @return boolean
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }

}