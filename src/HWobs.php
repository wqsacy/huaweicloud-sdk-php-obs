<?php 
namespace Wangqs\HuaweiOBS;

use Illuminate\Support\Facades\Facade;


/**
 * Class Facade
 *
 * @package Wangqs\HuaweiOBS
 */
class HWobs extends Facade
{

    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'hwobs';
    }
}
