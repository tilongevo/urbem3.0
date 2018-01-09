<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ConfiguracaoIde
 */
class ConfiguracaoIde
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $cgmChefeGoverno;

    /**
     * @var integer
     */
    private $cgmContador;

    /**
     * @var integer
     */
    private $cgmControleInterno;

    /**
     * @var integer
     */
    private $crcContador;

    /**
     * @var integer
     */
    private $ufCrcContador;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUf;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm2;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ConfiguracaoIde
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoIde
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
     * Set cgmChefeGoverno
     *
     * @param integer $cgmChefeGoverno
     * @return ConfiguracaoIde
     */
    public function setCgmChefeGoverno($cgmChefeGoverno)
    {
        $this->cgmChefeGoverno = $cgmChefeGoverno;
        return $this;
    }

    /**
     * Get cgmChefeGoverno
     *
     * @return integer
     */
    public function getCgmChefeGoverno()
    {
        return $this->cgmChefeGoverno;
    }

    /**
     * Set cgmContador
     *
     * @param integer $cgmContador
     * @return ConfiguracaoIde
     */
    public function setCgmContador($cgmContador)
    {
        $this->cgmContador = $cgmContador;
        return $this;
    }

    /**
     * Get cgmContador
     *
     * @return integer
     */
    public function getCgmContador()
    {
        return $this->cgmContador;
    }

    /**
     * Set cgmControleInterno
     *
     * @param integer $cgmControleInterno
     * @return ConfiguracaoIde
     */
    public function setCgmControleInterno($cgmControleInterno)
    {
        $this->cgmControleInterno = $cgmControleInterno;
        return $this;
    }

    /**
     * Get cgmControleInterno
     *
     * @return integer
     */
    public function getCgmControleInterno()
    {
        return $this->cgmControleInterno;
    }

    /**
     * Set crcContador
     *
     * @param integer $crcContador
     * @return ConfiguracaoIde
     */
    public function setCrcContador($crcContador)
    {
        $this->crcContador = $crcContador;
        return $this;
    }

    /**
     * Get crcContador
     *
     * @return integer
     */
    public function getCrcContador()
    {
        return $this->crcContador;
    }

    /**
     * Set ufCrcContador
     *
     * @param integer $ufCrcContador
     * @return ConfiguracaoIde
     */
    public function setUfCrcContador($ufCrcContador)
    {
        $this->ufCrcContador = $ufCrcContador;
        return $this;
    }

    /**
     * Get ufCrcContador
     *
     * @return integer
     */
    public function getUfCrcContador()
    {
        return $this->ufCrcContador;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ConfiguracaoIde
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmChefeGoverno = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     * @return ConfiguracaoIde
     */
    public function setFkSwUf(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        $this->ufCrcContador = $fkSwUf->getCodUf();
        $this->fkSwUf = $fkSwUf;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwUf
     *
     * @return \Urbem\CoreBundle\Entity\SwUf
     */
    public function getFkSwUf()
    {
        return $this->fkSwUf;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm1
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1
     * @return ConfiguracaoIde
     */
    public function setFkSwCgm1(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm1)
    {
        $this->cgmContador = $fkSwCgm1->getNumcgm();
        $this->fkSwCgm1 = $fkSwCgm1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm1
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm1()
    {
        return $this->fkSwCgm1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm2
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm2
     * @return ConfiguracaoIde
     */
    public function setFkSwCgm2(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm2)
    {
        $this->cgmControleInterno = $fkSwCgm2->getNumcgm();
        $this->fkSwCgm2 = $fkSwCgm2;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm2
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm2()
    {
        return $this->fkSwCgm2;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return ConfiguracaoIde
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }
}
