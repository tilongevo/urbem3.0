<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Lote
 */
class Lote
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $dtInscricao;

    /**
     * @var string
     */
    private $localizacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LoteUrbano
     */
    private $fkImobiliarioLoteUrbano;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LoteRural
     */
    private $fkImobiliarioLoteRural;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao
     */
    private $fkImobiliarioLoteLocalizacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento
     */
    private $fkImobiliarioLoteLoteamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaLote
     */
    private $fkImobiliarioAreaLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaLote
     */
    private $fkImobiliarioBaixaLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote
     */
    private $fkImobiliarioConfrontacaoLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    private $fkImobiliarioLicencaLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteBairro
     */
    private $fkImobiliarioLoteBairros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio
     */
    private $fkImobiliarioLoteCondominios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso
     */
    private $fkImobiliarioLoteProcessos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ProfundidadeMedia
     */
    private $fkImobiliarioProfundidadeMedias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo
     */
    private $fkImobiliarioParcelamentoSolos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem
     */
    private $fkImobiliarioLoteamentoLoteOrigens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    private $fkImobiliarioConfrontacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelLote
     */
    private $fkImobiliarioImovelLotes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado
     */
    private $fkImobiliarioLoteParcelados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAreaLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioBaixaLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConfrontacaoLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteBairros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteCondominios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteProcessos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioProfundidadeMedias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioParcelamentoSolos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteamentoLoteOrigens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioConfrontacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioImovelLotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteParcelados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return Lote
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Lote
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
     * Set dtInscricao
     *
     * @param \DateTime $dtInscricao
     * @return Lote
     */
    public function setDtInscricao(\DateTime $dtInscricao)
    {
        $this->dtInscricao = $dtInscricao;
        return $this;
    }

    /**
     * Get dtInscricao
     *
     * @return \DateTime
     */
    public function getDtInscricao()
    {
        return $this->dtInscricao;
    }

    /**
     * Set localizacao
     *
     * @param string $localizacao
     * @return Lote
     */
    public function setLocalizacao($localizacao = null)
    {
        $this->localizacao = $localizacao;
        return $this;
    }

    /**
     * Get localizacao
     *
     * @return string
     */
    public function getLocalizacao()
    {
        return $this->localizacao;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioAreaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaLote $fkImobiliarioAreaLote
     * @return Lote
     */
    public function addFkImobiliarioAreaLotes(\Urbem\CoreBundle\Entity\Imobiliario\AreaLote $fkImobiliarioAreaLote)
    {
        if (false === $this->fkImobiliarioAreaLotes->contains($fkImobiliarioAreaLote)) {
            $fkImobiliarioAreaLote->setFkImobiliarioLote($this);
            $this->fkImobiliarioAreaLotes->add($fkImobiliarioAreaLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAreaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AreaLote $fkImobiliarioAreaLote
     */
    public function removeFkImobiliarioAreaLotes(\Urbem\CoreBundle\Entity\Imobiliario\AreaLote $fkImobiliarioAreaLote)
    {
        $this->fkImobiliarioAreaLotes->removeElement($fkImobiliarioAreaLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAreaLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AreaLote
     */
    public function getFkImobiliarioAreaLotes()
    {
        return $this->fkImobiliarioAreaLotes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioBaixaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaLote $fkImobiliarioBaixaLote
     * @return Lote
     */
    public function addFkImobiliarioBaixaLotes(\Urbem\CoreBundle\Entity\Imobiliario\BaixaLote $fkImobiliarioBaixaLote)
    {
        if (false === $this->fkImobiliarioBaixaLotes->contains($fkImobiliarioBaixaLote)) {
            $fkImobiliarioBaixaLote->setFkImobiliarioLote($this);
            $this->fkImobiliarioBaixaLotes->add($fkImobiliarioBaixaLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioBaixaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\BaixaLote $fkImobiliarioBaixaLote
     */
    public function removeFkImobiliarioBaixaLotes(\Urbem\CoreBundle\Entity\Imobiliario\BaixaLote $fkImobiliarioBaixaLote)
    {
        $this->fkImobiliarioBaixaLotes->removeElement($fkImobiliarioBaixaLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioBaixaLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\BaixaLote
     */
    public function getFkImobiliarioBaixaLotes()
    {
        return $this->fkImobiliarioBaixaLotes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConfrontacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote $fkImobiliarioConfrontacaoLote
     * @return Lote
     */
    public function addFkImobiliarioConfrontacaoLotes(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote $fkImobiliarioConfrontacaoLote)
    {
        if (false === $this->fkImobiliarioConfrontacaoLotes->contains($fkImobiliarioConfrontacaoLote)) {
            $fkImobiliarioConfrontacaoLote->setFkImobiliarioLote($this);
            $this->fkImobiliarioConfrontacaoLotes->add($fkImobiliarioConfrontacaoLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConfrontacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote $fkImobiliarioConfrontacaoLote
     */
    public function removeFkImobiliarioConfrontacaoLotes(\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote $fkImobiliarioConfrontacaoLote)
    {
        $this->fkImobiliarioConfrontacaoLotes->removeElement($fkImobiliarioConfrontacaoLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConfrontacaoLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoLote
     */
    public function getFkImobiliarioConfrontacaoLotes()
    {
        return $this->fkImobiliarioConfrontacaoLotes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote
     * @return Lote
     */
    public function addFkImobiliarioLicencaLotes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote)
    {
        if (false === $this->fkImobiliarioLicencaLotes->contains($fkImobiliarioLicencaLote)) {
            $fkImobiliarioLicencaLote->setFkImobiliarioLote($this);
            $this->fkImobiliarioLicencaLotes->add($fkImobiliarioLicencaLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote
     */
    public function removeFkImobiliarioLicencaLotes(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote $fkImobiliarioLicencaLote)
    {
        $this->fkImobiliarioLicencaLotes->removeElement($fkImobiliarioLicencaLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLote
     */
    public function getFkImobiliarioLicencaLotes()
    {
        return $this->fkImobiliarioLicencaLotes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteBairro
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteBairro $fkImobiliarioLoteBairro
     * @return Lote
     */
    public function addFkImobiliarioLoteBairros(\Urbem\CoreBundle\Entity\Imobiliario\LoteBairro $fkImobiliarioLoteBairro)
    {
        if (false === $this->fkImobiliarioLoteBairros->contains($fkImobiliarioLoteBairro)) {
            $fkImobiliarioLoteBairro->setFkImobiliarioLote($this);
            $this->fkImobiliarioLoteBairros->add($fkImobiliarioLoteBairro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteBairro
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteBairro $fkImobiliarioLoteBairro
     */
    public function removeFkImobiliarioLoteBairros(\Urbem\CoreBundle\Entity\Imobiliario\LoteBairro $fkImobiliarioLoteBairro)
    {
        $this->fkImobiliarioLoteBairros->removeElement($fkImobiliarioLoteBairro);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteBairros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteBairro
     */
    public function getFkImobiliarioLoteBairros()
    {
        return $this->fkImobiliarioLoteBairros;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio $fkImobiliarioLoteCondominio
     * @return Lote
     */
    public function addFkImobiliarioLoteCondominios(\Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio $fkImobiliarioLoteCondominio)
    {
        if (false === $this->fkImobiliarioLoteCondominios->contains($fkImobiliarioLoteCondominio)) {
            $fkImobiliarioLoteCondominio->setFkImobiliarioLote($this);
            $this->fkImobiliarioLoteCondominios->add($fkImobiliarioLoteCondominio);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteCondominio
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio $fkImobiliarioLoteCondominio
     */
    public function removeFkImobiliarioLoteCondominios(\Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio $fkImobiliarioLoteCondominio)
    {
        $this->fkImobiliarioLoteCondominios->removeElement($fkImobiliarioLoteCondominio);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteCondominios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio
     */
    public function getFkImobiliarioLoteCondominios()
    {
        return $this->fkImobiliarioLoteCondominios;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso $fkImobiliarioLoteProcesso
     * @return Lote
     */
    public function addFkImobiliarioLoteProcessos(\Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso $fkImobiliarioLoteProcesso)
    {
        if (false === $this->fkImobiliarioLoteProcessos->contains($fkImobiliarioLoteProcesso)) {
            $fkImobiliarioLoteProcesso->setFkImobiliarioLote($this);
            $this->fkImobiliarioLoteProcessos->add($fkImobiliarioLoteProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso $fkImobiliarioLoteProcesso
     */
    public function removeFkImobiliarioLoteProcessos(\Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso $fkImobiliarioLoteProcesso)
    {
        $this->fkImobiliarioLoteProcessos->removeElement($fkImobiliarioLoteProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso
     */
    public function getFkImobiliarioLoteProcessos()
    {
        return $this->fkImobiliarioLoteProcessos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioProfundidadeMedia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ProfundidadeMedia $fkImobiliarioProfundidadeMedia
     * @return Lote
     */
    public function addFkImobiliarioProfundidadeMedias(\Urbem\CoreBundle\Entity\Imobiliario\ProfundidadeMedia $fkImobiliarioProfundidadeMedia)
    {
        if (false === $this->fkImobiliarioProfundidadeMedias->contains($fkImobiliarioProfundidadeMedia)) {
            $fkImobiliarioProfundidadeMedia->setFkImobiliarioLote($this);
            $this->fkImobiliarioProfundidadeMedias->add($fkImobiliarioProfundidadeMedia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioProfundidadeMedia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ProfundidadeMedia $fkImobiliarioProfundidadeMedia
     */
    public function removeFkImobiliarioProfundidadeMedias(\Urbem\CoreBundle\Entity\Imobiliario\ProfundidadeMedia $fkImobiliarioProfundidadeMedia)
    {
        $this->fkImobiliarioProfundidadeMedias->removeElement($fkImobiliarioProfundidadeMedia);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioProfundidadeMedias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ProfundidadeMedia
     */
    public function getFkImobiliarioProfundidadeMedias()
    {
        return $this->fkImobiliarioProfundidadeMedias;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioParcelamentoSolo
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo
     * @return Lote
     */
    public function addFkImobiliarioParcelamentoSolos(\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo)
    {
        if (false === $this->fkImobiliarioParcelamentoSolos->contains($fkImobiliarioParcelamentoSolo)) {
            $fkImobiliarioParcelamentoSolo->setFkImobiliarioLote($this);
            $this->fkImobiliarioParcelamentoSolos->add($fkImobiliarioParcelamentoSolo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioParcelamentoSolo
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo
     */
    public function removeFkImobiliarioParcelamentoSolos(\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo)
    {
        $this->fkImobiliarioParcelamentoSolos->removeElement($fkImobiliarioParcelamentoSolo);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioParcelamentoSolos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo
     */
    public function getFkImobiliarioParcelamentoSolos()
    {
        return $this->fkImobiliarioParcelamentoSolos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteamentoLoteOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem $fkImobiliarioLoteamentoLoteOrigem
     * @return Lote
     */
    public function addFkImobiliarioLoteamentoLoteOrigens(\Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem $fkImobiliarioLoteamentoLoteOrigem)
    {
        if (false === $this->fkImobiliarioLoteamentoLoteOrigens->contains($fkImobiliarioLoteamentoLoteOrigem)) {
            $fkImobiliarioLoteamentoLoteOrigem->setFkImobiliarioLote($this);
            $this->fkImobiliarioLoteamentoLoteOrigens->add($fkImobiliarioLoteamentoLoteOrigem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteamentoLoteOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem $fkImobiliarioLoteamentoLoteOrigem
     */
    public function removeFkImobiliarioLoteamentoLoteOrigens(\Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem $fkImobiliarioLoteamentoLoteOrigem)
    {
        $this->fkImobiliarioLoteamentoLoteOrigens->removeElement($fkImobiliarioLoteamentoLoteOrigem);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteamentoLoteOrigens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem
     */
    public function getFkImobiliarioLoteamentoLoteOrigens()
    {
        return $this->fkImobiliarioLoteamentoLoteOrigens;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao
     * @return Lote
     */
    public function addFkImobiliarioConfrontacoes(\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao)
    {
        if (false === $this->fkImobiliarioConfrontacoes->contains($fkImobiliarioConfrontacao)) {
            $fkImobiliarioConfrontacao->setFkImobiliarioLote($this);
            $this->fkImobiliarioConfrontacoes->add($fkImobiliarioConfrontacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao
     */
    public function removeFkImobiliarioConfrontacoes(\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao)
    {
        $this->fkImobiliarioConfrontacoes->removeElement($fkImobiliarioConfrontacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioConfrontacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    public function getFkImobiliarioConfrontacoes()
    {
        return $this->fkImobiliarioConfrontacoes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioImovelLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelLote $fkImobiliarioImovelLote
     * @return Lote
     */
    public function addFkImobiliarioImovelLotes(\Urbem\CoreBundle\Entity\Imobiliario\ImovelLote $fkImobiliarioImovelLote)
    {
        if (false === $this->fkImobiliarioImovelLotes->contains($fkImobiliarioImovelLote)) {
            $fkImobiliarioImovelLote->setFkImobiliarioLote($this);
            $this->fkImobiliarioImovelLotes->add($fkImobiliarioImovelLote);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioImovelLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ImovelLote $fkImobiliarioImovelLote
     */
    public function removeFkImobiliarioImovelLotes(\Urbem\CoreBundle\Entity\Imobiliario\ImovelLote $fkImobiliarioImovelLote)
    {
        $this->fkImobiliarioImovelLotes->removeElement($fkImobiliarioImovelLote);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioImovelLotes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ImovelLote
     */
    public function getFkImobiliarioImovelLotes()
    {
        return $this->fkImobiliarioImovelLotes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteParcelado
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado $fkImobiliarioLoteParcelado
     * @return Lote
     */
    public function addFkImobiliarioLoteParcelados(\Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado $fkImobiliarioLoteParcelado)
    {
        if (false === $this->fkImobiliarioLoteParcelados->contains($fkImobiliarioLoteParcelado)) {
            $fkImobiliarioLoteParcelado->setFkImobiliarioLote($this);
            $this->fkImobiliarioLoteParcelados->add($fkImobiliarioLoteParcelado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteParcelado
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado $fkImobiliarioLoteParcelado
     */
    public function removeFkImobiliarioLoteParcelados(\Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado $fkImobiliarioLoteParcelado)
    {
        $this->fkImobiliarioLoteParcelados->removeElement($fkImobiliarioLoteParcelado);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteParcelados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado
     */
    public function getFkImobiliarioLoteParcelados()
    {
        return $this->fkImobiliarioLoteParcelados;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioLoteUrbano
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteUrbano $fkImobiliarioLoteUrbano
     * @return Lote
     */
    public function setFkImobiliarioLoteUrbano(\Urbem\CoreBundle\Entity\Imobiliario\LoteUrbano $fkImobiliarioLoteUrbano)
    {
        $fkImobiliarioLoteUrbano->setFkImobiliarioLote($this);
        $this->fkImobiliarioLoteUrbano = $fkImobiliarioLoteUrbano;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioLoteUrbano
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LoteUrbano
     */
    public function getFkImobiliarioLoteUrbano()
    {
        return $this->fkImobiliarioLoteUrbano;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioLoteRural
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteRural $fkImobiliarioLoteRural
     * @return Lote
     */
    public function setFkImobiliarioLoteRural(\Urbem\CoreBundle\Entity\Imobiliario\LoteRural $fkImobiliarioLoteRural)
    {
        $fkImobiliarioLoteRural->setFkImobiliarioLote($this);
        $this->fkImobiliarioLoteRural = $fkImobiliarioLoteRural;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioLoteRural
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LoteRural
     */
    public function getFkImobiliarioLoteRural()
    {
        return $this->fkImobiliarioLoteRural;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioLoteLocalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao $fkImobiliarioLoteLocalizacao
     * @return Lote
     */
    public function setFkImobiliarioLoteLocalizacao(\Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao $fkImobiliarioLoteLocalizacao)
    {
        $fkImobiliarioLoteLocalizacao->setFkImobiliarioLote($this);
        $this->fkImobiliarioLoteLocalizacao = $fkImobiliarioLoteLocalizacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioLoteLocalizacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LoteLocalizacao
     */
    public function getFkImobiliarioLoteLocalizacao()
    {
        return $this->fkImobiliarioLoteLocalizacao;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioLoteLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento $fkImobiliarioLoteLoteamento
     * @return Lote
     */
    public function setFkImobiliarioLoteLoteamento(\Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento $fkImobiliarioLoteLoteamento)
    {
        $fkImobiliarioLoteLoteamento->setFkImobiliarioLote($this);
        $this->fkImobiliarioLoteLoteamento = $fkImobiliarioLoteLoteamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioLoteLoteamento
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento
     */
    public function getFkImobiliarioLoteLoteamento()
    {
        return $this->fkImobiliarioLoteLoteamento;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return ($this->fkImobiliarioLoteLocalizacao)
            ? str_pad($this->fkImobiliarioLoteLocalizacao->getValor(), 5, '0', STR_PAD_LEFT)
            : (string) $this->codLote;
    }
}
