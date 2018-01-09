<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * AtributoNormaValor
 */
class AtributoNormaValor
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codTipoNorma;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma
     */
    private $fkNormasAtributoTipoNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return AtributoNormaValor
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoNormaValor
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoNormaValor
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AtributoNormaValor
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codTipoNorma
     *
     * @param integer $codTipoNorma
     * @return AtributoNormaValor
     */
    public function setCodTipoNorma($codTipoNorma)
    {
        $this->codTipoNorma = $codTipoNorma;
        return $this;
    }

    /**
     * Get codTipoNorma
     *
     * @return integer
     */
    public function getCodTipoNorma()
    {
        return $this->codTipoNorma;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoNormaValor
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoNormaValor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return AtributoNormaValor
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasAtributoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma
     * @return AtributoNormaValor
     */
    public function setFkNormasAtributoTipoNorma(\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma)
    {
        $this->codCadastro = $fkNormasAtributoTipoNorma->getCodCadastro();
        $this->codAtributo = $fkNormasAtributoTipoNorma->getCodAtributo();
        $this->codTipoNorma = $fkNormasAtributoTipoNorma->getCodTipoNorma();
        $this->codModulo = $fkNormasAtributoTipoNorma->getCodModulo();
        $this->fkNormasAtributoTipoNorma = $fkNormasAtributoTipoNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasAtributoTipoNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma
     */
    public function getFkNormasAtributoTipoNorma()
    {
        return $this->fkNormasAtributoTipoNorma;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValor();
    }
}
