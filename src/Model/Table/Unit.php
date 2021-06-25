<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class Unit extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('clases');
        $this->setEntityClass('App\Model\Entity\Unit');
        //$this->hasMany('Sedes',['className'=> 'App\Model\Table\UnitVenue'])->setForeignKey('id_clase')->setBindingKey('id');
    }
}

