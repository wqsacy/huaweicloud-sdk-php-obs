<?php namespace Wangqs\HuaweiOBS;

use Wangqs\ObsV3\ObsClient;
use Wangqs\HuaweiOBS\Traits\Upload;
use Wangqs\HuaweiOBS\Traits\Download;
use Wangqs\HuaweiOBS\Traits\Objects;

class Client {

    use Upload,Download,Objects;

    protected $obs      = null;
    protected $bucket   = '';

    public function __construct(ObsClient $obsClient)
    {
        $this->obs      = $obsClient;
        $this->bucket   = config("hwobs.bucket");
    }

    public function obs()
    {
        return $this->obs;
    }

}