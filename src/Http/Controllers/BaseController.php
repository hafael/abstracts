<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 22/11/2017
 * Time: 12:21
 */

namespace Hafael\Abstracts\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 * @package Hafael\Abstracts\Http\Controllers
 * @resource Abstract BaseController
 *
 * Controller for testing
 */
class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}