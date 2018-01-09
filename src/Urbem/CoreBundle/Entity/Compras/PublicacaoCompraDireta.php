<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * PublicacaoCompraDireta
 */
class PublicacaoCompraDireta
{
    /**
     * PK
     * @var integer
     */
    private $codCompraDireta;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicioEntidade;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $cgmVeiculo;

    /**
     * @var \DateTime
     */
    private $dataPublicacao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $numPublicacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDireta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;


    /**
     * Set codCompraDireta
     *
     * @param integer $codCompraDireta
     * @return PublicacaoCompraDireta
     */
    public function setCodCompraDireta($codCompraDireta)
    {
        $this->codCompraDireta = $codCompraDireta;
        return $this;
    }

    /**
     * Get codCompraDireta
     *
     * @return integer
     */
    public function getCodCompraDireta()
    {
        return $this->codCompraDireta;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return PublicacaoCompraDireta
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
     * Set exercicioEntidade
     *
     * @param string $exercicioEntidade
     * @return PublicacaoCompraDireta
     */
    public function setExercicioEntidade($exercicioEntidade)
    {
        $this->exercicioEntidade = $exercicioEntidade;
        return $this;
    }

    /**
     * Get exercicioEntidade
     *
     * @return string
     */
    public function getExercicioEntidade()
    {
        return $this->exercicioEntidade;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return PublicacaoCompraDireta
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set cgmVeiculo
     *
     * @param integer $cgmVeiculo
     * @return PublicacaoCompraDireta
     */
    public function setCgmVeiculo($cgmVeiculo)
    {
        $this->cgmVeiculo = $cgmVeiculo;
        return $this;
    }

    /**
     * Get cgmVeiculo
     *
     * @return integer
     */
    public function getCgmVeiculo()
    {
        return $this->cgmVeiculo;
    }

    /**
     * Set dataPublicacao
     *
     * @param \DateTime $dataPublicacao
     * @return PublicacaoCompraDireta
     */
    public function setDataPublicacao(\DateTime $dataPublicacao)
    {
        $this->dataPublicacao = $dataPublicacao;
        return $this;
    }

    /**
     * Get dataPublicacao
     *
     * @return \DateTime
     */
    public function getDataPublicacao()
    {
        return $this->dataPublicacao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return PublicacaoCompraDireta
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set numPublicacao
     *
     * @param integer $numPublicacao
     * @return PublicacaoCompraDireta
     */
    public function setNumPublicacao($numPublicacao = null)
    {
        $this->numPublicacao = $numPublicacao;
        return $this;
    }

    /**
     * Get numPublicacao
     *
     * @return integer
     */
    public function getNumPublicacao()
    {
        return $this->numPublicacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return PublicacaoCompraDireta
     */
    public function setFkComprasCompraDireta(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        $this->codCompraDireta = $fkComprasCompraDireta->getCodCompraDireta();
        $this->codEntidade = $fkComprasCompraDireta->getCodEntidade();
        $this->exercicioEntidade = $fkComprasCompraDireta->getExercicioEntidade();
        $this->codModalidade = $fkComprasCompraDireta->getCodModalidade();
        $this->fkComprasCompraDireta = $fkComprasCompraDireta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasCompraDireta
     *
     * @return \Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    public function getFkComprasCompraDireta()
    {
        return $this->fkComprasCompraDireta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return PublicacaoCompraDireta
     */
    public function setFkLicitacaoVeiculosPublicidade(\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade)
    {
        $this->cgmVeiculo = $fkLicitacaoVeiculosPublicidade->getNumcgm();
        $this->fkLicitacaoVeiculosPublicidade = $fkLicitacaoVeiculosPublicidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoVeiculosPublicidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    public function getFkLicitacaoVeiculosPublicidade()
    {
        return $this->fkLicitacaoVeiculosPublicidade;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkLicitacaoVeiculosPublicidade;
    }
}
