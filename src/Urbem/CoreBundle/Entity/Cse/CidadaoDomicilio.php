<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * CidadaoDomicilio
 */
class CidadaoDomicilio
{
    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * PK
     * @var integer
     */
    private $codDomicilio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInclusao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Cse\Responsavel
     */
    private $fkCseResponsavel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Domicilio
     */
    private $fkCseDomicilio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtInclusao = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return CidadaoDomicilio
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set codDomicilio
     *
     * @param integer $codDomicilio
     * @return CidadaoDomicilio
     */
    public function setCodDomicilio($codDomicilio)
    {
        $this->codDomicilio = $codDomicilio;
        return $this;
    }

    /**
     * Get codDomicilio
     *
     * @return integer
     */
    public function getCodDomicilio()
    {
        return $this->codDomicilio;
    }

    /**
     * Set dtInclusao
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInclusao
     * @return CidadaoDomicilio
     */
    public function setDtInclusao(\Urbem\CoreBundle\Helper\DatePK $dtInclusao)
    {
        $this->dtInclusao = $dtInclusao;
        return $this;
    }

    /**
     * Get dtInclusao
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInclusao()
    {
        return $this->dtInclusao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return CidadaoDomicilio
     */
    public function setFkCseCidadao(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->codCidadao = $fkCseCidadao->getCodCidadao();
        $this->fkCseCidadao = $fkCseCidadao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseCidadao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadao()
    {
        return $this->fkCseCidadao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio
     * @return CidadaoDomicilio
     */
    public function setFkCseDomicilio(\Urbem\CoreBundle\Entity\Cse\Domicilio $fkCseDomicilio)
    {
        $this->codDomicilio = $fkCseDomicilio->getCodDomicilio();
        $this->fkCseDomicilio = $fkCseDomicilio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseDomicilio
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Domicilio
     */
    public function getFkCseDomicilio()
    {
        return $this->fkCseDomicilio;
    }

    /**
     * OneToOne (inverse side)
     * Set CseResponsavel
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Responsavel $fkCseResponsavel
     * @return CidadaoDomicilio
     */
    public function setFkCseResponsavel(\Urbem\CoreBundle\Entity\Cse\Responsavel $fkCseResponsavel)
    {
        $fkCseResponsavel->setFkCseCidadaoDomicilio($this);
        $this->fkCseResponsavel = $fkCseResponsavel;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkCseResponsavel
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Responsavel
     */
    public function getFkCseResponsavel()
    {
        return $this->fkCseResponsavel;
    }
}
