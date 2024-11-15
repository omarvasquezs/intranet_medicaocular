<?php

/**
 * BaseController
 * php version 8.2
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://omarvasquezs.github.io
 */

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

// GROCERY CRUD
require APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php';
use Config\Database as ConfigDatabase;
use Config\GroceryCrud as ConfigGroceryCrud;
use GroceryCrud\Core\GroceryCrud;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/omarvs91
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['url', 'form'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;
    protected $gc;
    protected $usuarios;
    protected $usuarios_roles;
    protected $documentos;
    protected $permisos;
    protected $boletas;
    protected $publicaciones;
    protected $cts;

    /**
     * Handles the global variables.
     *
     * @param RequestInterface  $request  The request object.
     * @param ResponseInterface $response The response object.
     * @param LoggerInterface   $logger   The logger object.
     *
     * @return void
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        date_default_timezone_set('America/Lima');
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->gc = $this->getGroceryCrudEnterprise();
        $this->usuarios = new \App\Models\Usuarios();
        $this->usuarios_roles = new \App\Models\UsuariosRoles();
        $this->documentos = new \App\Models\Documentos();
        $this->permisos = new \App\Models\Permisos();
        $this->boletas = new \App\Models\Boletas();
        $this->publicaciones = new \App\Models\Publicaciones();
        $this->cts = new \App\Models\Cts();
        // Custom validation rules
        \Valitron\Validator::addRule(
            'noSpacesBetweenLetters',
            function ($field, $value, array $params, array $fields) {

                // Check if the value contains any spaces between letters
                if (preg_match('/\s/', $value)) {
                    return false; // Return false if spaces are found
                }

                return true; // Return true if no spaces between letters are found
            }, 'no debe tener espacios.'
        );
    }
    /**
     * Handles the main output for rendering.
     * 
     * @param $output output object for rendering
     *
     * @return mixed
     */
    protected function mainOutput($output = null)
    {
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        return view('output', (array) $output);
    }
    /**
     * Handles the main output GC for rendering.
     * 
     * @param $output output object for rendering
     *
     * @return mixed
     */
    protected function mainOutputGC($output = null)
    {
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        return view('gc_output', (array) $output);
    }
    /**
     * Handles the getDbData to manage database creds.
     *
     * @return mixed
     */
    protected function getDbData()
    {
        $db = (new ConfigDatabase())->default;
        return [
            'adapter' => [
                'driver' => 'Pdo_Mysql',
                'host'     => $db['hostname'],
                'database' => $db['database'],
                'username' => $db['username'],
                'password' => $db['password'],
                'charset' => 'utf8'
            ]
        ];
    }
    /**
     * Handles the getGroceryCrudEnterprise.
     * 
     * @param $bootstrap bootstrap theme on CRUD.
     * @param $jquery    handles jQuery on CRUD.
     *
     * @return mixed
     */
    protected function getGroceryCrudEnterprise($bootstrap = true, $jquery = true)
    {
        $db = $this->getDbData();
        $config = (new ConfigGroceryCrud())->getDefaultConfig();

        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }
    /**
     * Handles the uploadFirmaValidations.
     *
     * @return mixed
     */
    public function uploadFirmaValidations()
    {
        return [
            'maxUploadSize' => '20M', // 20 Mega Bytes
            'minUploadSize' => '1K', // 1 Kilo Byte
            'allowedFileTypes' => [
                'png'
            ]
        ];
    }
    /**
     * Handles the uploadDocumentoValidations.
     *
     * @return mixed
     */
    public function uploadDocumentoValidations()
    {
        return [
            'maxUploadSize' => '20M', // 20 Mega Bytes
            'minUploadSize' => '1K', // 1 Kilo Byte
            'allowedFileTypes' => [
                'pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'txt'
            ]
        ];
    }
}
