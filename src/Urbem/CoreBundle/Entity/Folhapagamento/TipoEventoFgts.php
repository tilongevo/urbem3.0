<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoEventoFgts
 */
class TipoEventoFgts
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento
     */
    private $fkFolhapagamentoFgtsEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoFgtsEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEventoFgts
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
     * @return TipoEventoFgts
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
     * Add FolhapagamentoFgtsEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento
     * @return TipoEventoFgts
     */
    public function addFkFolhapagamentoFgtsEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento)
    {
        if (false === $this->fkFolhapagamentoFgtsEventos->contains($fkFolhapagamentoFgtsEvento)) {
            $fkFolhapagamentoFgtsEvento->setFkFolhapagamentoTipoEventoFgts($this);
            $this->fkFolhapagamentoFgtsEventos->add($fkFolhapagamentoFgtsEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFgtsEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento
     */
    public function removeFkFolhapagamentoFgtsEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento $fkFolhapagamentoFgtsEvento)
    {
        $this->fkFolhapagamentoFgtsEventos->removeElement($fkFolhapagamentoFgtsEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFgtsEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento
     */
    public function getFkFolhapagamentoFgtsEventos()
    {
        return $this->fkFolhapagamentoFgtsEventos;
    }
}
