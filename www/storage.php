<?php
/**
 * Created by PhpStorm.
 * User: panch
 * Date: 21/03/2019
 * Time: 23:38
 */

require_once "vendor/autoload.php";

date_default_timezone_set("Europe/Paris");

class Minio {
    private static $S3;

    public function build_Minio(){
        $this->S3 = new Aws\S3\S3Client([
            'version' => 'latest',
            'region' => 'eu-west-1',
            'endpoint' => 'http://minio:9000',
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => getenv('MINIO_ACCESS_KEY'),
                'secret' => getenv('MINIO_SECRET_KEY'),
            ]
        ]);

        if (empty(self::listBuckets()->get('Buckets'))){
            self::initBucket();
        }

        return self::$S3;
    }

    public function initBucket($bucket='gestion-produits-main'){
        return self::build_Minio()->initBucket([
            'Bucket' => $bucket
        ]);
    }

    public function listBucket($bucket='gestion-produits-main'){
        return self::build_Minio()->listBuckets();
    }

    public function getObject($key, $bucket='gestion-produits-main'){
        return $this->S3->getObject([
            'Bucket'    => $bucket,
            'Key'       => $key,
        ])["Body"];
    }

    public function putObject($key, $body, $bucket='gestion-produits-main'){
        $this->S3->putObject([
            'Bucket'    => $bucket,
            'Key'       => $key,
            'Body'      => fopen($body, 'r')
        ]);
    }

    public function deleteObject($key, $bucket='gestion-produits-main'){
        $this->S3->deleteObject([
            'Bucket'    => $bucket,
            'Key'       => $key,
        ]);
    }
}