<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * AtributoDesoneracao
 */
class AtributoDesoneracao
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
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor
     */
    private $fkArrecadacaoAtributoDesoneracaoValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao
     */
    private $fkArrecadacaoDesoneracao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoAtributoDesoneracaoValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDesoneracao
     *
     * @param integer $codDesoneracao
     * @return AtributoDesoneracao
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoDesoneracao
     */
    public function setCodModulo($codModulo)
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoDesoneracao
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return AtributoDesoneracao
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return AtributoDesoneracao
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoDesoneracaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor $fkArrecadacaoAtributoDesoneracaoValor
     * @return AtributoDesoneracao
     */
    public function addFkArrecadacaoAtributoDesoneracaoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracaoValor $fkArrecadacaoAtributoDesoneracaoValor)
    {
        if (false === $this->fkArrecadacaoAtributoDesoneracaoValores->contains($fkArrecadacaoAtributoDesoneracaoValor)) {
            $fkArrecadacaoAtributoDesoneracaoValor->setFkArrecadacaoAtributoDesoneracao($this);
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDesoneracao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao $fkArrecadacaoDesoneracao
     * @return AtributoDesoneracao
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
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoDesoneracao
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModulo = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastro = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributo = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }
}
