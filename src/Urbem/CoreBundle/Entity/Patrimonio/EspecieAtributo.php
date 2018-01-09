<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * EspecieAtributo
 */
class EspecieAtributo
{
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
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie
     */
    private $fkPatrimonioBemAtributoEspecies;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Especie
     */
    private $fkPatrimonioEspecie;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioBemAtributoEspecies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return EspecieAtributo
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
     * @return EspecieAtributo
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
     * @return EspecieAtributo
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
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return EspecieAtributo
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return EspecieAtributo
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return EspecieAtributo
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return EspecieAtributo
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
     * Add PatrimonioBemAtributoEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie $fkPatrimonioBemAtributoEspecie
     * @return EspecieAtributo
     */
    public function addFkPatrimonioBemAtributoEspecies(\Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie $fkPatrimonioBemAtributoEspecie)
    {
        if (false === $this->fkPatrimonioBemAtributoEspecies->contains($fkPatrimonioBemAtributoEspecie)) {
            $fkPatrimonioBemAtributoEspecie->setFkPatrimonioEspecieAtributo($this);
            $this->fkPatrimonioBemAtributoEspecies->add($fkPatrimonioBemAtributoEspecie);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemAtributoEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie $fkPatrimonioBemAtributoEspecie
     */
    public function removeFkPatrimonioBemAtributoEspecies(\Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie $fkPatrimonioBemAtributoEspecie)
    {
        $this->fkPatrimonioBemAtributoEspecies->removeElement($fkPatrimonioBemAtributoEspecie);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemAtributoEspecies
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemAtributoEspecie
     */
    public function getFkPatrimonioBemAtributoEspecies()
    {
        return $this->fkPatrimonioBemAtributoEspecies;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return EspecieAtributo
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

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioEspecie
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie
     * @return EspecieAtributo
     */
    public function setFkPatrimonioEspecie(\Urbem\CoreBundle\Entity\Patrimonio\Especie $fkPatrimonioEspecie)
    {
        $this->codEspecie = $fkPatrimonioEspecie->getCodEspecie();
        $this->codGrupo = $fkPatrimonioEspecie->getCodGrupo();
        $this->codNatureza = $fkPatrimonioEspecie->getCodNatureza();
        $this->fkPatrimonioEspecie = $fkPatrimonioEspecie;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioEspecie
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Especie
     */
    public function getFkPatrimonioEspecie()
    {
        return $this->fkPatrimonioEspecie;
    }
}
