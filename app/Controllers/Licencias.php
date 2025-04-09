<?php

/**
 * Licencias Controller
 * php version 8.2
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://omarvasquezs.github.io
 */

namespace App\Controllers;

/**
 * Class Licencias
 *
 * @category Controllers
 * @package  App\Controllers
 * @author   Omar Vásquez <omarvs91@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://omarvasquezs.github.io
 */
class Licencias extends BaseController
{    
    /**
     * Handles the licencias_admin page for administrators.
     *
     * @return mixed
     */
    public function licenciasAdmin()
    {
        // Check if user has admin role
        if (!in_array(1, session()->get('roles'))) {
            return redirect()->to(base_url('/'))->with('error', 'No tiene permiso para acceder a esta página.');
        }

        $this->gc->setTable("licencias")
            ->defaultOrdering('licencias.id', 'desc')
            ->setSubject("LICENCIAS", "ADMINISTRACIÓN DE LICENCIAS")
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->setRead()
            ->addFields(
                [
                    'id_usuario',
                    'sustentacion',
                    'fecha_inicio',
                    'fecha_fin',
                    'fecha_retorno',
                    'goce_haber'
                ]
            )
            ->editFields(['fecha_inicio', 'fecha_fin', 'fecha_retorno', 'sustentacion', 'goce_haber'])
            ->readOnlyEditFields(['id_usuario', 'fecha_creacion'])
            ->readFields(['id_usuario', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'sustentacion', 'revisado_por', 'goce_haber'])
            ->columns(['id_usuario', 'fecha_creacion', 'rango', 'fecha_inicio', 'goce_haber'])
            ->fieldTypeColumn('rango', 'varchar')
            ->fieldTypeColumn('fecha_inicio', 'invisible')
            ->mapColumn('rango', 'fecha_fin')
            ->callbackColumn(
                'rango',
                function ($value, $row) {
                    return $row->fecha_inicio . ' - ' . $value;
                }
            )
            ->callbackBeforeInsert(
                function ($stateParameters) {
                    $stateParameters->data['revisado_por'] = session()->get('user_id');
                    return $stateParameters;
                }
            )
            ->callbackBeforeUpdate(
                function ($stateParameters) {
                    $stateParameters->data['revisado_por'] = session()->get('user_id');
                    return $stateParameters;
                }
            )
            ->displayAs('id_usuario', 'USUARIO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('rango', 'RANGO DE FECHAS')
            ->displayAs('goce_haber', 'GOCE DE HABER')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->fieldType('sustentacion', 'text')
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date')
            ->fieldType('fecha_retorno', 'native_date')
            ->fieldType('goce_haber', 'dropdown', [
                0 => 'NO',
                1 => 'SI'
            ]);

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }

    /**
     * Handles the mis_licencias page for reviewing user's own licencias.
     *
     * @return mixed
     */
    public function misLicencias()
    {
        $this->gc->setTable("licencias")
            ->defaultOrdering('licencias.id', 'desc')
            ->setSubject("LICENCIAS", "CONSULTA DE LICENCIAS")
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->unsetAdd()
            ->unsetEdit()
            ->unsetDelete()
            ->setRead()
            ->readFields(['id_usuario', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'sustentacion', 'revisado_por', 'goce_haber'])
            ->columns(['fecha_creacion', 'rango', 'fecha_inicio', 'goce_haber'])
            ->fieldTypeColumn('rango', 'varchar')
            ->fieldTypeColumn('fecha_inicio', 'invisible')
            ->mapColumn('rango', 'fecha_fin')
            ->callbackColumn(
                'rango',
                function ($value, $row) {
                    return $row->fecha_inicio . ' - ' . $value;
                }
            )
            ->where(
                [
                    'licencias.id_usuario' => session()->get('user_id')
                ]
            )
            ->displayAs('id_usuario', 'USUARIO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('rango', 'RANGO DE FECHAS')
            ->displayAs('goce_haber', 'GOCE DE HABER')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->fieldType('sustentacion', 'text')
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date')
            ->fieldType('fecha_retorno', 'native_date')
            ->fieldType('goce_haber', 'dropdown', [
                0 => 'NO',
                1 => 'SI'
            ]);

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }

    /**
     * Handles the licencias_all page for viewing all licenses (read-only).
     *
     * @return mixed
     */
    public function licenciasAll()
    {
        // Check if user has admin role
        if (!in_array(3, session()->get('roles'))) {
            return redirect()->to(base_url('/'))->with('error', 'No tiene permiso para acceder a esta página.');
        }

        $this->gc->setTable("licencias")
            ->defaultOrdering('licencias.id', 'desc')
            ->setSubject("LICENCIAS", "CONSULTA DE LICENCIAS")
            ->unsetFilters()
            ->unsetPrint()
            ->unsetExport()
            ->unsetAdd()
            ->unsetEdit()
            ->unsetDelete()
            ->setRead()
            ->readFields(['id_usuario', 'fecha_creacion', 'fecha_inicio', 'fecha_fin', 'fecha_retorno', 'sustentacion', 'revisado_por', 'goce_haber'])
            ->columns(['id_usuario', 'fecha_creacion', 'rango', 'fecha_inicio', 'goce_haber'])
            ->fieldTypeColumn('rango', 'varchar')
            ->fieldTypeColumn('fecha_inicio', 'invisible')
            ->mapColumn('rango', 'fecha_fin')
            ->callbackColumn(
                'rango',
                function ($value, $row) {
                    return $row->fecha_inicio . ' - ' . $value;
                }
            )
            ->displayAs('id_usuario', 'USUARIO')
            ->displayAs('sustentacion', 'SUSTENTACIÓN')
            ->displayAs('fecha_creacion', 'FECHA CREACION')
            ->displayAs('fecha_inicio', 'FECHA DE INICIO')
            ->displayAs('fecha_fin', 'FECHA FIN')
            ->displayAs('fecha_retorno', 'FECHA DE RETORNO')
            ->displayAs('revisado_por', 'REVISADO POR')
            ->displayAs('rango', 'RANGO DE FECHAS')
            ->displayAs('goce_haber', 'GOCE DE HABER')
            ->setRelation('id_usuario', 'usuarios', 'nombres')
            ->setRelation('revisado_por', 'usuarios', 'nombres')
            ->fieldType('sustentacion', 'text')
            ->fieldType('fecha_inicio', 'native_date')
            ->fieldType('fecha_fin', 'native_date')
            ->fieldType('fecha_retorno', 'native_date')
            ->fieldType('goce_haber', 'dropdown', [
                0 => 'NO',
                1 => 'SI'
            ]);

        $output = $this->gc->render();

        return $this->mainOutput($output);
    }
}