<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 22/11/2017
 * Time: 12:20
 */

namespace Hafael\Abstracts\Http\Controllers\Api;

use Hafael\Abstracts\Http\Controllers\BaseController as Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use League\Fractal\Manager;
use Hafael\Abstracts\Traits\BaseApiReponses;


class BaseController extends Controller
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        BaseApiReponses;

    protected $statusCode = 200;

    const CODE_WRONG_ARGS = 'AUT1-WRONGARGS';
    const CODE_NOT_FOUND = 'AUT1-NOTFOUND';
    const CODE_INTERNAL_ERROR = 'AUT1-INTERNALERROR';
    const CODE_UNAUTHORIZED = 'AUT1-UNAUTHORIZED';
    const CODE_FORBIDDEN = 'AUT1-FORBIDDEN';
    const CODE_MOV_INSUFFICIENTFUNDS = 'MOV_INSUFFICIENTFUNDS';
    const CODE_CAR_DISABLED = 'CAR_DISABLED';
    const CODE_UBER_NOT_FOUND = 'AUT1-UBERNOTFOUND';
    const CODE_CAMPAIGN_UNAVAILABLE = 'CAMPAIGN_UNAVAILABLE';

    /**
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }


}