<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * EmissaoDocumento
 */
class EmissaoDocumento
{
    /**
     * PK
     * @var integer
     */
    private $numParcelamento;

    /**
     * PK
     * @var integer
     */
    private $numEmissao;

    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $numDocumento;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numcgmUsuario;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Divida\Documento
     */
    private $fkDividaDocumento;

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
     * Set numParcelamento
     *
     * @param integer $numParcelamento
     * @return EmissaoDocumento
     */
    public function setNumParcelamento($numParcelamento)
    {
        $this->numParcelamento = $numParcelamento;
        return $this;
    }

    /**
     * Get numParcelamento
     *
     * @return integer
     */
    public function getNumParcelamento()
    {
        return $this->numParcelamento;
    }

    /**
     * Set numEmissao
     *
     * @param integer $numEmissao
     * @return EmissaoDocumento
     */
    public function setNumEmissao($numEmissao)
    {
        $this->numEmissao = $numEmissao;
        return $this;
    }

    /**
     * Get numEmissao
     *
     * @return integer
     */
    public function getNumEmissao()
    {
        return $this->numEmissao;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return EmissaoDocumento
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
     * @return EmissaoDocumento
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
     * Set numDocumento
     *
     * @param integer $numDocumento
     * @return EmissaoDocumento
     */
    public function setNumDocumento($numDocumento)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    /**
     * Get numDocumento
     *
     * @return integer
     */
    public function getNumDocumento()
    {
        return $this->numDocumento;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return EmissaoDocumento
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
     * Set numcgmUsuario
     *
     * @param integer $numcgmUsuario
     * @return EmissaoDocumento
     */
    public function setNumcgmUsuario($numcgmUsuario)
    {
        $this->numcgmUsuario = $numcgmUsuario;
        return $this;
    }

    /**
     * Get numcgmUsuario
     *
     * @return integer
     */
    public function getNumcgmUsuario()
    {
        return $this->numcgmUsuario;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EmissaoDocumento
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
     * ManyToOne (inverse side)
     * Set fkDividaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento
     * @return EmissaoDocumento
     */
    public function setFkDividaDocumento(\Urbem\CoreBundle\Entity\Divida\Documento $fkDividaDocumento)
    {
        $this->numParcelamento = $fkDividaDocumento->getNumParcelamento();
        $this->codTipoDocumento = $fkDividaDocumento->getCodTipoDocumento();
        $this->codDocumento = $fkDividaDocumento->getCodDocumento();
        $this->fkDividaDocumento = $fkDividaDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDividaDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Divida\Documento
     */
    public function getFkDividaDocumento()
    {
        return $this->fkDividaDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return EmissaoDocumento
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgmUsuario = $fkAdministracaoUsuario->getNumcgm();
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
