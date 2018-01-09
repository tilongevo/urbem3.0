<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ServidorCtps
 */
class ServidorCtps
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
    private $codCtps;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Ctps
     */
    private $fkPessoalCtps;


    /**
     * Set codServidor
     *
     * @param integer $codServidor
     * @return ServidorCtps
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
     * Set codCtps
     *
     * @param integer $codCtps
     * @return ServidorCtps
     */
    public function setCodCtps($codCtps)
    {
        $this->codCtps = $codCtps;
        return $this;
    }

    /**
     * Get codCtps
     *
     * @return integer
     */
    public function getCodCtps()
    {
        return $this->codCtps;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return ServidorCtps
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
     * Set fkPessoalCtps
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ctps $fkPessoalCtps
     * @return ServidorCtps
     */
    public function setFkPessoalCtps(\Urbem\CoreBundle\Entity\Pessoal\Ctps $fkPessoalCtps)
    {
        $this->codCtps = $fkPessoalCtps->getCodCtps();
        $this->fkPessoalCtps = $fkPessoalCtps;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCtps
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Ctps
     */
    public function getFkPessoalCtps()
    {
        return $this->fkPessoalCtps;
    }
}
