<?php

namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * RequisicaoHomologada
 */
class RequisicaoHomologada
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codRequisicao;

    /**
     * PK
     * @var integer
     */
    private $codAlmoxarifado;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $cgmHomologador;

    /**
     * @var boolean
     */
    private $homologada;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    private $fkAlmoxarifadoRequisicao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return RequisicaoHomologada
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codRequisicao
     *
     * @param integer $codRequisicao
     * @return RequisicaoHomologada
     */
    public function setCodRequisicao($codRequisicao)
    {
        $this->codRequisicao = $codRequisicao;
        return $this;
    }

    /**
     * Get codRequisicao
     *
     * @return integer
     */
    public function getCodRequisicao()
    {
        return $this->codRequisicao;
    }

    /**
     * Set codAlmoxarifado
     *
     * @param integer $codAlmoxarifado
     * @return RequisicaoHomologada
     */
    public function setCodAlmoxarifado($codAlmoxarifado)
    {
        $this->codAlmoxarifado = $codAlmoxarifado;
        return $this;
    }

    /**
     * Get codAlmoxarifado
     *
     * @return integer
     */
    public function getCodAlmoxarifado()
    {
        return $this->codAlmoxarifado;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return RequisicaoHomologada
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
     * Set cgmHomologador
     *
     * @param integer $cgmHomologador
     * @return RequisicaoHomologada
     */
    public function setCgmHomologador($cgmHomologador)
    {
        $this->cgmHomologador = $cgmHomologador;
        return $this;
    }

    /**
     * Get cgmHomologador
     *
     * @return integer
     */
    public function getCgmHomologador()
    {
        return $this->cgmHomologador;
    }

    /**
     * Set homologada
     *
     * @param boolean $homologada
     * @return RequisicaoHomologada
     */
    public function setHomologada($homologada)
    {
        $this->homologada = $homologada;
        return $this;
    }

    /**
     * Get homologada
     *
     * @return boolean
     */
    public function getHomologada()
    {
        return $this->homologada;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoRequisicao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao
     * @return RequisicaoHomologada
     */
    public function setFkAlmoxarifadoRequisicao(\Urbem\CoreBundle\Entity\Almoxarifado\Requisicao $fkAlmoxarifadoRequisicao)
    {
        $this->exercicio = $fkAlmoxarifadoRequisicao->getExercicio();
        $this->codRequisicao = $fkAlmoxarifadoRequisicao->getCodRequisicao();
        $this->codAlmoxarifado = $fkAlmoxarifadoRequisicao->getCodAlmoxarifado();
        $this->fkAlmoxarifadoRequisicao = $fkAlmoxarifadoRequisicao;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoRequisicao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Requisicao
     */
    public function getFkAlmoxarifadoRequisicao()
    {
        return $this->fkAlmoxarifadoRequisicao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return RequisicaoHomologada
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->cgmHomologador = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }
}
