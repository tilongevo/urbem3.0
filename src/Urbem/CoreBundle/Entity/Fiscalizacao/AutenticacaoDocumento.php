<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * AutenticacaoDocumento
 */
class AutenticacaoDocumento
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $nrLivro;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro
     */
    private $fkFiscalizacaoAutenticacaoLivro;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return AutenticacaoDocumento
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set nrLivro
     *
     * @param integer $nrLivro
     * @return AutenticacaoDocumento
     */
    public function setNrLivro($nrLivro)
    {
        $this->nrLivro = $nrLivro;
        return $this;
    }

    /**
     * Get nrLivro
     *
     * @return integer
     */
    public function getNrLivro()
    {
        return $this->nrLivro;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return AutenticacaoDocumento
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return AutenticacaoDocumento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return AutenticacaoDocumento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoAutenticacaoLivro
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro $fkFiscalizacaoAutenticacaoLivro
     * @return AutenticacaoDocumento
     */
    public function setFkFiscalizacaoAutenticacaoLivro(\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro $fkFiscalizacaoAutenticacaoLivro)
    {
        $this->inscricaoEconomica = $fkFiscalizacaoAutenticacaoLivro->getInscricaoEconomica();
        $this->nrLivro = $fkFiscalizacaoAutenticacaoLivro->getNrLivro();
        $this->fkFiscalizacaoAutenticacaoLivro = $fkFiscalizacaoAutenticacaoLivro;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoAutenticacaoLivro
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoLivro
     */
    public function getFkFiscalizacaoAutenticacaoLivro()
    {
        return $this->fkFiscalizacaoAutenticacaoLivro;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return AutenticacaoDocumento
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }
}
