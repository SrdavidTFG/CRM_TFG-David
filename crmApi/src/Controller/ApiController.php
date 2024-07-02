<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Response;
use Cake\Http\Client;
use App\Model\Document\MongoDocument;
use TCPDF;
/**
 * Api Controller
 *
 *
 * @method \App\Model\Entity\Api[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
/**
 * @OA\Info(
 *     title="Mi API",
 *     version="1.0.0"
 * )
 */
/**
 * @OA\Schema(
 *     schema="Usuario",
 *     title="Usuario",
 *     description="Esquema del objeto Usuario",
 *     @OA\Property(property="nombre", type="string", example="Juan Pérez", description="Nombre del usuario"),
 *     @OA\Property(property="email", type="string", format="email", example="juan@example.com", description="Correo electrónico del usuario"),
 *     @OA\Property(property="usuario", type="string", example="juanperez", description="Nombre de usuario"),
 *     @OA\Property(property="contrasena", type="string", example="********", description="Contraseña del usuario")
 * )
 */
/**
 * @OA\Schema(
 *     schema="Contacto",
 *     title="Contacto",
 *     description="Esquema del objeto Contacto",
 *     @OA\Property(property="nombre", type="string", example="Ana García", description="Nombre del contacto"),
 *     @OA\Property(property="email", type="string", format="email", example="ana@example.com", description="Correo electrónico del contacto"),
 *     @OA\Property(property="telefono", type="string", example="123456789", description="Número de teléfono del contacto")
 * )
 */
/**
 * @OA\Schema(
 *     schema="Movimiento",
 *     title="Movimiento",
 *     description="Esquema del movimiento asociado a un usuario",
 *     @OA\Property(property="nombre", type="string", example="Movimiento 1", description="Nombre del movimiento"),
 *     @OA\Property(property="array_generador", type="string", example="Array Generador 1", description="Nombre del array generador"),
 *     @OA\Property(property="nombre_campos", type="array", @OA\Items(type="string"), example={"Campo 1", "Campo 2"}, description="Nombres de los campos asociados al movimiento"),
 *     @OA\Property(property="instancias", type="array", @OA\Items(type="string"), example={"Instancia 1", "Instancia 2"}, description="Instancias asociadas al movimiento")
 * )
 */
/**
 * @OA\Schema(
 *     schema="TipoMovimiento",
 *     title="Tipo de Movimiento",
 *     description="Esquema que describe un tipo de movimiento",
 *     @OA\Property(property="email", type="string", example="usuario@ejemplo.com", description="Correo electrónico del usuario asociado"),
 *     @OA\Property(property="nombre", type="string", example="Tipo de Movimiento 1", description="Nombre del tipo de movimiento"),
 *     @OA\Property(property="nombresCampos", type="array", @OA\Items(type="string"), example={"Campo 1", "Campo 2"}, description="Nombres de los campos asociados al tipo de movimiento"),
 *     @OA\Property(property="tiposCampos", type="array", @OA\Items(type="string"), example={"Tipo 1", "Tipo 2"}, description="Tipos de los campos asociados al tipo de movimiento")
 * )
 */
/**
 * @OA\Schema(
 *     schema="CampoMovimiento",
 *     title="Campo de Movimiento",
 *     description="Esquema que describe un campo de movimiento",
 *     @OA\Property(property="nombre", type="string", example="Campo 1", description="Nombre del campo"),
 *     @OA\Property(property="tipo", type="string", example="Texto", description="Tipo del campo")
 * )
 */

class ApiController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $api = $this->paginate($this->Api);

        $this->set(compact('api'));
    }

    /**
     * View method
     *
     * @param string|null $id Api id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $api = $this->Api->get($id, [
            'contain' => [],
        ]);

        $this->set('api', $api);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $api = $this->Api->newEntity();
        if ($this->request->is('post')) {
            $api = $this->Api->patchEntity($api, $this->request->getData());
            if ($this->Api->save($api)) {
                $this->Flash->success(__('The api has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The api could not be saved. Please, try again.'));
        }
        $this->set(compact('api'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Api id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $api = $this->Api->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $api = $this->Api->patchEntity($api, $this->request->getData());
            if ($this->Api->save($api)) {
                $this->Flash->success(__('The api has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The api could not be saved. Please, try again.'));
        }
        $this->set(compact('api'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Api id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $api = $this->Api->get($id);
        if ($this->Api->delete($api)) {
            $this->Flash->success(__('The api has been deleted.'));
        } else {
            $this->Flash->error(__('The api could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function swagger()
    {
        return $this->redirect('webroot/swagger-ui');
    }
/**
 * TraerUsuarios
 *
 * @OA\Get(
 *     path="/articles",
 *     summary="Obtener lista de usuarios",
 *     tags={"Usuarios"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de usuarios obtenida correctamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Usuario")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno del servidor"
 *     )
 * )
 */

    public function TraerUsuarios()
    {
 
        $this->loadComponent('Mongo');

      $data= $this->Mongo->TraerUsuarios();
        
        // Devolver una respuesta JSON con los datos
        $response = new Response();
        $response = $response->withType('application/json')->withStringBody(json_encode($data));
        return $response;
    }
 /**
 * TraerContactos
 *
 * @OA\Get(
 *     path="/contacts",
 *     summary="Obtener lista de contactos",
 *     tags={"Contactos"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de contactos obtenida correctamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Contacto")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno del servidor"
 *     )
 * )
 */
    public function TraerContactos()
    {
     

     
        $this->loadComponent('Mongo');

      $data= $this->Mongo->TraerContactos();
        // Devolver una respuesta JSON con los datos
        $response = new Response();
        $response = $response->withType('application/json')->withStringBody(json_encode($data));
        return $response;
    }

/**
 * getToken
 *
 * @OA\Post(
 *     path="/get-token",
 *     summary="Obtener token de autenticación",
 *     tags={"Autenticación"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos de autenticación",
 *         @OA\JsonContent(
 *             @OA\Property(property="username", type="string", example="davidmontero.glifing@gmail.com", description="Nombre de usuario"),
 *             @OA\Property(property="password", type="string", example="Pokemonnegra2*", description="Contraseña del usuario")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Token de autenticación obtenido correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX3V1aWQiOiIxMjM0NTY3ODkwIiwicm9sZSI6ImFkbWluIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c", description="Token de autenticación")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Credenciales inválidas", description="Mensaje de error")
 *         )
 *     )
 * )
 */

    public function getToken()
    {
        $this->autoRender = false; 
        $username = 'davidmontero.glifing@gmail.com';
        $password = 'Pokemonnegra2*';

        $http = new Client();
        $response = $http->post('https://api.clientify.net/v1/api-auth/obtain_token/', json_encode([
            'username' => $username,
            'password' => $password
        ]), [
            'type' => 'json',
            'headers' => ['Content-Type' => 'application/json']
        ]);

        if ($response->isOk()) {
            $responseData = $response->getJson();
        } else {
            $responseData = 'Unexpected HTTP status: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();
        }

        $this->set(compact('responseData'));
        return($responseData);
    }
/**
 * TraerClientify
 *
 * @OA\Get(
 *     path="/clientify-contacts",
 *     summary="Obtener contactos desde Clientify",
 *     tags={"Clientify"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de contactos obtenida correctamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="string", example="123456", description="ID del contacto"),
 *                 @OA\Property(property="owner", type="string", example="owner123", description="Propietario del contacto"),
 *                 @OA\Property(property="owner_name", type="string", example="John Doe", description="Nombre del propietario"),
 *                 @OA\Property(property="first_name", type="string", example="Jane", description="Nombre del contacto"),
 *                 @OA\Property(property="last_name", type="string", example="Doe", description="Apellido del contacto"),
 *                 @OA\Property(property="status", type="string", example="active", description="Estado del contacto"),
 *                 @OA\Property(property="emails", type="array", @OA\Items(type="string"), description="Lista de correos electrónicos del contacto"),
 *                 @OA\Property(property="phones", type="array", @OA\Items(type="string"), description="Lista de números de teléfono del contacto"),
 *                 @OA\Property(property="created", type="string", example="2023-01-01T12:00:00Z", description="Fecha de creación del contacto"),
 *                 @OA\Property(property="modified", type="string", example="2023-01-02T08:00:00Z", description="Fecha de modificación del contacto"),
 *                 @OA\Property(property="last_contact", type="string", example="2023-01-03T15:30:00Z", description="Último contacto con el contacto")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado: token de autenticación inválido o expirado",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unauthorized", description="Mensaje de error")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno del servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unexpected HTTP status: 500 Internal Server Error", description="Mensaje de error")
 *         )
 *     )
 * )
 */

    public function TraerClientify()
    {
        // Desactivar autorender
        $this->autoRender = false;
        $token = $this->getToken();
        $client = new Client();
        $headers = [
            'Authorization' => 'Token '.$token['token'] 
        ];

        $response = $client->get('https://api.clientify.net/v1/contacts/', [], [
            'headers' => $headers
        ]);

        if ($response->isOk()) {
            $responseData = json_decode($response->getStringBody(), true);
            $contacts = $responseData['results'];
            
            // Reestructurar los datos en un array de arrays
            $structuredData = [];
            foreach ($contacts as $contact) {
                $structuredData[] = [
                    'id' => $contact['id'],
                    'owner' => $contact['owner'],
                    'owner_name' => $contact['owner_name'],
                    'first_name' => $contact['first_name'],
                    'last_name' => $contact['last_name'],
                    'status' => $contact['status'],
                    'emails' => array_map(function($email) {
                        return $email['email'];
                    }, $contact['emails']),
                    'phones' => array_map(function($phone) {
                        return $phone['phone'];
                    }, $contact['phones']),
                    'created' => $contact['created'],
                    'modified' => $contact['modified'],
                    'last_contact' => $contact['last_contact']
                ];
            }
            // Devolver la respuesta en formato JSON
            $this->response = $this->response->withType('application/json')
                                             ->withStringBody(json_encode($structuredData));
        } else {
            $error = 'Unexpected HTTP status: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();
            // Devolver el error en formato JSON
            $this->response = $this->response->withType('application/json')
                                             ->withStringBody(json_encode(['error' => $error]));
        }
        
        return $this->response;
    }
/**
 * enviarContactoClientify
 *
 * @OA\Post(
 *     path="/clientify-contacts",
 *     summary="Enviar contacto a Clientify",
 *     tags={"Clientify"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos del contacto a enviar",
 *         @OA\JsonContent(
 *             required={"first_name", "last_name", "email", "phone", "status", "title", "company", "street", "city", "state", "country", "postal_code"},
 *             @OA\Property(property="first_name", type="string", example="John", description="Nombre del contacto"),
 *             @OA\Property(property="last_name", type="string", example="Doe", description="Apellido del contacto"),
 *             @OA\Property(property="email", type="string", example="john.doe@example.com", description="Correo electrónico del contacto"),
 *             @OA\Property(property="phone", type="string", example="+1234567890", description="Número de teléfono del contacto"),
 *             @OA\Property(property="status", type="string", example="active", description="Estado del contacto"),
 *             @OA\Property(property="title", type="string", example="Mr.", description="Título del contacto"),
 *             @OA\Property(property="company", type="string", example="Acme Corp", description="Nombre de la empresa del contacto"),
 *             @OA\Property(property="street", type="string", example="123 Main St", description="Calle del contacto"),
 *             @OA\Property(property="city", type="string", example="Anytown", description="Ciudad del contacto"),
 *             @OA\Property(property="state", type="string", example="State", description="Estado/provincia del contacto"),
 *             @OA\Property(property="country", type="string", example="Country", description="País del contacto"),
 *             @OA\Property(property="postal_code", type="string", example="12345", description="Código postal del contacto")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Contacto enviado correctamente a Clientify",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Contacto enviado exitosamente", description="Mensaje de éxito")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autorizado: token de autenticación inválido o expirado",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unauthorized", description="Mensaje de error")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error interno del servidor al intentar enviar el contacto",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unexpected HTTP status: 500 Internal Server Error", description="Mensaje de error")
 *         )
 *     )
 * )
 */

    public function enviarContactoClientify()
{
    // Desactivar autorender
    $this->autoRender = false;
    $token = $this->getToken();
    $client = new Client();
    
    $headers = [
        'Authorization' => 'Token '.$token['token'] ,
        'Content-Type' => 'application/json'
    ];
    $first_name = $this->request->getQuery('first_name');
    $last_name = $this->request->getQuery('last_name');
    $email = $this->request->getQuery('email');
    $phone = $this->request->getQuery('phone');

    $status = $this->request->getQuery('status');
    $title = $this->request->getQuery('title');
    $company = $this->request->getQuery('company');
    $street = $this->request->getQuery('street');

    $city = $this->request->getQuery('city');
    $state = $this->request->getQuery('state');
    $country = $this->request->getQuery('country');
    $postal_code = $this->request->getQuery('postal_code');
    
    

    $body = '
        {
            "first_name": "'.$first_name.'",
            "last_name": "'.$last_name.'",
            "email": "'.$email.'",
            "phone": "'.$phone.'",
            "status": "'.$status.'",
            "title": "'.$title.'",
            "company": "'.$company.'",
            "contact_type": "",
            "contact_source": "Archivo CSV",
            "addresses": [{"street":"'.$street.'", "city":"'.$city.'", "state":"'.$state.'", "country":"'.$country.'", "postal_code":"'.$postal_code.'", "type":1}],
            "custom_fields": [],
            "description": "Description you can add to the contact",
            "remarks": "Just remarks",
            "summary": "Summary for the contact",
            "message": "Text to show in the contact wall",
            "re_property_name": "Hakeem Hicks",
            "tags": ["test"],
            "last_contact": null,
            "gdpr_accept": true,
            "other_companies": [
                {
                    "title": "exist company demo"
                    
                },
                {
                    "title": "exist company demo2"
                    
                },
                {
                    "title": "new company demo"
                }
                ]
        }'
    ;


    try {
        $response = $client->post('https://api.clientify.net/v1/contacts/', $body, [
            'headers' => $headers
        ]);

        if ($response->getStatusCode() == 200) {
            echo $response->getBody();
            $this->response = $this->response->withType('application/json')
                                             ->withStringBody(json_encode($response));
            return $this->$response;
        } else {
            echo 'Unexpected HTTP status: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
/**
 * InsertarUsuario
 *
 * @OA\Post(
 *     path="/insertar-usuario",
 *     summary="Insertar un usuario en la base de datos Mongo",
 *     tags={"Usuarios"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos del usuario a insertar",
 *         @OA\JsonContent(
 *             required={"database", "nombre", "email", "user"},
 *             @OA\Property(property="database", type="string", example="nombre_de_la_base_de_datos", description="Nombre de la base de datos Mongo"),
 *             @OA\Property(property="nombre", type="string", example="John Doe", description="Nombre del usuario"),
 *             @OA\Property(property="email", type="string", example="john.doe@example.com", description="Correo electrónico del usuario"),
 *             @OA\Property(property="user", type="string", example="johndoe", description="Nombre de usuario del usuario")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuario insertado correctamente en la base de datos",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Usuario insertado correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */


    public function InsertarUsuario()
{
    $this->autoRender = false; 
    $database = $this->request->getQuery('database');
    $nombre = $this->request->getQuery('nombre');
    $email = $this->request->getQuery('email');
    $user = $this->request->getQuery('user');


    $this->loadComponent('Mongo');

  $this->Mongo->insertIntoDatabase( $database , $email, $nombre, $user);
    
    // Devolver una respuesta JSON con los datos
    $response = new Response();
    
    // $response = $response->withType('application/json')->withStringBody(json_encode($response));

    return null;
}
/**
 * ModificarUsuario
 *
 * @OA\Post(
 *     path="/modificar-usuario",
 *     summary="Modificar un usuario en la base de datos Mongo",
 *     tags={"Usuarios"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos del usuario a modificar",
 *         @OA\JsonContent(
 *             required={"database", "nombre", "email", "user"},
 *             @OA\Property(property="database", type="string", example="nombre_de_la_base_de_datos", description="Nombre de la base de datos Mongo"),
 *             @OA\Property(property="nombre", type="string", example="John Doe", description="Nombre del usuario"),
 *             @OA\Property(property="email", type="string", example="john.doe@example.com", description="Correo electrónico del usuario"),
 *             @OA\Property(property="user", type="string", example="johndoe", description="Nombre de usuario del usuario")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuario modificado correctamente en la base de datos",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Usuario modificado correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function ModificarUsuario()
{
    $this->autoRender = false; 
    $database = $this->request->getQuery('database');
    $nombre = $this->request->getQuery('nombre');
    $email = $this->request->getQuery('email');
    $user = $this->request->getQuery('user');


    $this->loadComponent('Mongo');

  $this->Mongo->replaceInDatabase( $database , $email, $nombre, $user);
    
    // Devolver una respuesta JSON con los datos
    $response = new Response();
    
     $response = $response->withType('application/json')->withStringBody(json_encode($response));

    return null;
}
/**
 * EliminarUsuario
 *
 * @OA\Post(
 *     path="/eliminar-usuario",
 *     summary="Eliminar un usuario de la base de datos Mongo",
 *     tags={"Usuarios"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos del usuario a eliminar",
 *         @OA\JsonContent(
 *             required={"database", "email"},
 *             @OA\Property(property="database", type="string", example="nombre_de_la_base_de_datos", description="Nombre de la base de datos Mongo"),
 *             @OA\Property(property="email", type="string", example="john.doe@example.com", description="Correo electrónico del usuario a eliminar")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuario eliminado correctamente de la base de datos",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Usuario eliminado correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function EliminarUsuario()
{
    $this->autoRender = false; 
    $database = $this->request->getQuery('database');
    $email = $this->request->getQuery('email');


    $this->loadComponent('Mongo');

  $this->Mongo->deleteInDatabase( $database , $email);
    
    // Devolver una respuesta JSON con los datos
    $response = new Response();
    
     $response = $response->withType('application/json')->withStringBody(json_encode($response));

    return null;
}
/**
 * obtenerMovimientos
 *
 * @OA\Get(
 *     path="/obtener-movimientos",
 *     summary="Obtener los movimientos asociados a un usuario por su correo electrónico",
 *     tags={"Movimientos"},
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         required=true,
 *         description="Correo electrónico del usuario para filtrar los movimientos",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de movimientos obtenida correctamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Movimiento")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: correo electrónico faltante o incorrecto",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function obtenerMovimientos(){
    $this->autoRender = false; 
    $email = $this->request->getQuery('email');

    $this->loadComponent('Mongo');

    $movimientos = $this->Mongo->LoadLists($email);
    $response = new Response();
    // Devolver una respuesta JSON con los datos
    $response = $response->withType('application/json')->withStringBody(json_encode($movimientos));
    return $response;
   
}
/**
 * anadirVentanaMovimientos
 *
 * @OA\Post(
 *     path="/anadir-ventana-movimientos",
 *     summary="Añadir una nueva ventana de movimientos para un usuario",
 *     tags={"Movimientos"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos para añadir una nueva ventana de movimientos",
 *         @OA\JsonContent(
 *             required={"nombre", "email"},
 *             @OA\Property(property="nombre", type="string", example="Ventana de movimientos 1", description="Nombre de la nueva ventana de movimientos"),
 *             @OA\Property(property="email", type="string", example="john.doe@example.com", description="Correo electrónico del usuario asociado")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ventana de movimientos añadida correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Ventana de movimientos añadida correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function anadirVentanaMovimientos(){
    $this->autoRender = false; 
    $nombre = $this->request->getQuery('nombre');
    $email = $this->request->getQuery('email');

    $this->loadComponent('Mongo');

    $movimientos = $this->Mongo->NewList($nombre,$email);
    $response = new Response();
    // Devolver una respuesta JSON con los datos
    $response = $response->withType('application/json')->withStringBody(json_encode($movimientos));
    return $response;
   
}
/**
 * eliminarMovimiento
 *
 * @OA\Delete(
 *     path="/eliminar-movimiento",
 *     summary="Eliminar un movimiento de una lista específica para un usuario",
 *     tags={"Movimientos"},
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         required=true,
 *         description="Correo electrónico del usuario dueño de la lista de movimientos",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="NombreListaMovimiento",
 *         in="query",
 *         required=true,
 *         description="Nombre de la lista de movimientos de la cual se eliminará un movimiento",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Movimiento eliminado correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Movimiento eliminado correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function eliminarMovimiento(){
    $this->autoRender = false; 
    $email = $this->request->getQuery('email');
    $nombreLista = $this->request->getQuery('NombreListaMovimiento');

    $this->loadComponent('Mongo');

    $movimientos = $this->Mongo->DropMovemment($email,$nombreLista);
    $response = new Response();
    // Devolver una respuesta JSON con los datos
    $response = $response->withType('application/json')->withStringBody(json_encode($movimientos));
    return $response;
   
}
/**
 * anadirInstanciasMovimientos
 *
 * @OA\Post(
 *     path="/anadir-instancias-movimientos",
 *     summary="Añadir instancias de movimientos a una lista específica para un usuario",
 *     tags={"Movimientos"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos para añadir instancias de movimientos a una lista específica",
 *         @OA\JsonContent(
 *             required={"nombre", "lista", "email", "TiposCampos"},
 *             @OA\Property(property="nombre", type="string", example="Instancia 1", description="Nombre o contenido de la instancia a añadir"),
 *             @OA\Property(property="lista", type="string", example="Lista de movimientos 1", description="Nombre de la lista de movimientos donde se añadirá la instancia"),
 *             @OA\Property(property="email", type="string", example="john.doe@example.com", description="Correo electrónico del usuario asociado"),
 *             @OA\Property(property="TiposCampos", type="string", example="Campos específicos de la instancia", description="Tipos o detalles de los campos de la instancia")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Instancia de movimiento añadida correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Instancia de movimiento añadida correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function anadirInstanciasMovimientos(){
    $this->autoRender = false; 
    $contenido = $this->request->getQuery('nombre');
    $nombreLista = $this->request->getQuery('lista');
    $email = $this->request->getQuery('email');
    $tiposCampos= $this->request->getQuery('TiposCampos');
    debug($contenido);
    $this->loadComponent('Mongo');
    $movimientos = $this->Mongo->NewInstance($contenido,$nombreLista,$email,$tiposCampos);
    $response = new Response();
    // Devolver una respuesta JSON con los datos
    $response = $response->withType('application/json')->withStringBody(json_encode($movimientos));
    return $response;

}
/**
 * EditarInstanciasMovimientos
 *
 * @OA\Put(
 *     path="/editar-instancias-movimientos",
 *     summary="Editar una instancia de movimiento en una lista específica para un usuario",
 *     tags={"Movimientos"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos para editar una instancia de movimiento en una lista específica",
 *         @OA\JsonContent(
 *             required={"contenido", "email", "nombreLista", "id"},
 *             @OA\Property(property="contenido", type="string", example="Nuevo contenido", description="Nuevo contenido o nombre de la instancia a editar"),
 *             @OA\Property(property="email", type="string", example="john.doe@example.com", description="Correo electrónico del usuario asociado"),
 *             @OA\Property(property="nombreLista", type="string", example="Lista de movimientos 1", description="Nombre de la lista de movimientos donde se encuentra la instancia a editar"),
 *             @OA\Property(property="id", type="string", example="123456789", description="ID único de la instancia a editar")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Instancia de movimiento editada correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Instancia de movimiento editada correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function EditarInstanciasMovimientos(){
    $this->autoRender = false; 
    $contenido = $this->request->getQuery('contenido');
    $email = $this->request->getQuery('email');
    $nombreLista = $this->request->getQuery('nombreLista');
    $id = $this->request->getQuery('id');
    $this->loadComponent('Mongo');
    $movimientos = $this->Mongo->UpdateInstance($contenido,$email,$nombreLista, $id);
    $response = new Response();
    // Devolver una respuesta JSON con los datos
    $response = $response->withType('application/json')->withStringBody(json_encode($movimientos));
    return $response;

}
/**
 * EliminarInstanciasMovimientos
 *
 * @OA\Delete(
 *     path="/eliminar-instancias-movimientos",
 *     summary="Eliminar una instancia de movimiento en una lista específica para un usuario",
 *     tags={"Movimientos"},
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         required=true,
 *         description="Correo electrónico del usuario asociado",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="nombreLista",
 *         in="query",
 *         required=true,
 *         description="Nombre de la lista de movimientos donde se encuentra la instancia a eliminar",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         required=true,
 *         description="ID único de la instancia a eliminar",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Instancia de movimiento eliminada correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Instancia de movimiento eliminada correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function EliminarInstanciasMovimientos(){
    $this->autoRender = false; 
    $email = $this->request->getQuery('email');
    $nombreLista = $this->request->getQuery('nombreLista');
    $id = $this->request->getQuery('id');
    $this->loadComponent('Mongo');
    $movimientos = $this->Mongo->DropInstance($email,$nombreLista, $id);
    $response = new Response();
    // Devolver una respuesta JSON con los datos
    $response = $response->withType('application/json')->withStringBody(json_encode($movimientos));
    return $response;

}
/**
 * FiltrarPorNombre
 *
 * @OA\Get(
 *     path="/filtrar-por-nombre",
 *     summary="Filtrar usuarios por nombre en una base específica",
 *     tags={"Usuarios"},
 *     @OA\Parameter(
 *         name="Nombre",
 *         in="query",
 *         required=true,
 *         description="Nombre del usuario a filtrar",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="Base",
 *         in="query",
 *         required=true,
 *         description="Base de datos específica donde se realizará el filtro",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de usuarios filtrados correctamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Usuario")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function FiltrarPorNombre(){
    $this->autoRender = false; 
    $nombre = $this->request->getQuery('Nombre');
    $base = $this->request->getQuery('Base');
    $this->loadComponent('Mongo');
    $data = $this->Mongo->FilterUser($nombre,$base);
    $response = new Response();
    $response = $response->withType('application/json')->withStringBody(json_encode($data));
    return $response;

}
/**
 * CrearTipoMovimiento
 *
 * @OA\Post(
 *     path="/crear-tipo-movimiento",
 *     summary="Crear un nuevo tipo de movimiento con campos personalizados",
 *     tags={"Movimientos"},
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         required=true,
 *         description="Correo electrónico del usuario que crea el tipo de movimiento",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="nombre",
 *         in="query",
 *         required=true,
 *         description="Nombre del nuevo tipo de movimiento a crear",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="nombresCampos",
 *         in="query",
 *         required=true,
 *         description="Nombres de los campos personalizados del nuevo tipo de movimiento",
 *         @OA\Schema(type="array", @OA\Items(type="string"))
 *     ),
 *     @OA\Parameter(
 *         name="tiposCampos",
 *         in="query",
 *         required=true,
 *         description="Tipos de datos de los campos personalizados del nuevo tipo de movimiento",
 *         @OA\Schema(type="array", @OA\Items(type="string", enum={"string", "integer", "boolean", "array"}))
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tipo de movimiento creado exitosamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/TipoMovimiento")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: datos incompletos o incorrectos",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function CrearTipoMovimiento(){
    $this->autoRender = false; 
    $email = $this->request->getQuery('email');
    $nombre = $this->request->getQuery('nombre');
    $nombresCampos = $this->request->getQuery('nombresCampos');
    $tiposCampos = $this->request->getQuery('tiposCampos');
    $this->loadComponent('Mongo');
    $data = $this->Mongo->CreateTypeOfMovement($email,$nombre,$nombresCampos,$tiposCampos);
    $response = new Response();
    $response = $response->withType('application/json')->withStringBody(json_encode($data));
    return $response;

}
/**
 * CargarTipoMovimiento
 *
 * @OA\Get(
 *     path="/cargar-tipo-movimiento",
 *     summary="Cargar todos los tipos de movimiento disponibles",
 *     tags={"Movimientos"},
 *     @OA\Response(
 *         response=200,
 *         description="Tipos de movimiento cargados exitosamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/TipoMovimiento")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: no se pudieron cargar los tipos de movimiento",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function CargarTipoMovimiento(){
    $this->autoRender = false; 
    $this->loadComponent('Mongo');
    $data = $this->Mongo->LoadTypeofMovement();
    $response = new Response();
    $response = $response->withType('application/json')->withStringBody(json_encode($data));
    return $response;

}
/**
 * obtenerMovimientosUsuario
 *
 * @OA\Get(
 *     path="/obtener-movimientos-usuario",
 *     summary="Obtener los movimientos asociados a un usuario por su correo electrónico",
 *     tags={"Movimientos"},
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         required=true,
 *         description="Correo electrónico del usuario para obtener sus movimientos",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Movimientos del usuario obtenidos exitosamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Movimiento")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: no se pudieron obtener los movimientos del usuario",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function obtenerMovimientosUsuario(){
    $this->autoRender = false; 
    $email = $this->request->getQuery('email');
    $this->loadComponent('Mongo');
    $data = $this->Mongo->LoadUserMovements($email);
    $response = new Response();
    $response = $response->withType('application/json')->withStringBody(json_encode($data));
    return $response;

}
/**
 * obtenerCamposMovimiento
 *
 * @OA\Get(
 *     path="/obtener-campos-movimiento",
 *     summary="Obtener los campos asociados a un movimiento para un usuario específico",
 *     tags={"Movimientos"},
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         required=true,
 *         description="Correo electrónico del usuario para obtener los campos del movimiento",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="nombreMovimiento",
 *         in="query",
 *         required=true,
 *         description="Nombre del movimiento para el cual se desean obtener los campos",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Campos del movimiento obtenidos exitosamente",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/CampoMovimiento")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: no se pudieron obtener los campos del movimiento",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function obtenerCamposMovimiento(){
    $this->autoRender = false; 
    $email = $this->request->getQuery('email');
    $nombreMovimiento = $this->request->getQuery('nombreMovimiento');
    $this->loadComponent('Mongo');
    $data = $this->Mongo->LoaditemsMovement($email,$nombreMovimiento);
    $response = new Response();
    $response = $response->withType('application/json')->withStringBody(json_encode($data));
    return $response;

}
/**
 * DescargarAPdf
 *
 * @OA\Get(
 *     path="/descargar-a-pdf",
 *     summary="Descargar contenido en formato PDF",
 *     tags={"Descargas"},
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         required=true,
 *         description="Correo electrónico del usuario para descargar el contenido",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="database",
 *         in="query",
 *         required=true,
 *         description="Nombre de la base de datos de donde se obtendrá el contenido (puede ser 'Contactos' o 'CRM_CONTACTS')",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Archivo PDF descargado exitosamente",
 *         @OA\MediaType(
 *             mediaType="application/pdf"
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la solicitud: no se pudo generar el archivo PDF",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Bad Request", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function DescargarAPdf(){
    $this->autoRender = false; 
    $email = $this->request->getQuery('email');
    $DataBase = $this->request->getQuery('database');
    if($DataBase=="Contactos"){
        $DataBase="CRM_CONTACTS";
    }
    $this->loadComponent('Mongo');
    $pdfContent = $this->Mongo->LoadToPdf($DataBase,$email);
    $response = $this->response->withType('application/pdf')
    ->withHeader('Content-Disposition', 'attachment; filename="data.pdf"')
    ->withStringBody($pdfContent);

return $response;

}
/**
 * ValidarUsuario
 *
 * @OA\Get(
 *     path="/validar-usuario",
 *     summary="Validar las credenciales de un usuario",
 *     tags={"Usuarios"},
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         required=true,
 *         description="Correo electrónico del usuario a autenticar",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="contraseña",
 *         in="query",
 *         required=true,
 *         description="Contraseña del usuario a autenticar",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuario autenticado exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="authenticated", type="boolean", example=true, description="Indica si el usuario fue autenticado correctamente"),
 *             @OA\Property(property="message", type="string", example="Usuario autenticado correctamente", description="Mensaje de éxito")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Error de autenticación: credenciales incorrectas",
 *         @OA\JsonContent(
 *             @OA\Property(property="authenticated", type="boolean", example=false, description="Indica si la autenticación falló"),
 *             @OA\Property(property="message", type="string", example="Credenciales incorrectas", description="Mensaje de error")
 *         )
 *     )
 * )
 */

public function ValidarUsuario(){
    $this->autoRender = false; 
    $email = $this->request->getQuery('email');
    $pswd = $this->request->getQuery('contraseña');
    
    $this->loadComponent('Mongo');
    $data = $this->Mongo->autenticateUser($pswd,$email);
    $response = new Response();
    $response = $response->withType('application/json')->withStringBody(json_encode($data));
return $response;

}
}