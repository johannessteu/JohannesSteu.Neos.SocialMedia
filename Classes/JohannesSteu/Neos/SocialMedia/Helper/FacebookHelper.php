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
    public function newsStream($pageid, $limit = 10)
    {
        $configuration = $this->configuration;
        $fields = $this->configuration['fields'];
        unset($this->configuration['fields']);

        $fb = new \Facebook\Facebook($this->configuration);

        $posts = $fb->get(sprintf('/%s/posts?fields=%s&limit=%s', $pageid, $fields, $limit))->getGraphEdge();
        return $posts->asArray();
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