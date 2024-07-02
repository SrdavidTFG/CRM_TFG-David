<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use MongoDB\Client;
use MongoDB\BSON\ObjectID;
use App\Model\Document\MongoDocument;
use TCPDF;
use Cake\Utility\Security;


/**
 * MongoDB component
 * @author David Montero Hernandez
 * @copyright Glifing S.L.
 * @version 1.0
 * 
 * 
 *
 */
class MongoComponent extends Component
{
    private $mongo;
        //$cliente = new Client("mongodb://David:1234@172.19.0.3:27017/crm?authSource=admin");
        //"mongodb://David:1234@mongo_crm.docker.com:27017/crm?authSource=admin"
    public function initialize(array $config)
    {
        parent::initialize($config);
        // Configuracion
        $username      = Configure::read('Glifing.mongodb.username');
        $password      = Configure::read('Glifing.mongodb.password');
        $database      = Configure::read('Glifing.mongodb.database');
        $admin         = Configure::read('Glifing.mongodb.admin');
        $host          = Configure::read('Glifing.mongodb.host');
        $port          = Configure::read('Glifing.mongodb.port');
        $connectionLine=("mongodb://".$username.":".$password."@".$host.":".$port."/".$database."?authSource=".$admin);
        $this->mongo = new Client($connectionLine);
    }

    public function TraerUsuarios(){

        $database   =$this->mongo->selectDatabase("crm");
        $collection =$database->selectCollection("Usuarios");
        $objeto     =$collection->find()->toArray();
        return $objeto;
    }

    public function TraerContactos(){

        $database   =$this->mongo->selectDatabase("crm");
        $collection =$database->selectCollection("CRM_CONTACTS");
        $objeto     =$collection->find()->toArray();
        return $objeto;
    }
    /**
     * 
     *
     * @return 
     * @author David Montero Hernandez[Glifing S.L.]
     * @param 
     * @param
     */
    public function doesRegistryExists()
    {
    $filter = ['nombre' => 'Bob'];
    $database   =$this->mongo->selectDatabase("crm");
    $collection =$database->selectCollection("CRM_CONTACTS");
    $objeto     =$collection->findOne($filter);
    print_r($objeto);
    }
    public function insertIntoDatabase( $databaseU , $email, $nombre, $user)
    {
        debug($databaseU);
    $database   =$this->mongo   ->selectDatabase("crm");
    $collection =$database      ->selectCollection($databaseU);
    $filter     =['email' => $email];
    $objeto     =$collection->findOne($filter);

    if(!$objeto){
        if(strcasecmp($databaseU, "Usuarios") === 0){
            $hash = Security::hash($email, 'sha256');
        $new_object = [
            "email" => $email,
            "nombre" => $nombre,
            "userGlifing" => $user,
            "contraseña" => $hash
        ];
    }else{
        $new_object = [
            "email" => $email,
            "nombre" => $nombre,
            "userGlifing" => $user,
            "Movimientos" => []
        ];
    }
    
    $metio=$collection ->insertOne($new_object);
    debug($metio);
    }
    else{
        print("El registro ". $objeto->email ." ya existe");
    }
    
    }
    public function deleteInDatabase($databaseU, $email)
    {
    $database   =$this->mongo   ->selectDatabase("crm");
    $collection =$database      ->selectCollection($databaseU);
    $filter     =['email' => $email];
    $objeto     =$collection->findOne($filter);
    if($objeto){
    $collection ->deleteOne($objeto);
    }
    }
    public function LoadToPdf($databaseU, $email)
    {
        // Iniciar el buffer de salida
        ob_start();
        
        // Conectar a MongoDB
        $database = $this->mongo->selectDatabase("crm");
        $collection = $database->selectCollection($databaseU);

        if ($email == -1) {
            $objeto = $collection->find()->toArray();
        } else {
            $filter = ['email' => $email];
            $objeto = $collection->findOne($filter);
            $objeto = [$objeto]; // Convertir a array para un manejo uniforme
        }

        // Limpieza de la salida previa
        if (ob_get_length()) {
            ob_end_clean();
        }
        
        // Iniciar TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Generar HTML para el PDF
        $html = '
<style>
    h1 {
        text-align: center;
        font-family: Arial, sans-serif;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }
    table th, table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }
    table th {
        background-color: #f2f2f2;
        color: #333;
        font-weight: bold;
    }
    table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>
<h1>Datos de registro</h1>
<table border="1">
    <thead>
        <tr>';
        
if (!empty($objeto)) {
    $keys = array_keys((array)$objeto[0]);
    foreach ($keys as $key) {
        $html .= '<th>' . htmlspecialchars((string)$key) . '</th>';
    }
    $html .= '</tr></thead><tbody>';
    foreach ($objeto as $doc) {
        $html .= '<tr>';
        foreach ($keys as $key) {
            $value = $doc[$key] ?? '';
            if (is_object($value) || is_array($value)) {
                $value = json_encode($value);
            }
            $html .= '<td>' . htmlspecialchars((string)$value) . '</td>';
        }
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="100%">No data found</td></tr>';
}

$html .= '</tbody></table>';


        // Escribir HTML en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Descargar el PDF
        $pdf->Output('data.pdf', 'D');
        return $pdf->Output('', 'S');
    }
    //No actualiza el registro, cambia todo lo que hubiera por lo que le digas
    public function replaceInDatabase($databaseU , $email, $nombre, $user)
    {
    $database   =$this->mongo   ->selectDatabase("crm");
    $collection =$database      ->selectCollection($databaseU);
    $filter         =['email' => $email];
    $objeto_old     =$collection->findOne($filter);
    $objeto         =$collection->findOne(['email' => $objeto_new->email]);
    if(!$objeto){
        $update = [
            '$set' => [
                'nombre' => $nombre,
                'userGlifing' => $user
            ]
        ];
        $result = $collection->updateOne($filter, $update);
    }
    }
    //Cambia solo las cosas que le digas, el resto las deja igual
    public function updateRegister($databaseU , $email, $nombre, $user)
    {
    $database   =$this->mongo   ->selectDatabase("crm");
    $collection =$database      ->selectCollection($databaseU);
    $objeto_old =$collection    ->findOne();
    if($objeto){
        $new_object = [
            'email' => $email,
            'nombre' => $nombre,
            'userGlifing' => $user,
            'Movimientos' => [
                'Clientify' => [
                    'Movimiento1' => [
                        'id' => 1,
                        'nombre' => 'Jose'
                    ]
                ],
                ''

            ]
        ];
                $objeto     =  $collection->findOne(['email' => $objeto_new->email]);
        if(!$objeto){
            $collection->updateOne($objeto_old,$objeto_new);
        }
    }
    }
    public function autenticateUser($pswd,$email){
        $database = $this->mongo->selectDatabase("crm");
        $collection = $database->selectCollection("Usuarios");
        $filter = ['email' => $email];
        $user = $collection->findOne($filter);
        if(strcasecmp($pswd,$user['contraseña'])==0){
            return 1;
        }
        else{
            return 0;
        }
    }


    public function LoadLists($email){
        $database = $this->mongo->selectDatabase("crm");
        $collection = $database->selectCollection("CRM_CONTACTS");
        $filter = ['email' => $email];
        $objeto_old = $collection->findOne($filter);
        
        $movimientos = []; // Inicializa $movimientos como un array vacío
    
        if ($objeto_old && isset($objeto_old['Movimientos'])) {
            $movimientos = $objeto_old['Movimientos'];
        }
        return [$movimientos];
    }
    public function LoadUserMovements($email){
        $database = $this->mongo->selectDatabase("crm");
        $collection = $database->selectCollection("Movimientos");
        $filter = ['email' => $email];
        $objeto_old = $collection->find($filter)->toArray();
        foreach ($objeto_old as $objeto){
            if (isset($objeto['nombre'])) {
                $names[] = $objeto['nombre'];
            }
        }                          
        return $names;
    }
    public function LoaditemsMovement($email, $nombreMovimiento) {
        // Selecciona la base de datos y la colección
        $database = $this->mongo->selectDatabase("crm");
        $collection = $database->selectCollection("Movimientos");
        
        // Filtra por el email y el nombreMovimiento proporcionados
        $filter = [
            'email' => $email,
            'nombre' => $nombreMovimiento
        ];
        
        // Encuentra un documento que coincida con el filtro
        $document = $collection->findOne($filter);
        
        // Verifica si se encontró un documento y si contiene el campo 'arrayGenerador'
        if ($document && isset($document['arrayGenerador'])) {
            // Devuelve el campo 'arrayGenerador'
            return $document['arrayGenerador'];
        }
        
        // Si no se encuentra el documento o no contiene el campo 'arrayGenerador', devuelve un array vacío
        return [];
    }
    
    
    
    public function NewList($name, $email) {
        $database = $this->mongo->selectDatabase("crm");
        $collection = $database->selectCollection("CRM_CONTACTS");
        $filter = ['email' => $email];
        $objeto_old = $collection->findOne($filter);
        
        if ($objeto_old && isset($objeto_old['Movimientos'])) {
            $movimientos = $objeto_old['Movimientos'];
            
            // Verificar si ya existe un movimiento con el mismo nombre
            $movimientoExistente = false;
            foreach ($movimientos as $movimiento) {
                if ($movimiento['nombre'] === $name) {
                    $movimientoExistente = true;
                    break;
                }
            }
            if (!$movimientoExistente) {
                // Agregar el nuevo movimiento
            }
            
            // Si no existe, agregamos el nuevo movimiento
            if (empty($movimientoExistente)) {
                $nuevoMovimiento = array(
                    "nombre" => $name,
                    "instancias" => []
                );
    
                $actualizacion = array('$push' => array('Movimientos' => $nuevoMovimiento));
                $collection->updateOne($filter, $actualizacion);
                // Recuperamos nuevamente el objeto actualizado
                $objeto_old = $collection->findOne($filter);
                $movimientos = $objeto_old['Movimientos'];
            }
        } else {
            // Si no hay movimientos en el objeto, creamos uno nuevo con el nuevo movimiento
            $nuevoMovimiento = array(
                "nombre" => $name,
                "instancias" => []
            );
    
            $actualizacion = array('$set' => array('Movimientos' => [$nuevoMovimiento]));
            $collection->updateOne($filter, $actualizacion);
            // Recuperamos nuevamente el objeto actualizado
            $objeto_old = $collection->findOne($filter);
            $movimientos = $objeto_old['Movimientos'];
        }
    
        return [$movimientos];
    }
    public function DropMovemment($email, $nombrelista){
        $database = $this->mongo->selectDatabase("crm");
        $collection = $database->selectCollection("CRM_CONTACTS");
        $filter = ['email' => $email];
        $objeto_old = $collection->findOne($filter);
        
        $movimientos = []; // Inicializa $movimientos como un array vacío
    
        if ($objeto_old && isset($objeto_old['Movimientos'])) {
            $movimientos = $objeto_old['Movimientos'];
        }

        $collection->updateOne(
            ['email' => ($email)],
            ['$pull' => ['Movimientos' => ['nombre' => $nombrelista]]]
        );
        $objeto_old = $collection->findOne($filter);
        return [$objeto_old];
    }
    public function NewInstance($nombre, $lista, $email,$tiposCampos){ 
        $database = $this->mongo->selectDatabase("crm");
        $collection = $database->selectCollection("CRM_CONTACTS");
        $filter = ['email' => $email];
        $objeto_old = $collection->findOne($filter);
        $idUltimaInstancia=1;
        ##Aqui tengo que buscar a el contacto por el email, luego buscar el movimiento que sea y coger la variable instancias de ese movimiento, añadirle el nuevo movimiento y tras eso volverla a colocar y guardarla
        $movimientos = []; // Inicializa $movimientos como un array vacío
        $conjuntoDeInstancias = [];
        if ($objeto_old && isset($objeto_old['Movimientos'])) {
            $movimientos = $objeto_old['Movimientos'];
        }
            
            // Verificar si ya existe un movimiento con el mismo nombre
            $movimientoExistente = false;
            foreach ($movimientos as $movimiento) {
                if ($movimiento['nombre'] === $lista) {
                  
                    $movimientoExistente = true;
                    $conjuntoDeInstancias = $movimiento['instancias'];
                    break;
                }
            }
            foreach ($conjuntoDeInstancias as $UltimaInstancia){
                $idUltimaInstancia = ($UltimaInstancia['id'] +1);
            }
            //Crear siguiente instancia TODO->Llamar a la funcion loadTypeofMovement
            $nuevaInstancia=$this->LoadTypeofMovement($lista,$email,$tiposCampos,$nombre,$idUltimaInstancia);
            debug($nuevaInstancia);
            
            $actualizacion = array('$push' => array('Movimientos.$.instancias' => $nuevaInstancia));
            $resultado = $collection->updateOne(
                array('email' =>($email), 'Movimientos.nombre' => $lista),
                $actualizacion
            );
            $objeto_new = $collection->findOne($filter);
        return [$objeto_new];

    }
    public function UpdateInstance($fecha, $email, $nombreLista, $id) {
        $id = intval($id);
        $database = $this->mongo->selectDatabase("crm");
        $collectionContacts = $database->selectCollection("CRM_CONTACTS");
        $collectionMovimientos = $database->selectCollection("Movimientos");
        $filter = ['email' => $email];
        
        // Buscar el contacto por email
        $objeto_old = $collectionContacts->findOne($filter);
        
        if ($objeto_old && isset($objeto_old['Movimientos'])) {
            // Buscar el movimiento específico por nombre
            $movimientoExistente = false;
            foreach ($objeto_old['Movimientos'] as $movimiento) {
                if ($movimiento['nombre'] === $nombreLista) {
                    $movimientoExistente = true;
                    break;
                }
            }
            
            if ($movimientoExistente) {
                // Realizar una consulta a la colección Movimientos para obtener arrayGenerador
                $filtroMovimientos = ['email' => $email, 'nombre' => $nombreLista];
                $documentoMovimientos = $collectionMovimientos->findOne($filtroMovimientos, ['projection' => ['arrayGenerador' => 1]]);
                
                if ($documentoMovimientos && isset($documentoMovimientos['arrayGenerador'])) {
                    $tiposCampos = (array) $documentoMovimientos['arrayGenerador'];
                } else {
                    throw new \Exception("No se encontró el documento o el campo 'arrayGenerador' está ausente en la colección Movimientos.");
                }
                
                // Llamar a la función LoadTypeofMovement
                $nuevaInstancia = $this->LoadTypeofMovement($nombreLista, $email, $tiposCampos, $fecha, $id);
                $actualizacion = [
                    '$pull' => [
                        'Movimientos.$.instancias' => ['id' => $id]
                    ]
                ];
    
                $resultado = $collectionContacts->updateOne(
                    ['email' => $email, 'Movimientos.nombre' => $nombreLista],
                    $actualizacion
                );
                // Actualizar la instancia específica por id
                $actualizacion = array('$push' => array('Movimientos.$.instancias' => $nuevaInstancia));
    
                $resultado = $collectionContacts->updateOne(
                    array('email' =>($email), 'Movimientos.nombre' => $nombreLista),
                    $actualizacion
                );
    
                // Obtener el objeto actualizado
                $objeto_new = $collectionContacts->findOne($filter);
                return [$objeto_new];
            } else {
                debug("No se encontró el movimiento especificado.");
            }
        } else {
            debug("No se encontró el contacto o no tiene movimientos asociados.");
        }
        return null;
    }
    
    

    

    public function DropInstance($email, $nombreLista, $id)
{
    $database = $this->mongo->selectDatabase("crm");
    $collection = $database->selectCollection("CRM_CONTACTS");
    $filter = ['email' => $email];
    
    // Buscar el contacto por email
    $objeto_old = $collection->findOne($filter);
    
    if ($objeto_old && isset($objeto_old['Movimientos'])) {
        // Buscar el movimiento específico por nombre
        $movimientoExistente = false;
        foreach ($objeto_old['Movimientos'] as $movimiento) {
            if ($movimiento['nombre'] === $nombreLista) {
                $movimientoExistente = true;
                break;
            }
        }
        
        if ($movimientoExistente) {
            // Eliminar la instancia específica por id
            $actualizacion = [
                '$pull' => [
                    'Movimientos.$.instancias' => ['id' => intval($id)]
                ]
            ];

            $resultado = $collection->updateOne(
                ['email' => $email, 'Movimientos.nombre' => $nombreLista],
                $actualizacion
            );

            // Obtener el objeto actualizado
            $objeto_new = $collection->findOne($filter);
            return [$objeto_new];
        }
    }
    return null;
}
public function FilterUser($nombre,$base)
{
    $database = $this->mongo->selectDatabase("crm");
    $collection = $database->selectCollection($base);
    $letrasEscapadas = preg_quote($nombre, '/');

    // Construye la expresión regular para buscar nombres de usuario que contengan las letras especificadas
    $patron = new \MongoDB\BSON\Regex($letrasEscapadas, 'i');
    //$letrasEscapadas = preg_quote($letrasEscapadas, '/');
    $filter = ['nombre' => $patron];
    $usuarios = $collection->find($filter)->toArray();
    return $usuarios;
}

public function CreateTypeOfMovement($email,$nombre,$nombreCampos,$tipos){
    $database = $this->mongo->selectDatabase("crm");
    $collection = $database->selectCollection("Movimientos");
    debug($tipos);
    $tipos= (string) $tipos;
    $tipos = explode(',', $tipos);


    $mongoObject = array(
        "email" => $email,
        "nombre" => $nombre,
        "arrayGenerador" => [],
        "nombreCampos"=>$nombreCampos,
        "instancias" => new \stdClass() // Crear un objeto en lugar de un array
    );
    
    // Recorrer el array de tipos y añadir los datos correspondientes
    foreach ($tipos as $index => $tipo) {
        $campoNombre = $nombreCampos[$index];
        switch ($tipo) {
            case 1:
                $mongoObject['instancias']->$campoNombre = "string";
                $mongoObject['arrayGenerador'][] = intval($tipo);
                break;
            case 2:
                $mongoObject['instancias']->$campoNombre = [];
                $mongoObject['arrayGenerador'][] = intval($tipo);
                break;
            case 3:
                $mongoObject['instancias']->$campoNombre = 123; // Un entero de ejemplo
                $mongoObject['arrayGenerador'][] = intval($tipo);
                break;
            default:
                // Puedes manejar otros casos o errores aquí
                break;
        }
    }
    $result = $collection->insertOne($mongoObject);
    debug($result);
    return [$mongoObject];
}

public function LoadTypeofMovement($lista, $email, $tipos, $datos, $id) {
    // Buscar en la base de datos por el nombre
    $database = $this->mongo->selectDatabase("crm");
    $collection = $database->selectCollection("Movimientos");
    $filtro = ['nombre' => $lista, 'email' => $email];
debug($datos);
debug($tipos);
    // Realizar la búsqueda y obtener el campo nombreCampos
    $documento = $collection->findOne($filtro, ['projection' => ['nombreCampos' => 1]]);
debug($documento);
    // Verificar si se encontró el documento y si tiene el campo nombreCampos
    if ($documento && isset($documento['nombreCampos'])) {
        $nombreCampos = $documento['nombreCampos'];
    } else {
        throw new \Exception("No se encontró el documento o el campo 'nombreCampos' está ausente.");
    }

    // Convertir $tipos y $datos en arrays
    if(!is_array($tipos)){$tipos = explode(',', (string) $tipos);}
    
    $datos = explode(',', (string) $datos);

    // Convertir $nombreCampos en un array
    $nombreCampos = explode(',', (string) $nombreCampos);

    $mongoObject = [
        'id' => $id,
        
    ];

    $cont = 0;

    foreach ($tipos as $tipo) {
        if (isset($nombreCampos[$cont]) && isset($datos[$cont])) {
            $nombreCampo = $nombreCampos[$cont]; // Asigna un nombre de campo
            $contenido = $datos[$cont]; // Asigna el contenido
        } else {
            // Maneja el caso en que el índice no existe
            throw new \Exception("Índice $cont no definido en nombreCampos o datos.");
        }

        switch ($tipo) {
            case 1:
            case 2:
            case 3:
                $mongoObject[$nombreCampo] = $contenido;
                
                break;
            default:
                // Manejar otros casos o errores aquí si es necesario
                break;
        }
        $cont++;
    }

    // Devolver el objeto generado
    return $mongoObject;
}

}