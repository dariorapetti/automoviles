<?php

namespace App\Controller;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends BaseController
{

    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function index(Request $request)
    {
      return $this->redirectToRoute("usuarios_index");
    }
}
