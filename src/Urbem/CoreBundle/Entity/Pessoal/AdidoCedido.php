<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\AdidoCedido as AdidoCedidoConstants;

/**
 * AdidoCedido
 */
class AdidoCedido
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $cgmCedenteCessionario;

    /**
     * @var \DateTime
     */
    private $dtInicial;

    /**
     * @var \DateTime
     */
    private $dtFinal;

    /**
     * @var string
     */
    private $tipoCedencia;

    /**
     * @var string
     */
    private $indicativoOnus;

    /**
     * @var string
     */
    private $numConvenio;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoExcluido
     */
    private $fkPessoalAdidoCedidoExcluido;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal
     */
    private $fkPessoalAdidoCedidoLocais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAdidoCedidoLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return AdidoCedido
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return AdidoCedido
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AdidoCedido
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
     * Set cgmCedenteCessionario
     *
     * @param integer $cgmCedenteCessionario
     * @return AdidoCedido
     */
    public function setCgmCedenteCessionario($cgmCedenteCessionario)
    {
        $this->cgmCedenteCessionario = $cgmCedenteCessionario;
        return $this;
    }

    /**
     * Get cgmCedenteCessionario
     *
     * @return integer
     */
    public function getCgmCedenteCessionario()
    {
        return $this->cgmCedenteCessionario;
    }

    /**
     * Set dtInicial
     *
     * @param \DateTime $dtInicial
     * @return AdidoCedido
     */
    public function setDtInicial(\DateTime $dtInicial)
    {
        $this->dtInicial = $dtInicial;
        return $this;
    }

    /**
     * Get dtInicial
     *
     * @return \DateTime
     */
    public function getDtInicial()
    {
        return $this->dtInicial;
    }

    /**
     * Set dtFinal
     *
     * @param \DateTime $dtFinal
     * @return AdidoCedido
     */
    public function setDtFinal(\DateTime $dtFinal = null)
    {
        $this->dtFinal = $dtFinal;
        return $this;
    }

    /**
     * Get dtFinal
     *
     * @return \DateTime
     */
    public function getDtFinal()
    {
        return $this->dtFinal;
    }

    /**
     * Set tipoCedencia
     *
     * @param string $tipoCedencia
     * @return AdidoCedido
     */
    public function setTipoCedencia($tipoCedencia)
    {
        $this->tipoCedencia = $tipoCedencia;
        return $this;
    }

    /**
     * Get tipoCedencia
     *
     * @return string
     */
    public function getTipoCedencia()
    {
        return $this->tipoCedencia;
    }

    /**
     * Set indicativoOnus
     *
     * @param string $indicativoOnus
     * @return AdidoCedido
     */
    public function setIndicativoOnus($indicativoOnus)
    {
        $this->indicativoOnus = $indicativoOnus;
        return $this;
    }

    /**
     * Get indicativoOnus
     *
     * @return string
     */
    public function getIndicativoOnus()
    {
        return $this->indicativoOnus;
    }

    /**
     * Set numConvenio
     *
     * @param string $numConvenio
     * @return AdidoCedido
     */
    public function setNumConvenio($numConvenio = null)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return string
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAdidoCedidoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal $fkPessoalAdidoCedidoLocal
     * @return AdidoCedido
     */
    public function addFkPessoalAdidoCedidoLocais(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal $fkPessoalAdidoCedidoLocal)
    {
        if (false === $this->fkPessoalAdidoCedidoLocais->contains($fkPessoalAdidoCedidoLocal)) {
            $fkPessoalAdidoCedidoLocal->setFkPessoalAdidoCedido($this);
            $this->fkPessoalAdidoCedidoLocais->add($fkPessoalAdidoCedidoLocal);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAdidoCedidoLocal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal $fkPessoalAdidoCedidoLocal
     */
    public function removeFkPessoalAdidoCedidoLocais(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal $fkPessoalAdidoCedidoLocal)
    {
        $this->fkPessoalAdidoCedidoLocais->removeElement($fkPessoalAdidoCedidoLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAdidoCedidoLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal
     */
    public function getFkPessoalAdidoCedidoLocais()
    {
        return $this->fkPessoalAdidoCedidoLocais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return AdidoCedido
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return AdidoCedido
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
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return AdidoCedido
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmCedenteCessionario = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalAdidoCedidoExcluido
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoExcluido $fkPessoalAdidoCedidoExcluido
     * @return AdidoCedido
     */
    public function setFkPessoalAdidoCedidoExcluido(\Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoExcluido $fkPessoalAdidoCedidoExcluido)
    {
        $fkPessoalAdidoCedidoExcluido->setFkPessoalAdidoCedido($this);
        $this->fkPessoalAdidoCedidoExcluido = $fkPessoalAdidoCedidoExcluido;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalAdidoCedidoExcluido
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoExcluido
     */
    public function getFkPessoalAdidoCedidoExcluido()
    {
        return $this->fkPessoalAdidoCedidoExcluido;
    }

    /**
     * @return int
     */
    public function getMatricula()
    {
        return $this->getFkPessoalContratoServidor()
        ->getFkPessoalContrato()->getRegistro();
    }

    /**
     * @return string
     */
    public function getServidor()
    {
        return $this->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
        . " - "
        . $this->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
        ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
    }

    /**
     * @return string|null
     */
    public function getLocal()
    {
        $codLocal = $this->getFkPessoalAdidoCedidoLocais();

        if (! $codLocal->isEmpty()) {
            return $codLocal->last()->getFkOrganogramaLocal()->getDescricao();
        }
        return null;
    }

    /**
     * @return string
     */
    public function getTipoCedenciaTranslate()
    {
        return array_search($this->tipoCedencia, AdidoCedidoConstants::TIPOCEDENCIA);
    }

    /**
     * @return string
     */
    public function getIndicativoOnusTranslate()
    {
        return array_search($this->indicativoOnus, AdidoCedidoConstants::INDICATIVOONUS);
    }
}
