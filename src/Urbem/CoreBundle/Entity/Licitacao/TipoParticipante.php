<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoParticipante
 */
class TipoParticipante
{
    /**
     * PK
     * @var integer
     */
    private $codTipoParticipante;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio
     */
    private $fkLicitacaoParticipanteConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante
     */
    private $fkTcemgConvenioParticipantes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoParticipanteConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConvenioParticipantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoParticipante
     *
     * @param integer $codTipoParticipante
     * @return TipoParticipante
     */
    public function setCodTipoParticipante($codTipoParticipante)
    {
        $this->codTipoParticipante = $codTipoParticipante;
        return $this;
    }

    /**
     * Get codTipoParticipante
     *
     * @return integer
     */
    public function getCodTipoParticipante()
    {
        return $this->codTipoParticipante;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoParticipante
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
     * Add LicitacaoParticipanteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio
     * @return TipoParticipante
     */
    public function addFkLicitacaoParticipanteConvenios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio)
    {
        if (false === $this->fkLicitacaoParticipanteConvenios->contains($fkLicitacaoParticipanteConvenio)) {
            $fkLicitacaoParticipanteConvenio->setFkLicitacaoTipoParticipante($this);
            $this->fkLicitacaoParticipanteConvenios->add($fkLicitacaoParticipanteConvenio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoParticipanteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio
     */
    public function removeFkLicitacaoParticipanteConvenios(\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio $fkLicitacaoParticipanteConvenio)
    {
        $this->fkLicitacaoParticipanteConvenios->removeElement($fkLicitacaoParticipanteConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoParticipanteConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ParticipanteConvenio
     */
    public function getFkLicitacaoParticipanteConvenios()
    {
        return $this->fkLicitacaoParticipanteConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConvenioParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante
     * @return TipoParticipante
     */
    public function addFkTcemgConvenioParticipantes(\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante)
    {
        if (false === $this->fkTcemgConvenioParticipantes->contains($fkTcemgConvenioParticipante)) {
            $fkTcemgConvenioParticipante->setFkLicitacaoTipoParticipante($this);
            $this->fkTcemgConvenioParticipantes->add($fkTcemgConvenioParticipante);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConvenioParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante
     */
    public function removeFkTcemgConvenioParticipantes(\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante)
    {
        $this->fkTcemgConvenioParticipantes->removeElement($fkTcemgConvenioParticipante);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConvenioParticipantes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante
     */
    public function getFkTcemgConvenioParticipantes()
    {
        return $this->fkTcemgConvenioParticipantes;
    }

    public function __toString()
    {
        return sprintf('%s - %s', $this->codTipoParticipante, $this->descricao);
    }
}
