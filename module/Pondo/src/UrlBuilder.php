<?php

namespace Pondo;

/**
 * Class UrlBuilder
 */
class UrlBuilder
{
    public const BASE_URL_BACKOFFICE = 'backoffice';
    public const BASE_URL_BACKOFFICE_API = 'backoffice_api';
    public const BASE_URL_FRONTOFFICE = 'frontoffice';
    public const BASE_URL_WEBSITE = 'website';
    public const BASE_URL_MEDIA = 'media';

    /**
     * @var array All base URL's in the format [const => baseUrl]
     */
    protected $baseUrls;

    /**
     * UrlBuilder constructor.
     * @param array $baseUrls
     */
    public function __construct(array $baseUrls)
    {
        $this->baseUrls = $baseUrls;
    }

    /**
     * @param string      $baseUrl
     * @param string      $path
     * @param array|null  $query
     * @param string|null $fragment
     * @return string
     * @throws \InvalidArgumentException
     */
    public function buildUrl(string $baseUrl, string $path, ?array $query = null, ?string $fragment = null)
    {
        if (!isset($this->baseUrls[$baseUrl])) {
            throw new \InvalidArgumentException(sprintf('Cannot find base URL with name %s', $baseUrl));
        }

        $url = rtrim($this->baseUrls[$baseUrl], '/') . '/' . ltrim($path, '/');

        if ($query !== null) {
            $url .= '?' . http_build_query($query);
        }

        if ($fragment !== null) {
            $url .= '#' . $fragment;
        }

        return $url;
    }
}
