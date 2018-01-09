<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * RetencaoFonte
 */
class RetencaoFonte
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $competencia;

    /**
     * @var integer
     */
    private $valorRetencao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento
     */
    private $fkFiscalizacaoProcessoLevantamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota
     */
    private $fkFiscalizacaoRetencaoNotas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoRetencaoNotas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return RetencaoFonte
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return RetencaoFonte
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set valorRetencao
     *
     * @param integer $valorRetencao
     * @return RetencaoFonte
     */
    public function setValorRetencao($valorRetencao)
    {
        $this->valorRetencao = $valorRetencao;
        return $this;
    }

    /**
     * Get valorRetencao
     *
     * @return integer
     */
    public function getValorRetencao()
    {
        return $this->valorRetencao;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota
     * @return RetencaoFonte
     */
    public function addFkFiscalizacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota)
    {
        if (false === $this->fkFiscalizacaoRetencaoNotas->contains($fkFiscalizacaoRetencaoNota)) {
            $fkFiscalizacaoRetencaoNota->setFkFiscalizacaoRetencaoFonte($this);
            $this->fkFiscalizacaoRetencaoNotas->add($fkFiscalizacaoRetencaoNota);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota
     */
    public function removeFkFiscalizacaoRetencaoNotas(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota $fkFiscalizacaoRetencaoNota)
    {
        $this->fkFiscalizacaoRetencaoNotas->removeElement($fkFiscalizacaoRetencaoNota);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoRetencaoNotas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoNota
     */
    public function getFkFiscalizacaoRetencaoNotas()
    {
        return $this->fkFiscalizacaoRetencaoNotas;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoProcessoLevantamento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento
     * @return RetencaoFonte
     */
    public function setFkFiscalizacaoProcessoLevantamento(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoLevantamento->getCodProcesso();
        $this->competencia = $fkFiscalizacaoProcessoLevantamento->getCompetencia();
        $this->fkFiscalizacaoProcessoLevantamento = $fkFiscalizacaoProcessoLevantamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoProcessoLevantamento
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento
     */
    public function getFkFiscalizacaoProcessoLevantamento()
    {
        return $this->fkFiscalizacaoProcessoLevantamento;
    }
}
