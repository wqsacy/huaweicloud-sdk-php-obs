<?php

namespace Wangqs\Obs\Internal\Signature;

use Wangqs\Obs\Internal\Common\Model;

interface SignatureInterface
{
	function doAuth(array &$requestConfig, array &$params, Model $model);
}