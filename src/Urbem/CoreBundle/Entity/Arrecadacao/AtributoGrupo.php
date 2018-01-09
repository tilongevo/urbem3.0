<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * AtributoGrupo
 */
class AtributoGrupo
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
    private $codGrupo;

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
     * @var string
     */
    private $anoExercicio;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor
     */
    private $fkArrecadacaoAtributoGrupoValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    private $fkArrecadacaoGrupoCredito;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoAtributoGrupoValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AtributoGrupo
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
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return AtributoGrupo
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return AtributoGrupo
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
     * @return AtributoGrupo
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
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return AtributoGrupo
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return AtributoGrupo
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
     * Add ArrecadacaoAtributoGrupoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor $fkArrecadacaoAtributoGrupoValor
     * @return AtributoGrupo
     */
    public function addFkArrecadacaoAtributoGrupoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor $fkArrecadacaoAtributoGrupoValor)
    {
        if (false === $this->fkArrecadacaoAtributoGrupoValores->contains($fkArrecadacaoAtributoGrupoValor)) {
            $fkArrecadacaoAtributoGrupoValor->setFkArrecadacaoAtributoGrupo($this);
            $this->fkArrecadacaoAtributoGrupoValores->add($fkArrecadacaoAtributoGrupoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoGrupoValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor $fkArrecadacaoAtributoGrupoValor
     */
    public function removeFkArrecadacaoAtributoGrupoValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor $fkArrecadacaoAtributoGrupoValor)
    {
        $this->fkArrecadacaoAtributoGrupoValores->removeElement($fkArrecadacaoAtributoGrupoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoGrupoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupoValor
     */
    public function getFkArrecadacaoAtributoGrupoValores()
    {
        return $this->fkArrecadacaoAtributoGrupoValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return AtributoGrupo
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
     * Set fkArrecadacaoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito
     * @return AtributoGrupo
     */
    public function setFkArrecadacaoGrupoCredito(\Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito)
    {
        $this->codGrupo = $fkArrecadacaoGrupoCredito->getCodGrupo();
        $this->anoExercicio = $fkArrecadacaoGrupoCredito->getAnoExercicio();
        $this->fkArrecadacaoGrupoCredito = $fkArrecadacaoGrupoCredito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoGrupoCredito
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    public function getFkArrecadacaoGrupoCredito()
    {
        return $this->fkArrecadacaoGrupoCredito;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->codAtributo,
            $this->fkAdministracaoAtributoDinamico->getNomAtributo()
        );
    }
}
