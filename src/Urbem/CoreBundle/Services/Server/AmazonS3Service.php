<?php

namespace Urbem\CoreBundle\Services\Server;

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;

/**
 * Class AmazonS3Service
 *
 * @package Acme\DemoBundle\Service
 */
class AmazonS3Service
{
    /**
     * @var S3Client
     */
    private $client;
    /**
     * @var string
     */
    private $bucket;
    /**
     * @param string $bucket
     * @param array  $s3arguments
     */
    public function __construct($bucket, array $s3arguments)
    {
        $config = (object)$s3arguments['credentials'];
        $credentials = new Credentials($config->key, $config->secret);
        $this->setBucket($bucket);
        $this->setClient(new S3Client([
            'version' => $config->version,
            'region'  => $config->region,
            'credentials' => $credentials
        ]));
    }
    /**
     * @param string $fileName
     * @param string $content
     * @param array  $meta
     * @param string $privacy
     * @return string file url
     */
    public function upload($fileName, $content, array $meta = [], $privacy = 'public-read')
    {
        return $this->getClient()->putObject(
            [
                'Bucket' => $this->getBucket(),
                'Key'    => $fileName,
                'Body'   => $content,
                'ACL'    => $privacy,
            ]
        );
    }
    /**
     * @param string       $fileName
     * @param string|null  $newFilename
     * @param array        $meta
     * @param string       $privacy
     * @return string file url
     */
    public function uploadFile($fileName, $newFilename = null, array $meta = [], $privacy = 'public-read') {
        if(!$newFilename) {
            $newFilename = basename($fileName);
        }
        if(!isset($meta['contentType'])) {
            // Detect Mime Type
            $mimeTypeHandler = finfo_open(FILEINFO_MIME_TYPE);
            $meta['contentType'] = finfo_file($mimeTypeHandler, $fileName);
            finfo_close($mimeTypeHandler);
        }
        return $this->upload($newFilename, file_get_contents($fileName), $meta, $privacy);
    }
    /**
     * Getter of client
     *
     * @return S3Client
     */
    protected function getClient()
    {
        return $this->client;
    }
    /**
     * Setter of client
     *
     * @param S3Client $client
     *
     * @return $this
     */
    private function setClient(S3Client $client)
    {
        $this->client = $client;
        return $this;
    }
    /**
     * Getter of bucket
     *
     * @return string
     */
    protected function getBucket()
    {
        return $this->bucket;
    }
    /**
     * Setter of bucket
     *
     * @param string $bucket
     *
     * @return $this
     */
    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
        return $this;
    }
}
