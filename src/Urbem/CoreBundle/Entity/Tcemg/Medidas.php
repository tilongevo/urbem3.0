<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * Medidas
 */
class Medidas
{
    /**
     * PK
     * @var integer
     */
    private $codMedida;

    /**
     * @var integer
     */
    private $codPoder;

    /**
     * @var integer
     */
    private $codMes;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $riscosFiscais;

    /**
     * @var boolean
     */
    private $metasFiscais;

    /**
     * @var boolean
     */
    private $contratacaoAro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\PoderPublico
     */
    private $fkAdministracaoPoderPublico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    private $fkAdministracaoMes;


    /**
     * Set codMedida
     *
     * @param integer $codMedida
     * @return Medidas
     */
    public function setCodMedida($codMedida)
    {
        $this->codMedida = $codMedida;
        return $this;
    }

    /**
     * Get codMedida
     *
     * @return integer
     */
    public function getCodMedida()
    {
        return $this->codMedida;
    }

    /**
     * Set codPoder
     *
     * @param integer $codPoder
     * @return Medidas
     */
    public function setCodPoder($codPoder)
    {
        $this->codPoder = $codPoder;
        return $this;
    }

    /**
     * Get codPoder
     *
     * @return integer
     */
    public function getCodPoder()
    {
        return $this->codPoder;
    }

    /**
     * Set codMes
     *
     * @param integer $codMes
     * @return Medidas
     */
    public function setCodMes($codMes)
    {
        $this->codMes = $codMes;
        return $this;
    }

    /**
     * Get codMes
     *
     * @return integer
     */
    public function getCodMes()
    {
        return $this->codMes;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Medidas
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set riscosFiscais
     *
     * @param boolean $riscosFiscais
     * @return Medidas
     */
    public function setRiscosFiscais($riscosFiscais = null)
    {
        $this->riscosFiscais = $riscosFiscais;
        return $this;
    }

    /**
     * Get riscosFiscais
     *
     * @return boolean
     */
    public function getRiscosFiscais()
    {
        return $this->riscosFiscais;
    }

    /**
     * Set metasFiscais
     *
     * @param boolean $metasFiscais
     * @return Medidas
     */
    public function setMetasFiscais($metasFiscais = null)
    {
        $this->metasFiscais = $metasFiscais;
        return $this;
    }

    /**
     * Get metasFiscais
     *
     * @return boolean
     */
    public function getMetasFiscais()
    {
        return $this->metasFiscais;
    }

    /**
     * Set contratacaoAro
     *
     * @param boolean $contratacaoAro
     * @return Medidas
     */
    public function setContratacaoAro($contratacaoAro = null)
    {
        $this->contratacaoAro = $contratacaoAro;
        return $this;
    }

    /**
     * Get contratacaoAro
     *
     * @return boolean
     */
    public function getContratacaoAro()
    {
        return $this->contratacaoAro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoPoderPublico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\PoderPublico $fkAdministracaoPoderPublico
     * @return Medidas
     */
    public function setFkAdministracaoPoderPublico(\Urbem\CoreBundle\Entity\Administracao\PoderPublico $fkAdministracaoPoderPublico)
    {
        $this->codPoder = $fkAdministracaoPoderPublico->getCodPoder();
        $this->fkAdministracaoPoderPublico = $fkAdministracaoPoderPublico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoPoderPublico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\PoderPublico
     */
    public function getFkAdministracaoPoderPublico()
    {
        return $this->fkAdministracaoPoderPublico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoMes
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes
     * @return Medidas
     */
    public function setFkAdministracaoMes(\Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes)
    {
        $this->codMes = $fkAdministracaoMes->getCodMes();
        $this->fkAdministracaoMes = $fkAdministracaoMes;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoMes
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    public function getFkAdministracaoMes()
    {
        return $this->fkAdministracaoMes;
    }
}
