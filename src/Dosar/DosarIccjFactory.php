<?php

namespace Mihaib\IccjService\Dosar;

use Mihaib\IccjService\Dosar\Entities\DosarIccj;
use Mihaib\IccjService\Dosar\Values\CaleAtacDosarIccj;
use Mihaib\IccjService\Dosar\Values\ParteDosarIccj;
use Mihaib\IccjService\Dosar\Values\TermenDosarIccj;
use stdClass;

class DosarIccjFactory
{
    public static function fromObject(stdClass $data): DosarIccj
    {
        if (!is_array($data->termene)) {
            $data->termene = [];
        }

        return new DosarIccj(
            $data->numar,
            $data->numarVechi,
            $data->data,
            $data->dataInitiala,
            $data->departament,
            $data->categorieCaz,
            $data->stadiuProcesual,
            $data->stadiulProcesualCombinat,
            $data->obiect,
            $data->obiecteSecundare,
            array_map(fn ($termen) => new TermenDosarIccj(
                $termen->data,
                $termen->ora,
                $termen->complet,
                $termen->numarDocument,
                $termen->dataDocument,
                $termen->tipDocument,
                $termen->solutie,
                $termen->detaliiSolutie,
            ), $data->termene),
            array_map(fn ($parte) => new ParteDosarIccj(
                $parte->nume,
                $parte->calitateaProcesualaCurenta,
                $parte->calitateaProcesualaAnterioara,
                $parte->data
            ), $data->parti),
            array_map(fn ($caleAtac) => new CaleAtacDosarIccj(
                $caleAtac->data,
                $caleAtac->tip,
                $caleAtac->numeParteDeclaranta,
            ), $data->caiAtac)
        );
    }
}
