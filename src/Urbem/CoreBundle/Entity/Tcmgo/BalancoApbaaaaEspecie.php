<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * BalancoApbaaaaEspecie
 */
class BalancoApbaaaaEspecie
{
    /**
     * PK
     * @var integer
     */
    private $tipoBemMovel;

    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Especie
     */
    private $fkPatrimonioEspecie;


    /**
     * Set tipoBemMovel
     *
     * @param integer $tipoBemMovel
     * @return BalancoApbaaaaEspecie
     */
    public function setTipoBemMovel($tipoBemMovel)
    {
        $this->tipoBemMovel = $tipoBemMovel;
        return $this;
    }

    /**
     * Get tipoBemMovel
     *
     * @return integer
     */
    public function getTipoBemMovel()
    {
        return $this->tipoBemMovel;
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return BalancoApbaaaaEspecie
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
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return BalancoApbaaaaEspecie
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
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return BalancoApbaaaaEspecie
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie
     * @return BalancoApbaaaaEspecie
     */
    public function setFkPatrimonioEspecie(\Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie)
    {
        $this->codEspecie = $fkPatrimonioEspecie->getCodEspecie();
        $this->codGrupo = $fkPatrimonioEspecie->getCodGrupo();
        $this->codNatureza = $fkPatrimonioEspecie->getCodNatureza();
        $this->fkPatrimonioEspecie = $fkPatrimonioEspecie;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioEspecie
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Especie
     */
    public function getFkPatrimonioEspecie()
    {
        return $this->fkPatrimonioEspecie;
    }
}
