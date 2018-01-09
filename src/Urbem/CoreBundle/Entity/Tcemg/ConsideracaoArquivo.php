<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * ConsideracaoArquivo
 */
class ConsideracaoArquivo
{
    /**
     * PK
     * @var integer
     */
    private $codArquivo;

    /**
     * @var string
     */
    private $nomArquivo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivoDescricao
     */
    private $fkTcemgConsideracaoArquivoDescricoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgConsideracaoArquivoDescricoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codArquivo
     *
     * @param integer $codArquivo
     * @return ConsideracaoArquivo
     */
    public function setCodArquivo($codArquivo)
    {
        $this->codArquivo = $codArquivo;
        return $this;
    }

    /**
     * Get codArquivo
     *
     * @return integer
     */
    public function getCodArquivo()
    {
        return $this->codArquivo;
    }

    /**
     * Set nomArquivo
     *
     * @param string $nomArquivo
     * @return ConsideracaoArquivo
     */
    public function setNomArquivo($nomArquivo)
    {
        $this->nomArquivo = $nomArquivo;
        return $this;
    }

    /**
     * Get nomArquivo
     *
     * @return string
     */
    public function getNomArquivo()
    {
        return $this->nomArquivo;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConsideracaoArquivoDescricao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivoDescricao $fkTcemgConsideracaoArquivoDescricao
     * @return ConsideracaoArquivo
     */
    public function addFkTcemgConsideracaoArquivoDescricoes(\Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivoDescricao $fkTcemgConsideracaoArquivoDescricao)
    {
        if (false === $this->fkTcemgConsideracaoArquivoDescricoes->contains($fkTcemgConsideracaoArquivoDescricao)) {
            $fkTcemgConsideracaoArquivoDescricao->setFkTcemgConsideracaoArquivo($this);
            $this->fkTcemgConsideracaoArquivoDescricoes->add($fkTcemgConsideracaoArquivoDescricao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConsideracaoArquivoDescricao
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivoDescricao $fkTcemgConsideracaoArquivoDescricao
     */
    public function removeFkTcemgConsideracaoArquivoDescricoes(\Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivoDescricao $fkTcemgConsideracaoArquivoDescricao)
    {
        $this->fkTcemgConsideracaoArquivoDescricoes->removeElement($fkTcemgConsideracaoArquivoDescricao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConsideracaoArquivoDescricoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConsideracaoArquivoDescricao
     */
    public function getFkTcemgConsideracaoArquivoDescricoes()
    {
        return $this->fkTcemgConsideracaoArquivoDescricoes;
    }
}
