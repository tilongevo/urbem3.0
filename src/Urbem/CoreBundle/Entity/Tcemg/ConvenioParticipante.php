<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConvenioParticipante
 */
class ConvenioParticipante
{
    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $cgmParticipante;

    /**
     * @var integer
     */
    private $vlConcedido;

    /**
     * @var integer
     */
    private $percentual;

    /**
     * @var integer
     */
    private $codTipoParticipante;

    /**
     * @var string
     */
    private $esfera = 'Federal';

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcemg\Convenio
     */
    private $fkTcemgConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    private $fkComprasFornecedor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\TipoParticipante
     */
    private $fkLicitacaoTipoParticipante;


    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return ConvenioParticipante
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ConvenioParticipante
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConvenioParticipante
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
     * Set cgmParticipante
     *
     * @param integer $cgmParticipante
     * @return ConvenioParticipante
     */
    public function setCgmParticipante($cgmParticipante)
    {
        $this->cgmParticipante = $cgmParticipante;
        return $this;
    }

    /**
     * Get cgmParticipante
     *
     * @return integer
     */
    public function getCgmParticipante()
    {
        return $this->cgmParticipante;
    }

    /**
     * Set vlConcedido
     *
     * @param integer $vlConcedido
     * @return ConvenioParticipante
     */
    public function setVlConcedido($vlConcedido)
    {
        $this->vlConcedido = $vlConcedido;
        return $this;
    }

    /**
     * Get vlConcedido
     *
     * @return integer
     */
    public function getVlConcedido()
    {
        return $this->vlConcedido;
    }

    /**
     * Set percentual
     *
     * @param integer $percentual
     * @return ConvenioParticipante
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return integer
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * Set codTipoParticipante
     *
     * @param integer $codTipoParticipante
     * @return ConvenioParticipante
     */
    public function setCodTipoParticipante($codTipoParticipante)
    {
        $this->codTipoParticipante = $codTipoParticipante;
        return $this;
    }

    /**
     * Get codTipoParticipante
     *
     * @return integer
     */
    public function getCodTipoParticipante()
    {
        return $this->codTipoParticipante;
    }

    /**
     * Set esfera
     *
     * @param string $esfera
     * @return ConvenioParticipante
     */
    public function setEsfera($esfera)
    {
        $this->esfera = $esfera;
        return $this;
    }

    /**
     * Get esfera
     *
     * @return string
     */
    public function getEsfera()
    {
        return $this->esfera;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcemgConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\Convenio $fkTcemgConvenio
     * @return ConvenioParticipante
     */
    public function setFkTcemgConvenio(\Urbem\CoreBundle\Entity\Tcemg\Convenio $fkTcemgConvenio)
    {
        $this->codConvenio = $fkTcemgConvenio->getCodConvenio();
        $this->codEntidade = $fkTcemgConvenio->getCodEntidade();
        $this->exercicio = $fkTcemgConvenio->getExercicio();
        $this->fkTcemgConvenio = $fkTcemgConvenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcemgConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\Convenio
     */
    public function getFkTcemgConvenio()
    {
        return $this->fkTcemgConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor
     * @return ConvenioParticipante
     */
    public function setFkComprasFornecedor(\Urbem\CoreBundle\Entity\Compras\Fornecedor $fkComprasFornecedor)
    {
        $this->cgmParticipante = $fkComprasFornecedor->getCgmFornecedor();
        $this->fkComprasFornecedor = $fkComprasFornecedor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasFornecedor
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Fornecedor
     */
    public function getFkComprasFornecedor()
    {
        return $this->fkComprasFornecedor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoTipoParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\TipoParticipante $fkLicitacaoTipoParticipante
     * @return ConvenioParticipante
     */
    public function setFkLicitacaoTipoParticipante(\Urbem\CoreBundle\Entity\Licitacao\TipoParticipante $fkLicitacaoTipoParticipante)
    {
        $this->codTipoParticipante = $fkLicitacaoTipoParticipante->getCodTipoParticipante();
        $this->fkLicitacaoTipoParticipante = $fkLicitacaoTipoParticipante;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoTipoParticipante
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\TipoParticipante
     */
    public function getFkLicitacaoTipoParticipante()
    {
        return $this->fkLicitacaoTipoParticipante;
    }
}
