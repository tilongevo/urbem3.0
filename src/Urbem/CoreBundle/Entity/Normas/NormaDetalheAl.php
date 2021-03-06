<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * NormaDetalheAl
 */
class NormaDetalheAl
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $codLeiAlteracao;

    /**
     * @var integer
     */
    private $codNormaAlteracao;

    /**
     * @var string
     */
    private $descricaoAlteracao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Lei
     */
    private $fkNormasLei;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma1;


    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return NormaDetalheAl
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
     * Set codLeiAlteracao
     *
     * @param integer $codLeiAlteracao
     * @return NormaDetalheAl
     */
    public function setCodLeiAlteracao($codLeiAlteracao)
    {
        $this->codLeiAlteracao = $codLeiAlteracao;
        return $this;
    }

    /**
     * Get codLeiAlteracao
     *
     * @return integer
     */
    public function getCodLeiAlteracao()
    {
        return $this->codLeiAlteracao;
    }

    /**
     * Set codNormaAlteracao
     *
     * @param integer $codNormaAlteracao
     * @return NormaDetalheAl
     */
    public function setCodNormaAlteracao($codNormaAlteracao)
    {
        $this->codNormaAlteracao = $codNormaAlteracao;
        return $this;
    }

    /**
     * Get codNormaAlteracao
     *
     * @return integer
     */
    public function getCodNormaAlteracao()
    {
        return $this->codNormaAlteracao;
    }

    /**
     * Set descricaoAlteracao
     *
     * @param string $descricaoAlteracao
     * @return NormaDetalheAl
     */
    public function setDescricaoAlteracao($descricaoAlteracao)
    {
        $this->descricaoAlteracao = $descricaoAlteracao;
        return $this;
    }

    /**
     * Get descricaoAlteracao
     *
     * @return string
     */
    public function getDescricaoAlteracao()
    {
        return $this->descricaoAlteracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasLei
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Lei $fkNormasLei
     * @return NormaDetalheAl
     */
    public function setFkNormasLei(\Urbem\CoreBundle\Entity\Normas\Lei $fkNormasLei)
    {
        $this->codLeiAlteracao = $fkNormasLei->getCodLei();
        $this->fkNormasLei = $fkNormasLei;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasLei
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Lei
     */
    public function getFkNormasLei()
    {
        return $this->fkNormasLei;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma1
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma1
     * @return NormaDetalheAl
     */
    public function setFkNormasNorma1(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma1)
    {
        $this->codNormaAlteracao = $fkNormasNorma1->getCodNorma();
        $this->fkNormasNorma1 = $fkNormasNorma1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma1
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma1()
    {
        return $this->fkNormasNorma1;
    }

    /**
     * OneToOne (owning side)
     * Set NormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return NormaDetalheAl
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }
}
