<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * CadastroEconomicoEmpresaDireito
 */
class CadastroEconomicoEmpresaDireito
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codCategoria;

    /**
     * @var string
     */
    private $numRegistroJunta;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor
     */
    private $fkEconomicoAtributoEmpresaDireitoValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\Sociedade
     */
    private $fkEconomicoSociedades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica
     */
    private $fkEconomicoEmpresaDireitoNaturezaJuridicas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    private $fkSwCgmPessoaJuridica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Categoria
     */
    private $fkEconomicoCategoria;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtributoEmpresaDireitoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoSociedades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoEmpresaDireitoNaturezaJuridicas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return CadastroEconomicoEmpresaDireito
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return CadastroEconomicoEmpresaDireito
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
     * Set codCategoria
     *
     * @param integer $codCategoria
     * @return CadastroEconomicoEmpresaDireito
     */
    public function setCodCategoria($codCategoria)
    {
        $this->codCategoria = $codCategoria;
        return $this;
    }

    /**
     * Get codCategoria
     *
     * @return integer
     */
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }

    /**
     * Set numRegistroJunta
     *
     * @param string $numRegistroJunta
     * @return CadastroEconomicoEmpresaDireito
     */
    public function setNumRegistroJunta($numRegistroJunta = null)
    {
        $this->numRegistroJunta = $numRegistroJunta;
        return $this;
    }

    /**
     * Get numRegistroJunta
     *
     * @return string
     */
    public function getNumRegistroJunta()
    {
        return $this->numRegistroJunta;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtributoEmpresaDireitoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor $fkEconomicoAtributoEmpresaDireitoValor
     * @return CadastroEconomicoEmpresaDireito
     */
    public function addFkEconomicoAtributoEmpresaDireitoValores(\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor $fkEconomicoAtributoEmpresaDireitoValor)
    {
        if (false === $this->fkEconomicoAtributoEmpresaDireitoValores->contains($fkEconomicoAtributoEmpresaDireitoValor)) {
            $fkEconomicoAtributoEmpresaDireitoValor->setFkEconomicoCadastroEconomicoEmpresaDireito($this);
            $this->fkEconomicoAtributoEmpresaDireitoValores->add($fkEconomicoAtributoEmpresaDireitoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtributoEmpresaDireitoValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor $fkEconomicoAtributoEmpresaDireitoValor
     */
    public function removeFkEconomicoAtributoEmpresaDireitoValores(\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor $fkEconomicoAtributoEmpresaDireitoValor)
    {
        $this->fkEconomicoAtributoEmpresaDireitoValores->removeElement($fkEconomicoAtributoEmpresaDireitoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtributoEmpresaDireitoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtributoEmpresaDireitoValor
     */
    public function getFkEconomicoAtributoEmpresaDireitoValores()
    {
        return $this->fkEconomicoAtributoEmpresaDireitoValores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoSociedade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade
     * @return CadastroEconomicoEmpresaDireito
     */
    public function addFkEconomicoSociedades(\Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade)
    {
        if (false === $this->fkEconomicoSociedades->contains($fkEconomicoSociedade)) {
            $fkEconomicoSociedade->setFkEconomicoCadastroEconomicoEmpresaDireito($this);
            $this->fkEconomicoSociedades->add($fkEconomicoSociedade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoSociedade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade
     */
    public function removeFkEconomicoSociedades(\Urbem\CoreBundle\Entity\Economico\Sociedade $fkEconomicoSociedade)
    {
        $this->fkEconomicoSociedades->removeElement($fkEconomicoSociedade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoSociedades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\Sociedade
     */
    public function getFkEconomicoSociedades()
    {
        return $this->fkEconomicoSociedades;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoEmpresaDireitoNaturezaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica
     * @return CadastroEconomicoEmpresaDireito
     */
    public function addFkEconomicoEmpresaDireitoNaturezaJuridicas(\Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica)
    {
        if (false === $this->fkEconomicoEmpresaDireitoNaturezaJuridicas->contains($fkEconomicoEmpresaDireitoNaturezaJuridica)) {
            $fkEconomicoEmpresaDireitoNaturezaJuridica->setFkEconomicoCadastroEconomicoEmpresaDireito($this);
            $this->fkEconomicoEmpresaDireitoNaturezaJuridicas->add($fkEconomicoEmpresaDireitoNaturezaJuridica);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoEmpresaDireitoNaturezaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica
     */
    public function removeFkEconomicoEmpresaDireitoNaturezaJuridicas(\Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica $fkEconomicoEmpresaDireitoNaturezaJuridica)
    {
        $this->fkEconomicoEmpresaDireitoNaturezaJuridicas->removeElement($fkEconomicoEmpresaDireitoNaturezaJuridica);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoEmpresaDireitoNaturezaJuridicas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica
     */
    public function getFkEconomicoEmpresaDireitoNaturezaJuridicas()
    {
        return $this->fkEconomicoEmpresaDireitoNaturezaJuridicas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaJuridica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica
     * @return CadastroEconomicoEmpresaDireito
     */
    public function setFkSwCgmPessoaJuridica(\Urbem\CoreBundle\Entity\SwCgmPessoaJuridica $fkSwCgmPessoaJuridica)
    {
        $this->numcgm = $fkSwCgmPessoaJuridica->getNumcgm();
        $this->fkSwCgmPessoaJuridica = $fkSwCgmPessoaJuridica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaJuridica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaJuridica
     */
    public function getFkSwCgmPessoaJuridica()
    {
        return $this->fkSwCgmPessoaJuridica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCategoria
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Categoria $fkEconomicoCategoria
     * @return CadastroEconomicoEmpresaDireito
     */
    public function setFkEconomicoCategoria(\Urbem\CoreBundle\Entity\Economico\Categoria $fkEconomicoCategoria)
    {
        $this->codCategoria = $fkEconomicoCategoria->getCodCategoria();
        $this->fkEconomicoCategoria = $fkEconomicoCategoria;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCategoria
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Categoria
     */
    public function getFkEconomicoCategoria()
    {
        return $this->fkEconomicoCategoria;
    }

    /**
     * OneToOne (owning side)
     * Set EconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return CadastroEconomicoEmpresaDireito
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }
}
