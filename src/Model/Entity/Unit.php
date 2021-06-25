<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Unit extends Entity
{
    protected $_accessible = [
        'id' => true,
        'nombre' => true,
        'id_curso' => true
    ];
}