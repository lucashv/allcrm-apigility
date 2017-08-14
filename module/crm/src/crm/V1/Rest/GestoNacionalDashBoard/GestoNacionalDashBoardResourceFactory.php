<?php
namespace crm\V1\Rest\GestoNacionalDashBoard;

class GestoNacionalDashBoardResourceFactory
{
    public function __invoke($services)
    {
        return new GestoNacionalDashBoardResource($services->get('GestorNacionalDashBoardService'));
    }
}
