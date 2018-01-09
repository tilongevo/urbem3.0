<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * TabelasRh
 */
class TabelasRh
{
    /**
     * PK
     * @var integer
     */
    private $schemaCod;

    /**
     * PK
     * @var string
     */
    private $nomeTabela;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\SchemaRh
     */
    private $fkAdministracaoSchemaRh;


    /**
     * Set schemaCod
     *
     * @param integer $schemaCod
     * @return TabelasRh
     */
    public function setSchemaCod($schemaCod)
    {
        $this->schemaCod = $schemaCod;
        return $this;
    }

    /**
     * Get schemaCod
     *
     * @return integer
     */
    public function getSchemaCod()
    {
        return $this->schemaCod;
    }

    /**
     * Set nomeTabela
     *
     * @param string $nomeTabela
     * @return TabelasRh
     */
    public function setNomeTabela($nomeTabela)
    {
        $this->nomeTabela = $nomeTabela;
        return $this;
    }

    /**
     * Get nomeTabela
     *
     * @return string
     */
    public function getNomeTabela()
    {
        return $this->nomeTabela;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return TabelasRh
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoSchemaRh
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\SchemaRh $fkAdministracaoSchemaRh
     * @return TabelasRh
     */
    public function setFkAdministracaoSchemaRh(\Urbem\CoreBundle\Entity\Administracao\SchemaRh $fkAdministracaoSchemaRh)
    {
        $this->schemaCod = $fkAdministracaoSchemaRh->getSchemaCod();
        $this->fkAdministracaoSchemaRh = $fkAdministracaoSchemaRh;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoSchemaRh
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\SchemaRh
     */
    public function getFkAdministracaoSchemaRh()
    {
        return $this->fkAdministracaoSchemaRh;
    }
}
