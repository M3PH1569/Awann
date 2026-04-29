<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
// abstract class BaseController extends Controller
// {
//     /**
//      * Be sure to declare properties for any property fetch you initialized.
//      * The creation of dynamic property is deprecated in PHP 8.2.
//      */

//     // protected $session;

//     /**
//      * @return void
//      */
//     public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
//     {
//         // Load here all helpers you want to be available in your controllers that extend BaseController.
//         // Caution: Do not put the this below the parent::initController() call below.
//         // $this->helpers = ['form', 'url'];

//         // Caution: Do not edit this line.
//         parent::initController($request, $response, $logger);

//         // Preload any models, libraries, etc, here.
//         // $this->session = service('session');
//     }
// }

abstract class BaseController extends Controller
{
    // ... properti lainnya ...

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Bersihkan semua input global dari karakter 0xa0
        $_GET = $this->filterBadUtf8($_GET);
        $_POST = $this->filterBadUtf8($_POST);
        $_REQUEST = $this->filterBadUtf8($_REQUEST);
    }

    private function filterBadUtf8($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'filterBadUtf8'], $data);
        }

        if (is_string($data)) {
            // Hapus byte 0xa0 secara eksplisit
            $data = str_replace(chr(160), ' ', $data);
            $data = str_replace("\xA0", ' ', $data);

            // Buang karakter yang tidak valid secara UTF-8
            return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        }

        return $data;
    }
}
