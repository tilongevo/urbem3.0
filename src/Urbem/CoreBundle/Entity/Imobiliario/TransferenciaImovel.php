<?php

namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TransferenciaImovel
 */
class TransferenciaImovel
{
    /**
     * PK
     * @var integer
     */
    private $codTransferencia;

    /**
     * @var integer
     */
    private $codNatureza;

    /**
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $dtCadastro;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovelTransferencia
     */
    private $fkImobiliarioMatriculaImovelTransferencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaEfetivacao
     */
    private $fkImobiliarioTransferenciaEfetivacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso
     */
    private $fkImobiliarioTransferenciaProcesso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCancelamento
     */
    private $fkImobiliarioTransferenciaCancelamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem
     */
    private $fkImobiliarioTransferenciaCorretagem;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente
     */
    private $fkImobiliarioTransferenciaAdquirentes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento
     */
    private $fkImobiliarioTransferenciaDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia
     */
    private $fkImobiliarioNaturezaTransferencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioTransferenciaAdquirentes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioTransferenciaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtCadastro = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codTransferencia
     *
     * @param integer $codTransferencia
     * @return TransferenciaImovel
     */
    public function setCodTransferencia($codTransferencia)
    {
        $this->codTransferencia = $codTransferencia;
        return $this;
    }

    /**
     * Get codTransferencia
     *
     * @return integer
     */
    public function getCodTransferencia()
    {
        return $this->codTransferencia;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return TransferenciaImovel
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return TransferenciaImovel
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set dtCadastro
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $dtCadastro
     * @return TransferenciaImovel
     */
    public function setDtCadastro(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTransferenciaAdquirente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente $fkImobiliarioTransferenciaAdquirente
     * @return TransferenciaImovel
     */
    public function addFkImobiliarioTransferenciaAdquirentes(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente $fkImobiliarioTransferenciaAdquirente)
    {
        if (false === $this->fkImobiliarioTransferenciaAdquirentes->contains($fkImobiliarioTransferenciaAdquirente)) {
            $fkImobiliarioTransferenciaAdquirente->setFkImobiliarioTransferenciaImovel($this);
            $this->fkImobiliarioTransferenciaAdquirentes->add($fkImobiliarioTransferenciaAdquirente);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTransferenciaAdquirente
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente $fkImobiliarioTransferenciaAdquirente
     */
    public function removeFkImobiliarioTransferenciaAdquirentes(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente $fkImobiliarioTransferenciaAdquirente)
    {
        $this->fkImobiliarioTransferenciaAdquirentes->removeElement($fkImobiliarioTransferenciaAdquirente);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTransferenciaAdquirentes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente
     */
    public function getFkImobiliarioTransferenciaAdquirentes()
    {
        return $this->fkImobiliarioTransferenciaAdquirentes;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioTransferenciaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento $fkImobiliarioTransferenciaDocumento
     * @return TransferenciaImovel
     */
    public function addFkImobiliarioTransferenciaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento $fkImobiliarioTransferenciaDocumento)
    {
        if (false === $this->fkImobiliarioTransferenciaDocumentos->contains($fkImobiliarioTransferenciaDocumento)) {
            $fkImobiliarioTransferenciaDocumento->setFkImobiliarioTransferenciaImovel($this);
            $this->fkImobiliarioTransferenciaDocumentos->add($fkImobiliarioTransferenciaDocumento);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioTransferenciaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento $fkImobiliarioTransferenciaDocumento
     */
    public function removeFkImobiliarioTransferenciaDocumentos(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento $fkImobiliarioTransferenciaDocumento)
    {
        $this->fkImobiliarioTransferenciaDocumentos->removeElement($fkImobiliarioTransferenciaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioTransferenciaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento
     */
    public function getFkImobiliarioTransferenciaDocumentos()
    {
        return $this->fkImobiliarioTransferenciaDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioNaturezaTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia $fkImobiliarioNaturezaTransferencia
     * @return TransferenciaImovel
     */
    public function setFkImobiliarioNaturezaTransferencia(\Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia $fkImobiliarioNaturezaTransferencia)
    {
        $this->codNatureza = $fkImobiliarioNaturezaTransferencia->getCodNatureza();
        $this->fkImobiliarioNaturezaTransferencia = $fkImobiliarioNaturezaTransferencia;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioNaturezaTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia
     */
    public function getFkImobiliarioNaturezaTransferencia()
    {
        return $this->fkImobiliarioNaturezaTransferencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return TransferenciaImovel
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioMatriculaImovelTransferencia
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovelTransferencia $fkImobiliarioMatriculaImovelTransferencia
     * @return TransferenciaImovel
     */
    public function setFkImobiliarioMatriculaImovelTransferencia(\Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovelTransferencia $fkImobiliarioMatriculaImovelTransferencia)
    {
        $fkImobiliarioMatriculaImovelTransferencia->setFkImobiliarioTransferenciaImovel($this);
        $this->fkImobiliarioMatriculaImovelTransferencia = $fkImobiliarioMatriculaImovelTransferencia;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioMatriculaImovelTransferencia
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovelTransferencia
     */
    public function getFkImobiliarioMatriculaImovelTransferencia()
    {
        return $this->fkImobiliarioMatriculaImovelTransferencia;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioTransferenciaEfetivacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaEfetivacao $fkImobiliarioTransferenciaEfetivacao
     * @return TransferenciaImovel
     */
    public function setFkImobiliarioTransferenciaEfetivacao(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaEfetivacao $fkImobiliarioTransferenciaEfetivacao)
    {
        $fkImobiliarioTransferenciaEfetivacao->setFkImobiliarioTransferenciaImovel($this);
        $this->fkImobiliarioTransferenciaEfetivacao = $fkImobiliarioTransferenciaEfetivacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioTransferenciaEfetivacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaEfetivacao
     */
    public function getFkImobiliarioTransferenciaEfetivacao()
    {
        return $this->fkImobiliarioTransferenciaEfetivacao;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioTransferenciaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso $fkImobiliarioTransferenciaProcesso
     * @return TransferenciaImovel
     */
    public function setFkImobiliarioTransferenciaProcesso(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso $fkImobiliarioTransferenciaProcesso)
    {
        $fkImobiliarioTransferenciaProcesso->setFkImobiliarioTransferenciaImovel($this);
        $this->fkImobiliarioTransferenciaProcesso = $fkImobiliarioTransferenciaProcesso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioTransferenciaProcesso
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso
     */
    public function getFkImobiliarioTransferenciaProcesso()
    {
        return $this->fkImobiliarioTransferenciaProcesso;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioTransferenciaCancelamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCancelamento $fkImobiliarioTransferenciaCancelamento
     * @return TransferenciaImovel
     */
    public function setFkImobiliarioTransferenciaCancelamento(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCancelamento $fkImobiliarioTransferenciaCancelamento)
    {
        $fkImobiliarioTransferenciaCancelamento->setFkImobiliarioTransferenciaImovel($this);
        $this->fkImobiliarioTransferenciaCancelamento = $fkImobiliarioTransferenciaCancelamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioTransferenciaCancelamento
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCancelamento
     */
    public function getFkImobiliarioTransferenciaCancelamento()
    {
        return $this->fkImobiliarioTransferenciaCancelamento;
    }

    /**
     * OneToOne (inverse side)
     * Set ImobiliarioTransferenciaCorretagem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem $fkImobiliarioTransferenciaCorretagem
     * @return TransferenciaImovel
     */
    public function setFkImobiliarioTransferenciaCorretagem(\Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem $fkImobiliarioTransferenciaCorretagem)
    {
        $fkImobiliarioTransferenciaCorretagem->setFkImobiliarioTransferenciaImovel($this);
        $this->fkImobiliarioTransferenciaCorretagem = $fkImobiliarioTransferenciaCorretagem;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioTransferenciaCorretagem
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem
     */
    public function getFkImobiliarioTransferenciaCorretagem()
    {
        return $this->fkImobiliarioTransferenciaCorretagem;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codTransferencia;
    }
}
