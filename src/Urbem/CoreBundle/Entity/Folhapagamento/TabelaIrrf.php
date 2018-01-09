<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TabelaIrrf
 */
class TabelaIrrf
{
    /**
     * PK
     * @var integer
     */
    private $codTabela;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $vlDependente;

    /**
     * @var integer
     */
    private $vlLimiteIsencao;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FaixaDescontoIrrf
     */
    private $fkFolhapagamentoFaixaDescontoIrrfs;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento
     */
    private $fkFolhapagamentoTabelaIrrfEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento
     */
    private $fkFolhapagamentoTabelaIrrfComprovanteRendimentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid
     */
    private $fkFolhapagamentoTabelaIrrfCids;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoFaixaDescontoIrrfs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTabelaIrrfEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoTabelaIrrfCids = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTabela
     *
     * @param integer $codTabela
     * @return TabelaIrrf
     */
    public function setCodTabela($codTabela)
    {
        $this->codTabela = $codTabela;
        return $this;
    }

    /**
     * Get codTabela
     *
     * @return integer
     */
    public function getCodTabela()
    {
        return $this->codTabela;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return TabelaIrrf
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set vlDependente
     *
     * @param integer $vlDependente
     * @return TabelaIrrf
     */
    public function setVlDependente($vlDependente)
    {
        $this->vlDependente = $vlDependente;
        return $this;
    }

    /**
     * Get vlDependente
     *
     * @return integer
     */
    public function getVlDependente()
    {
        return $this->vlDependente;
    }

    /**
     * Set vlLimiteIsencao
     *
     * @param integer $vlLimiteIsencao
     * @return TabelaIrrf
     */
    public function setVlLimiteIsencao($vlLimiteIsencao)
    {
        $this->vlLimiteIsencao = $vlLimiteIsencao;
        return $this;
    }

    /**
     * Get vlLimiteIsencao
     *
     * @return integer
     */
    public function getVlLimiteIsencao()
    {
        return $this->vlLimiteIsencao;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return TabelaIrrf
     */
    public function setVigencia(\DateTime $vigencia)
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
     * OneToMany (owning side)
     * Add FolhapagamentoFaixaDescontoIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FaixaDescontoIrrf $fkFolhapagamentoFaixaDescontoIrrf
     * @return TabelaIrrf
     */
    public function addFkFolhapagamentoFaixaDescontoIrrfs(\Urbem\CoreBundle\Entity\Folhapagamento\FaixaDescontoIrrf $fkFolhapagamentoFaixaDescontoIrrf)
    {
        if (false === $this->fkFolhapagamentoFaixaDescontoIrrfs->contains($fkFolhapagamentoFaixaDescontoIrrf)) {
            $fkFolhapagamentoFaixaDescontoIrrf->setFkFolhapagamentoTabelaIrrf($this);
            $this->fkFolhapagamentoFaixaDescontoIrrfs->add($fkFolhapagamentoFaixaDescontoIrrf);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFaixaDescontoIrrf
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FaixaDescontoIrrf $fkFolhapagamentoFaixaDescontoIrrf
     */
    public function removeFkFolhapagamentoFaixaDescontoIrrfs(\Urbem\CoreBundle\Entity\Folhapagamento\FaixaDescontoIrrf $fkFolhapagamentoFaixaDescontoIrrf)
    {
        $this->fkFolhapagamentoFaixaDescontoIrrfs->removeElement($fkFolhapagamentoFaixaDescontoIrrf);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFaixaDescontoIrrfs
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FaixaDescontoIrrf
     */
    public function getFkFolhapagamentoFaixaDescontoIrrfs()
    {
        return $this->fkFolhapagamentoFaixaDescontoIrrfs;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTabelaIrrfEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento
     * @return TabelaIrrf
     */
    public function addFkFolhapagamentoTabelaIrrfEventos(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento)
    {
        if (false === $this->fkFolhapagamentoTabelaIrrfEventos->contains($fkFolhapagamentoTabelaIrrfEvento)) {
            $fkFolhapagamentoTabelaIrrfEvento->setFkFolhapagamentoTabelaIrrf($this);
            $this->fkFolhapagamentoTabelaIrrfEventos->add($fkFolhapagamentoTabelaIrrfEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTabelaIrrfEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento
     */
    public function removeFkFolhapagamentoTabelaIrrfEventos(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento)
    {
        $this->fkFolhapagamentoTabelaIrrfEventos->removeElement($fkFolhapagamentoTabelaIrrfEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTabelaIrrfEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento
     */
    public function getFkFolhapagamentoTabelaIrrfEventos()
    {
        return $this->fkFolhapagamentoTabelaIrrfEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTabelaIrrfComprovanteRendimento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento $fkFolhapagamentoTabelaIrrfComprovanteRendimento
     * @return TabelaIrrf
     */
    public function addFkFolhapagamentoTabelaIrrfComprovanteRendimentos(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento $fkFolhapagamentoTabelaIrrfComprovanteRendimento)
    {
        if (false === $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos->contains($fkFolhapagamentoTabelaIrrfComprovanteRendimento)) {
            $fkFolhapagamentoTabelaIrrfComprovanteRendimento->setFkFolhapagamentoTabelaIrrf($this);
            $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos->add($fkFolhapagamentoTabelaIrrfComprovanteRendimento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTabelaIrrfComprovanteRendimento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento $fkFolhapagamentoTabelaIrrfComprovanteRendimento
     */
    public function removeFkFolhapagamentoTabelaIrrfComprovanteRendimentos(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento $fkFolhapagamentoTabelaIrrfComprovanteRendimento)
    {
        $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos->removeElement($fkFolhapagamentoTabelaIrrfComprovanteRendimento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTabelaIrrfComprovanteRendimentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento
     */
    public function getFkFolhapagamentoTabelaIrrfComprovanteRendimentos()
    {
        return $this->fkFolhapagamentoTabelaIrrfComprovanteRendimentos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTabelaIrrfCid
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid $fkFolhapagamentoTabelaIrrfCid
     * @return TabelaIrrf
     */
    public function addFkFolhapagamentoTabelaIrrfCids(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid $fkFolhapagamentoTabelaIrrfCid)
    {
        if (false === $this->fkFolhapagamentoTabelaIrrfCids->contains($fkFolhapagamentoTabelaIrrfCid)) {
            $fkFolhapagamentoTabelaIrrfCid->setFkFolhapagamentoTabelaIrrf($this);
            $this->fkFolhapagamentoTabelaIrrfCids->add($fkFolhapagamentoTabelaIrrfCid);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTabelaIrrfCid
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid $fkFolhapagamentoTabelaIrrfCid
     */
    public function removeFkFolhapagamentoTabelaIrrfCids(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid $fkFolhapagamentoTabelaIrrfCid)
    {
        $this->fkFolhapagamentoTabelaIrrfCids->removeElement($fkFolhapagamentoTabelaIrrfCid);
    }
    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTabelaIrrfCids
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid
     */
    public function getFkFolhapagamentoTabelaIrrfCids()
    {
        return $this->fkFolhapagamentoTabelaIrrfCids;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Tabela de IRRF';
    }
}
