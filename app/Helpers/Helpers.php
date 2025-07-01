<?php

namespace App\Helpers;

use App\Models\Guias;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Models\marcas;
use App\Models\Predios;
use App\Models\solicitudesModel;
use Carbon\Carbon;
use PhpCfdi\Credentials\Credential;

class Helpers
{ 


  public static function firmarCadena(string $cadenaOriginal, string $password, int $userId)
{
    try {
        // Validación de usuario y contraseña
        $passwords = [
            6 => '890418jks',   // Karen Velázquez
            9 => 'Mejia2307',   // Erik
            7 => 'ZA27CI09',    // Zaida
            14 => 'v921009villa' // Mario
        ];

        $password = $passwords[$userId] ?? $password;

        // Rutas de los archivos en storage
        $cerPath = storage_path("app/public/firmas/efirma/{$userId}.cer");
        $keyPath = storage_path("app/public/firmas/efirma/{$userId}.key");

        // Verificar que los archivos existen
        if (!file_exists($cerPath) || !file_exists($keyPath)) {
            return [
                'error' => 'No se encontraron los archivos de la firma'
            ]; // ✅ Devolvemos un ARRAY en lugar de JsonResponse
        }

        // Crear la credencial con los archivos
        $credential = Credential::openFiles($cerPath, $keyPath, $password);

        // Firmar la cadena
        $firma = base64_encode($credential->sign($cadenaOriginal));

        return [
            'cadena_original' => $cadenaOriginal,
            'firma' => $firma,
            'rfc' => $credential->certificate()->rfc(),
            'nombre' => $credential->certificate()->legalName()
        ];
    } catch (\Exception $e) {
        return [
            'error' => 'No se pudo firmar la cadena: ' . $e->getMessage()
        ]; // ✅ Ahora el error es un array y no un JsonResponse
    }
}


  public static function generarFolioMarca($id_empresa)
  {
      $count = marcas::where('id_empresa', $id_empresa)->count();
      return chr(65 + ($count % 26)); // 65 es el código ASCII para 'A'
  }

  public static function generarFolioGuia($id_predio)
  {
      $predio = Predios::where('id_predio', $id_predio)->first();
      $count = Guias::where('id_predio', $id_predio)->count();
      $numPredio = str_replace('UVEM', '', $predio->num_predio);
       // Rellenar el contador con ceros hasta 3 dígitos
      $countPadded = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
      // Generar el folio concatenando el número del predio con la letra 'G' y el contador relleno
      return $numPredio . 'G' . $countPadded; 
  }

  public static function generarFolioSolicitud()
    {
        // Obtener el año actual
        $year = date('Y');
        
        // Contar cuántos registros hay en el modelo solicitudesModel
        $count = solicitudesModel::count() + 1; // Sumar 1 al número actual para el siguiente consecutivo

        // Formatear el consecutivo con ceros a la izquierda (5 dígitos)
        //$consecutivo = str_pad($count, 5, '0', STR_PAD_LEFT);
        $consecutivo =  str_pad($count + 12691, 5, '0', STR_PAD_LEFT);

        // Retornar el folio en el formato SOL-año-consecutivo
        return "SOL-$consecutivo";
    }
    public static function formatearFecha($fecha)
    {
        if (empty($fecha)) {
            return 'N/A'; // Retornar 'N/A' si la fecha es vacía
        }
    
        try {
            // Intentar crear un objeto Carbon, sin importar si es 'date' o 'datetime'
            $fechaCarbon = Carbon::parse($fecha);
            $fechaCarbon->locale('es'); // Establecer el idioma a español
    
            // Formatear la fecha
            return $fechaCarbon->translatedFormat('d \d\e F \d\e\l Y');
        } catch (\Exception $e) {
            return 'N/A'; // Retornar 'N/A' si hay algún error al parsear la fecha
    }
    }


    
    public static function formatearFechaHora($fecha)
      {
          // Verificar que la cadena de fecha tenga el formato correcto: 'Y-m-d H:i:s' (Año-Mes-Día Hora:Minutos:Segundos)
          if (empty($fecha) || !preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $fecha)) {
              return 'N/A'; // Retornar 'N/A' si el formato es incorrecto o la fecha es vacía
          }

          // Crear un objeto Carbon a partir de la cadena de fecha y hora
          $fechaCarbon = Carbon::createFromFormat('Y-m-d H:i:s', $fecha);
          $fechaCarbon->locale('es');

          // Formatear la fecha y hora en español
          return $fechaCarbon->translatedFormat('d \d\e F \d\e\l Y \a \l\a\s H:i:s');
      }


      public static function extraerHora($fecha){
        return Carbon::parse($fecha)->format("H:i:s");
      }

  public static function appClasses()
  {

    $data = config('custom.custom');




    // default data array
    $DefaultData = [
      'myLayout' => 'vertical',
      'myTheme' => 'theme-default',
      'myStyle' => 'light',
      'myRTLSupport' => true,
      'myRTLMode' => true,
      'hasCustomizer' => true,
      'showDropdownOnHover' => true,
      'displayCustomizer' => true,
      'contentLayout' => 'compact',
      'headerType' => 'fixed',
      'navbarType' => 'fixed',
      'menuFixed' => true,
      'menuCollapsed' => false,
      'footerFixed' => false,
      'menuFlipped' => false,
      // 'menuOffcanvas' => false,
      'customizerControls' => [
        'rtl',
        'style',
        'headerType',
        'contentLayout',
        'layoutCollapsed',
        'showDropdownOnHover',
        'layoutNavbarOptions',
        'themes',
      ],
      //   'defaultLanguage'=>'en',
    ];

    // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
    $data = array_merge($DefaultData, $data);

    // All options available in the template
    $allOptions = [
      'myLayout' => ['vertical', 'horizontal', 'blank', 'front'],
      'menuCollapsed' => [true, false],
      'hasCustomizer' => [true, false],
      'showDropdownOnHover' => [true, false],
      'displayCustomizer' => [true, false],
      'contentLayout' => ['compact', 'wide'],
      'headerType' => ['fixed', 'static'],
      'navbarType' => ['fixed', 'static', 'hidden'],
      'myStyle' => ['light', 'dark', 'system'],
      'myTheme' => ['theme-default', 'theme-bordered', 'theme-semi-dark'],
      'myRTLSupport' => [true, false],
      'myRTLMode' => [true, false],
      'menuFixed' => [true, false],
      'footerFixed' => [true, false],
      'menuFlipped' => [true, false],
      // 'menuOffcanvas' => [true, false],
      'customizerControls' => [],
      // 'defaultLanguage'=>array('en'=>'en','fr'=>'fr','de'=>'de','ar'=>'ar'),
    ];

    //if myLayout value empty or not match with default options in custom.php config file then set a default value
    foreach ($allOptions as $key => $value) {
      if (array_key_exists($key, $DefaultData)) {
        if (gettype($DefaultData[$key]) === gettype($data[$key])) {
          // data key should be string
          if (is_string($data[$key])) {
            // data key should not be empty
            if (isset($data[$key]) && $data[$key] !== null) {
              // data key should not be exist inside allOptions array's sub array
              if (!array_key_exists($data[$key], $value)) {
                // ensure that passed value should be match with any of allOptions array value
                $result = array_search($data[$key], $value, 'strict');
                if (empty($result) && $result !== 0) {
                  $data[$key] = $DefaultData[$key];
                }
              }
            } else {
              // if data key not set or
              $data[$key] = $DefaultData[$key];
            }
          }
        } else {
          $data[$key] = $DefaultData[$key];
        }
      }
    }
    $styleVal = $data['myStyle'] == "dark" ? "dark" : "light";
    $styleUpdatedVal = $styleVal;
    if (isset($_COOKIE['mode'])) {
      if ($_COOKIE['mode'] === "system") {
        if (isset($_COOKIE['colorPref'])) {
          $styleVal = Str::lower($_COOKIE['colorPref']);
        }
      } else {
        $styleVal = $_COOKIE['mode'];
      }
      $styleUpdatedVal = $_COOKIE['mode'];
    }
    isset($_COOKIE['theme']) ? $themeVal = $_COOKIE['theme'] : $themeVal = $data['myTheme'];

    $directionVal = isset($_COOKIE['direction']) ? ($_COOKIE['direction'] === "true" ? 'rtl' : 'ltr') : $data['myRTLMode'];

    //layout classes
    $layoutClasses = [
      'layout' => $data['myLayout'],
      'theme' => $themeVal,
      'themeOpt' => $data['myTheme'],
      'style' => $styleVal,
      'styleOpt' => $data['myStyle'],
      'styleOptVal' => $styleUpdatedVal,
      'rtlSupport' => $data['myRTLSupport'],
      'rtlMode' => $data['myRTLMode'],
      'textDirection' => $directionVal,//$data['myRTLMode'],
      'menuCollapsed' => $data['menuCollapsed'],
      'hasCustomizer' => $data['hasCustomizer'],
      'showDropdownOnHover' => $data['showDropdownOnHover'],
      'displayCustomizer' => $data['displayCustomizer'],
      'contentLayout' => $data['contentLayout'],
      'headerType' => $data['headerType'],
      'navbarType' => $data['navbarType'],
      'menuFixed' => $data['menuFixed'],
      'footerFixed' => $data['footerFixed'],
      'menuFlipped' => $data['menuFlipped'],
      'customizerControls' => $data['customizerControls'],
    ];

    // sidebar Collapsed
    if ($layoutClasses['menuCollapsed'] == true) {
      $layoutClasses['menuCollapsed'] = 'layout-menu-collapsed';
    }

    // Header Type
    if ($layoutClasses['headerType'] == 'fixed') {
      $layoutClasses['headerType'] = 'layout-menu-fixed';
    }
    // Navbar Type
    if ($layoutClasses['navbarType'] == 'fixed') {
      $layoutClasses['navbarType'] = 'layout-navbar-fixed';
    } elseif ($layoutClasses['navbarType'] == 'static') {
      $layoutClasses['navbarType'] = '';
    } else {
      $layoutClasses['navbarType'] = 'layout-navbar-hidden';
    }

    // Menu Fixed
    if ($layoutClasses['menuFixed'] == true) {
      $layoutClasses['menuFixed'] = 'layout-menu-fixed';
    }


    // Footer Fixed
    if ($layoutClasses['footerFixed'] == true) {
      $layoutClasses['footerFixed'] = 'layout-footer-fixed';
    }

    // Menu Flipped
    if ($layoutClasses['menuFlipped'] == true) {
      $layoutClasses['menuFlipped'] = 'layout-menu-flipped';
    }

    // Menu Offcanvas
    // if ($layoutClasses['menuOffcanvas'] == true) {
    //   $layoutClasses['menuOffcanvas'] = 'layout-menu-offcanvas';
    // }

    // RTL Supported template
    if ($layoutClasses['rtlSupport'] == true) {
      $layoutClasses['rtlSupport'] = '/rtl';
    }

    // RTL Layout/Mode
    if ($layoutClasses['rtlMode'] == true) {
      $layoutClasses['rtlMode'] = 'rtl';
      $layoutClasses['textDirection'] = isset($_COOKIE['direction']) ? ($_COOKIE['direction'] === "true" ? 'rtl' : 'ltr') : 'rtl';

    } else {
      $layoutClasses['rtlMode'] = 'ltr';
      $layoutClasses['textDirection'] = isset($_COOKIE['direction']) && $_COOKIE['direction'] === "true" ? 'rtl' : 'ltr';

    }

    // Show DropdownOnHover for Horizontal Menu
    if ($layoutClasses['showDropdownOnHover'] == true) {
      $layoutClasses['showDropdownOnHover'] = true;
    } else {
      $layoutClasses['showDropdownOnHover'] = false;
    }

    // To hide/show display customizer UI, not js
    if ($layoutClasses['displayCustomizer'] == true) {
      $layoutClasses['displayCustomizer'] = true;
    } else {
      $layoutClasses['displayCustomizer'] = false;
    }

    return $layoutClasses;
  }

  public static function updatePageConfig($pageConfigs)
  {
    $demo = 'custom';
    if (isset($pageConfigs)) {
      if (count($pageConfigs) > 0) {
        foreach ($pageConfigs as $config => $val) {
          Config::set('custom.' . $demo . '.' . $config, $val);
        }
      }
    }
  }
}
