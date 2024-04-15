<?php

namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use App\Entity\Article;
    use App\Repository\ArticleRepository;
    use Doctrine\Persistence\ManagerRegistry;
    use Symfony\Component\HttpFoundation\Request;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
     
class ArticleController extends AbstractController
{
    #[Route("/", name: "base")]
    public function home(): Response
    {
        return $this->render("article/home.html.twig");
    }
    #[Route("/article/new", name: "new_form")]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        // creates a article object and initializes some data for this example
        $article = new Article();
        $article->setCreatedata(new \DateTimeImmutable("tomorrow"));
        $form = $this->createFormBuilder($article)
            ->add("title", TextType::class)
            ->add("image", TextType::class)
            ->add("content", TextType::class)
            ->add("save", SubmitType::class, ["label" => "Create Article"])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$article` variable has also been updated
            $article = $form->getData();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute("app_article");
        }
        return $this->render("/article/create.html.twig", ["form" => $form]);
    }
    #[Route("/delete/{id}", name: "article_delete")]
    public function delete($id, ArticleRepository $repo, EntityManagerInterface $entityManager
    )
    {
        $article = $repo->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute("app_article");
    }
    #[Route("/article/{id}", name: "article_show")]
    public function show($id, ArticleRepository $repo)
    {
        $article = $repo->find($id);
        return $this->render("article/show.html.twig", ["article" => $article]);
    }
   
   

    #[Route("/article", name: "app_article")]
    public function index(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll('Titre de l\'article');
        return $this->render("article/index.html.twig", [
            "controller_name" => "BlogController",
            "articles" => $articles,
        ]);
    }
}
