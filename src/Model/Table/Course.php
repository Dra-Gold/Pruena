<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class Course extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('cursos');
        $this->hasMany('Members',['className'=> 'App\Model\Table\Member'])->setForeignKey('id_curso')->setBindingKey('id');
        $this->hasMany('Classroom',['className'=> 'App\Model\Table\Unit'])->setForeignKey('id_curso')->setBindingKey('id');
        $this->setEntityClass('App\Model\Entity\Course');
    }
}

