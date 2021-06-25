<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class Course extends Table
{
    public function initialize(array $config): void
    {
        $this->setTable('alumnos_cursos_clases_sedes');
    }
}

