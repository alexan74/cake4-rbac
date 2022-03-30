<?php
namespace Rbac\Model\Entity;

use Cake\ORM\Entity;

/**
 * RbacAccion Entity
 *
 * @property int $id
 * @property string $controller
 * @property string|null $action
 * @property int|null $solo_lectura
 * @property int|null $carga_publica
 * @property int|null $carga_login_publica
 * @property int|null $carga_login_interna
 * @property int|null $carga_administracion
 * @property int|null $heredado
 * @property int|null $oculto
 *
 * @property \App\Model\Entity\RbacPerfil[] $rbac_perfiles
 */
class RbacAccion extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id' => true,
        'controller' => true,
        'action' => true,
        'solo_lectura' => true,
        'carga_publica' => true,
        'carga_login_publica' => true,
        'carga_login_interna' => true,
        'carga_administracion' => true,
        'heredado' => true,
        'oculto' => true,
        'rbac_perfiles' => true
    ];
}
