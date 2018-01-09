<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * DependenteExcluido
 */
class DependenteExcluido
{
    /**
     * PK
     * @var integer
     */
    private $codDependente;

    /**
     * PK
     * @var integer
     */
    private $codServidor;

    /**
     * @var \DateTime
     */
    private $dataExclusao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente
     */
    private $fkPessoalServidorDependente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dataExclusao = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codDependente
     *
     * @param integer $codDependente
     * @return DependenteExcluido
     */
    public function setCodDependente($codDependente)
    {
        $this->codDependente = $codDependente;
        return $this;
    }

    /**
     * Get codDependente
     *
     * @return integer
     */
    public function getCodDependente()
    {
        return $this->codDependente;
    }

    /**
     * Set codServidor
     *
     * @param integer $codServidor
     * @return DependenteExcluido
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
     * Set dataExclusao
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $dataExclusao
     * @return DependenteExcluido
     */
    public function setDataExclusao(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $dataExclusao)
    {
        $this->dataExclusao = $dataExclusao;
        return $this;
    }

    /**
     * Get dataExclusao
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getDataExclusao()
    {
        return $this->dataExclusao;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalServidorDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente
     * @return DependenteExcluido
     */
    public function setFkPessoalServidorDependente(\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente)
    {
        $this->codServidor = $fkPessoalServidorDependente->getCodServidor();
        $this->codDependente = $fkPessoalServidorDependente->getCodDependente();
        $this->fkPessoalServidorDependente = $fkPessoalServidorDependente;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalServidorDependente
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente
     */
    public function getFkPessoalServidorDependente()
    {
        return $this->fkPessoalServidorDependente;
    }
}
