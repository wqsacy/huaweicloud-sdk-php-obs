# Laravel-HuaWeiOBS

[Huawei Cloud OBS](https://support.huaweicloud.com/devg-obs_php_sdk_doc_zh/zh-cn_topic_0132036136.html) storage for Laravel based on [wangqs/laravel-filesystem-obs](https://github.com/wqsacy/laravel-filesystem-obs).

## Installation and Configuration

Install the current version of the `goodgay/huaweiobs` package via composer:

```sh
composer require wangqs/laravel-filesystem-obs
```

### Laravel

The package's service provider will automatically register its service provider.

Publish the configuration file:

```sh
php artisan vendor:publish --provider="Wangqs\HuaweiOBS\HWOBSServiceProvider"
```

##### Alternative configuration method via .env file

After you publish the configuration file as suggested above, you may configure OBS
by adding the following to your application's `.env` file (with appropriate values):
  
```ini
HWOBS_ACCESS_KEY_ID=xxxxxxxx
HWOBS_SECRET_ACCESS_KEY=xxxxxxx
HWOBS_DEFAULT_REGION=region
HWOBS_BUCKET=test
HWOBS_URL=
HWOBS_ENDPOINT=https://obs.xxxxx.myhuaweicloud.com
```


### Lumen

If you work with Lumen, please register the service provider and configuration in `bootstrap/app.php`:

```php
$app->register(Wangqs\HuaweiOBS\HWOBSServiceProvider::class);
$app->configure('hwobs');

```

Manually copy the configuration file to your application.



## Usage

The `HWobs` facade is just an entry point into the [php-obs sdk](https://github.com/huaweicloud/huaweicloud-sdk-php-obs),
so previously you might have used:

```php

use Wangqs\ObsV3\ObsClient;
$obsClient = ObsClient::factory ( [
		'key' => $ak,
		'secret' => $sk,
		'endpoint' => $endpoint,
		'socket_timeout' => 30,
		'connect_timeout' => 10
] );

$resp = $obsClient -> listObjects(['Bucket' => $bucketName]);
foreach ( $resp ['Contents'] as $content ) {
    printf("\t%s etag[%s]\n", $content ['Key'], $content ['ETag']);
}
printf("\n");
    
```

You can now replace those last two lines with simply:

```php
use Wangqs\HuaweiOBS\HWobs;

$return = HWobs::all();

//or

$return = HWobs::obs()->listObjects(['Bucket' => $bucketName]);
```

Lumen users who wish to use Facades can do so by editing the 
`bootstrap/app.php` file to include the following:

```php
$app->withFacades(true,[
     Wangqs\HuaweiOBS\HWobs::class  => 'Hwobs'
]);
```




```php
// 文件系统的配置文件位于 config/filesystems.php
'hwobs' => [
    'driver'    => 'hwobs',
    'key'       => env('HWOBS_ACCESS_KEY_ID',''),
    'secret'    => env('HWOBS_SECRET_ACCESS_KEY',''),
    'region'    => env('HWOBS_DEFAULT_REGION',''),
    'bucket'    => env('HWOBS_BUCKET',''),
    'url'       => env('HWOBS_URL',''),
    'endpoint'  => env('HWOBS_ENDPOINT',''),
    'exceptionResponseMode'  => false,
],


Storage::disk('hwobs')->put('file.txt', 'Contents');

```



## Advanced Usage

Because the package is a wrapper around the official php-obs sdk, you can 
do pretty much anything with this package. 

To upload:

```php
$resp = HWobs::putText("object-name","some content");
$resp = HWobs::putFile("object-name","./some.txt");
```

To download:

```php
$resp = HWobs::getText("object-name");
$resp = HWobs::getStream("object-name");
$resp = HWobs::getFile("object-name",'save_path.txt');
```

To manage objects:

```php
$resp = HWobs::getMetadata("object-name");
$resp = HWobs::delete("object-name");
$resp = HWobs::all();
$resp = HWobs::deleteMulti(['object-name1','object-name2']);
```
