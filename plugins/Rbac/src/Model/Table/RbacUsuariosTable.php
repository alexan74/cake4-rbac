<?php
namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
//use Cake\Datasource\RulesChecker;

class RbacUsuariosTable extends Table
{

    public $ldap;

    public $hostname = 'ldap.mrec.ar';

    public $base = 'dc=mrec,dc=ar';

    public function buildRules(RulesChecker $rules):RulesChecker
    {
        $rules->add($rules->isUnique(['usuario','correo']));
        $rules->add($rules->existsIn(['perfil_default_id'], 'RbacPerfiles'));
        
        return $rules;
    }
    
    public function validationDefault(Validator $validator) :Validator
    {
        $validator->notEmptyString('correo')->requirePresence('correo');
        $validator->notEmptyString('usuario')->requirePresence('usuario');
        $validator->add('usuario', 'uniqueUser', [
            'rule' => function ($value, $context) {
            if(isset($context['data']['id'])) {
                return !$this->exists(['usuario' => $value, 'id !=' => $context['data']['id']]);
            }
            return !$this->exists(['usuario' => $value]);
            },
            'message' => 'User already registered',
        ]);
        $validator->add('correo', 'uniqueEmail', [
            'rule' => function ($value, $context) {
            if(isset($context['data']['id'])) {
                return !$this->exists(['correo' => $value, 'id !=' => $context['data']['id']]);
            }
            return !$this->exists(['correo' => $value]);
            },
            'message' => 'Email address already registered',
        ]);
        return $validator;
    }
    
    public function initialize(array $config):void
    {
        parent::initialize($config);

        $this->setTable('rbac_usuarios');
        $this->order    = 'RbacUsuarios.apellido';
        $this->validate = array(
            'usuario' => array(
                /*'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true
                ),*/
                'unique', ['rule' => 'validateUnique', 'provider' => 'table'],
                'between' => array(
                    'rule' => array('between', 3, 100),
                ),
            ),
            'correo' => array(
                'unique', ['rule' => 'validateUnique', 'provider' => 'table'],
            ),
            /*,
            'contrasenia2' => array(
            'rule' => 'checkpasswords',
            'message' => 'Por favor reingrese la contraseña'
            )*/
            /*,
        'nombre' => array(
        'alphaNumeric' => array(
        'rule' => 'alphaNumeric',
        'required' => true
        ),
        'between' => array(
        'rule' => array('between', 2, 200)
        )
        ),
        'apellido' => array(
        'alphaNumeric' => array(
        'rule' => 'alphaNumeric',
        'required' => true
        ),
        'between' => array(
        'rule' => array('between', 2, 200)
        )
        )
        ,

        'password' => array(
        'notEmptyString' => array(
        'rule' => 'notEmpty',
        'required' => true
        )
        ),
        'seed' => array(
        'notEmptyString' => array(
        'rule' => 'notEmpty',
        'required' => true
        )
        )
         */
        );

        $this->belongsTo('PerfilDefault', [
            'className'    => 'Rbac.RbacPerfiles',
            'foreignKey'   => 'perfil_default_id',
            'propertyName' => 'perfil_default',
        ]);
        
        $this->belongsToMany('RbacPerfiles', [
            'className'        => 'Rbac.RbacPerfiles',
            'joinTable'        => 'rbac_perfiles_rbac_usuarios',
            'foreignKey'       => 'rbac_usuario_id',
            'targetForeignKey' => 'rbac_perfil_id',
            //'propertyName' => 'RbacPerfil',
        ]
            );
    }

    /*public $hasMany = array(
    'RbacToken' => array(
    'className' => 'Rbac.RbacToken',
    'foreignKey' => 'usuario_id'
    )
    );*/

    public function saveAll2($data = null, $validate = true, $fieldList = array())
    {
        // Clear modified field value before each save
        $this->set($data);
        if ($data['RbacUsuario']['valida_ldap']) {
            $validar_trigrama = $this->validar_trigrama_ldap($data['RbacUsuario']['usuario']);
            $validar_trigrama = $validar_trigrama['result'];
        } elseif ($data['RbacUsuario']['valida_ldap'] == 0) {
            $validar_trigrama = true;
        }
        if ($validar_trigrama) {
            //si es un reg nuevo encriptar la nueva pass
            if ($this->id == null && $data['RbacUsuario']['usuario'] != '' && $data['RbacUsuario']['valida_ldap']) {
                $this->securityEncrypt();
            }

            //return parent::saveAll($this->data, $validate, $fieldList);
            return parent::saveAll($this->data);

        } else {
            throw new \ErrorException('El Trigrama ingresado no se pudo validar, el usuario no se creo.');
        }
    }

    /**
     * Encriptacion de password, seteo de valores seed y password.
     */
    private function securityEncrypt()
    {
        if (!(isset($this->data[$this->alias]['password']))) {
            $password = md5(rand(0, 9999));
        } else {
            $password = $this->data[$this->alias]['password'];
        }

        $seed                                 = md5(rand(0, 9999));
        $password                             = hash('sha256', $seed . $password);
        $this->data[$this->alias]['seed']     = $seed;
        $this->data[$this->alias]['password'] = $password;
    }

    /**
     * @param string $usuario
     * @param int $password
     * @return boolean, TRUE si la autenticacion es correcta, FALSE en caso contrario.
     */
    public function autenticacion($usuario, $password)
    {
        $result  = $this->findByUsuario($usuario);
        $usuario = $result->toArray();
        if (!empty($usuario[0]['seed'])) 
        	$seed = $usuario[0]['seed'];
       	else
       		$seed = '';
        $passwordInput = hash('sha256', $seed . $password);
        return (isset($usuario[0]['password']) && $passwordInput == $usuario[0]['password']);
        
    }
    
    public function perfilDefault($usuario)
    {
        $result  = $this->findByUsuario($usuario);
        $usuario = $result->toArray();
        
        if (!empty($usuario[0]['perfil_default']))
            return $usuario[0]['perfil_default'];
        else
            return FALSE;
                
    }

    /**
     * El metodo verifica que el nombre de usuario(trigrama) existe y esta activo.
     * @param string $trigrama
     * @return array, error = TRUE ok o FALSE ko, message error en caso de .
     */
    public function validar_trigrama_ldap($trigrama)
    {

        $ldapConnection = ldap_connect($this->hostname);

        if (!$ldapConnection) {
            return array('result' => false, 'message' => "El servidor LDAP " . $this->hostname . " no responde.");
        }

        $ldapSearch = ldap_search($ldapConnection, $this->base, "(&(uid=$trigrama)(accountstatus=active))", array("dn", "cn"));

        $ldapUserInfo = ldap_get_entries($ldapConnection, $ldapSearch);

        if ($ldapUserInfo["count"] == 0) {
            return array('result' => false, 'message' => "El usuario $trigrama no existe o no est&aacute; activo.");
        } else {
            return array('result' => true, 'message' => null);
        }
    }

    /**
     * El método retorna los resultados key sensitive dado $trigrama
     * @param string $trigrama
     * @return array (formato preparado para autocomplete de jquery)
     */
    public function get_trigrama_autocomplete($trigrama)
    {

        $ldapConnection = ldap_connect($this->hostname);

        if (!$ldapConnection) {
            return array('result' => false, 'message' => "El servidor LDAP " . $this->hostname . " no responde.");
        }

        $ldapSearch = ldap_search($ldapConnection, $this->base, "(&(uid=$trigrama*)(accountstatus=active))", array("dn", "cn"));

        if (!$ldapSearch) {
            return array('result' => false, 'message' => "El usuario $trigrama no existe o no est&aacute; activo.");
        }

        $ldapUserInfo = ldap_get_entries($ldapConnection, $ldapSearch);

        $result = array();

        if ($ldapUserInfo["count"] == 0) {
            $result['error'] = 1;
        } else {
            $result['error'] = 0;

            $i = 0;

            foreach ($ldapUserInfo as $info) {
                if ($info['cn'][0] != null) {
                    $result[$i]['value'] = substr($info['dn'], 4, 3);
                    $result[$i]['label'] = $info['cn'][0] . ' (' . substr($info['dn'], 4, 3) . ')';
                    $i++;
                }
            }
        }

        return array('result' => $result, 'message' => null);
    }

}
