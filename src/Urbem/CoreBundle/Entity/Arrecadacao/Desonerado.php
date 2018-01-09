<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Desonerado
 */
class Desonerado
{
    /**
     * PK
     * @var integer
     */
    private $codDesoneracao;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $ocorrencia;

    /**
     * @var \DateTime
     */
    private $dataConcessao;

    /**
     * @var \DateTime
     */
    private $dataProrrogacao;

    /**
     * @var \DateTime
     */
    private $dataRevogacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor
     */
    private $fkArrecadacaoAtributoDesoneracaoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel
     */
    private $fkArrecadacaoDesoneradoImoveis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao
     */
    private $fkArrecadacaoLancamentoUsaDesoneracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico
     */
    private $fkArrecadacaoDesoneradoCadEconomicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao
     */
    private $fkArrecadacaoLancamentoConcedeDesoneracoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    private $fkArrecadacaoDesoneracao;

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
        $this->fkArrecadacaoAtributoDesoneracaoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDesoneradoImoveis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLancamentoUsaDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoDesoneradoCadEconomicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoLancamentoConcedeDesoneracoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDesoneracao
     *
     * @param integer $codDesoneracao
     * @return Desonerado
     */
    public function setCodDesoneracao($codDesoneracao)
    {
        $this->codDesoneracao = $codDesoneracao;
        return $this;
    }

    /**
     * Get codDesoneracao
     *
     * @return integer
     */
    public function getCodDesoneracao()
    {
        return $this->codDesoneracao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Desonerado
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
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return Desonerado
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
        return $this;
    }

    /**
     * Get ocorrencia
     *
     * @return integer
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * Set dataConcessao
     *
     * @param \DateTime $dataConcessao
     * @return Desonerado
     */
    public function setDataConcessao(\DateTime $dataConcessao)
    {
        $this->dataConcessao = $dataConcessao;
        return $this;
    }

    /**
     * Get dataConcessao
     *
     * @return \DateTime
     */
    public function getDataConcessao()
    {
        return $this->dataConcessao;
    }

    /**
     * Set dataProrrogacao
     *
     * @param \DateTime $dataProrrogacao
     * @return Desonerado
     */
    public function setDataProrrogacao(\DateTime $dataProrrogacao = null)
    {
        $this->dataProrrogacao = $dataProrrogacao;
        return $this;
    }

    /**
     * Get dataProrrogacao
     *
     * @return \DateTime
     */
    public function getDataProrrogacao()
    {
        return $this->dataProrrogacao;
    }

    /**
     * Set dataRevogacao
     *
     * @param \DateTime $dataRevogacao
     * @return Desonerado
     */
    public function setDataRevogacao(\DateTime $dataRevogacao = null)
    {
        $this->dataRevogacao = $dataRevogacao;
        return $this;
    }

    /**
     * Get dataRevogacao
     *
     * @return \DateTime
     */
    public function getDataRevogacao()
    {
        return $this->dataRevogacao;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoDesoneracaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor $fkArrecadacaoAtributoDesoneracaoValor
     * @return Desonerado
     */
    public function addFkArrecadacaoAtributoDesoneracaoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor $fkArrecadacaoAtributoDesoneracaoValor)
    {
        if (false === $this->fkArrecadacaoAtributoDesoneracaoValores->contains($fkArrecadacaoAtributoDesoneracaoValor)) {
            $fkArrecadacaoAtributoDesoneracaoValor->setFkArrecadacaoDesonerado($this);
            $this->fkArrecadacaoAtributoDesoneracaoValores->add($fkArrecadacaoAtributoDesoneracaoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoDesoneracaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor $fkArrecadacaoAtributoDesoneracaoValor
     */
    public function removeFkArrecadacaoAtributoDesoneracaoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor $fkArrecadacaoAtributoDesoneracaoValor)
    {
        $this->fkArrecadacaoAtributoDesoneracaoValores->removeElement($fkArrecadacaoAtributoDesoneracaoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoDesoneracaoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor
     */
    public function getFkArrecadacaoAtributoDesoneracaoValores()
    {
        return $this->fkArrecadacaoAtributoDesoneracaoValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDesoneradoImovel
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel $fkArrecadacaoDesoneradoImovel
     * @return Desonerado
     */
    public function addFkArrecadacaoDesoneradoImoveis(\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel $fkArrecadacaoDesoneradoImovel)
    {
        if (false === $this->fkArrecadacaoDesoneradoImoveis->contains($fkArrecadacaoDesoneradoImovel)) {
            $fkArrecadacaoDesoneradoImovel->setFkArrecadacaoDesonerado($this);
            $this->fkArrecadacaoDesoneradoImoveis->add($fkArrecadacaoDesoneradoImovel);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesoneradoImovel
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel $fkArrecadacaoDesoneradoImovel
     */
    public function removeFkArrecadacaoDesoneradoImoveis(\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel $fkArrecadacaoDesoneradoImovel)
    {
        $this->fkArrecadacaoDesoneradoImoveis->removeElement($fkArrecadacaoDesoneradoImovel);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesoneradoImoveis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoImovel
     */
    public function getFkArrecadacaoDesoneradoImoveis()
    {
        return $this->fkArrecadacaoDesoneradoImoveis;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLancamentoUsaDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao $fkArrecadacaoLancamentoUsaDesoneracao
     * @return Desonerado
     */
    public function addFkArrecadacaoLancamentoUsaDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao $fkArrecadacaoLancamentoUsaDesoneracao)
    {
        if (false === $this->fkArrecadacaoLancamentoUsaDesoneracoes->contains($fkArrecadacaoLancamentoUsaDesoneracao)) {
            $fkArrecadacaoLancamentoUsaDesoneracao->setFkArrecadacaoDesonerado($this);
            $this->fkArrecadacaoLancamentoUsaDesoneracoes->add($fkArrecadacaoLancamentoUsaDesoneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLancamentoUsaDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao $fkArrecadacaoLancamentoUsaDesoneracao
     */
    public function removeFkArrecadacaoLancamentoUsaDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao $fkArrecadacaoLancamentoUsaDesoneracao)
    {
        $this->fkArrecadacaoLancamentoUsaDesoneracoes->removeElement($fkArrecadacaoLancamentoUsaDesoneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLancamentoUsaDesoneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoUsaDesoneracao
     */
    public function getFkArrecadacaoLancamentoUsaDesoneracoes()
    {
        return $this->fkArrecadacaoLancamentoUsaDesoneracoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDesoneradoCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico $fkArrecadacaoDesoneradoCadEconomico
     * @return Desonerado
     */
    public function addFkArrecadacaoDesoneradoCadEconomicos(\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico $fkArrecadacaoDesoneradoCadEconomico)
    {
        if (false === $this->fkArrecadacaoDesoneradoCadEconomicos->contains($fkArrecadacaoDesoneradoCadEconomico)) {
            $fkArrecadacaoDesoneradoCadEconomico->setFkArrecadacaoDesonerado($this);
            $this->fkArrecadacaoDesoneradoCadEconomicos->add($fkArrecadacaoDesoneradoCadEconomico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesoneradoCadEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico $fkArrecadacaoDesoneradoCadEconomico
     */
    public function removeFkArrecadacaoDesoneradoCadEconomicos(\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico $fkArrecadacaoDesoneradoCadEconomico)
    {
        $this->fkArrecadacaoDesoneradoCadEconomicos->removeElement($fkArrecadacaoDesoneradoCadEconomico);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDesoneradoCadEconomicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\DesoneradoCadEconomico
     */
    public function getFkArrecadacaoDesoneradoCadEconomicos()
    {
        return $this->fkArrecadacaoDesoneradoCadEconomicos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoLancamentoConcedeDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao $fkArrecadacaoLancamentoConcedeDesoneracao
     * @return Desonerado
     */
    public function addFkArrecadacaoLancamentoConcedeDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao $fkArrecadacaoLancamentoConcedeDesoneracao)
    {
        if (false === $this->fkArrecadacaoLancamentoConcedeDesoneracoes->contains($fkArrecadacaoLancamentoConcedeDesoneracao)) {
            $fkArrecadacaoLancamentoConcedeDesoneracao->setFkArrecadacaoDesonerado($this);
            $this->fkArrecadacaoLancamentoConcedeDesoneracoes->add($fkArrecadacaoLancamentoConcedeDesoneracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoLancamentoConcedeDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao $fkArrecadacaoLancamentoConcedeDesoneracao
     */
    public function removeFkArrecadacaoLancamentoConcedeDesoneracoes(\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao $fkArrecadacaoLancamentoConcedeDesoneracao)
    {
        $this->fkArrecadacaoLancamentoConcedeDesoneracoes->removeElement($fkArrecadacaoLancamentoConcedeDesoneracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoLancamentoConcedeDesoneracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\LancamentoConcedeDesoneracao
     */
    public function getFkArrecadacaoLancamentoConcedeDesoneracoes()
    {
        return $this->fkArrecadacaoLancamentoConcedeDesoneracoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     * @return Desonerado
     */
    public function setFkArrecadacaoDesoneracao(\Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao)
    {
        $this->codDesoneracao = $fkArrecadacaoDesoneracao->getCodDesoneracao();
        $this->fkArrecadacaoDesoneracao = $fkArrecadacaoDesoneracao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoDesoneracao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    public function getFkArrecadacaoDesoneracao()
    {
        return $this->fkArrecadacaoDesoneracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Desonerado
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
}
