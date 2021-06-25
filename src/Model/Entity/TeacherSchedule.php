<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class TeacherSchedule extends Entity
{
    protected $_accessible = [
        'id' => true,
        'id_persona' => true,
        'dia_semana' => true,
        'disponible' => true,
        'fecha' => true,
        'hora_inicio' => true
    ];
}