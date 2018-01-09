<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoEventoFerias
 */
class TipoEventoFerias
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
     * @var string
     */
    private $natureza;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento
     */
    private $fkFolhapagamentoFeriasEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoFeriasEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEventoFerias
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
     * @return TipoEventoFerias
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
     * Set natureza
     *
     * @param string $natureza
     * @return TipoEventoFerias
     */
    public function setNatureza($natureza)
    {
        $this->natureza = $natureza;
        return $this;
    }

    /**
     * Get natureza
     *
     * @return string
     */
    public function getNatureza()
    {
        return $this->natureza;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoFeriasEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $fkFolhapagamentoFeriasEvento
     * @return TipoEventoFerias
     */
    public function addFkFolhapagamentoFeriasEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $fkFolhapagamentoFeriasEvento)
    {
        if (false === $this->fkFolhapagamentoFeriasEventos->contains($fkFolhapagamentoFeriasEvento)) {
            $fkFolhapagamentoFeriasEvento->setFkFolhapagamentoTipoEventoFerias($this);
            $this->fkFolhapagamentoFeriasEventos->add($fkFolhapagamentoFeriasEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoFeriasEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $fkFolhapagamentoFeriasEvento
     */
    public function removeFkFolhapagamentoFeriasEventos(\Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $fkFolhapagamentoFeriasEvento)
    {
        $this->fkFolhapagamentoFeriasEventos->removeElement($fkFolhapagamentoFeriasEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoFeriasEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento
     */
    public function getFkFolhapagamentoFeriasEventos()
    {
        return $this->fkFolhapagamentoFeriasEventos;
    }
}
