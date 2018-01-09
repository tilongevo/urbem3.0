<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ModeloCarne
 */
class ModeloCarne
{
    /**
     * PK
     * @var integer
     */
    private $codModelo;

    /**
     * @var string
     */
    private $nomModelo;

    /**
     * @var string
     */
    private $nomArquivo;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var boolean
     */
    private $capaPrimeiraFolha;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoDebitoLayoutCarne
     */
    private $fkArrecadacaoObservacaoDebitoLayoutCarne;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne
     */
    private $fkArrecadacaoAcaoModeloCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne
     */
    private $fkArrecadacaoInformacaoAdicionalLayoutCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoLayoutCarne
     */
    private $fkArrecadacaoObservacaoLayoutCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne
     */
    private $fkArrecadacaoVariaveisLayoutCarnes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoAcaoModeloCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoObservacaoLayoutCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoVariaveisLayoutCarnes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModelo
     *
     * @param integer $codModelo
     * @return ModeloCarne
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set nomModelo
     *
     * @param string $nomModelo
     * @return ModeloCarne
     */
    public function setNomModelo($nomModelo)
    {
        $this->nomModelo = $nomModelo;
        return $this;
    }

    /**
     * Get nomModelo
     *
     * @return string
     */
    public function getNomModelo()
    {
        return $this->nomModelo;
    }

    /**
     * Set nomArquivo
     *
     * @param string $nomArquivo
     * @return ModeloCarne
     */
    public function setNomArquivo($nomArquivo)
    {
        $this->nomArquivo = $nomArquivo;
        return $this;
    }

    /**
     * Get nomArquivo
     *
     * @return string
     */
    public function getNomArquivo()
    {
        return $this->nomArquivo;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ModeloCarne
     */
    public function setCodModulo($codModulo = null)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set capaPrimeiraFolha
     *
     * @param boolean $capaPrimeiraFolha
     * @return ModeloCarne
     */
    public function setCapaPrimeiraFolha($capaPrimeiraFolha)
    {
        $this->capaPrimeiraFolha = $capaPrimeiraFolha;
        return $this;
    }

    /**
     * Get capaPrimeiraFolha
     *
     * @return boolean
     */
    public function getCapaPrimeiraFolha()
    {
        return $this->capaPrimeiraFolha;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAcaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne $fkArrecadacaoAcaoModeloCarne
     * @return ModeloCarne
     */
    public function addFkArrecadacaoAcaoModeloCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne $fkArrecadacaoAcaoModeloCarne)
    {
        if (false === $this->fkArrecadacaoAcaoModeloCarnes->contains($fkArrecadacaoAcaoModeloCarne)) {
            $fkArrecadacaoAcaoModeloCarne->setFkArrecadacaoModeloCarne($this);
            $this->fkArrecadacaoAcaoModeloCarnes->add($fkArrecadacaoAcaoModeloCarne);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAcaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne $fkArrecadacaoAcaoModeloCarne
     */
    public function removeFkArrecadacaoAcaoModeloCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne $fkArrecadacaoAcaoModeloCarne)
    {
        $this->fkArrecadacaoAcaoModeloCarnes->removeElement($fkArrecadacaoAcaoModeloCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAcaoModeloCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne
     */
    public function getFkArrecadacaoAcaoModeloCarnes()
    {
        return $this->fkArrecadacaoAcaoModeloCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoInformacaoAdicionalLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne $fkArrecadacaoInformacaoAdicionalLayoutCarne
     * @return ModeloCarne
     */
    public function addFkArrecadacaoInformacaoAdicionalLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne $fkArrecadacaoInformacaoAdicionalLayoutCarne)
    {
        if (false === $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes->contains($fkArrecadacaoInformacaoAdicionalLayoutCarne)) {
            $fkArrecadacaoInformacaoAdicionalLayoutCarne->setFkArrecadacaoModeloCarne($this);
            $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes->add($fkArrecadacaoInformacaoAdicionalLayoutCarne);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoInformacaoAdicionalLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne $fkArrecadacaoInformacaoAdicionalLayoutCarne
     */
    public function removeFkArrecadacaoInformacaoAdicionalLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne $fkArrecadacaoInformacaoAdicionalLayoutCarne)
    {
        $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes->removeElement($fkArrecadacaoInformacaoAdicionalLayoutCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoInformacaoAdicionalLayoutCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicionalLayoutCarne
     */
    public function getFkArrecadacaoInformacaoAdicionalLayoutCarnes()
    {
        return $this->fkArrecadacaoInformacaoAdicionalLayoutCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoObservacaoLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoLayoutCarne $fkArrecadacaoObservacaoLayoutCarne
     * @return ModeloCarne
     */
    public function addFkArrecadacaoObservacaoLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoLayoutCarne $fkArrecadacaoObservacaoLayoutCarne)
    {
        if (false === $this->fkArrecadacaoObservacaoLayoutCarnes->contains($fkArrecadacaoObservacaoLayoutCarne)) {
            $fkArrecadacaoObservacaoLayoutCarne->setFkArrecadacaoModeloCarne($this);
            $this->fkArrecadacaoObservacaoLayoutCarnes->add($fkArrecadacaoObservacaoLayoutCarne);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoObservacaoLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoLayoutCarne $fkArrecadacaoObservacaoLayoutCarne
     */
    public function removeFkArrecadacaoObservacaoLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoLayoutCarne $fkArrecadacaoObservacaoLayoutCarne)
    {
        $this->fkArrecadacaoObservacaoLayoutCarnes->removeElement($fkArrecadacaoObservacaoLayoutCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoObservacaoLayoutCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoLayoutCarne
     */
    public function getFkArrecadacaoObservacaoLayoutCarnes()
    {
        return $this->fkArrecadacaoObservacaoLayoutCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoVariaveisLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne $fkArrecadacaoVariaveisLayoutCarne
     * @return ModeloCarne
     */
    public function addFkArrecadacaoVariaveisLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne $fkArrecadacaoVariaveisLayoutCarne)
    {
        if (false === $this->fkArrecadacaoVariaveisLayoutCarnes->contains($fkArrecadacaoVariaveisLayoutCarne)) {
            $fkArrecadacaoVariaveisLayoutCarne->setFkArrecadacaoModeloCarne($this);
            $this->fkArrecadacaoVariaveisLayoutCarnes->add($fkArrecadacaoVariaveisLayoutCarne);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoVariaveisLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne $fkArrecadacaoVariaveisLayoutCarne
     */
    public function removeFkArrecadacaoVariaveisLayoutCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne $fkArrecadacaoVariaveisLayoutCarne)
    {
        $this->fkArrecadacaoVariaveisLayoutCarnes->removeElement($fkArrecadacaoVariaveisLayoutCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoVariaveisLayoutCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\VariaveisLayoutCarne
     */
    public function getFkArrecadacaoVariaveisLayoutCarnes()
    {
        return $this->fkArrecadacaoVariaveisLayoutCarnes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return ModeloCarne
     */
    public function setFkAdministracaoModulo(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->codModulo = $fkAdministracaoModulo->getCodModulo();
        $this->fkAdministracaoModulo = $fkAdministracaoModulo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModulo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulo()
    {
        return $this->fkAdministracaoModulo;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoObservacaoDebitoLayoutCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoDebitoLayoutCarne $fkArrecadacaoObservacaoDebitoLayoutCarne
     * @return ModeloCarne
     */
    public function setFkArrecadacaoObservacaoDebitoLayoutCarne(\Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoDebitoLayoutCarne $fkArrecadacaoObservacaoDebitoLayoutCarne)
    {
        $fkArrecadacaoObservacaoDebitoLayoutCarne->setFkArrecadacaoModeloCarne($this);
        $this->fkArrecadacaoObservacaoDebitoLayoutCarne = $fkArrecadacaoObservacaoDebitoLayoutCarne;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoObservacaoDebitoLayoutCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ObservacaoDebitoLayoutCarne
     */
    public function getFkArrecadacaoObservacaoDebitoLayoutCarne()
    {
        return $this->fkArrecadacaoObservacaoDebitoLayoutCarne;
    }
}
