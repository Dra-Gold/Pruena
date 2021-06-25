<?php

namespace App\Controller;

use App\Model\Table\Person;
use App\Model\Table\Course;
class PersonController extends AppController
{
    public function show()
    {
        $per=new Person();
        $person=$per->find()->where(['id_tipo_documento' => 4])->contain(['Members','Members.Curso','Members.Curso.Classroom'])->all();
        $this->set(compact('person'));
        
    }

    public function teacher()
    {
        $curso=new Course();
        $cursos=$curso->find()->contain(['Members','Members.Perso'])->all();
        $this->set(compact('cursos'));

    }

}