<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Member extends Entity
{
    protected $_accessible = [
        'id' => true,
        'id_persona' => true,
        'id_curso' => true
    ];
}