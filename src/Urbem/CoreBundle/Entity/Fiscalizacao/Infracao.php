<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * Infracao
 */
class Infracao
{
    /**
     * PK
     * @var integer
     */
    private $codInfracao;

    /**
     * @var string
     */
    private $nomInfracao;

    /**
     * @var boolean
     */
    private $comminar;

    /**
     * @var integer
     */
    private $codTipoFiscalizacao;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade
     */
    private $fkFiscalizacaoInfracaoPenalidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa
     */
    private $fkFiscalizacaoInfracaoBaixas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao
     */
    private $fkFiscalizacaoNotificacaoTermoInfracoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao
     */
    private $fkFiscalizacaoTipoFiscalizacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoInfracaoPenalidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoInfracaoBaixas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoNotificacaoTermoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codInfracao
     *
     * @param integer $codInfracao
     * @return Infracao
     */
    public function setCodInfracao($codInfracao)
    {
        $this->codInfracao = $codInfracao;
        return $this;
    }

    /**
     * Get codInfracao
     *
     * @return integer
     */
    public function getCodInfracao()
    {
        return $this->codInfracao;
    }

    /**
     * Set nomInfracao
     *
     * @param string $nomInfracao
     * @return Infracao
     */
    public function setNomInfracao($nomInfracao)
    {
        $this->nomInfracao = $nomInfracao;
        return $this;
    }

    /**
     * Get nomInfracao
     *
     * @return string
     */
    public function getNomInfracao()
    {
        return $this->nomInfracao;
    }

    /**
     * Set comminar
     *
     * @param boolean $comminar
     * @return Infracao
     */
    public function setComminar($comminar)
    {
        $this->comminar = $comminar;
        return $this;
    }

    /**
     * Get comminar
     *
     * @return boolean
     */
    public function getComminar()
    {
        return $this->comminar;
    }

    /**
     * Set codTipoFiscalizacao
     *
     * @param integer $codTipoFiscalizacao
     * @return Infracao
     */
    public function setCodTipoFiscalizacao($codTipoFiscalizacao)
    {
        $this->codTipoFiscalizacao = $codTipoFiscalizacao;
        return $this;
    }

    /**
     * Get codTipoFiscalizacao
     *
     * @return integer
     */
    public function getCodTipoFiscalizacao()
    {
        return $this->codTipoFiscalizacao;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Infracao
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
     * OneToMany (owning side)
     * Add FiscalizacaoInfracaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade
     * @return Infracao
     */
    public function addFkFiscalizacaoInfracaoPenalidades(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade)
    {
        if (false === $this->fkFiscalizacaoInfracaoPenalidades->contains($fkFiscalizacaoInfracaoPenalidade)) {
            $fkFiscalizacaoInfracaoPenalidade->setFkFiscalizacaoInfracao($this);
            $this->fkFiscalizacaoInfracaoPenalidades->add($fkFiscalizacaoInfracaoPenalidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInfracaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade
     */
    public function removeFkFiscalizacaoInfracaoPenalidades(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade)
    {
        $this->fkFiscalizacaoInfracaoPenalidades->removeElement($fkFiscalizacaoInfracaoPenalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInfracaoPenalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade
     */
    public function getFkFiscalizacaoInfracaoPenalidades()
    {
        return $this->fkFiscalizacaoInfracaoPenalidades;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoInfracaoBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa $fkFiscalizacaoInfracaoBaixa
     * @return Infracao
     */
    public function addFkFiscalizacaoInfracaoBaixas(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa $fkFiscalizacaoInfracaoBaixa)
    {
        if (false === $this->fkFiscalizacaoInfracaoBaixas->contains($fkFiscalizacaoInfracaoBaixa)) {
            $fkFiscalizacaoInfracaoBaixa->setFkFiscalizacaoInfracao($this);
            $this->fkFiscalizacaoInfracaoBaixas->add($fkFiscalizacaoInfracaoBaixa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInfracaoBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa $fkFiscalizacaoInfracaoBaixa
     */
    public function removeFkFiscalizacaoInfracaoBaixas(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa $fkFiscalizacaoInfracaoBaixa)
    {
        $this->fkFiscalizacaoInfracaoBaixas->removeElement($fkFiscalizacaoInfracaoBaixa);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInfracaoBaixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoBaixa
     */
    public function getFkFiscalizacaoInfracaoBaixas()
    {
        return $this->fkFiscalizacaoInfracaoBaixas;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoNotificacaoTermoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao $fkFiscalizacaoNotificacaoTermoInfracao
     * @return Infracao
     */
    public function addFkFiscalizacaoNotificacaoTermoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao $fkFiscalizacaoNotificacaoTermoInfracao)
    {
        if (false === $this->fkFiscalizacaoNotificacaoTermoInfracoes->contains($fkFiscalizacaoNotificacaoTermoInfracao)) {
            $fkFiscalizacaoNotificacaoTermoInfracao->setFkFiscalizacaoInfracao($this);
            $this->fkFiscalizacaoNotificacaoTermoInfracoes->add($fkFiscalizacaoNotificacaoTermoInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotificacaoTermoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao $fkFiscalizacaoNotificacaoTermoInfracao
     */
    public function removeFkFiscalizacaoNotificacaoTermoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao $fkFiscalizacaoNotificacaoTermoInfracao)
    {
        $this->fkFiscalizacaoNotificacaoTermoInfracoes->removeElement($fkFiscalizacaoNotificacaoTermoInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotificacaoTermoInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao
     */
    public function getFkFiscalizacaoNotificacaoTermoInfracoes()
    {
        return $this->fkFiscalizacaoNotificacaoTermoInfracoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoTipoFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao $fkFiscalizacaoTipoFiscalizacao
     * @return Infracao
     */
    public function setFkFiscalizacaoTipoFiscalizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao $fkFiscalizacaoTipoFiscalizacao)
    {
        $this->codTipoFiscalizacao = $fkFiscalizacaoTipoFiscalizacao->getCodTipo();
        $this->fkFiscalizacaoTipoFiscalizacao = $fkFiscalizacaoTipoFiscalizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoTipoFiscalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\TipoFiscalizacao
     */
    public function getFkFiscalizacaoTipoFiscalizacao()
    {
        return $this->fkFiscalizacaoTipoFiscalizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Infracao
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
