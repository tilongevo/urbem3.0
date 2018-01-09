<?php
 
namespace Urbem\CoreBundle\Entity\Documentodinamico;

/**
 * TagBase
 */
class TagBase
{
    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $esquema;

    /**
     * @var string
     */
    private $tabela;

    /**
     * @var string
     */
    private $coluna;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Documentodinamico\Documento
     */
    private $fkDocumentodinamicoDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;


    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return TagBase
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
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TagBase
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return TagBase
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
     * Set descricao
     *
     * @param string $descricao
     * @return TagBase
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
     * Set esquema
     *
     * @param string $esquema
     * @return TagBase
     */
    public function setEsquema($esquema)
    {
        $this->esquema = $esquema;
        return $this;
    }

    /**
     * Get esquema
     *
     * @return string
     */
    public function getEsquema()
    {
        return $this->esquema;
    }

    /**
     * Set tabela
     *
     * @param string $tabela
     * @return TagBase
     */
    public function setTabela($tabela)
    {
        $this->tabela = $tabela;
        return $this;
    }

    /**
     * Get tabela
     *
     * @return string
     */
    public function getTabela()
    {
        return $this->tabela;
    }

    /**
     * Set coluna
     *
     * @param string $coluna
     * @return TagBase
     */
    public function setColuna($coluna)
    {
        $this->coluna = $coluna;
        return $this;
    }

    /**
     * Get coluna
     *
     * @return string
     */
    public function getColuna()
    {
        return $this->coluna;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkDocumentodinamicoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Documentodinamico\Documento $fkDocumentodinamicoDocumento
     * @return TagBase
     */
    public function setFkDocumentodinamicoDocumento(\Urbem\CoreBundle\Entity\Documentodinamico\Documento $fkDocumentodinamicoDocumento)
    {
        $this->codDocumento = $fkDocumentodinamicoDocumento->getCodDocumento();
        $this->fkDocumentodinamicoDocumento = $fkDocumentodinamicoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkDocumentodinamicoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Documentodinamico\Documento
     */
    public function getFkDocumentodinamicoDocumento()
    {
        return $this->fkDocumentodinamicoDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return TagBase
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
}
