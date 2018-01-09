<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoEventoIrrf
 */
class TipoEventoIrrf
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento
     */
    private $fkFolhapagamentoTabelaIrrfEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoTabelaIrrfEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEventoIrrf
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoEventoIrrf
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTabelaIrrfEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento
     * @return TipoEventoIrrf
     */
    public function addFkFolhapagamentoTabelaIrrfEventos(\Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento $fkFolhapagamentoTabelaIrrfEvento)
    {
        if (false === $this->fkFolhapagamentoTabelaIrrfEventos->contains($fkFolhapagamentoTabelaIrrfEvento)) {
            $fkFolhapagamentoTabelaIrrfEvento->setFkFolhapagamentoTipoEventoIrrf($this);
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
}
