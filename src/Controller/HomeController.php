<?php

namespace App\Controller;

use App\Repository\MangaRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function renderSearch(): Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class, ['label' => false])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-outline-light',
                ]
            ])
            ->getForm();

        return $this->render('search/_searchModal.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return Response
     */

    public function handleSearch(Request $request, ProductRepository $productRepository, PaginatorInterface $paginator): Response
    {

        $query = $request->request->get('form')['query'];
        if ($query){
            $products = $productRepository->findProductsByName($query);
        }

        $products = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1), 9
        );


        return $this->render('search/searchProducts.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/", name="home_video")
     * @return Response
     */
    public function homeVideo(): Response
    {
        return $this->render('home/homeVideo.html.twig');
    }


    /**
     * @Route("/home", name="home")
     * @param MangaRepository $repository
     * @param ProductRepository $repositoryProd
     * @return Response
     */
    public function index(MangaRepository $repository, ProductRepository $repositoryProd): Response
    {

        $licences = $repository->findBy(
            [],
            ['title' => 'DESC'], 6
        );

        $products = $repositoryProd->findBy(
            [],
            ['created_at' => 'DESC'], 4
        );

        return $this->render('home/index.html.twig', [
            'licences' => $licences,
            'products' => $products,
        ]);
    }

    /**
     * @Route("/copyright", name="copyright")
     * @return Response
     */
    public function copyright(): Response
    {
        return $this->render('partials/legalMention.html.twig');
    }

}
