<?php

namespace App\Controllers;

class Amonestaciones extends BaseController
{
    public function index()
    {
        $this->gc->setTable('amonestaciones')
            ->setSubject('AMONESTACION', 'AMONESTACIONES')
            ->unsetAddFields(['fecha_creacion', 'revisado_por'])
            ->unsetEditFields(['fecha_creacion', 'revisado_por'])
            ->unsetPrint()
            ->unsetExport()
            ->unsetSettings()
            ->unsetFilters()
            ->unsetDelete()
            ->setDeleteMultiple()
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->displayAs('id_usuario', 'USUARIO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('goce_haber', 'GOCE DE HABER')
            ->fieldType('goce_haber', 'boolean')
            ->setRead()
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date')
            ->fieldType('fecha_retorno', 'native_date')
            ->requiredFields(
                ['id_usuario', 'sustentacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno']
            )
            ->requiredEditFields(['id_usuario', 'sustentacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno'])
            ->callbackReadField(
                'revisado_por',
                function ($fieldValue, $primaryKeyValue) {
                    return $this->usuarios->find($fieldValue)['nombres'];
                }
            )
            ->callbackBeforeInsert(
                function ($stateParameters) {
                    $fecha_inicio = $stateParameters->data['fecha_inicio'];
                    $fecha_fin = $stateParameters->data['fecha_fin'];
                    $fecha_retorno = $stateParameters->data['fecha_retorno'];

                    $stateParameters->data['revisado_por'] = session()->get('user_id');

                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();

                    if ($fecha_fin <= $fecha_inicio) {
                        return $errorMessage->setMessage(
                            "La fecha de fin debe ser posterior
                            a la fecha de inicio.\n"
                        );
                    }

                    if ($fecha_retorno <= $fecha_fin) {
                        return $errorMessage->setMessage(
                            "La fecha de retorno debe ser posterior
                            a la fecha de inicio.\n"
                        );
                    }

                    return $stateParameters;
                }
            )
            ->callbackBeforeUpdate(
                function ($stateParameters) {
                    $fecha_inicio = $stateParameters->data['fecha_inicio'];
                    $fecha_fin = $stateParameters->data['fecha_fin'];
                    $fecha_retorno = $stateParameters->data['fecha_retorno'];

                    $stateParameters->data['revisado_por'] = session()->get('user_id');

                    $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();

                    if ($fecha_fin <= $fecha_inicio) {
                        return $errorMessage->setMessage(
                            "La fecha de fin debe ser posterior
                            a la fecha de inicio.\n"
                        );
                    }

                    if ($fecha_retorno <= $fecha_fin) {
                        return $errorMessage->setMessage(
                            "La fecha de retorno debe ser posterior
                            a la fecha de inicio.\n"
                        );
                    }

                    return $stateParameters;
                }
            )
            ->columns(['id_usuario', 'fecha_creacion']);
        $output = $this->gc->render();
        return $this->mainOutput($output);
    }
    public function mis_amonestaciones()
    {
        $this->gc->setTable('amonestaciones')
            ->setSubject('AMONESTACION', 'AMONESTACIONES DE ' . session()->get('nombres'))
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->unsetAddFields(['fecha_creacion', 'revisado_por'])
            ->unsetEditFields(['fecha_creacion', 'revisado_por'])
            ->displayAs('id_usuario', 'USUARIO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('goce_haber', 'GOCE DE HABER')
            ->fieldType('goce_haber', 'boolean')
            ->callbackReadField(
                'revisado_por',
                function ($fieldValue, $primaryKeyValue) {
                    return $this->usuarios->find($fieldValue)['nombres'];
                }
            )
            ->unsetExport()
            ->unsetPrint()
            ->unsetFilters()
            ->unsetEdit()
            ->unsetAdd()
            ->unsetDelete()
            ->setRead()
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date')
            ->fieldType('fecha_retorno', 'native_date')
            ->columns(['fecha_creacion'])
            ->where(
                [
                    'id_usuario' => session()->get('user_id')
                ]
            );
        $output = $this->gc->render();
        return $this->mainOutput($output);
    }
}
