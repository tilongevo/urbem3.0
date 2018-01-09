<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * Vigencia
 */
class Vigencia
{
    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * @var string
     */
    private $tipo = 'v';

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\FaixaDesconto
     */
    private $fkBeneficioFaixaDescontos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;
    
    /**
     * @var array
     */
    private static $tipoTrans = array(
        'v' => 'label.valeTransporte',
        'a' => 'label.auxilioRefeicao'
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioFaixaDescontos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return Vigencia
     */
    public function setCodVigencia($codVigencia)
    {
        $this->codVigencia = $codVigencia;
        return $this;
    }

    /**
     * Get codVigencia
     *
     * @return integer
     */
    public function getCodVigencia()
    {
        return $this->codVigencia;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return Vigencia
     */
    public function setVigencia(\DateTime $vigencia = null)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Vigencia
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Vigencia
     */
    public function setCodNorma($codNorma = null)
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
     * OneToMany (owning side)
     * Add BeneficioFaixaDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\FaixaDesconto $fkBeneficioFaixaDesconto
     * @return Vigencia
     */
    public function addFkBeneficioFaixaDescontos(\Urbem\CoreBundle\Entity\Beneficio\FaixaDesconto $fkBeneficioFaixaDesconto)
    {
        if (false === $this->fkBeneficioFaixaDescontos->contains($fkBeneficioFaixaDesconto)) {
            $fkBeneficioFaixaDesconto->setFkBeneficioVigencia($this);
            $this->fkBeneficioFaixaDescontos->add($fkBeneficioFaixaDesconto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioFaixaDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\FaixaDesconto $fkBeneficioFaixaDesconto
     */
    public function removeFkBeneficioFaixaDescontos(\Urbem\CoreBundle\Entity\Beneficio\FaixaDesconto $fkBeneficioFaixaDesconto)
    {
        $this->fkBeneficioFaixaDescontos->removeElement($fkBeneficioFaixaDesconto);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioFaixaDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\FaixaDesconto
     */
    public function getFkBeneficioFaixaDescontos()
    {
        return $this->fkBeneficioFaixaDescontos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Vigencia
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
     * @return string [description]
     */
    public function __toString()
    {
        return (string) $this->getCodVigencia();
    }
    
    /**
     * @return string
     */
    public function getTipoTrans()
    {
        return self::$tipoTrans[$this->getTipo()];
    }
}
