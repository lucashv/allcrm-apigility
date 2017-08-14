<?php

namespace crm\V1\Rest\ContatoCorretorBloqueio;


use crm\Entity\ContatoCorretorBloqueio;

class ContatoBloqueioFactory
{
    private $contatoCorretorBloqueio;

    private $em;

    public function __construct($em, ContatoCorretorBloqueio $contatoCorretorBloqueio)
    {
        $this->contatoCorretorBloqueio = $contatoCorretorBloqueio;
        $this->em = $em;
    }


    public function create($data)
    {

        $contato       = $this->em->getRepository('crm\Entity\Contatos')->find( $data['contato']);
        $corretor      = $this->em->getRepository('crm\Entity\Usuarios')->find(  $data['corretorId']);
        $contatoCorretorBloqueio = new ContatoCorretorBloqueio();
        $contatoCorretorBloqueio->setCorretor($corretor)
             ->setContato($contato)
             ->setDataBloqueio()
             ->setStatus(1);
        return $contatoCorretorBloqueio;
    }

}