<?php

namespace Urbem\CoreBundle\Entity\Calendario;

/**
 * Feriado
 */
class Feriado
{
    /**
     * PK
     * @var integer
     */
    private $codFeriado;

    /**
     * @var \DateTime
     */
    private $dtFeriado;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $tipoferiado;

    /**
     * @var string
     */
    private $abrangencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Calendario\DiaCompensado
     */
    private $fkCalendarioDiaCompensado;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Calendario\PontoFacultativo
     */
    private $fkCalendarioPontoFacultativo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Calendario\FeriadoVariavel
     */
    private $fkCalendarioFeriadoVariavel;

    /**
     * @var array
     */
    public static $choiceTipoFeriadoList = [
        "F" => "label.calendario_feriado.fixo",
        "V" => "label.calendario_feriado.variavel",
        "P" => "label.calendario_feriado.pontofacultativo",
        "D" => "label.calendario_feriado.diacompensado"
    ];

    /**
     * @var array
     */
    public static $choiceAbrangenciaList = [
        "F" => "label.calendario_feriado.federal",
        "E" => "label.calendario_feriado.estadual",
        "M" => "label.calendario_feriado.municipal",
        "N" => " Não declarada"
    ];

    /**
     * @return mixed
     */
    public function getChoiceTipoFeriadoValue()
    {
        return self::$choiceTipoFeriadoList[$this->tipoferiado];
    }

    /**
     * @return mixed
     */
    public function getChoiceAbrangenciaValue()
    {
        if (empty(trim($this->abrangencia))) {
            $this->abrangencia = 'N';
        }

        return self::$choiceAbrangenciaList[$this->abrangencia];
    }


    /**
     * Set codFeriado
     *
     * @param integer $codFeriado
     * @return Feriado
     */
    public function setCodFeriado($codFeriado)
    {
        $this->codFeriado = $codFeriado;
        return $this;
    }

    /**
     * Get codFeriado
     *
     * @return integer
     */
    public function getCodFeriado()
    {
        return $this->codFeriado;
    }

    /**
     * Set dtFeriado
     *
     * @param \DateTime $dtFeriado
     * @return Feriado
     */
    public function setDtFeriado(\DateTime $dtFeriado)
    {
        $this->dtFeriado = $dtFeriado;
        return $this;
    }

    /**
     * Get dtFeriado
     *
     * @return \DateTime
     */
    public function getDtFeriado()
    {
        return $this->dtFeriado;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Feriado
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set tipoferiado
     *
     * @param string $tipoferiado
     * @return Feriado
     */
    public function setTipoferiado($tipoferiado)
    {
        $this->tipoferiado = $tipoferiado;
        return $this;
    }

    /**
     * Get tipoferiado
     *
     * @return string
     */
    public function getTipoferiado()
    {
        return $this->tipoferiado;
    }

    /**
     * Set abrangencia
     *
     * @param string $abrangencia
     * @return Feriado
     */
    public function setAbrangencia($abrangencia)
    {
        $this->abrangencia = $abrangencia;
        return $this;
    }

    /**
     * Get abrangencia
     *
     * @return string
     */
    public function getAbrangencia()
    {
        return $this->abrangencia;
    }

    /**
     * OneToOne (inverse side)
     * Set CalendarioDiaCompensado
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\DiaCompensado $fkCalendarioDiaCompensado
     * @return Feriado
     */
    public function setFkCalendarioDiaCompensado(\Urbem\CoreBundle\Entity\Calendario\DiaCompensado $fkCalendarioDiaCompensado)
    {
        $fkCalendarioDiaCompensado->setFkCalendarioFeriado($this);
        $this->fkCalendarioDiaCompensado = $fkCalendarioDiaCompensado;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkCalendarioDiaCompensado
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\DiaCompensado
     */
    public function getFkCalendarioDiaCompensado()
    {
        return $this->fkCalendarioDiaCompensado;
    }

    /**
     * OneToOne (inverse side)
     * Set CalendarioPontoFacultativo
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\PontoFacultativo $fkCalendarioPontoFacultativo
     * @return Feriado
     */
    public function setFkCalendarioPontoFacultativo(\Urbem\CoreBundle\Entity\Calendario\PontoFacultativo $fkCalendarioPontoFacultativo)
    {
        $fkCalendarioPontoFacultativo->setFkCalendarioFeriado($this);
        $this->fkCalendarioPontoFacultativo = $fkCalendarioPontoFacultativo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkCalendarioPontoFacultativo
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\PontoFacultativo
     */
    public function getFkCalendarioPontoFacultativo()
    {
        return $this->fkCalendarioPontoFacultativo;
    }

    /**
     * OneToOne (inverse side)
     * Set CalendarioFeriadoVariavel
     *
     * @param \Urbem\CoreBundle\Entity\Calendario\FeriadoVariavel $fkCalendarioFeriadoVariavel
     * @return Feriado
     */
    public function setFkCalendarioFeriadoVariavel(\Urbem\CoreBundle\Entity\Calendario\FeriadoVariavel $fkCalendarioFeriadoVariavel)
    {
        $fkCalendarioFeriadoVariavel->setFkCalendarioFeriado($this);
        $this->fkCalendarioFeriadoVariavel = $fkCalendarioFeriadoVariavel;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkCalendarioFeriadoVariavel
     *
     * @return \Urbem\CoreBundle\Entity\Calendario\FeriadoVariavel
     */
    public function getFkCalendarioFeriadoVariavel()
    {
        return $this->fkCalendarioFeriadoVariavel;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getDescricao();
    }
}
