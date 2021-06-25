<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Person extends Entity
{
    protected $_accessible = [
        'id' => true,
        'nombre' => true,
        'apellido_paterno' => true,
        'apellido_materno' => true,
        'id_tipo_documento' => true,
        'numero_documento' => true
    ];
}