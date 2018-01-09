<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TipoRemuneracao
 */
class TipoRemuneracao
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao
     */
    private $fkFolhapagamentoTcemgEntidadeRemuneracoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoTcemgEntidadeRemuneracoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoRemuneracao
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
     * @return TipoRemuneracao
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
     * Add FolhapagamentoTcemgEntidadeRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao $fkFolhapagamentoTcemgEntidadeRemuneracao
     * @return TipoRemuneracao
     */
    public function addFkFolhapagamentoTcemgEntidadeRemuneracoes(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao $fkFolhapagamentoTcemgEntidadeRemuneracao)
    {
        if (false === $this->fkFolhapagamentoTcemgEntidadeRemuneracoes->contains($fkFolhapagamentoTcemgEntidadeRemuneracao)) {
            $fkFolhapagamentoTcemgEntidadeRemuneracao->setFkTcemgTipoRemuneracao($this);
            $this->fkFolhapagamentoTcemgEntidadeRemuneracoes->add($fkFolhapagamentoTcemgEntidadeRemuneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcemgEntidadeRemuneracao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao $fkFolhapagamentoTcemgEntidadeRemuneracao
     */
    public function removeFkFolhapagamentoTcemgEntidadeRemuneracoes(\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao $fkFolhapagamentoTcemgEntidadeRemuneracao)
    {
        $this->fkFolhapagamentoTcemgEntidadeRemuneracoes->removeElement($fkFolhapagamentoTcemgEntidadeRemuneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcemgEntidadeRemuneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcemgEntidadeRemuneracao
     */
    public function getFkFolhapagamentoTcemgEntidadeRemuneracoes()
    {
        return $this->fkFolhapagamentoTcemgEntidadeRemuneracoes;
    }
}
