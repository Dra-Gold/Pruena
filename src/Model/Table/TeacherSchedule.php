<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class TeacherSchedule extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('horarios_profesores');
        $this->belongsTo('Perso',['className'=> 'App\Model\Table\Person'])->setForeignKey('id_persona');
        $this->setEntityClass('App\Model\Entity\TeacherSchedule');
    }
}

