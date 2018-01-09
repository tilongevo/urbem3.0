<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoBem
 */
class TipoBem
{
    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * @var integer
     */
    private $codTipoTcm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Grupo
     */
    private $fkPatrimonioGrupo;


    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return TipoBem
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return TipoBem
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set codTipoTcm
     *
     * @param integer $codTipoTcm
     * @return TipoBem
     */
    public function setCodTipoTcm($codTipoTcm)
    {
        $this->codTipoTcm = $codTipoTcm;
        return $this;
    }

    /**
     * Get codTipoTcm
     *
     * @return integer
     */
    public function getCodTipoTcm()
    {
        return $this->codTipoTcm;
    }

    /**
     * OneToOne (owning side)
     * Set PatrimonioGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo
     * @return TipoBem
     */
    public function setFkPatrimonioGrupo(\Urbem\CoreBundle\Entity\Patrimonio\Grupo $fkPatrimonioGrupo)
    {
        $this->codGrupo = $fkPatrimonioGrupo->getCodGrupo();
        $this->codNatureza = $fkPatrimonioGrupo->getCodNatureza();
        $this->fkPatrimonioGrupo = $fkPatrimonioGrupo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPatrimonioGrupo
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Grupo
     */
    public function getFkPatrimonioGrupo()
    {
        return $this->fkPatrimonioGrupo;
    }
}
