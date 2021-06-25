<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;


use Cake\ORM\Table;

class Person extends Table
{
    public function initialize(array $config): void
    {
       
        $this->setTable('personas');
        $this->hasMany('TeacherShedules',['className'=> 'App\Model\Table\TeacherSchedule'])->setForeignKey('id_persona')->setBindingKey('id');
        $this->hasMany('Members',['className'=> 'App\Model\Table\Member'])->setForeignKey('id_persona')->setBindingKey('id');
        $this->setEntityClass('App\Model\Entity\Person');
    }
}

