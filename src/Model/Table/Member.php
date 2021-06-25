<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class Member extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('alumnos_cursos');
        $this->belongsTo('Perso',['className'=> 'App\Model\Table\Person'])->setForeignKey('id_persona')->setBindingKey('id');
        $this->belongsTo('Curso',['className'=> 'App\Model\Table\Course'])->setForeignKey('id_curso')->setBindingKey('id');
        $this->setEntityClass('App\Model\Entity\Member');
    }
}

