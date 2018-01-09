<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * Servico
 */
class Servico
{
    /**
     * PK
     * @var integer
     */
    private $codServico;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $nomServico;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AliquotaServico
     */
    private $fkEconomicoAliquotaServicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelServicoValor
     */
    private $fkEconomicoNivelServicoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico
     */
    private $fkFiscalizacaoRetencaoServicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico
     */
    private $fkArrecadacaoRetencaoServicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ServicoAtividade
     */
    private $fkEconomicoServicoAtividades;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAliquotaServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoNivelServicoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoRetencaoServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoRetencaoServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoServicoAtividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codServico
     *
     * @param integer $codServico
     * @return Servico
     */
    public function setCodServico($codServico)
    {
        $this->codServico = $codServico;
        return $this;
    }

    /**
     * Get codServico
     *
     * @return integer
     */
    public function getCodServico()
    {
        return $this->codServico;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Servico
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
     * Set nomServico
     *
     * @param string $nomServico
     * @return Servico
     */
    public function setNomServico($nomServico)
    {
        $this->nomServico = $nomServico;
        return $this;
    }

    /**
     * Get nomServico
     *
     * @return string
     */
    public function getNomServico()
    {
        return $this->nomServico;
    }

    /**
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return Servico
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAliquotaServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AliquotaServico $fkEconomicoAliquotaServico
     * @return Servico
     */
    public function addFkEconomicoAliquotaServicos(\Urbem\CoreBundle\Entity\Economico\AliquotaServico $fkEconomicoAliquotaServico)
    {
        if (false === $this->fkEconomicoAliquotaServicos->contains($fkEconomicoAliquotaServico)) {
            $fkEconomicoAliquotaServico->setFkEconomicoServico($this);
            $this->fkEconomicoAliquotaServicos->add($fkEconomicoAliquotaServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAliquotaServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AliquotaServico $fkEconomicoAliquotaServico
     */
    public function removeFkEconomicoAliquotaServicos(\Urbem\CoreBundle\Entity\Economico\AliquotaServico $fkEconomicoAliquotaServico)
    {
        $this->fkEconomicoAliquotaServicos->removeElement($fkEconomicoAliquotaServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAliquotaServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AliquotaServico
     */
    public function getFkEconomicoAliquotaServicos()
    {
        return $this->fkEconomicoAliquotaServicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoNivelServicoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelServicoValor $fkEconomicoNivelServicoValor
     * @return Servico
     */
    public function addFkEconomicoNivelServicoValores(\Urbem\CoreBundle\Entity\Economico\NivelServicoValor $fkEconomicoNivelServicoValor)
    {
        if (false === $this->fkEconomicoNivelServicoValores->contains($fkEconomicoNivelServicoValor)) {
            $fkEconomicoNivelServicoValor->setFkEconomicoServico($this);
            $this->fkEconomicoNivelServicoValores->add($fkEconomicoNivelServicoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoNivelServicoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelServicoValor $fkEconomicoNivelServicoValor
     */
    public function removeFkEconomicoNivelServicoValores(\Urbem\CoreBundle\Entity\Economico\NivelServicoValor $fkEconomicoNivelServicoValor)
    {
        $this->fkEconomicoNivelServicoValores->removeElement($fkEconomicoNivelServicoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoNivelServicoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelServicoValor
     */
    public function getFkEconomicoNivelServicoValores()
    {
        return $this->fkEconomicoNivelServicoValores;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoRetencaoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico $fkFiscalizacaoRetencaoServico
     * @return Servico
     */
    public function addFkFiscalizacaoRetencaoServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico $fkFiscalizacaoRetencaoServico)
    {
        if (false === $this->fkFiscalizacaoRetencaoServicos->contains($fkFiscalizacaoRetencaoServico)) {
            $fkFiscalizacaoRetencaoServico->setFkEconomicoServico($this);
            $this->fkFiscalizacaoRetencaoServicos->add($fkFiscalizacaoRetencaoServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoRetencaoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico $fkFiscalizacaoRetencaoServico
     */
    public function removeFkFiscalizacaoRetencaoServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico $fkFiscalizacaoRetencaoServico)
    {
        $this->fkFiscalizacaoRetencaoServicos->removeElement($fkFiscalizacaoRetencaoServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoRetencaoServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoServico
     */
    public function getFkFiscalizacaoRetencaoServicos()
    {
        return $this->fkFiscalizacaoRetencaoServicos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoRetencaoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico $fkArrecadacaoRetencaoServico
     * @return Servico
     */
    public function addFkArrecadacaoRetencaoServicos(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico $fkArrecadacaoRetencaoServico)
    {
        if (false === $this->fkArrecadacaoRetencaoServicos->contains($fkArrecadacaoRetencaoServico)) {
            $fkArrecadacaoRetencaoServico->setFkEconomicoServico($this);
            $this->fkArrecadacaoRetencaoServicos->add($fkArrecadacaoRetencaoServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoRetencaoServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico $fkArrecadacaoRetencaoServico
     */
    public function removeFkArrecadacaoRetencaoServicos(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico $fkArrecadacaoRetencaoServico)
    {
        $this->fkArrecadacaoRetencaoServicos->removeElement($fkArrecadacaoRetencaoServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoRetencaoServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico
     */
    public function getFkArrecadacaoRetencaoServicos()
    {
        return $this->fkArrecadacaoRetencaoServicos;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoServicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade
     * @return Servico
     */
    public function addFkEconomicoServicoAtividades(\Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade)
    {
        if (false === $this->fkEconomicoServicoAtividades->contains($fkEconomicoServicoAtividade)) {
            $fkEconomicoServicoAtividade->setFkEconomicoServico($this);
            $this->fkEconomicoServicoAtividades->add($fkEconomicoServicoAtividade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoServicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade
     */
    public function removeFkEconomicoServicoAtividades(\Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade)
    {
        $this->fkEconomicoServicoAtividades->removeElement($fkEconomicoServicoAtividade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoServicoAtividades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ServicoAtividade
     */
    public function getFkEconomicoServicoAtividades()
    {
        return $this->fkEconomicoServicoAtividades;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('s% - s%', $this->getCodServico(), $this->getNomServico());
    }
}
