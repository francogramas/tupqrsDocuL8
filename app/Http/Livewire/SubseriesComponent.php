<?php

namespace App\Http\Livewire;

use App\Models\Serie;
use App\Models\empresa;
use App\Models\Subserie;
use App\Models\SeccionEmpresa;
use App\Models\TipologiaDocumento;
use App\Models\Pqr;

use Livewire\Component;

class SubseriesComponent extends Component
{
    public $secciones, $empresa, $series, $serie, $subseries, $subserie, $empresas, $empresa_id, $seccion, $seccion_id,
    $serie_id, $subserie_id, $nombre, $codigo, $So_Pa, $So_El, $So_Di, $Re_AG, $Re_AC, $DF_CT, $DF_E, $DF_MD, $DF_S,
    $ACC_P, $ACC_Pr, $procedimiento, $diasTermino, $radicadoSalida, $radicadoEntrada, $pqrs, $boolSeccion, $boolSerie,
    $boolEditSerie, $boolSubserie, $codigoSerie, $nombreSerie, $codigoSeccion, $nombreSeccion, $boolEditSeccion,
    $boolEditSubserie, $nombreTipologia, $tipologias, $tipologia, $boolEditTipologia, $pqrs_id;

    public function mount()
    {
        $this->empresa = empresa::first();
        $this->empresa_id = $this->empresa->id;
        $this->empresas = empresa::all();
        $this->pqrs = Pqr::all();
        $this->diasTermino=$this->pqrs->first()->diastermino;
        $this->cambiarEmpresa();
        $this->findSubseries();
    }
    public function render()
    {
        $this->tipologias = TipologiaDocumento::where('subserie_id', $this->subserie_id)->get();
        return view('livewire.subseries-component');
    }

    public function findSubseries()
    {
       try {
        $this->subseries = Subserie::where('serie_id', $this->serie_id)->where('seccion_id', $this->seccion_id)->get();
        $this->subserie_id = $this->subseries->first()->id;
        $this->tipologias = TipologiaDocumento::where('subserie_id', $this->subserie_id)->get();

       } catch (\Throwable $th) {

        $this->subserie_id = 0;
        $this->tipologias = TipologiaDocumento::where('subserie_id', 0)->get();
       }
    }

    public function soporteEvent($id)
    {

        $this->So_Pa = false;
        $this->So_El = false;
        $this->So_Di = false;

        if ($id==1) {
            $this->So_Pa = true;
        }
        elseif($id==2) {
            $this->So_El = true;
        }
        elseif($id==3) {
            $this->So_Di = true;
        }
    }
    public function disposicionFinalEvent($id)
    {
        $this->DF_CT=false;
        $this->DF_E=false;
        $this->DF_MD=false;
        $this->DF_S=false;

        if ($id==1) {
            $this->DF_CT = true;
        }
        elseif($id==2) {
            $this->DF_E = true;
        }
        elseif($id==3) {
            $this->DF_MD = true;
        }
        elseif($id==4) {
            $this->DF_S = true;
        }
    }

    public function accesoEvent($id)
    {
        $this->ACC_P = false;
        $this->ACC_Pr = false;


        if ($id==1) {
            $this->ACC_P = true;
        }
        elseif($id==2) {
            $this->ACC_Pr = true;
        }
    }

    public function radicadoEvent($id)
    {
        $this->radicadoSalida = false;
        $this->radicadoEntrada = false;


        if ($id==1) {
            $this->radicadoSalida = true;
        }
        elseif($id==2) {
            $this->radicadoEntrada = true;
        }
    }


//----------------------- CRUD SUBSERIES -------------------
    public function guardar()
    {

        Subserie::create([
            'serie_id'=>$this->serie_id,
            'seccion_id'=>$this->seccion_id,
            'codigo'=>$this->codigo,
            'nombre'=>$this->nombre,
            'Re_AG'=>$this->Re_AG,
            'Re_AC'=>$this->Re_AC,
            'DF_CT'=>$this->DF_CT,
            'DF_E'=>$this->DF_E,
            'DF_MD'=>$this->DF_MD,
            'DF_S'=>$this->DF_S,
            'ACC_P'=>$this->ACC_P,
            'ACC_Pr'=>$this->ACC_Pr,
            'procedimiento'=>$this->procedimiento,
        ]);
        $this->findSubseries();

        $this->limpiar();
    }

    public function editSubserie($id)
    {
        $this->subserie = Subserie::find($id);
        $this->serie_id = $this->subserie->serie_id;
        $this->seccion_id = $this->subserie->seccion_id;
        $this->codigo = $this->subserie->codigo;
        $this->nombre = $this->subserie->nombre;
        $this->Re_AG = $this->subserie->Re_AG;
        $this->Re_AC = $this->subserie->Re_AC;
        $this->DF_CT = $this->subserie->DF_CT;
        $this->DF_E = $this->subserie->DF_E;
        $this->DF_MD = $this->subserie->DF_MD;
        $this->DF_S = $this->subserie->DF_S;
        $this->ACC_P = $this->subserie->ACC_P;
        $this->ACC_Pr = $this->subserie->ACC_Pr;
        $this->procedimiento = $this->subserie->procedimiento;

        $this->boolEditSubserie = true;
        $this->cerrar();


    }

    public function updateSubserie()
    {

        $this->subserie->serie_id = $this->serie_id;
        $this->subserie->seccion_id = $this->seccion_id;
        $this->subserie->codigo = $this->codigo;
        $this->subserie->nombre = $this->nombre;
        $this->subserie->Re_AG = $this->Re_AG;
        $this->subserie->Re_AC = $this->Re_AC;
        $this->subserie->DF_CT = $this->DF_CT;
        $this->subserie->DF_E = $this->DF_E;
        $this->subserie->DF_MD = $this->DF_MD;
        $this->subserie->DF_S = $this->DF_S;
        $this->subserie->ACC_P = $this->ACC_P;
        $this->subserie->ACC_Pr = $this->ACC_Pr;
        $this->subserie->procedimiento = $this->procedimiento;
        $this->subserie->save();

        $this->boolEditSubserie = false;
        $this->limpiar();

    }


    public function deleteSubserie($id)
    {
        try {
            Subserie::find($id)->delete();
        } catch (\Throwable $th) {

        }
    }
    // --------------------- Crud Series  ---------------------
    public function crearSerie()
    {
        Serie::create(
            [
                'empresa_id' => $this->empresa_id,
                'nombre' => $this->nombreSerie,
                'codigo' => $this->codigoSerie,
            ]
        );
        $this->nombreSerie = null;
        $this->codigoSerie = null;
        $this->series = Serie::where('empresa_id', $this->empresa_id)->get();
    }

    public function editSerie($id)
    {
        $this->serie = Serie::find($id);
        $this->nombreSerie = $this->serie->nombre;
        $this->codigoSerie = $this->serie->codigo;
        $this->boolEditSerie = true;
    }

    public function updateSerie()
    {

        $this->serie->codigo = $this->codigoSerie;
        $this->serie->nombre = $this->nombreSerie;
        $this->serie->save();

        $this->nombreSerie = null;
        $this->codigoSerie = null;
        $this->series = Serie::where('empresa_id', $this->empresa_id)->get();
        $this->boolEditSerie = false;

    }

    public function deleteSerie($id)
    {
        try {
            Serie::find($id)->delete();
            $this->series = Serie::where('empresa_id', $this->empresa_id)->get();
        } catch (\Throwable $th) {

        }
    }

// ------------------------- CRUD SECCIONES ------------------------------
    public function createSeccionEmpresa()
    {

        SeccionEmpresa::create([
            'codigo'=>$this->codigoSeccion,
            'nombre'=>$this->nombreSeccion,
            'empresa_id'=>$this->empresa_id,
            'estado_id'=>1,
        ]);

        $this->secciones = SeccionEmpresa::where('empresa_id', $this->empresa_id)->get();
    }
    public function editSeccionEmpresas($id)
    {
        $this->seccion = SeccionEmpresa::find($id);
        $this->codigoSeccion = $this->seccion->codigo;
        $this->nombreSeccion = $this->seccion->nombre;
        $this->boolEditSeccion = true;
    }

    public function updateSeccionEmpresa()
    {
        $this->seccion->codigo = $this->codigoSeccion;
        $this->seccion->nombre = $this->nombreSeccion;
        $this->seccion->save();
        $this->codigoSeccion = null;
        $this->nombreSeccion = null;
        $this->secciones = SeccionEmpresa::where('empresa_id', $this->empresa_id)->get();
        $this->boolEditSeccion = false;

    }

    public function deleteSeccion($id)
    {
        try {
            SeccionEmpresa::find($id)->delete();
            $this->secciones = SeccionEmpresa::where('empresa_id', $this->empresa_id)->get();
            $this->tipologias = TipologiaDocumento::where('subserie_id', $this->subserie_id)->get();
        } catch (\Throwable $th) {

        }
    }

    public function limpiar()
    {
        $this->codigo = null;
        $this->nombre = null;
        $this->procedimiento = null;
        $this->DF_CT = false;
        $this->DF_E = false;
        $this->DF_MD = false;
        $this->DF_S = false;
    }

    public function cambiarEmpresa()
    {
        $this->empresa = empresa::find($this->empresa_id);
        $this->secciones = SeccionEmpresa::where('empresa_id', $this->empresa_id)->get();
        $this->series = Serie::where('empresa_id', $this->empresa_id)->get();
        $this->serie_id = Serie::where('empresa_id', $this->empresa_id)->first()->id;
        if ($this->secciones) {
            $this->seccion_id = $this->secciones->first()->id;
        }
        $this->So_Pa = true;
        $this->So_El = false;
        $this->So_Di = false;
        $this->DF_CT=true;
        $this->DF_E=false;
        $this->DF_MD=false;
        $this->DF_S=false;
        $this->ACC_P = true;
        $this->ACC_Pr = false;
        $this->radicadoSalida = false;
        $this->radicadoEntrada = true;
        $this->pqrs_id = 1;
        $this->Re_AG = 0;
        $this->Re_AC = 0;
    }

    //----------------------------- crud tipologìas ------------------------
    public function CrearTipologia()
    {
        TipologiaDocumento::create([
            'subserie_id'=>$this->subserie_id,
            'nombre'=>$this->nombreTipologia,
            'So_Pa'=>$this->So_Pa,
            'So_El'=>$this->So_El,
            'So_Di'=>$this->So_Di,
            'diasTermino'=>$this->diasTermino,
            'radicadoSalida'=>$this->radicadoSalida,
            'radicadoEntrada'=>$this->radicadoEntrada,
            'pqrs_id'=>$this->pqrs_id,
        ]);
        $this->nombreTipologia = null;
    }

    public function editTipologia($id)
    {
        $this->tipologia = TipologiaDocumento::find($id);
        $this->nombreTipologia = $this->tipologia->nombre;
        $this->So_Pa = $this->tipologia->So_Pa;
        $this->So_El = $this->tipologia->So_El;
        $this->So_Di = $this->tipologia->So_Di;
        $this->diasTermino = $this->tipologia->diasTermino;
        $this->radicadoSalida = $this->tipologia->radicadoSalida;
        $this->radicadoEntrada = $this->tipologia->radicadoEntrada;
        $this->pqrs_id = $this->tipologia->pqrs_id;
        $this->boolEditTipologia = true;
    }

    public function updateTipologia()
    {
        $this->tipologia->nombre = $this->nombreTipologia;
        $this->tipologia->So_Pa = $this->So_Pa;
        $this->tipologia->So_El = $this->So_El;
        $this->tipologia->So_Di = $this->So_Di;
        $this->tipologia->diasTermino = $this->diasTermino;
        $this->tipologia->radicadoSalida = $this->radicadoSalida;
        $this->tipologia->radicadoEntrada = $this->radicadoEntrada;
        $this->tipologia->pqrs_id = $this->pqrs_id;
        $this->tipologia->save();

        $this->boolEditTipologia = false;
        $this->nombreTipologia = null;
    }

    public function deleteTipologia($id)
    {
        try {
            TipologiaDocumento::find($id)->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        $this->tipologias = TipologiaDocumento::where('subserie_id', $this->subserie_id)->get();
    }

    public function cerrar()
    {
        $this->boolSeccion = false;
        $this->boolSerie = false;
        $this->boolSubserie = false;
        $this->boolEditSerie = false;
        $this->boolEditSeccion = false;
        $this->nombreSerie = null;
        $this->codigoSerie = null;
        $this->codigoSeccion = null;
        $this->nombreSeccion = null;
    }

    public function administrar($tipo)
    {
        $this->cerrar();
        if ($tipo==1) {
            $this->boolSeccion = true;
        } elseif($tipo==2) {
            $this->boolSerie = true;
        }
        elseif($tipo==3){
            $this->boolSubserie = true;
        }
    }

    public function calDiasTermino()
    {
        $this->diasTermino = Pqr::find($this->pqrs_id)->first()->diastermino;
    }

}
