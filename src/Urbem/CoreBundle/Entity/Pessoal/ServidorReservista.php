<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ServidorReservista
 */
class ServidorReservista
{
    /**
     * PK
     * @var integer
     */
    private $codServidor;

    /**
     * @var string
     */
    private $nrCarteiraRes;

    /**
     * @var string
     */
    private $catReservista;

    /**
     * @var string
     */
    private $origemReservista;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    private $fkPessoalServidor;

    /**
     * Set codServidor
     *
     * @param integer $codServidor
     * @return ServidorReservista
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
     * Set nrCarteiraRes
     *
     * @param string $nrCarteiraRes
     * @return ServidorReservista
     */
    public function setNrCarteiraRes($nrCarteiraRes)
    {
        $this->nrCarteiraRes = $nrCarteiraRes;
        return $this;
    }

    /**
     * Get nrCarteiraRes
     *
     * @return string
     */
    public function getNrCarteiraRes()
    {
        return $this->nrCarteiraRes;
    }

    /**
     * Set catReservista
     *
     * @param string $catReservista
     * @return ServidorReservista
     */
    public function setCatReservista($catReservista)
    {
        $this->catReservista = $catReservista;
        return $this;
    }

    /**
     * Get catReservista
     *
     * @return string
     */
    public function getCatReservista()
    {
        return $this->catReservista;
    }

    /**
     * Set origemReservista
     *
     * @param string $origemReservista
     * @return ServidorReservista
     */
    public function setOrigemReservista($origemReservista)
    {
        $this->origemReservista = $origemReservista;
        return $this;
    }

    /**
     * Get origemReservista
     *
     * @return string
     */
    public function getOrigemReservista()
    {
        return $this->origemReservista;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor
     * @return ServidorReservista
     */
    public function setFkPessoalServidor(\Urbem\CoreBundle\Entity\Pessoal\Servidor $fkPessoalServidor)
    {
        $this->codServidor = $fkPessoalServidor->getCodServidor();
        $this->fkPessoalServidor = $fkPessoalServidor;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Servidor
     */
    public function getFkPessoalServidor()
    {
        return $this->fkPessoalServidor;
    }
}
