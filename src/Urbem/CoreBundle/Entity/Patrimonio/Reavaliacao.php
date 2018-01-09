<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * Reavaliacao
 */
class Reavaliacao
{
    /**
     * PK
     * @var integer
     */
    private $codReavaliacao;

    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * @var \DateTime
     */
    private $dtReavaliacao;

    /**
     * @var integer
     */
    private $vidaUtil;

    /**
     * @var integer
     */
    private $vlReavaliacao;

    /**
     * @var string
     */
    private $motivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao
     */
    private $fkPatrimonioDepreciacaoReavaliacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioDepreciacaoReavaliacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codReavaliacao
     *
     * @param integer $codReavaliacao
     * @return Reavaliacao
     */
    public function setCodReavaliacao($codReavaliacao)
    {
        $this->codReavaliacao = $codReavaliacao;
        return $this;
    }

    /**
     * Get codReavaliacao
     *
     * @return integer
     */
    public function getCodReavaliacao()
    {
        return $this->codReavaliacao;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return Reavaliacao
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set dtReavaliacao
     *
     * @param \DateTime $dtReavaliacao
     * @return Reavaliacao
     */
    public function setDtReavaliacao(\DateTime $dtReavaliacao)
    {
        $this->dtReavaliacao = $dtReavaliacao;
        return $this;
    }

    /**
     * Get dtReavaliacao
     *
     * @return \DateTime
     */
    public function getDtReavaliacao()
    {
        return $this->dtReavaliacao;
    }

    /**
     * Set vidaUtil
     *
     * @param integer $vidaUtil
     * @return Reavaliacao
     */
    public function setVidaUtil($vidaUtil)
    {
        $this->vidaUtil = $vidaUtil;
        return $this;
    }

    /**
     * Get vidaUtil
     *
     * @return integer
     */
    public function getVidaUtil()
    {
        return $this->vidaUtil;
    }

    /**
     * Set vlReavaliacao
     *
     * @param integer $vlReavaliacao
     * @return Reavaliacao
     */
    public function setVlReavaliacao($vlReavaliacao)
    {
        $this->vlReavaliacao = $vlReavaliacao;
        return $this;
    }

    /**
     * Get vlReavaliacao
     *
     * @return integer
     */
    public function getVlReavaliacao()
    {
        return $this->vlReavaliacao;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return Reavaliacao
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioDepreciacaoReavaliacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao $fkPatrimonioDepreciacaoReavaliacao
     * @return Reavaliacao
     */
    public function addFkPatrimonioDepreciacaoReavaliacoes(\Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao $fkPatrimonioDepreciacaoReavaliacao)
    {
        if (false === $this->fkPatrimonioDepreciacaoReavaliacoes->contains($fkPatrimonioDepreciacaoReavaliacao)) {
            $fkPatrimonioDepreciacaoReavaliacao->setFkPatrimonioReavaliacao($this);
            $this->fkPatrimonioDepreciacaoReavaliacoes->add($fkPatrimonioDepreciacaoReavaliacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioDepreciacaoReavaliacao
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao $fkPatrimonioDepreciacaoReavaliacao
     */
    public function removeFkPatrimonioDepreciacaoReavaliacoes(\Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao $fkPatrimonioDepreciacaoReavaliacao)
    {
        $this->fkPatrimonioDepreciacaoReavaliacoes->removeElement($fkPatrimonioDepreciacaoReavaliacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioDepreciacaoReavaliacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoReavaliacao
     */
    public function getFkPatrimonioDepreciacaoReavaliacoes()
    {
        return $this->fkPatrimonioDepreciacaoReavaliacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return Reavaliacao
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }
}
