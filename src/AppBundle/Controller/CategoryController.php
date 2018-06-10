<?php

namespace AppBundle\Controller;

use AppBundle\Form\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/list", name="category_list")
     */
    public function listAction(Request $request)
    {
        $client = $this->get('eight_points_guzzle.client.api_city');
        $resp = $client->get('api/category/categories');
        $json = $resp->getBody()->getContents();
        $serializer = $this->get('jms_serializer');
        $data = $serializer->deserialize($json, "array<AppBundle\Entity\Category>", 'json');
        return $this->render('@App/Category/list.html.twig', [
            'categories' => $data,
        ]);
    }

    /**
     * @Route("/add", name="category_add")
     */
    public function addAction(Request $request)
    {
        $user = $this->getUser();
        $token = $user->getAccessToken();
        //echo "TOKEN: $token <br>";
        ###
        $client = $this->get('eight_points_guzzle.client.api_city');
        //$resp = $client->post('api/category/add');
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
        $form = $this->createForm(Category::class);
        $form->add('submit', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-default pull-right'),
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $fileName = 'fs.jpg';
            if (isset($data['photo'])) {
                $photo = $data['photo'];
                if ($photo instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                    $fileName = $this->generateUniqueFileName() . '.' . $photo->guessExtension();
                    $photo->move(
                        __DIR__ . '/../../../public_html/img/',
                        $fileName
                    );
                }
            }
            $resp = $client->post('api/category/add', [
                'headers' => $headers,
                'query' => [
                    'id' => 0,
                    'title' => $data['title'],
                    'description' => $data['description'],
                ],
                'multipart' => [
                    [
                        'name' => 'photo',
                        'contents' => file_get_contents(__DIR__ . '/../../../public_html/img/' . $fileName),
                        'filename' => $fileName
                    ],
                ],
            ]);
            $json = $resp->getBody()->getContents();
            //echo $json;
            $serializer = $this->get('jms_serializer');
        }
        return $this->render('@App/Category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/delete/{id}", name="category_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $user = $this->getUser();
        $token = $user->getAccessToken();
        $client = $this->get('eight_points_guzzle.client.api_city');
        //$resp = $client->post('api/category/add');
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];
        $resp = $client->post('api/category/delete', [
            'headers' => $headers,
            'query' => [
                'id' => $id,
            ],

        ]);
        $json = $resp->getBody()->getContents();
        //echo $json;
        return $this->redirectToRoute('category_list');
    }
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
