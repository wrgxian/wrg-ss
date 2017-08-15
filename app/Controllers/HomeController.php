<?php

namespace App\Controllers;

use App\Services\Factory;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\InviteCode;
use App\Utils\Check;
use App\Utils\Http;
use Exception;
use Swagger;

/**
 *  HomeController.
 */
class HomeController extends BaseController
{
    public function index()
    {
        return $this->view('index');
    }

    public function dashboard()
    {
        return $this->view('dashboard');
    }

    public function admin()
    {
        return $this->view('admin');
    }

    public function code()
    {
        $codes = InviteCode::where('user_id', '=', '0')->take(10)->get();
        return $this->view('code', [
            "codes" => $codes,
        ]);
    }

    public function debug(Request $request, $response, $args)
    {
        $server = [
            'headers' => $request->getHeaders(),
            'content_type' => $request->getContentType(),
            'cookies' => $request->getCookieParams(),
        ];
        $res = [
            'server_info' => $server,
            'ip' => Http::getClientIP(),
            'version' => get_version(),
            'reg_count' => Check::getIpRegCount(Http::getClientIP()),
            'e' => Factory::getCache()->has('ez370Y84NT5cBkuxoGHTYR5UqGdlKaS5zwOW515hLoSBG7ogtG5MgGNBdhUprMpn'),
            // 'user' => user(),
        ];
        return $this->echoJson($response, $res);
    }


    public function serverError()
    {
        throw new Exception("500");
    }


    /**
     * @SWG\Info(title="ss-panel API", version="4.0")
     */

    /**
     * @SWG\Get(
     *     path="https://demo.sspanel.xyz/doc",
     *     @SWG\Response(response="200", description="Api for ss-panel")
     * )
     */

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     */
    public function doc(Request $request, Response $response, $args)
    {
        $swagger = Swagger\scan(base_path('app'));
        header('Content-Type: application/json');
        echo $swagger;
    }


}
