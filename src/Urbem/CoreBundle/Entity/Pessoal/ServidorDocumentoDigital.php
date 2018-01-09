<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ServidorDocumentoDigital
 */
class ServidorDocumentoDigital
{
    /**
     * PK
     * @var integer
     */
    private $codServidor;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomeArquivo;

    /**
     * @var string
     */
    private $arquivoDigital;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\TipoDocumentoDigital
     */
    private $fkPessoalTipoDocumentoDigital;


    /**
     * Set codServidor
     *
     * @param integer $codServidor
     * @return ServidorDocumentoDigital
     */
    public function setCodServidor($codServidor)
    {
        $this->codServidor = $codServidor;
        return $this;
    }

    /**
     * Get codServidor
     *
     * @return integer
     */
    public function getCodServidor()
    {
        return $this->codServidor;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ServidorDocumentoDigital
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
     * Set nomeArquivo
     *
     * @param string $nomeArquivo
     * @return ServidorDocumentoDigital
     */
    public function setNomeArquivo($nomeArquivo)
    {
        $this->nomeArquivo = $nomeArquivo;
        return $this;
    }

    /**
     * Get nomeArquivo
     *
     * @return string
     */
    public function getNomeArquivo()
    {
        return $this->nomeArquivo;
    }

    /**
     * Set arquivoDigital
     *
     * @param string $arquivoDigital
     * @return ServidorDocumentoDigital
     */
    public function setArquivoDigital($arquivoDigital)
    {
        $this->arquivoDigital = $arquivoDigital;
        return $this;
    }

    /**
     * Get arquivoDigital
     *
     * @return string
     */
    public function getArquivoDigital()
    {
        return $this->arquivoDigital;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return ServidorDocumentoDigital
     */
    public function setFkPessoalServidor(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        $this->codServidor = $fkPessoalServidor->getCodServidor();
        $this->fkPessoalServidor = $fkPessoalServidor;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    public function getFkPessoalServidor()
    {
        return $this->fkPessoalServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalTipoDocumentoDigital
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoDocumentoDigital $fkPessoalTipoDocumentoDigital
     * @return ServidorDocumentoDigital
     */
    public function setFkPessoalTipoDocumentoDigital(\Urbem\CoreBundle\Entity\Pessoal\TipoDocumentoDigital $fkPessoalTipoDocumentoDigital)
    {
        $this->codTipo = $fkPessoalTipoDocumentoDigital->getCodTipo();
        $this->fkPessoalTipoDocumentoDigital = $fkPessoalTipoDocumentoDigital;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalTipoDocumentoDigital
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\TipoDocumentoDigital
     */
    public function getFkPessoalTipoDocumentoDigital()
    {
        return $this->fkPessoalTipoDocumentoDigital;
    }

}
