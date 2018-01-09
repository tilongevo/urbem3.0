<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * LoteFeriasOrgao
 */
class LoteFeriasOrgao
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\LoteFerias
     */
    private $fkPessoalLoteFerias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteFeriasOrgao
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return LoteFeriasOrgao
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalLoteFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\LoteFerias $fkPessoalLoteFerias
     * @return LoteFeriasOrgao
     */
    public function setFkPessoalLoteFerias(\Urbem\CoreBundle\Entity\Pessoal\LoteFerias $fkPessoalLoteFerias)
    {
        $this->codLote = $fkPessoalLoteFerias->getCodLote();
        $this->fkPessoalLoteFerias = $fkPessoalLoteFerias;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalLoteFerias
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\LoteFerias
     */
    public function getFkPessoalLoteFerias()
    {
        return $this->fkPessoalLoteFerias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return LoteFeriasOrgao
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }
}
