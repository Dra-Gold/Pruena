<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class UnitVenue extends Entity
{
    protected $_accessible = [
        'id' => true,
        'fecha' => true,
        'hora_inicio' => true,
        'hora_fin' => true,
        'id_clase' => true,
        'id_sede' => true
    ];
}