<?php

namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * Apolice
 */
class Apolice
{
    /**
     * PK
     * @var integer
     */
    private $codApolice;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $numApolice;

    /**
     * @var \DateTime
     */
    private $dtVencimento;

    /**
     * @var string
     */
    private $contato;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * @var \DateTime
     */
    private $inicioVigencia;

    /**
     * @var integer
     */
    private $valorApolice;

    /**
     * @var integer
     */
    private $valorFranquia;

    /**
     * @var string
     */
    private $observacoes;

    /**
     * @var string
     */
    private $nomeArquivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem
     */
    private $fkPatrimonioApoliceBens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioApoliceBens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codApolice
     *
     * @param integer $codApolice
     * @return Apolice
     */
    public function setCodApolice($codApolice)
    {
        $this->codApolice = $codApolice;
        return $this;
    }

    /**
     * Get codApolice
     *
     * @return integer
     */
    public function getCodApolice()
    {
        return $this->codApolice;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Apolice
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set numApolice
     *
     * @param string $numApolice
     * @return Apolice
     */
    public function setNumApolice($numApolice)
    {
        $this->numApolice = $numApolice;
        return $this;
    }

    /**
     * Get numApolice
     *
     * @return string
     */
    public function getNumApolice()
    {
        return $this->numApolice;
    }

    /**
     * Set dtVencimento
     *
     * @param \DateTime $dtVencimento
     * @return Apolice
     */
    public function setDtVencimento(\DateTime $dtVencimento)
    {
        $this->dtVencimento = $dtVencimento;
        return $this;
    }

    /**
     * Get dtVencimento
     *
     * @return \DateTime
     */
    public function getDtVencimento()
    {
        return $this->dtVencimento;
    }

    /**
     * Set contato
     *
     * @param string $contato
     * @return Apolice
     */
    public function setContato($contato)
    {
        $this->contato = $contato;
        return $this;
    }

    /**
     * Get contato
     *
     * @return string
     */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return Apolice
     */
    public function setDtAssinatura(\DateTime $dtAssinatura = null)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * Set inicioVigencia
     *
     * @param \DateTime $inicioVigencia
     * @return Apolice
     */
    public function setInicioVigencia(\DateTime $inicioVigencia = null)
    {
        $this->inicioVigencia = $inicioVigencia;
        return $this;
    }

    /**
     * Get inicioVigencia
     *
     * @return \DateTime
     */
    public function getInicioVigencia()
    {
        return $this->inicioVigencia;
    }

    /**
     * Set valorApolice
     *
     * @param integer $valorApolice
     * @return Apolice
     */
    public function setValorApolice($valorApolice = null)
    {
        $this->valorApolice = $valorApolice;
        return $this;
    }

    /**
     * Get valorApolice
     *
     * @return integer
     */
    public function getValorApolice()
    {
        return $this->valorApolice;
    }

    /**
     * Set valorFranquia
     *
     * @param integer $valorFranquia
     * @return Apolice
     */
    public function setValorFranquia($valorFranquia = null)
    {
        $this->valorFranquia = $valorFranquia;
        return $this;
    }

    /**
     * Get valorFranquia
     *
     * @return integer
     */
    public function getValorFranquia()
    {
        return $this->valorFranquia;
    }

    /**
     * Set observacoes
     *
     * @param string $observacoes
     * @return Apolice
     */
    public function setObservacoes($observacoes = null)
    {
        $this->observacoes = $observacoes;
        return $this;
    }

    /**
     * Get observacoes
     *
     * @return string
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * Set nomeArquivo
     *
     * @param string $nomeArquivo
     * @return Apolice
     */
    public function setNomeArquivo($nomeArquivo = null)
    {
        $this->nomeArquivo = $nomeArquivo;
        return $this;
    }

    /**
     * Get nomeArquivo
     *
     * @return string
     */
    public function getNomeArquivo()
    {
        return $this->nomeArquivo;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioApoliceBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem $fkPatrimonioApoliceBem
     * @return Apolice
     */
    public function addFkPatrimonioApoliceBens(\Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem $fkPatrimonioApoliceBem)
    {
        if (false === $this->fkPatrimonioApoliceBens->contains($fkPatrimonioApoliceBem)) {
            $fkPatrimonioApoliceBem->setFkPatrimonioApolice($this);
            $this->fkPatrimonioApoliceBens->add($fkPatrimonioApoliceBem);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioApoliceBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem $fkPatrimonioApoliceBem
     */
    public function removeFkPatrimonioApoliceBens(\Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem $fkPatrimonioApoliceBem)
    {
        $this->fkPatrimonioApoliceBens->removeElement($fkPatrimonioApoliceBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioApoliceBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\ApoliceBem
     */
    public function getFkPatrimonioApoliceBens()
    {
        return $this->fkPatrimonioApoliceBens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Apolice
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->codApolice) {
            return sprintf(
                '%s - %s',
                $this->numApolice,
                $this->fkSwCgm->getNomCgm()
            );
        } else {
            return "Apolice";
        }
    }
}
