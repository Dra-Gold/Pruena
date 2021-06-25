<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class UnitVenue extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('clases_sedes');
        $this->setEntityClass('App\Model\Entity\UnitVenue');
        $this->belongsTo('Clases',['className'=> 'App\Model\Table\Unit'])->setForeignKey('id_clase');
    }
}

