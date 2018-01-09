<?php

namespace Urbem\CoreBundle\Model\Calendario;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Symfony\Component\HttpFoundation\Response;

class CalendarioModel
{
    private $entityManager = null;

    public $feriado_tipo = array();
    public $feriado_abrangencia = array();
    public $feriado_cor = array();

    public function __construct(ORM\EntityManager $entityManager, $translator)
    {

        $this->entityManager = $entityManager;

        $this->feriado_tipo['F'] = $translator->trans('label.calendario_feriado.fixo');
        $this->feriado_tipo['V'] = $translator->trans('label.calendario_feriado.variavel');
        $this->feriado_tipo['P'] = $translator->trans('label.calendario_feriado.pontofacultativo');
        $this->feriado_tipo['D'] = $translator->trans('label.calendario_feriado.diacompensado');
        $this->feriado_abrangencia['F'] = $translator->trans('label.calendario_feriado.federal');
        $this->feriado_abrangencia['E'] = $translator->trans('label.calendario_feriado.estadual');
        $this->feriado_abrangencia['M'] = $translator->trans('label.calendario_feriado.municipal');

        $this->feriado_cor['F'] = '#F66';
        $this->feriado_cor['V'] = '#3CF';
        $this->feriado_cor['P'] = '#6C0';
        $this->feriado_cor['D'] = '#FF0';
    }

    public function getCorByTipoFeriado()
    {
        return $this->feriado_cor;
    }

    public function getTipoByTipoFeriado()
    {
        return $this->feriado_tipo;
    }

    public function getAbrangenciaByTipoFeriado()
    {
        return $this->feriado_abrangencia;
    }
}
