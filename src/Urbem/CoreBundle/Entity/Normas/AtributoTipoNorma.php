<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * AtributoTipoNorma
 */
class AtributoTipoNorma
{
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
    private $codTipoNorma;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoNormaValor
     */
    private $fkNormasAtributoNormaValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Cadastro
     */
    private $fkAdministracaoCadastro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    private $fkNormasTipoNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkNormasAtributoNormaValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoTipoNorma
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
     * @return AtributoTipoNorma
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
     * Set codTipoNorma
     *
     * @param integer $codTipoNorma
     * @return AtributoTipoNorma
     */
    public function setCodTipoNorma($codTipoNorma)
    {
        $this->codTipoNorma = $codTipoNorma;
        return $this;
    }

    /**
     * Get codTipoNorma
     *
     * @return integer
     */
    public function getCodTipoNorma()
    {
        return $this->codTipoNorma;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoTipoNorma
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
     * Set ativo
     *
     * @param boolean $ativo
     * @return AtributoTipoNorma
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
     * Add NormasAtributoNormaValor
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoNormaValor $fkNormasAtributoNormaValor
     * @return AtributoTipoNorma
     */
    public function addFkNormasAtributoNormaValores(\Urbem\CoreBundle\Entity\Normas\AtributoNormaValor $fkNormasAtributoNormaValor)
    {
        if (false === $this->fkNormasAtributoNormaValores->contains($fkNormasAtributoNormaValor)) {
            $fkNormasAtributoNormaValor->setFkNormasAtributoTipoNorma($this);
            $this->fkNormasAtributoNormaValores->add($fkNormasAtributoNormaValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasAtributoNormaValor
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoNormaValor $fkNormasAtributoNormaValor
     */
    public function removeFkNormasAtributoNormaValores(\Urbem\CoreBundle\Entity\Normas\AtributoNormaValor $fkNormasAtributoNormaValor)
    {
        $this->fkNormasAtributoNormaValores->removeElement($fkNormasAtributoNormaValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasAtributoNormaValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoNormaValor
     */
    public function getFkNormasAtributoNormaValores()
    {
        return $this->fkNormasAtributoNormaValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoCadastro
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro
     * @return AtributoTipoNorma
     */
    public function setFkAdministracaoCadastro(\Urbem\CoreBundle\Entity\Administracao\Cadastro $fkAdministracaoCadastro)
    {
        $this->codModulo = $fkAdministracaoCadastro->getCodModulo();
        $this->codCadastro = $fkAdministracaoCadastro->getCodCadastro();
        $this->fkAdministracaoCadastro = $fkAdministracaoCadastro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoCadastro
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Cadastro
     */
    public function getFkAdministracaoCadastro()
    {
        return $this->fkAdministracaoCadastro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoTipoNorma
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
     * Set fkNormasTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma
     * @return AtributoTipoNorma
     */
    public function setFkNormasTipoNorma(\Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma)
    {
        $this->codTipoNorma = $fkNormasTipoNorma->getCodTipoNorma();
        $this->fkNormasTipoNorma = $fkNormasTipoNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasTipoNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    public function getFkNormasTipoNorma()
    {
        return $this->fkNormasTipoNorma;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFkAdministracaoAtributoDinamico();
    }
}
