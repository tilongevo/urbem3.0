<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TipoFuncaoServidorTemporario
 */
class TipoFuncaoServidorTemporario
{
    /**
     * PK
     * @var integer
     */
    private $codTipoFuncao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario
     */
    private $fkFolhapagamentoTcmbaCargoServidorTemporarios;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoTcmbaCargoServidorTemporarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoFuncao
     *
     * @param integer $codTipoFuncao
     * @return TipoFuncaoServidorTemporario
     */
    public function setCodTipoFuncao($codTipoFuncao)
    {
        $this->codTipoFuncao = $codTipoFuncao;
        return $this;
    }

    /**
     * Get codTipoFuncao
     *
     * @return integer
     */
    public function getCodTipoFuncao()
    {
        return $this->codTipoFuncao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoFuncaoServidorTemporario
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
     * Add FolhapagamentoTcmbaCargoServidorTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario
     * @return TipoFuncaoServidorTemporario
     */
    public function addFkFolhapagamentoTcmbaCargoServidorTemporarios(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario)
    {
        if (false === $this->fkFolhapagamentoTcmbaCargoServidorTemporarios->contains($fkFolhapagamentoTcmbaCargoServidorTemporario)) {
            $fkFolhapagamentoTcmbaCargoServidorTemporario->setFkTcmbaTipoFuncaoServidorTemporario($this);
            $this->fkFolhapagamentoTcmbaCargoServidorTemporarios->add($fkFolhapagamentoTcmbaCargoServidorTemporario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTcmbaCargoServidorTemporario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario
     */
    public function removeFkFolhapagamentoTcmbaCargoServidorTemporarios(\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario $fkFolhapagamentoTcmbaCargoServidorTemporario)
    {
        $this->fkFolhapagamentoTcmbaCargoServidorTemporarios->removeElement($fkFolhapagamentoTcmbaCargoServidorTemporario);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTcmbaCargoServidorTemporarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TcmbaCargoServidorTemporario
     */
    public function getFkFolhapagamentoTcmbaCargoServidorTemporarios()
    {
        return $this->fkFolhapagamentoTcmbaCargoServidorTemporarios;
    }
}
