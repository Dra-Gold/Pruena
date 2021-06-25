<?php

namespace App\Controller;

class TeacherSchedulesController extends AppController
{
    public function save_add() {
		$idClient = \CigarrilloBuilder::get('idClient');
		$teachers = $this->TeacherSchedule->Person->find('list', [
			'fields' => ['id', 'nombre_completo'],
			'conditions' => ['clases_virtuales' => 1, 'id_cliente' => $idClient],
			'order' => 'nombre_completo ASC'
		]);

		$data = $this->request->input('json_decode', true);

		$errorCode = '';
		$unitVenues = [];

		if (!empty($data)) {
			$dataSource = $this->TeacherSchedule->getDataSource();
			$dataSource->begin();
			$error = false;
			$days = [];
			$teacherSchedule = $data['TeacherSchedule'];

			if ($teacherSchedule['fecha_inicio'] != '') {

				/**
				 *  linea 34 divide la fecha en array donde el saparador es -
                 *  linea 35 valida que las partes del array en su conjunto sean una fecha valida
                 *  linea 36 a 37 si la fecha anteriormente validad es menor a la fecha actual asigna falso a la variable
				 */
				$initParts = explode('-', $teacherSchedule['fecha_inicio']);
				$validInit = checkdate($initParts[1], $initParts[2], $initParts[0]);
				if ($teacherSchedule['fecha_inicio'] < date('Y-m-d')) {
					$validInit = false;
				}
				/** Fin explicación **/

				if ($validInit) {
					$saveType = 1;
					$days[] = $teacherSchedule['fecha_inicio'];
					if ($teacherSchedule['fecha_fin'] != '') {

						$endParts = explode('-', $teacherSchedule['fecha_fin']);
						$validEnd = checkdate($endParts[1], $endParts[2], $endParts[0]);
						if ($teacherSchedule['fecha_fin'] < date('Y-m-d')) {
							$validEnd = false;
						}

						if ($validEnd) {

							/**
							 *  linea 61 si la fecha inicio es menor o igual a fecha fin
                             *  linea 63 asigna una fecha inicio a una variable
                             *  mientras fecha de inivio sea distinto a fecha fin se ejecuta el siguiente codigo
                             *  se le asigna a variable creada anteriormente una fecha que la fecha mas un dia hasta que 
                             *  la variable sea igual a fecha fin , al mismo tiempo se crea un array acumunlando las fechas +1 hasta que el ciclo termine
							 */
							if ($teacherSchedule['fecha_inicio'] <= $teacherSchedule['fecha_fin']) {

								$currentDay = $teacherSchedule['fecha_inicio'];
								while ($currentDay != $teacherSchedule['fecha_fin']) {
									$currentDay = date('Y-m-d', strtotime('next day', strtotime($currentDay)));
									$days[] = $currentDay;
								}
							}
							else {
								$error = __('Error: La fecha de fin es anterior a la fecha de inicio');
							}
							/** Fin explicación **/
						}
						else {
							$error = __('Error: La fecha de fin es inválida');
						}
					}
				}
				else {
					$error = __('Error: La fecha de inicio es inválida');
				}

			} else if (!empty($teacherSchedule['dias_semana'])) {
				$saveType = 2; //Guarda días
				$days = $teacherSchedule['dias_semana'];
				if (count(array_diff($days, [1, 2, 3, 4, 5, 6, 7])) > 0) {
					$error = __('Error: Los días no son válidos');
				}
			}
			else {
				$error = __('Debe seleccionar un día de semana o una fecha');
			}

			if ($teacherSchedule['disponible'] == 0 && !$error) {
				

				if ($saveType == 1) {

					/**
					 *  crea varible que se le asigna todos los datos de diferentes tablas que cumplan las condiciones que fecha sea igual a la variable
                     * que el id_persona de la tabla member sea igual a id_persona de shedule y el estado sea 0,1 
                     *  que contengan el metodo Member en TeacherShedule 
					 */
					$memberUnitVenues = $this->TeacherSchedule->Person->Member->MemberUnitVenue->find('all', [
						'conditions' => [
							'fecha' => $days,
							'Member.id_persona' => $teacherSchedule['id_persona'],
							'estado' => [0, 1]
						],
						'contain' => [
							'Member'
						]
					]);
					/** Fin explicación **/

				} else {
					
					/**
					 * crea varible que se le asigna todos los datos de diferentes tablas que cumplan las condiciones que fecha sea igual a la fecha actual,
                     * un campo creado para la query sea igual a la variable days ,que el id_persona de la tabla member sea igual a id_persona de shedule y el estado sea 0,1 
                     * que contengan el metodo Member en TeacherShedule 
					 */
					$memberUnitVenues = $this->TeacherSchedule->Person->Member->MemberUnitVenue->find('all', [
						'conditions' => [
							'fecha >=' => date('Y-m-d'),
							'weekday(fecha)+1' => $days,
							'Member.id_persona' => $teacherSchedule['id_persona'],
							'estado' => [0, 1]
						],
						'contain' => [
							'Member'
						]
					]);
					/** Fin explicación **/
				}

				if (!$error) {
					$init = date('H:i', strtotime($teacherSchedule['hora_inicio']));
					$end = date('H:i', strtotime($teacherSchedule['hora_fin']));

					//En tres casos una clase topa con un bloque
					foreach ($memberUnitVenues as $memberUnitVenue) {
						$id = $memberUnitVenue['MemberUnitVenue']['id'];
						$memberInit = date('H:i', strtotime($memberUnitVenue['MemberUnitVenue']['hora_inicio']));
						$memberEnd = date('H:i', strtotime($memberUnitVenue['MemberUnitVenue']['hora_fin']));

						//caso 1: clase empieza dentro del bloque
						if ($memberInit >= $init && $memberInit < $end) {
							$unitVenues[$id] = $id;
						}
						//caso 2: clase termina dentro del bloque
						if ($memberEnd > $init && $memberEnd <= $end) {
							$unitVenues[$id] = $id;
						}
						//caso 3: clase empieza antesd el bloque y termina después del bloque
						if ($memberInit <= $init && $memberEnd >= $end) {
							$unitVenues[$id] = $id;
						}
					}

					/**
					 *  si mantener clases esta vacio entonces se ve si la variable unitvenues es mayor que 1 tonces a la variable error 
                     *  se le asigna un valor igual que erroCode en caso de ser igual a 1 lo mismo con otro mensaje
					 */
					if (empty($teacherSchedule['mantener_clases'])) {
						if (count($unitVenues) > 1) {
							$error = __('El profesor tiene varias clases agendadas dentro del horario');
							$errorCode = 'MC01';
						}
						if (count($unitVenues) == 1) {
							$error = __('El profesor tiene una clase agendada dentro del horario');
							$errorCode = 'MC02';
						}
					}
					/** Fin explicación **/
				}
			}

			if ($saveType == 2) {
				
				/**
				 *  a la variable se le asigna el resultado de la query , la cual es un array indexado 
                 * que query busca con las condiciones   agrupadas por fecha
				 */
				$nextDays = $this->TeacherSchedule->find('list', [
					'fields' => ['id', 'fecha'],
					'conditions' => [
						'fecha >=' => date('Y-m-d'),
						'weekday(fecha)+1' => $days,
						'id_persona' => $teacherSchedule['id_persona'],
						'disponible !=' => $teacherSchedule['disponible']
					],
					'group' => 'fecha'
				]);
				/** Fin explicación **/

				if (!empty($nextDays)) {
					foreach ($nextDays as $id => $nextDay) {
						//guardar un registro de horario con fecha para el profesor
						$teacherSchedule['dia_semana'] = 0;
						$teacherSchedule['fecha'] = $nextDay;
						//crea horario de profesor
						$this->TeacherSchedule->id = $id;
						if (!$this->TeacherSchedule->save($teacherSchedule)) {
							$error = true;
						}
					}
				}
			}

		}
		else {
			$error = __('No se recibieron datos');
		}

		$response = [
			'error' => $error,
			'errorCode' => $errorCode,
			'unitVenues' => $unitVenues
		];

		$code = empty($error) ? 200 : 400;
		$this->set(compact('code', 'response'));
		$this->set('_serialize', ['code', 'response']);
	}

}