<?php
 
namespace Urbem\CoreBundle\Entity\Tcepe;

/**
 * DividaFundadaOperacaoCredito
 */
class DividaFundadaOperacaoCredito
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
    private $tipoOperacaoCredito;

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
    private $vlSaldoAnteriorTitulo;

    /**
     * @var integer
     */
    private $vlInscricaoExercicioTitulo;

    /**
     * @var integer
     */
    private $vlBaixaExercicioTitulo;

    /**
     * @var integer
     */
    private $vlSaldoAnteriorContrato;

    /**
     * @var integer
     */
    private $vlInscricaoExercicioContrato;

    /**
     * @var integer
     */
    private $vlBaixaExercicioContrato;

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
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaFundadaOperacaoCredito
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
     * @return DividaFundadaOperacaoCredito
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
     * Set tipoOperacaoCredito
     *
     * @param integer $tipoOperacaoCredito
     * @return DividaFundadaOperacaoCredito
     */
    public function setTipoOperacaoCredito($tipoOperacaoCredito)
    {
        $this->tipoOperacaoCredito = $tipoOperacaoCredito;
        return $this;
    }

    /**
     * Get tipoOperacaoCredito
     *
     * @return integer
     */
    public function getTipoOperacaoCredito()
    {
        return $this->tipoOperacaoCredito;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return DividaFundadaOperacaoCredito
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
     * @return DividaFundadaOperacaoCredito
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
     * @return DividaFundadaOperacaoCredito
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
     * Set vlSaldoAnteriorTitulo
     *
     * @param integer $vlSaldoAnteriorTitulo
     * @return DividaFundadaOperacaoCredito
     */
    public function setVlSaldoAnteriorTitulo($vlSaldoAnteriorTitulo = null)
    {
        $this->vlSaldoAnteriorTitulo = $vlSaldoAnteriorTitulo;
        return $this;
    }

    /**
     * Get vlSaldoAnteriorTitulo
     *
     * @return integer
     */
    public function getVlSaldoAnteriorTitulo()
    {
        return $this->vlSaldoAnteriorTitulo;
    }

    /**
     * Set vlInscricaoExercicioTitulo
     *
     * @param integer $vlInscricaoExercicioTitulo
     * @return DividaFundadaOperacaoCredito
     */
    public function setVlInscricaoExercicioTitulo($vlInscricaoExercicioTitulo = null)
    {
        $this->vlInscricaoExercicioTitulo = $vlInscricaoExercicioTitulo;
        return $this;
    }

    /**
     * Get vlInscricaoExercicioTitulo
     *
     * @return integer
     */
    public function getVlInscricaoExercicioTitulo()
    {
        return $this->vlInscricaoExercicioTitulo;
    }

    /**
     * Set vlBaixaExercicioTitulo
     *
     * @param integer $vlBaixaExercicioTitulo
     * @return DividaFundadaOperacaoCredito
     */
    public function setVlBaixaExercicioTitulo($vlBaixaExercicioTitulo = null)
    {
        $this->vlBaixaExercicioTitulo = $vlBaixaExercicioTitulo;
        return $this;
    }

    /**
     * Get vlBaixaExercicioTitulo
     *
     * @return integer
     */
    public function getVlBaixaExercicioTitulo()
    {
        return $this->vlBaixaExercicioTitulo;
    }

    /**
     * Set vlSaldoAnteriorContrato
     *
     * @param integer $vlSaldoAnteriorContrato
     * @return DividaFundadaOperacaoCredito
     */
    public function setVlSaldoAnteriorContrato($vlSaldoAnteriorContrato = null)
    {
        $this->vlSaldoAnteriorContrato = $vlSaldoAnteriorContrato;
        return $this;
    }

    /**
     * Get vlSaldoAnteriorContrato
     *
     * @return integer
     */
    public function getVlSaldoAnteriorContrato()
    {
        return $this->vlSaldoAnteriorContrato;
    }

    /**
     * Set vlInscricaoExercicioContrato
     *
     * @param integer $vlInscricaoExercicioContrato
     * @return DividaFundadaOperacaoCredito
     */
    public function setVlInscricaoExercicioContrato($vlInscricaoExercicioContrato = null)
    {
        $this->vlInscricaoExercicioContrato = $vlInscricaoExercicioContrato;
        return $this;
    }

    /**
     * Get vlInscricaoExercicioContrato
     *
     * @return integer
     */
    public function getVlInscricaoExercicioContrato()
    {
        return $this->vlInscricaoExercicioContrato;
    }

    /**
     * Set vlBaixaExercicioContrato
     *
     * @param integer $vlBaixaExercicioContrato
     * @return DividaFundadaOperacaoCredito
     */
    public function setVlBaixaExercicioContrato($vlBaixaExercicioContrato = null)
    {
        $this->vlBaixaExercicioContrato = $vlBaixaExercicioContrato;
        return $this;
    }

    /**
     * Get vlBaixaExercicioContrato
     *
     * @return integer
     */
    public function getVlBaixaExercicioContrato()
    {
        return $this->vlBaixaExercicioContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return DividaFundadaOperacaoCredito
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
     * @return DividaFundadaOperacaoCredito
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
}
