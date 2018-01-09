<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * PensionistaCid
 */
class PensionistaCid
{
    /**
     * PK
     * @var integer
     */
    private $codPensionista;

    /**
     * PK
     * @var integer
     */
    private $codContratoCedente;

    /**
     * @var integer
     */
    private $codCid;

    /**
     * @var \DateTime
     */
    private $dataLaudo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Pensionista
     */
    private $fkPessoalPensionista;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    private $fkPessoalCid;


    /**
     * Set codPensionista
     *
     * @param integer $codPensionista
     * @return PensionistaCid
     */
    public function setCodPensionista($codPensionista)
    {
        $this->codPensionista = $codPensionista;
        return $this;
    }

    /**
     * Get codPensionista
     *
     * @return integer
     */
    public function getCodPensionista()
    {
        return $this->codPensionista;
    }

    /**
     * Set codContratoCedente
     *
     * @param integer $codContratoCedente
     * @return PensionistaCid
     */
    public function setCodContratoCedente($codContratoCedente)
    {
        $this->codContratoCedente = $codContratoCedente;
        return $this;
    }

    /**
     * Get codContratoCedente
     *
     * @return integer
     */
    public function getCodContratoCedente()
    {
        return $this->codContratoCedente;
    }

    /**
     * Set codCid
     *
     * @param integer $codCid
     * @return PensionistaCid
     */
    public function setCodCid($codCid)
    {
        $this->codCid = $codCid;
        return $this;
    }

    /**
     * Get codCid
     *
     * @return integer
     */
    public function getCodCid()
    {
        return $this->codCid;
    }

    /**
     * Set dataLaudo
     *
     * @param \DateTime $dataLaudo
     * @return PensionistaCid
     */
    public function setDataLaudo(\DateTime $dataLaudo = null)
    {
        $this->dataLaudo = $dataLaudo;
        return $this;
    }

    /**
     * Get dataLaudo
     *
     * @return \DateTime
     */
    public function getDataLaudo()
    {
        return $this->dataLaudo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCid
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid
     * @return PensionistaCid
     */
    public function setFkPessoalCid(\Urbem\CoreBundle\Entity\Pessoal\Cid $fkPessoalCid)
    {
        $this->codCid = $fkPessoalCid->getCodCid();
        $this->fkPessoalCid = $fkPessoalCid;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCid
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cid
     */
    public function getFkPessoalCid()
    {
        return $this->fkPessoalCid;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista
     * @return PensionistaCid
     */
    public function setFkPessoalPensionista(\Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista)
    {
        $this->codPensionista = $fkPessoalPensionista->getCodPensionista();
        $this->codContratoCedente = $fkPessoalPensionista->getCodContratoCedente();
        $this->fkPessoalPensionista = $fkPessoalPensionista;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalPensionista
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Pensionista
     */
    public function getFkPessoalPensionista()
    {
        return $this->fkPessoalPensionista;
    }
}
