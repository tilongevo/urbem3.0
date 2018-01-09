<?php

namespace Urbem\CoreBundle\Entity\Diarias;

/**
 * Diaria
 */
class Diaria
{
    /**
     * PK
     * @var integer
     */
    private $codDiaria;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codMunicipio;

    /**
     * @var integer
     */
    private $codUf;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtTermino;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var integer
     */
    private $vlTotal;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var integer
     */
    private $vlUnitario;

    /**
     * @var \DateTime
     */
    private $hrInicio;

    /**
     * @var \DateTime
     */
    private $hrTermino;

    /**
     * @var \DateTime
     */
    private $timestampTipo;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho
     */
    private $fkDiariasDiariaEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Diarias\TipoDiaria
     */
    private $fkDiariasTipoDiaria;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwMunicipio
     */
    private $fkSwMunicipio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

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
     * Set codDiaria
     *
     * @param integer $codDiaria
     * @return Diaria
     */
    public function setCodDiaria($codDiaria)
    {
        $this->codDiaria = $codDiaria;
        return $this;
    }

    /**
     * Get codDiaria
     *
     * @return integer
     */
    public function getCodDiaria()
    {
        return $this->codDiaria;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return Diaria
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Diaria
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Diaria
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set codMunicipio
     *
     * @param integer $codMunicipio
     * @return Diaria
     */
    public function setCodMunicipio($codMunicipio)
    {
        $this->codMunicipio = $codMunicipio;
        return $this;
    }

    /**
     * Get codMunicipio
     *
     * @return integer
     */
    public function getCodMunicipio()
    {
        return $this->codMunicipio;
    }

    /**
     * Set codUf
     *
     * @param integer $codUf
     * @return Diaria
     */
    public function setCodUf($codUf)
    {
        $this->codUf = $codUf;
        return $this;
    }

    /**
     * Get codUf
     *
     * @return integer
     */
    public function getCodUf()
    {
        return $this->codUf;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Diaria
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Diaria
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
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return Diaria
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtTermino
     *
     * @param \DateTime $dtTermino
     * @return Diaria
     */
    public function setDtTermino(\DateTime $dtTermino)
    {
        $this->dtTermino = $dtTermino;
        return $this;
    }

    /**
     * Get dtTermino
     *
     * @return \DateTime
     */
    public function getDtTermino()
    {
        return $this->dtTermino;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return Diaria
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set vlTotal
     *
     * @param integer $vlTotal
     * @return Diaria
     */
    public function setVlTotal($vlTotal)
    {
        $this->vlTotal = $vlTotal;
        return $this;
    }

    /**
     * Get vlTotal
     *
     * @return integer
     */
    public function getVlTotal()
    {
        return $this->vlTotal;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return Diaria
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set vlUnitario
     *
     * @param integer $vlUnitario
     * @return Diaria
     */
    public function setVlUnitario($vlUnitario)
    {
        $this->vlUnitario = $vlUnitario;
        return $this;
    }

    /**
     * Get vlUnitario
     *
     * @return integer
     */
    public function getVlUnitario()
    {
        return $this->vlUnitario;
    }

    /**
     * Set hrInicio
     *
     * @param \DateTime $hrInicio
     * @return Diaria
     */
    public function setHrInicio(\DateTime $hrInicio)
    {
        $this->hrInicio = $hrInicio;
        return $this;
    }

    /**
     * Get hrInicio
     *
     * @return \DateTime
     */
    public function getHrInicio()
    {
        return $this->hrInicio;
    }

    /**
     * Set hrTermino
     *
     * @param \DateTime $hrTermino
     * @return Diaria
     */
    public function setHrTermino(\DateTime $hrTermino)
    {
        $this->hrTermino = $hrTermino;
        return $this;
    }

    /**
     * Get hrTermino
     *
     * @return \DateTime
     */
    public function getHrTermino()
    {
        return $this->hrTermino;
    }

    /**
     * Set timestampTipo
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTipo
     * @return Diaria
     */
    public function setTimestampTipo(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampTipo)
    {
        $this->timestampTipo = $timestampTipo;
        return $this;
    }

    /**
     * Get timestampTipo
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampTipo()
    {
        return $this->timestampTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return Diaria
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDiariasTipoDiaria
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\TipoDiaria $fkDiariasTipoDiaria
     * @return Diaria
     */
    public function setFkDiariasTipoDiaria(\Urbem\CoreBundle\Entity\Diarias\TipoDiaria $fkDiariasTipoDiaria)
    {
        $this->codTipo = $fkDiariasTipoDiaria->getCodTipo();
        $this->timestampTipo = $fkDiariasTipoDiaria->getTimestamp();
        $this->fkDiariasTipoDiaria = $fkDiariasTipoDiaria;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDiariasTipoDiaria
     *
     * @return \Urbem\CoreBundle\Entity\Diarias\TipoDiaria
     */
    public function getFkDiariasTipoDiaria()
    {
        return $this->fkDiariasTipoDiaria;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwMunicipio
     *
     * @param \Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio
     * @return Diaria
     */
    public function setFkSwMunicipio(\Urbem\CoreBundle\Entity\SwMunicipio $fkSwMunicipio)
    {
        $this->codMunicipio = $fkSwMunicipio->getCodMunicipio();
        $this->codUf = $fkSwMunicipio->getCodUf();
        $this->fkSwMunicipio = $fkSwMunicipio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwMunicipio
     *
     * @return \Urbem\CoreBundle\Entity\SwMunicipio
     */
    public function getFkSwMunicipio()
    {
        return $this->fkSwMunicipio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Diaria
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Diaria
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
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

    /**
     * OneToOne (inverse side)
     * Set DiariasDiariaEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho $fkDiariasDiariaEmpenho
     * @return Diaria
     */
    public function setFkDiariasDiariaEmpenho(\Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho $fkDiariasDiariaEmpenho)
    {
        $fkDiariasDiariaEmpenho->setFkDiariasDiaria($this);
        $this->fkDiariasDiariaEmpenho = $fkDiariasDiariaEmpenho;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDiariasDiariaEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Diarias\DiariaEmpenho
     */
    public function getFkDiariasDiariaEmpenho()
    {
        return $this->fkDiariasDiariaEmpenho;
    }

    /**
     * @return int
     */
    public function getMatricula()
    {
        return $this->getFkPessoalContrato()->getRegistro();
    }

    /**
     * @return string
     */
    public function getServidor()
    {
        return $this->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
    }

    /**
     * @return string
     */
    public function getMatriculaServidor()
    {
        return $this->getFkPessoalContrato()->getRegistro()
        . " - "
        . $this->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
    }
}
