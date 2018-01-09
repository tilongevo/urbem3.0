<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CompensacaoResto
 */
class CompensacaoResto
{
    /**
     * PK
     * @var integer
     */
    private $codCompensacao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    private $fkArrecadacaoCompensacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto
     */
    private $fkArrecadacaoCompensacaoUtilizaRestos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoCompensacaoUtilizaRestos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCompensacao
     *
     * @param integer $codCompensacao
     * @return CompensacaoResto
     */
    public function setCodCompensacao($codCompensacao)
    {
        $this->codCompensacao = $codCompensacao;
        return $this;
    }

    /**
     * Get codCompensacao
     *
     * @return integer
     */
    public function getCodCompensacao()
    {
        return $this->codCompensacao;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return CompensacaoResto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCompensacaoUtilizaResto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto $fkArrecadacaoCompensacaoUtilizaResto
     * @return CompensacaoResto
     */
    public function addFkArrecadacaoCompensacaoUtilizaRestos(\Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto $fkArrecadacaoCompensacaoUtilizaResto)
    {
        if (false === $this->fkArrecadacaoCompensacaoUtilizaRestos->contains($fkArrecadacaoCompensacaoUtilizaResto)) {
            $fkArrecadacaoCompensacaoUtilizaResto->setFkArrecadacaoCompensacaoResto($this);
            $this->fkArrecadacaoCompensacaoUtilizaRestos->add($fkArrecadacaoCompensacaoUtilizaResto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCompensacaoUtilizaResto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto $fkArrecadacaoCompensacaoUtilizaResto
     */
    public function removeFkArrecadacaoCompensacaoUtilizaRestos(\Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto $fkArrecadacaoCompensacaoUtilizaResto)
    {
        $this->fkArrecadacaoCompensacaoUtilizaRestos->removeElement($fkArrecadacaoCompensacaoUtilizaResto);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCompensacaoUtilizaRestos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CompensacaoUtilizaResto
     */
    public function getFkArrecadacaoCompensacaoUtilizaRestos()
    {
        return $this->fkArrecadacaoCompensacaoUtilizaRestos;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao
     * @return CompensacaoResto
     */
    public function setFkArrecadacaoCompensacao(\Urbem\CoreBundle\Entity\Arrecadacao\Compensacao $fkArrecadacaoCompensacao)
    {
        $this->codCompensacao = $fkArrecadacaoCompensacao->getCodCompensacao();
        $this->fkArrecadacaoCompensacao = $fkArrecadacaoCompensacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoCompensacao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Compensacao
     */
    public function getFkArrecadacaoCompensacao()
    {
        return $this->fkArrecadacaoCompensacao;
    }
}
