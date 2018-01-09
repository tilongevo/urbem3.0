<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * CentroCustoEntidade
 */
class CentroCustoEntidade
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codCentro;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao
     */
    private $fkAlmoxarifadoCentroCustoDotacoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    private $fkAlmoxarifadoCentroCusto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoCentroCustoDotacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return CentroCustoEntidade
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return CentroCustoEntidade
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set codCentro
     *
     * @param integer $codCentro
     * @return CentroCustoEntidade
     */
    public function setCodCentro($codCentro)
    {
        $this->codCentro = $codCentro;
        return $this;
    }

    /**
     * Get codCentro
     *
     * @return integer
     */
    public function getCodCentro()
    {
        return $this->codCentro;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoCentroCustoDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao $fkAlmoxarifadoCentroCustoDotacao
     * @return CentroCustoEntidade
     */
    public function addFkAlmoxarifadoCentroCustoDotacoes(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao $fkAlmoxarifadoCentroCustoDotacao)
    {
        if (false === $this->fkAlmoxarifadoCentroCustoDotacoes->contains($fkAlmoxarifadoCentroCustoDotacao)) {
            $fkAlmoxarifadoCentroCustoDotacao->setFkAlmoxarifadoCentroCustoEntidade($this);
            $this->fkAlmoxarifadoCentroCustoDotacoes->add($fkAlmoxarifadoCentroCustoDotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoCentroCustoDotacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao $fkAlmoxarifadoCentroCustoDotacao
     */
    public function removeFkAlmoxarifadoCentroCustoDotacoes(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao $fkAlmoxarifadoCentroCustoDotacao)
    {
        $this->fkAlmoxarifadoCentroCustoDotacoes->removeElement($fkAlmoxarifadoCentroCustoDotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoCentroCustoDotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoDotacao
     */
    public function getFkAlmoxarifadoCentroCustoDotacoes()
    {
        return $this->fkAlmoxarifadoCentroCustoDotacoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return CentroCustoEntidade
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCentroCusto
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto
     * @return CentroCustoEntidade
     */
    public function setFkAlmoxarifadoCentroCusto(\Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto $fkAlmoxarifadoCentroCusto)
    {
        $this->codCentro = $fkAlmoxarifadoCentroCusto->getCodCentro();
        $this->fkAlmoxarifadoCentroCusto = $fkAlmoxarifadoCentroCusto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCentroCusto
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto
     */
    public function getFkAlmoxarifadoCentroCusto()
    {
        return $this->fkAlmoxarifadoCentroCusto;
    }
}
