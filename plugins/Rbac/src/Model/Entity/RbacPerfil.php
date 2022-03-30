<?php
namespace Rbac\Model\Entity;

use Cake\ORM\Entity;

/**
 * RbacPerfil Entity
 *
 * @property int $id
 * @property string $descripcion
 * @property string|null $es_default
 * @property string|resource|null $usa_area_representacion
 * @property int|null $permiso_virtual_host_id
 * @property int|null $accion_default_id
 * @property int|null $perfil_publico
 *
 * @property \App\Model\Entity\PermisosVirtualHost $permisos_virtual_host
 * @property \App\Model\Entity\RbacAccion[] $rbac_acciones
 * @property \App\Model\Entity\RbacUsuario[] $rbac_usuarios
 */
class RbacPerfil extends Entity
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
        'descripcion' => true,
        'es_default' => true,
        'usa_area_representacion' => true,
        'permiso_virtual_host_id' => true,
        'accion_default_id' => true,
        'perfil_publico' => true,
        'permisos_virtual_host' => true,
        'rbac_acciones' => true,
        'rbac_usuarios' => true
    ];
}
