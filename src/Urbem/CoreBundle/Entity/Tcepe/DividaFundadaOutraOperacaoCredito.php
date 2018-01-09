<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * DividaFundadaOutraOperacaoCredito
 */
class DividaFundadaOutraOperacaoCredito
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
    private $codNorma;

    /**
     * PK
     * @var integer
     */
    private $numContrato;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * @var integer
     */
    private $cgmCredor;

    /**
     * @var integer
     */
    private $vlSaldoAnterior;

    /**
     * @var integer
     */
    private $vlInscricaoExercicio;

    /**
     * @var integer
     */
    private $vlBaixaExercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaFundadaOutraOperacaoCredito
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
     * @return DividaFundadaOutraOperacaoCredito
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return DividaFundadaOutraOperacaoCredito
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
     * Set numContrato
     *
     * @param integer $numContrato
     * @return DividaFundadaOutraOperacaoCredito
     */
    public function setNumContrato($numContrato)
    {
        $this->numContrato = $numContrato;
        return $this;
    }

    /**
     * Get numContrato
     *
     * @return integer
     */
    public function getNumContrato()
    {
        return $this->numContrato;
    }

    /**
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return DividaFundadaOutraOperacaoCredito
     */
    public function setDtAssinatura(\DateTime $dtAssinatura = null)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * Set cgmCredor
     *
     * @param integer $cgmCredor
     * @return DividaFundadaOutraOperacaoCredito
     */
    public function setCgmCredor($cgmCredor)
    {
        $this->cgmCredor = $cgmCredor;
        return $this;
    }

    /**
     * Get cgmCredor
     *
     * @return integer
     */
    public function getCgmCredor()
    {
        return $this->cgmCredor;
    }

    /**
     * Set vlSaldoAnterior
     *
     * @param integer $vlSaldoAnterior
     * @return DividaFundadaOutraOperacaoCredito
     */
    public function setVlSaldoAnterior($vlSaldoAnterior = null)
    {
        $this->vlSaldoAnterior = $vlSaldoAnterior;
        return $this;
    }

    /**
     * Get vlSaldoAnterior
     *
     * @return integer
     */
    public function getVlSaldoAnterior()
    {
        return $this->vlSaldoAnterior;
    }

    /**
     * Set vlInscricaoExercicio
     *
     * @param integer $vlInscricaoExercicio
     * @return DividaFundadaOutraOperacaoCredito
     */
    public function setVlInscricaoExercicio($vlInscricaoExercicio = null)
    {
        $this->vlInscricaoExercicio = $vlInscricaoExercicio;
        return $this;
    }

    /**
     * Get vlInscricaoExercicio
     *
     * @return integer
     */
    public function getVlInscricaoExercicio()
    {
        return $this->vlInscricaoExercicio;
    }

    /**
     * Set vlBaixaExercicio
     *
     * @param integer $vlBaixaExercicio
     * @return DividaFundadaOutraOperacaoCredito
     */
    public function setVlBaixaExercicio($vlBaixaExercicio = null)
    {
        $this->vlBaixaExercicio = $vlBaixaExercicio;
        return $this;
    }

    /**
     * Get vlBaixaExercicio
     *
     * @return integer
     */
    public function getVlBaixaExercicio()
    {
        return $this->vlBaixaExercicio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return DividaFundadaOutraOperacaoCredito
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
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return DividaFundadaOutraOperacaoCredito
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
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return DividaFundadaOutraOperacaoCredito
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmCredor = $fkSwCgm->getNumcgm();
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
}
