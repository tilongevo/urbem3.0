<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Cadastro
 */
class Cadastro
{
    const CADASTRO_PATRIMONIAL_ALMOXARIFADO_ATRIBUTO_CATALOGO_CLASSIFICACAO_ITEM_VALOR = 1;
    const CADASTRO_PATRIMONIAL_ALMOXARIFADO_ATRIBUTO_ESTOQUE_MATERIAL_VALOR = 2;
    const CADASTRO_TRIBUTARIO_HIERARQUIA = 1;
    const CADASTRO_TRIBUTARIO_LOTE_URBANO = 2;
    const CADASTRO_TRIBUTARIO_LOTE_RURAL = 3;
    const CADASTRO_TRIBUTARIO_IMOVEL = 4;
    const CADASTRO_TRIBUTARIO_TIPO_EDIFICACAO = 5;
    const CADASTRO_TRIBUTARIO_CONDOMINIO = 6;
    const CADASTRO_TRIBUTARIO_TRECHO = 7;
    const CADASTRO_TRIBUTARIO_FACE_QUADRA = 8;
    const CADASTRO_ARRECADACAO_DESONERACAO = 3;
    const CADASTRO_TIPO_LICENCA_DIVERSA = 4;
    const CADASTRO_TRIBUTARIO_CONSTRUCAO = 9;
    const CADASTRO_TRIBUTARIO_LICENCAS = 10;

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
     * @var string
     */
    private $nomCadastro;

    /**
     * @var string
     */
    private $mapeamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma
     */
    private $fkNormasAtributoTipoNormas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    private $fkNormasTipoNormas;

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
        $this->fkAdministracaoAtributoDinamicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkNormasAtributoTipoNormas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkNormasTipoNormas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Cadastro
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
     * @return Cadastro
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
     * Set nomCadastro
     *
     * @param string $nomCadastro
     * @return Cadastro
     */
    public function setNomCadastro($nomCadastro = null)
    {
        $this->nomCadastro = $nomCadastro;
        return $this;
    }

    /**
     * Get nomCadastro
     *
     * @return string
     */
    public function getNomCadastro()
    {
        return $this->nomCadastro;
    }

    /**
     * Set mapeamento
     *
     * @param string $mapeamento
     * @return Cadastro
     */
    public function setMapeamento($mapeamento = null)
    {
        $this->mapeamento = $mapeamento;
        return $this;
    }

    /**
     * Get mapeamento
     *
     * @return string
     */
    public function getMapeamento()
    {
        return $this->mapeamento;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return Cadastro
     */
    public function addFkAdministracaoAtributoDinamicos(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        if (false === $this->fkAdministracaoAtributoDinamicos->contains($fkAdministracaoAtributoDinamico)) {
            $fkAdministracaoAtributoDinamico->setFkAdministracaoCadastro($this);
            $this->fkAdministracaoAtributoDinamicos->add($fkAdministracaoAtributoDinamico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     */
    public function removeFkAdministracaoAtributoDinamicos(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->fkAdministracaoAtributoDinamicos->removeElement($fkAdministracaoAtributoDinamico);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAtributoDinamicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamicos()
    {
        return $this->fkAdministracaoAtributoDinamicos;
    }

    /**
     * OneToMany (owning side)
     * Add NormasAtributoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma
     * @return Cadastro
     */
    public function addFkNormasAtributoTipoNormas(\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma)
    {
        if (false === $this->fkNormasAtributoTipoNormas->contains($fkNormasAtributoTipoNorma)) {
            $fkNormasAtributoTipoNorma->setFkAdministracaoCadastro($this);
            $this->fkNormasAtributoTipoNormas->add($fkNormasAtributoTipoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasAtributoTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma
     */
    public function removeFkNormasAtributoTipoNormas(\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma $fkNormasAtributoTipoNorma)
    {
        $this->fkNormasAtributoTipoNormas->removeElement($fkNormasAtributoTipoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasAtributoTipoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma
     */
    public function getFkNormasAtributoTipoNormas()
    {
        return $this->fkNormasAtributoTipoNormas;
    }

    /**
     * OneToMany (owning side)
     * Add NormasTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma
     * @return Cadastro
     */
    public function addFkNormasTipoNormas(\Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma)
    {
        if (false === $this->fkNormasTipoNormas->contains($fkNormasTipoNorma)) {
            $fkNormasTipoNorma->setFkAdministracaoCadastro($this);
            $this->fkNormasTipoNormas->add($fkNormasTipoNorma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasTipoNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma
     */
    public function removeFkNormasTipoNormas(\Urbem\CoreBundle\Entity\Normas\TipoNorma $fkNormasTipoNorma)
    {
        $this->fkNormasTipoNormas->removeElement($fkNormasTipoNorma);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasTipoNormas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\TipoNorma
     */
    public function getFkNormasTipoNormas()
    {
        return $this->fkNormasTipoNormas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return Cadastro
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
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s', $this->getCodCadastro(), $this->getNomCadastro());
    }
}
